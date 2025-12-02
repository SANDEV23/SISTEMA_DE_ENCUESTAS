<?php

namespace App\Http\Controllers;

use App\Models\Survey;
use App\Models\Question;
use App\Models\Option;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class QuestionController extends Controller
{
    public function create($surveyId)
    {
        $survey = Survey::where('company_id', Auth::user()->company_id)
            ->with('questions.options')
            ->findOrFail($surveyId);

        return view('questions.create', compact('survey'));
    }

    public function store(Request $request, $surveyId)
    {
        $survey = Survey::where('company_id', Auth::user()->company_id)
            ->findOrFail($surveyId);

        $validated = $request->validate([
            'question' => 'required|string|max:500',
            'type' => 'required|in:text,select,checkbox',
            'options' => 'required_if:type,select,checkbox|array|min:2',
            'options.*' => 'required_if:type,select,checkbox|string|max:255',
        ]);

        DB::beginTransaction();
        try {
            $question = Question::create([
                'survey_id' => $survey->id,
                'question' => $validated['question'],
                'type' => $validated['type'],
            ]);

            if (in_array($validated['type'], ['select', 'checkbox']) && isset($validated['options'])) {
                foreach ($validated['options'] as $optionText) {
                    if (!empty($optionText)) {
                        Option::create([
                            'question_id' => $question->id,
                            'option_text' => $optionText,
                        ]);
                    }
                }
            }

            DB::commit();

            return redirect()->route('surveys.questions.create', $survey->id)
                ->with('success', 'Pregunta agregada exitosamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error al crear la pregunta. Intenta nuevamente.');
        }
    }

    public function destroy($surveyId, $questionId)
    {
        $survey = Survey::where('company_id', Auth::user()->company_id)
            ->findOrFail($surveyId);

        $question = Question::where('survey_id', $survey->id)
            ->findOrFail($questionId);

        $question->delete();

        return redirect()->route('surveys.questions.create', $survey->id)
            ->with('success', 'Pregunta eliminada exitosamente.');
    }

    public function finish($surveyId)
    {
        $survey = Survey::where('company_id', Auth::user()->company_id)
            ->findOrFail($surveyId);

        return redirect()->route('surveys.show', $survey->id)
            ->with('success', 'Encuesta finalizada y lista para compartir.');
    }
}
