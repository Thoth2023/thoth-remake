<?php

namespace App\Http\Controllers;

use App\Models\GeneralScore;
use App\Models\MinToApp;
use App\Models\Project;
use App\Models\QuestionQuality;
use App\Models\ScoreQuality;
use Illuminate\Http\Request;

class QualityAssessmentController extends Controller
{
    
    public function index($id) {
        $project = Project::findOrFail($id);
        return view('planning.quality_assessment', compact('project'));
    }

    public function create_general_score_interval(Request $request, string $id_project) {

        $urlToRedirect = '/projects/'.$id_project.'/planning/quality-assessment';
        
        $generalScores = Project::findOrFail($id_project)->generalScores;
        $generalScore = new GeneralScore([
            'description' => $request->gs_description,
            'start' => $request->start,
            'end' => $request->end,
            'id_project' => $id_project
        ]);
        if (!$this->isScoreValid($generalScore, $generalScores)) {
            return redirect($urlToRedirect);
        }
        $generalScore->save();

        return redirect($urlToRedirect);
    }

    public function set_min_to_app(Request $request, string $id_project) {

        $minToApp = null;

        if (MinToApp::where('id_project', $id_project)->exists()) {
            $minToApp = MinToApp::findOrFail($id_project);
            $minToApp->update([
                'id_general_score' => $request->minimum
            ]);
        } else {
            $minToApp = MinToApp::create([
                'id_general_score' => $request->minimum,
                'id_project' => $id_project
            ]);
        }
        return redirect('/projects/'.$id_project.'/planning/quality-assessment');
    }

    public function edit_general_score_interval(Request $request, string $id_project, string $id_general_score) {

        $urlToRedirect = '/projects/'.$id_project.'/planning/quality-assessment';
        
        $score = GeneralScore::findOrFail($id_general_score);
        $generalScores = Project::findOrFail($id_project)->generalScores;
        if (!$this->isScoreValid($score, $generalScores)) {
            return redirect($urlToRedirect);
        }
        $score->update([
            'description' => $request->description,
            'start' => $request->start,
            'end' => $request->end,
        ]);
        $score->save();

        return redirect($urlToRedirect);
    }

    public function remove_general_score(string $id_project, string $id_general_score) {
        
        $scoreToDelete = GeneralScore::findOrFail($id_general_score);
        if ($scoreToDelete->start != 0) {
            $scoreToDelete->delete();
        }
        return redirect('/projects/'.$id_project.'/planning/quality-assessment');
    }

    public function create_question_quality(Request $request, string $id_project) {

        $newQuestionQuality = QuestionQuality::create([
            'description' => $request->description,
            'id' => $request->id,
            'id_project' => $id_project,
            'wheight' => $request->wheight
        ]);

        return redirect('/projects/'.$id_project.'/planning/quality-assessment');
    }

    public function create_question_score(Request $request, string $id_project) {

        $scoreQuality = ScoreQuality::create([
            'description' => $request->description,
            'id_qa' => $request->question,
            'score' => $request->score,
            'score_rule' => $request->scoreRule
        ]);

        return redirect('/projects/'.$id_project.'/planning/quality-assessment');
    }

    private function isScoreValid(GeneralScore $generalScore, $generalScores) {
        if ($generalScore->start >= $generalScore->end) {
            return false;
        }
        $hasStartInterval = false;
        foreach ($generalScores as $gScore) {
            if (($generalScore->start < $gScore->start && $generalScore->end > $gScore->start) ||
            ($generalScore->start < $gScore->end && $generalScore->end > $gScore->end)) {
                return false;
            }
            $hasStartInterval = $hasStartInterval || $gScore->start == 0;
        }
        if (!$hasStartInterval && $generalScore->start != 0) {
            return false;
        }
        return true;
    }
}
