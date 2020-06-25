<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Session;
use App\CompetitionCategory;

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

    private function parseDate($dateTime)
    {
    	return date("Y-m-d H:i:s",strtotime($dateTime));
    }
}
