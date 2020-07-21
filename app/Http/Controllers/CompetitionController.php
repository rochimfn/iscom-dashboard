<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\CompetitionCategory;
use App\Mahasiswa;
use App\Question;
use App\Session;
use App\Submitted;
use App\Team;
use App\User;

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
        $canUpload = $this->canUpload();
        if( $canUpload['status'] == false ) {
            return view('participants/submission')->withErrors($canUpload['message'])->with(['questions' => [], 'submissions' => []]);
        }

        $team = User::with('team')->where('user_id', Auth::user()->user_id)->first()['team'];

        // $questionsAndSubmissions = Team::with(['question', 'submission'])->where('team_id', $team['team_id'])->first();
        $questions = Team::with('question')->where('team_id', $team['team_id'])->first()['question'];
        $submissions = Team::with('submission')->where('team_id', $team['team_id'])->first();
        $submissions = $submissions['submission']->keyBy('submitted_question_id');

        return view('participants/submission')->with(['questions' => $questions, 'submissions' => $submissions]);
    }

    public function storeSubmission(Request $request)
    {
        $canUpload = $this->canUpload();
        if( $canUpload['status'] == false ) {
            return redirect()->back()->withErrors($canUpload['message']);
        }

        $request->validate([
          'submitted_question_id' => 'required',
          'submission_file' => 'required|file'
        ]);

        $mahasiswa = Mahasiswa::with(['team', 'category'])->where('mahasiswa_nrp', Auth::user()->user_name)->first();

        $submitted = new Submitted;
        $submitted->submitted_question_id = $request->submitted_question_id;
        $submitted->submitted_team_id = $mahasiswa['team']['team_id'];
        $submitted->submitted_competition_category_abbreviation = $mahasiswa['category']['competition_category_abbreviation'];
        if ($request->has('submitted_title')) {
            $submitted->submitted_title = $request->submitted_title;
        } else {
            $question = Question::where('question_id', $request->submitted_question_id)->first()['question_title'];
            $submitted->submitted_title = $mahasiswa['team']['team_name'] . ': ' . $question ;
        }

        $file = $request->file('submission_file');
        $filename = $mahasiswa['team']['team_name'] . '_' . $submitted->submitted_title . '_' . time() .'.'. $file->getClientOriginalExtension();
        $location = '/uploads/submissions/' . $mahasiswa['category']['competition_category_abbreviation'] .'/'. $mahasiswa['team']['team_name'];
        $file->move(public_path($location), $filename);

        $submitted->submitted_file = $location . '/' . $filename;
        $submitted->save();

        return redirect()->back()->with('success', 'Sumbisi berhasil diunggah');
    }

    public function deleteSubmission($id)
    {
        $team = Mahasiswa::with('team')->where('mahasiswa_nrp', Auth::user()->user_name)->first()['team'];
        $submitted = Submitted::where(['submitted_question_id' => $id, 'submitted_team_id' => $team['team_id']])->first();
        if ( empty($submitted) ) {
            return redirect()->back()->withErrors('Someting wrong, can\'t delete');
        }
        unlink( public_path($submitted->submitted_file) );
        $submitted->delete();

        return redirect()->back()->with('success', 'Submisi berhasil dihapus');
    }

    private function isKti()
    {
        return Mahasiswa::with('category')->where('mahasiswa_nrp', Auth::user()->user_name)->first()['category']['is_kti'];
    }

    private function canUpload()
    {
        if($this->isKti()) {
            $sessions = Session::where('session_name', 'kti_submit')->first();
            $start = strtotime($sessions['session_start']);
            $end = strtotime($sessions['session_end']);

            return $this->checkDateSubmission($start, $end);
        } else {
            $sessions = Session::where('session_name', 'non_kti_submit')->first();
            $start = strtotime($sessions['session_start']);
            $end = strtotime($sessions['session_end']);

            return $this->checkDateSubmission($start, $end);
        }
    }

    private function checkDateSubmission($start, $end)
    {
        if( date("U") <= $start ) {
            return ['status' => false, 'message' => 'Submisi belum dibuka'];
        } elseif ( date("U") >= $end) {
            return ['status' => false, 'message' => 'Submisi sudah ditutup'];
        }

        return ['status' => true];
    }

    private function parseDate($dateTime)
    {
    	return date("Y-m-d H:i:s",strtotime($dateTime));
    }
}
