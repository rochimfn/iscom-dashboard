<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Team;
use App\Mahasiswa;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;

class UserController extends Controller
{
    use SendsPasswordResetEmails;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::with('mahasiswa')->with('dosen')->get();
        return $users;   
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // DB::enableQueryLog();
        $teams = Team::with(['mahasiswa', 'user'])->find(Auth::user()->user_id);
        return view('users/create')->with('teams', $teams);
        // $quries = DB::getQueryLog();
        // dd($quries);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $this->validate($request,[
            'mahasiswa_name' => ['required','string'],
            'nrp' => ['required', 'unique:App\User,user_name'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:App\User,email'],
        ]);
        
        $leader = User::with('team')->find(Auth::user()->user_id);
        $leader['team']['team_id'];

        Mahasiswa::create([
            'mahasiswa_name' => $data['mahasiswa_name'],
            'mahasiswa_nrp' => $data['nrp'],
            'mahasiswa_team_id' => $leader['team']['team_id'],
            'is_team_leader' => false
        ]);

        User::create([
            'user_name' => $data['nrp'],
            'email' => $data['email'],
            'password' => Hash::make('Passwordyangsangatsusahditembus'),
            'user_role_id' => 2, // Mahasiswa
        ]);

        $this->sendResetLinkEmail($request);

        return redirect('users/create')->with([
            'success' => 
            ['Anggota berhasil ditambahkan ke Team ' . $leader['team']['team_id'],
            'Reset password telah dikirimkan ke anggota (link berlaku selama 60menit)']
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
