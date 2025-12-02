<?php

namespace App\Http\Controllers;

use App\Models\Survey;
use App\Models\Question;
use App\Models\Answer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function show($surveyId)
    {
        $survey = Survey::where('company_id', Auth::user()->company_id)
            ->with(['questions.options', 'questions.answers.option'])
            ->findOrFail($surveyId);

        $totalResponses = Answer::where('survey_id', $surveyId)
            ->distinct('respondent_email')
            ->count('respondent_email');

        $reportData = [];

        foreach ($survey->questions as $question) {
            $questionData = [
                'question' => $question->question,
                'type' => $question->type,
                'total_answers' => 0,
                'data' => [],
            ];

            if ($question->type === 'text') {
                $textAnswers = Answer::where('question_id', $question->id)
                    ->whereNotNull('answer_text')
                    ->get();

                $questionData['total_answers'] = $textAnswers->count();
                $questionData['data'] = $textAnswers->map(function ($answer) {
                    return [
                        'text' => $answer->answer_text,
                        'respondent' => $answer->respondent_name,
                    ];
                });
            } else {
                foreach ($question->options as $option) {
                    $count = Answer::where('question_id', $question->id)
                        ->where('option_id', $option->id)
                        ->count();

                    $percentage = $totalResponses > 0
                        ? round(($count / $totalResponses) * 100, 2)
                        : 0;

                    $questionData['data'][] = [
                        'option' => $option->option_text,
                        'count' => $count,
                        'percentage' => $percentage,
                    ];

                    $questionData['total_answers'] += $count;
                }
            }

            $reportData[] = $questionData;
        }

        return view('reports.show', compact('survey', 'reportData', 'totalResponses'));
    }

    public function responses($surveyId)
    {
        $survey = Survey::where('company_id', Auth::user()->company_id)
            ->findOrFail($surveyId);

        $responses = Answer::where('survey_id', $surveyId)
            ->with(['question', 'option'])
            ->orderBy('respondent_email')
            ->orderBy('created_at')
            ->get()
            ->groupBy('respondent_email');

        return view('reports.responses', compact('survey', 'responses'));
    }
}
