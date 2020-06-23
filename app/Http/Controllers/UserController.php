<?php

namespace App\Http\Controllers;

use App\CompetitionCategory;
use App\User;
use App\Team;
use App\Mahasiswa;
use App\Dosen;
use Illuminate\Http\Request;
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
        $participants = CompetitionCategory::with('team')->get();
        $users = Mahasiswa::with('user')->with('team')->with('category')->get();
        return view('users/index')->with(['users' => $users, 'participants' => $participants]);   
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexDosen()
    {
        $users = Dosen::with('user')->get();
        return view('users/index_dosen')->with('users', $users);   
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // DB::enableQueryLog();
        $team = Team::with(['mahasiswa', 'user'])->find(Auth::user()->user_id);
        $members =  Mahasiswa::with('user')->where('mahasiswa_team_id', $team->team_id )->get();
        // return $teams = Team::with(['mahasiswa', 'user'])->find(Auth::user()->user_id);
        return view('users/create')->with(['team' => $team, 'members' => $members]);
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
            'nrp' => ['required','alpha_dash', 'unique:App\User,user_name'],
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

        return redirect('home/members')->with('success', 'Anggota berhasil ditambahkan ke Team ' . $leader['team']['team_name'] .', minta anggota periksa email');
    }

    public function storeDosen(Request $request)
    {
        $data = $this->validate($request,[
            'dosen_name' => ['required','string'],
            'user_name' => ['required','alpha_dash', 'unique:App\User,user_name'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:App\User,email'],
        ]);

        $user = User::create([
            'user_name' => $data['user_name'],
            'email' => $data['email'],
            'password' => Hash::make($data['user_name'].'37645'),
            'user_role_id' => 3, // Dosen
        ]);
        
        $user->save();

        Dosen::create([
            'dosen_name' => $data['dosen_name'],
            'dosen_user_id' => $user['user_id']
        ]);

        $this->sendResetLinkEmail($request);

        return redirect('users/dosen')->with('success', 'Evaluator berhasil ditambahkan');
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
        $data = $this->validate($request,[
            'mahasiswa_name' => ['required','string'],
            'nrp' => ['required', 'alpha_dash'],
            'email' => ['required', 'string', 'email', 'max:255'],
        ]);

        $team = Mahasiswa::where('mahasiswa_nrp', Auth::user()->user_name)->first();

        $user = User::where('user_id', $id)->first();
        $mahasiswa = Mahasiswa::where('mahasiswa_nrp', $user['user_name'])->first();
    

        if($team['mahasiswa_team_id'] !== $mahasiswa['mahasiswa_team_id']) {
            return redirect('users/create')->withErrors('Maaf kamu tidak berhak');   
        };
        
        $user['user_name'] = $data['nrp'];
        $user['email'] = $data['email'];
        $mahasiswa['mahasiswa_name'] = $data['mahasiswa_name'];
        $mahasiswa['mahasiswa_nrp'] = $data['nrp'];
        
        $user->save();
        $mahasiswa->save();

        if($mahasiswa['email'] !== $user['email']) {
            $this->sendResetLinkEmail($request);
        }

        return redirect('home/members')->with('success', 'Data anggota berhasi diubah');
    }

    public function updateDosen(Request $request, $id)
    {
        $data = $this->validate($request,[
            'dosen_name' => ['required','string'],
            'user_name' => ['required', 'alpha_dash'],
            'email' => ['required', 'string', 'email', 'max:255'],
        ]);

        $user = User::where('user_id', $id)->first();
        $dosen = Dosen::where('dosen_user_id', $user['user_id'])->first();
        
        $user['user_name'] = $data['user_name'];
        $user['email'] = $data['email'];
        $dosen['dosen_name'] = $data['dosen_name'];
        
        $user->save();
        $dosen->save();

        if($dosen['email'] !== $user['email']) {
            $this->sendResetLinkEmail($request);
        }

        return redirect('users/dosen')->with('success', 'Data evaluator berhasi diubah');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $team = Mahasiswa::where('mahasiswa_nrp', Auth::user()->user_name)->first();
        
        $user = User::where('user_id', $id)->first();
        $mahasiswa = Mahasiswa::where('mahasiswa_nrp', $user['user_name'])->first();

        if($team['mahasiswa_team_id'] !== $mahasiswa['mahasiswa_team_id']) {
            return redirect('users/create')->withErrors('Maaf kamu tidak berhak');   
        };

        $name = $mahasiswa['mahasiswa_name'];
        $user->delete();
        $mahasiswa->delete();

        return redirect('home/members')->with('success', 'Anggota ' . $name .' berhasil dihapus dari Tim');   
    }

    public function destroyDosen($id)
    {
        $user = User::where('user_id', $id)->first();
        $dosen = Dosen::where('dosen_user_id', $user['user_id'])->first();

        $name = $dosen['dosen_name'];
        $user->delete();
        $dosen->delete();

        return redirect('users/dosen')->with('success', 'Evaluator ' . $name .' berhasil dihapus');   
    }

    public function changePasswordForm()
    {
        return view('auth/passwords/change_password');
    }

    public function updatePassword(Request $request)
    {
        $data = $this->validate($request, [
            'old_password' => ['required','string'],
            'new_password' => ['required','string'],
            'confirmation_new_password' => ['required','string']
        ]);

        if($data['new_password'] !== $data['confirmation_new_password'])
        {
            return redirect()->back()->withErrors('Konfirmasi password tidak sesuai');
        }

        $user = User::where('user_id', Auth::user()->user_id)->first();
        
        if( !Hash::check( $data['old_password'], $user['password']))
        {
            return redirect()->back()->withErrors('Password lama tidak sesuai');
        }

        $user['password'] = $data['new_password'];
        $user->save();

        return redirect()->back()->with('success', 'Password berhasil diubah');
    }

    public function changeProfile()
    {
        $user = User::with('mahasiswa')->with('team')->where('user_id', Auth::user()->user_id)->first();
        $category = Team::with('category')->where('team_id', $user['team']['team_id'])->first()['category']['competition_category_name'];
        return view('auth/participant_profile')->with(['user' => $user, 'category' => $category]);
    }

    public function updateProfile(Request $request)
    {
        $data = $this->validate($request, [
            'email' => ['required', 'string', 'email', 'max:255'],
            'mahasiswa_name' => ['required', 'string'],
            'team_name' => ['required', 'string'],
        ]);

        $user = User::where('user_id', Auth::user()->user_id)->first();
        $mahasiswa = Mahasiswa::where('mahasiswa_nrp',$user['user_name'])->first();
        $team = Team::where('team_id', $mahasiswa['mahasiswa_team_id'])->first();

        
        if($user['email'] !== $data['email'] && !empty(User::where('email', $data['email'])->first())) {
            return redirect()->back()->withErrors('Email sudah terdaftar');
        }
        
        if($team['team_name'] !== $data['team_name'] && !empty(Team::where('team_name', $data['team_name'])->first())) {
            return redirect()->back()->withErrors('Nama Tim sudah terdaftar');
        }

        $user['email'] = $data['email'];
        $mahasiswa['mahasiswa_name'] = $data['mahasiswa_name'];
        $team['team_name'] = $data['team_name'];

        $user->save();
        $mahasiswa->save();
        $team->save();

        return redirect()->back()->with('success', 'Profil berhasil diubah');
    }
}
