<?php

namespace App\Http\Controllers;

use App\Models\Survey;
use App\Models\Question;
use App\Models\Answer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SurveyController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if (!$user->company_id) {
            return redirect()->route('dashboard')
                ->with('error', 'Debes estar asociado a una empresa para crear encuestas.');
        }

        $surveys = Survey::where('company_id', $user->company_id)
            ->withCount('questions')
            ->latest()
            ->paginate(10);

        return view('surveys.index', compact('surveys'));
    }

    public function create()
    {
        if (!Auth::user()->company_id) {
            return redirect()->route('dashboard')
                ->with('error', 'Debes estar asociado a una empresa para crear encuestas.');
        }

        return view('surveys.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
        ]);

        $survey = Survey::create([
            'company_id' => Auth::user()->company_id,
            'title' => $validated['title'],
            'description' => $validated['description'],
        ]);

        return redirect()->route('surveys.questions.create', $survey->id)
            ->with('success', 'Encuesta creada. Ahora agrega las preguntas.');
    }

    public function show($id)
    {
        $survey = Survey::with(['questions.options'])->findOrFail($id);
        return view('surveys.show', compact('survey'));
    }

    public function edit($id)
    {
        $survey = Survey::where('company_id', Auth::user()->company_id)
            ->findOrFail($id);

        return view('surveys.edit', compact('survey'));
    }

    public function update(Request $request, $id)
    {
        $survey = Survey::where('company_id', Auth::user()->company_id)
            ->findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
        ]);

        $survey->update($validated);

        return redirect()->route('surveys.show', $survey->id)
            ->with('success', 'Encuesta actualizada exitosamente.');
    }

    public function destroy($id)
    {
        $survey = Survey::where('company_id', Auth::user()->company_id)
            ->findOrFail($id);

        $survey->delete();

        return redirect()->route('surveys.index')
            ->with('success', 'Encuesta eliminada exitosamente.');
    }

    public function submit(Request $request, $id)
    {
        $survey = Survey::with('questions')->findOrFail($id);

        $validated = $request->validate([
            'respondent_name' => 'required|string|max:255',
            'respondent_email' => 'required|email|max:255',
            'answers' => 'required|array',
        ]);

        DB::beginTransaction();
        try {
            foreach ($validated['answers'] as $questionId => $answerData) {
                $question = Question::find($questionId);

                if ($question->type === 'text') {
                    Answer::create([
                        'survey_id' => $survey->id,
                        'question_id' => $questionId,
                        'answer_text' => $answerData,
                        'respondent_name' => $validated['respondent_name'],
                        'respondent_email' => $validated['respondent_email'],
                    ]);
                } elseif ($question->type === 'select') {
                    Answer::create([
                        'survey_id' => $survey->id,
                        'question_id' => $questionId,
                        'option_id' => $answerData,
                        'respondent_name' => $validated['respondent_name'],
                        'respondent_email' => $validated['respondent_email'],
                    ]);
                } elseif ($question->type === 'checkbox') {
                    if (is_array($answerData)) {
                        foreach ($answerData as $optionId) {
                            Answer::create([
                                'survey_id' => $survey->id,
                                'question_id' => $questionId,
                                'option_id' => $optionId,
                                'respondent_name' => $validated['respondent_name'],
                                'respondent_email' => $validated['respondent_email'],
                            ]);
                        }
                    }
                }
            }

            DB::commit();

            return redirect()->route('surveys.thank-you')
                ->with('success', 'Gracias por responder la encuesta!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error al guardar las respuestas. Intenta nuevamente.');
        }
    }

    public function thankYou()
    {
        return view('surveys.thank-you');
    }
}
