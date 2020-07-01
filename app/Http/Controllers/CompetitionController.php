<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Team;
use App\Session;
use App\CompetitionCategory;
use App\Question;
use App\Submitted;

class CompetitionController extends Controller
{
    public function sessionIndex()
    {
    	$sessions = Session::all()->keyBy('session_name');
    	return view('admin/competition/session')->with('sessions', $sessions);
    }

    public function updateSession(Request $request)
    {
    	$data = $this->validate($request,[
    		'registration_start' => ['required', 'date'],
    		'registration_end' => ['required', 'date'],
    		'kti_submit_start' => ['required', 'date'],
    		'kti_submit_end' => ['required', 'date'],
    		'non_kti_submit_start' => ['required', 'date'],
    		'non_kti_submit_end' => ['required', 'date']
    	]);
    	
    	$sessions = Session::all()->keyBy('session_name');
    	$sessions['registration']['session_start'] = $this->parseDate($data['registration_start']);
    	$sessions['registration']['session_end'] = $this->parseDate($data['registration_end']);
    	$sessions['kti_submit']['session_start'] = $this->parseDate($data['kti_submit_start']);
    	$sessions['kti_submit']['session_end'] = $this->parseDate($data['kti_submit_end']);
    	$sessions['non_kti_submit']['session_start'] = $this->parseDate($data['non_kti_submit_start']);
    	$sessions['non_kti_submit']['session_end'] = $this->parseDate($data['non_kti_submit_end']);

    	foreach ($sessions as $session) {
    		$session->save();
    	}

    	return redirect()->route('admin.competition.update.session')->with('success', 'Sessions Updated');
    }

    public function branchIndex()
    {
        $branch = CompetitionCategory::all();
        return view('admin/competition/branch')->with('branch', $branch);
    }

    public function branchStore(Request $request)
    {
        // $data = $this->validate($request, [
        //     'competition_category_name' => ['required', 'string'],
        //     'competition_category_abbreviation' => ['required', 'string', 'unique:App\CompetitionCategory,competition_category_abbreviation'],
        //     'competition_category_team_limit' => ['required']
        // ]);

        // return $data;
        return redirect()->back()->with('Dikunci oleh DBAdmin');
    }

    public function branchUpdate(Request $request, $id)
    {
        return redirect()->back()->with('Dikunci oleh DBAdmin');
    }

    public function branchDestroy(Request $request, $id)
    {
        return redirect()->back()->with('Dikunci oleh DBAdmin');
    }

    public function ktiIndexQuestion()
    {
        $category = CompetitionCategory::with('question')->where('is_kti', 1)->get();
        return view('admin/competition/index_kti')->with('category', $category);
    }

    public function ktiStoreQuestion(Request $request)
    {
        $data = $this->validate($request,[
            'branch' => ['required', 'numeric'],
            'title' => ['required'],
            'description' => ['required']
        ]);

        $question = Question::create([
            'question_competition_category_id' => $data['branch'],
            'question_title' => $data['title'],
            'question_description' => $data['description']
        ]);

        return redirect()->route('admin.competition.index.question.kti')->with('success', 'Instruksi baru ditambahkan');
    }

    public function ktiEditQuestion($id)
    {
        $question = Question::where('question_id', $id)->first();
        return view('admin/competition/edit_kti')->with('question', $question);
    }

    public function ktiUpdateQuestion(Request $request, $id)
    {
        $question = Question::where('question_id', $id)->first();

        $data = $this->validate($request,[
            'title' => ['required'],
            'description' => ['required']
        ]);

        $question['question_title'] = $data['title'];
        $question['question_description'] = $data['description'];
        
        $question->save();

        return redirect()->route('admin.competition.index.question.kti')->with('success', 'Instruksi berhasil diubah');
    }

    public function ktiDestroyQuestion($id)
    {
        $question = Question::where('question_id', $id)->first();
        $question->delete();
        return redirect()->route('admin.competition.index.question.kti')->with('success', 'Instruksi berhasil dihapus');
    }

    public function nonKtiIndexQuestion()
    {
        $category = CompetitionCategory::with('question')->where('is_kti', 0)->get();
        return view('admin/competition/index_non_kti')->with('category', $category);
    }

    public function nonKtiStoreQuestion(Request $request)
    {
        $data = $this->validate($request,[
            'branch' => ['required', 'numeric'],
            'title' => ['required'],
            'description' => ['required']
        ]);

        $question = Question::create([
            'question_competition_category_id' => $data['branch'],
            'question_title' => $data['title'],
            'question_description' => $data['description']
        ]);

        return redirect()->route('admin.competition.index.question.non-kti')->with('success', 'Instruksi baru ditambahkan');
    }

    public function nonKtiEditQuestion($id)
    {
        $question = Question::where('question_id', $id)->first();
        return view('admin/competition/edit_non_kti')->with('question', $question);
    }

    public function nonKtiUpdateQuestion(Request $request, $id)
    {
        $question = Question::where('question_id', $id)->first();

        $data = $this->validate($request,[
            'title' => ['required'],
            'description' => ['required']
        ]);

        $question['question_title'] = $data['title'];
        $question['question_description'] = $data['description'];
        
        $question->save();

        return redirect()->route('admin.competition.index.question.non-kti')->with('success', 'Instruksi berhasil diubah');
    }

    public function nonKtiDestroyQuestion($id)
    {
        $question = Question::where('question_id', $id)->first();
        $question->delete();
        return redirect()->route('admin.competition.index.question.non-kti')->with('success', 'Instruksi berhasil dihapus');
    }

    public function indexQuestion()
    {
        $team = User::with('team')->where('user_id', Auth::user()->user_id)->first();
        $team = $team['team'];
        $questions = Team::with('question')->where('team_id', $team['team_id'])->first();
        $questions = $questions['question'];
        $submissions = Team::with('submission')->where('team_id', $team['team_id'])->first();
        $submissions = $submissions['submission']->keyBy('submitted_question_id');

        return view('participants/submission')->with(['questions' => $questions, 'submissions' => $submissions]);
    }

    private function parseDate($dateTime)
    {
    	return date("Y-m-d H:i:s",strtotime($dateTime));
    }
}
