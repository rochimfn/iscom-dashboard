<?php

namespace App\Http\Controllers;

use App\CompetitionCategory;
use App\Dosen;
use App\Mahasiswa;
use App\Session;
use App\Team;
use App\User;
use App\Exports\MahasiswasExport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Maatwebsite\Excel\Facades\Excel;

class UserController extends Controller
{
    use SendsPasswordResetEmails;

    protected $salt;

    public function __construct()
    {
        $this->salt = env('APP_SALT', '_pass');
    }

    public function indexParticipants()
    {
        $participants = CompetitionCategory::with('team')->get();
        $users = Mahasiswa::with('user')->with('team')->with('category')->orderBy('mahasiswa_name')->get();

        return view('admin/index_participants')->with(['users' => $users, 'participants' => $participants]);
    }

    public function exportParticipants()
    {
        return Excel::download(new MahasiswasExport, 'peserta.xlsx');
    }

    public function indexDosen()
    {
        $users = Dosen::with('user')->get();

        return view('admin/index_dosen')->with('users', $users);
    }

    public function storeDosen(Request $request)
    {
        $data = $this->validate($request, [
            'dosen_name' => ['required', 'string'],
            'user_name' => ['required', 'alpha_dash', 'unique:App\User,user_name'],
            'email' => ['required', 'string', 'email', 'max:191', 'unique:App\User,email'],
        ]);

        $user = User::create([
            'user_name' => $data['user_name'],
            'email' => $data['email'],
            'password' => Hash::make($data['user_name'] . $this->salt),
            'user_role_id' => 3, // Dosen
        ]);

        $user->save();

        Dosen::create([
            'dosen_name' => $data['dosen_name'],
            'dosen_user_id' => $user['user_id']
        ]);

        $success = [
            'Evaluator berhasil ditambahkan.',
            "Gunakan password : '{$data['user_name']}{$this->salt}' untuk masuk.",
            'Atau ikuti reset password melalui email yang dikirimkan.'
        ];


        try {
            $this->sendResetLinkEmail($request);
        } catch (\Exception $e) {
            array_pop($success);
        }

        return redirect()->route('admin.users.dosen.index')->with('success', $success);
    }

    public function updateDosen(Request $request, $id)
    {
        $data = $this->validate($request, [
            'dosen_name' => ['required', 'string'],
            'user_name' => ['required', 'alpha_dash'],
            'email' => ['required', 'string', 'email', 'max:191'],
        ]);

        $user = User::where('user_id', $id)->first();
        $dosen = Dosen::where('dosen_user_id', $user['user_id'])->first();

        $user['user_name'] = $data['user_name'];
        $user['email'] = $data['email'];
        $dosen['dosen_name'] = $data['dosen_name'];

        $user->save();
        $dosen->save();

        return redirect()->route('admin.users.dosen.index')->with('success', 'Data evaluator berhasi diubah.');
    }

    public function deleteDosen($id)
    {
        $user = User::where('user_id', $id)->first();
        $dosen = Dosen::where('dosen_user_id', $user['user_id'])->first();

        $name = $dosen['dosen_name'];
        $user->delete();
        $dosen->delete();

        return redirect()->route('admin.users.dosen.index')->with('success', "Evaluator {$name} berhasil dihapus");
    }

    public function changeAdminProfile()
    {
        $user = User::where('user_id', Auth::user()->user_id)->first();
        return view('admin/profile')->with('user', $user);
    }

    public function updateAdminProfile(Request $request)
    {
        $data = $this->validate($request, [
            'email' => ['required', 'string', 'email', 'max:191'],
        ]);

        $user = User::where('user_id', Auth::user()->user_id)->first();

        if ($user['email'] !== $data['email'] && !empty(User::where('email', $data['email'])->first())) {
            return redirect()->back()->withErrors('Email sudah terdaftar');
        }

        $user['email'] = $data['email'];
        $user->save();

        return redirect()->route('admin.change.profile')->with('success', 'Profil berhasil diubah');
    }




    public function changeDosenProfile()
    {
        $user = User::with('dosen')->where('user_id', Auth::user()->user_id)->first();
        return view('dosen/profile')->with('user', $user);
    }

    public function updateDosenProfile(Request $request)
    {
        $data = $this->validate($request, [
            'email' => ['required', 'string', 'email', 'max:191'],
            'dosen_name' => ['required', 'string']
        ]);

        $user = User::where('user_id', Auth::user()->user_id)->first();
        $dosen = Dosen::where('user_id', Auth::user()->user_id)->first();


        if ($user['email'] !== $data['email'] && !empty(User::where('email', $data['email'])->first())) {
            return redirect()->back()->withErrors('Email sudah terdaftar');
        }


        $user['email'] = $data['email'];
        $dosen['dosen_name'] = $data['dosen_name'];

        $user->save();
        $dosen->save();

        return redirect()->route('dosen.change.profile')->with('success', 'Profil berhasil diubah');
    }




    public function memberIndex()
    {
        $team = Mahasiswa::with('team')->where('mahasiswa_nrp', Auth::user()->user_name)->first();
        $members =  Mahasiswa::with('user')->where('mahasiswa_team_id', $team['mahasiswa_team_id'])->get();
        $member_limit = $team['category']['competition_category_team_limit'];

        return view('participants/index')->with([
            'team' => $team['team'],
            'members' => $members,
            'member_limit' => $member_limit
        ]);
    }

    public function memberStore(Request $request)
    {
        $data = $this->validate($request, [
            'mahasiswa_name' => ['required', 'string'],
            'nrp' => ['required', 'alpha_dash', 'unique:App\User,user_name'],
            'email' => ['required', 'string', 'email', 'max:191', 'unique:App\User,email'],
        ]);

        $leader = User::with('team')->find(Auth::user()->user_id);

        Mahasiswa::create([
            'mahasiswa_name' => $data['mahasiswa_name'],
            'mahasiswa_nrp' => $data['nrp'],
            'mahasiswa_team_id' => $leader['team']['team_id'],
            'is_team_leader' => false
        ]);

        User::create([
            'user_name' => $data['nrp'],
            'email' => $data['email'],
            'password' => Hash::make($data['nrp'] . $this->salt),
            'user_role_id' => 2, // Mahasiswa
        ]);

        $success = [
            "Anggota berhasil ditambahkan ke Team {$leader['team']['team_name']}.",
            "Gunakan password : '{$data['nrp']}{$this->salt}' untuk masuk.",
            'Atau ikuti reset password melalui email yang dikirimkan.'
        ];

        try {
            $this->sendResetLinkEmail($request);
        } catch (\Exception $e) {
            array_pop($success);
        }

        return redirect()->route('participants.users.index')->with('success', $success);
    }

    public function memberUpdate(Request $request, $id)
    {
        $data = $this->validate($request, [
            'mahasiswa_name' => ['required', 'string'],
            'nrp' => ['required', 'alpha_dash'],
            'email' => ['required', 'string', 'email', 'max:191'],
        ]);

        $team = Mahasiswa::where('mahasiswa_nrp', Auth::user()->user_name)->first();

        $user = User::where('user_id', $id)->first();
        $mahasiswa = Mahasiswa::where('mahasiswa_nrp', $user['user_name'])->first();


        if ($team['mahasiswa_team_id'] !== $mahasiswa['mahasiswa_team_id']) {
            return redirect('users/create')->withErrors('Maaf kamu tidak berhak');
        };

        $user['user_name'] = $data['nrp'];
        $user['email'] = $data['email'];
        $mahasiswa['mahasiswa_name'] = $data['mahasiswa_name'];
        $mahasiswa['mahasiswa_nrp'] = $data['nrp'];

        $user->save();
        $mahasiswa->save();

        return redirect()->route('participants.users.index')->with('success', 'Data anggota berhasi diubah');
    }

    public function memberDelete($id)
    {
        if (Auth::id() == $id) {
            return redirect()->back()->withErrors('Tidak dapat menghapus diri sendiri');
        }
        $team = Mahasiswa::where('mahasiswa_nrp', Auth::user()->user_name)->first();

        $user = User::where('user_id', $id)->first();
        $mahasiswa = Mahasiswa::where('mahasiswa_nrp', $user['user_name'])->first();

        if ($team['mahasiswa_team_id'] !== $mahasiswa['mahasiswa_team_id']) {
            return redirect('users/create')->withErrors('Maaf kamu tidak berhak');
        };
        if ($mahasiswa['is_team_leader']) {
            return redirect()->back()->withErrors('Ketua tidak dapat dihapus');
        }

        $name = $mahasiswa['mahasiswa_name'];
        $user->delete();
        $mahasiswa->delete();

        return redirect()->route('participants.users.index')->with('success', 'Anggota ' . $name . ' berhasil dihapus dari Tim');
    }

    public function changeParticipantProfile()
    {
        $user = User::with('mahasiswa')->with('team')->where('user_id', Auth::user()->user_id)->first();
        $category = Team::with('category')->where('team_id', $user['team']['team_id'])->first()['category']['competition_category_name'];
        return view('participants/profile')->with(['user' => $user, 'category' => $category, 'canChangeProfile' => $this->canChangeProfile()]);
    }

    public function updateParticipantProfile(Request $request)
    {
        if (!$this->canChangeProfile()) {
            return redirect()->back()->withErrors('Profil tidak dapat diubah');
        }
        $data = $this->validate($request, [
            'email' => ['required', 'string', 'email', 'max:191'],
            'mahasiswa_name' => ['required', 'string'],
            'team_name' => ['required', 'string'],
        ]);

        $user = User::where('user_id', Auth::user()->user_id)->first();
        $mahasiswa = Mahasiswa::where('mahasiswa_nrp', $user['user_name'])->first();
        $team = Team::where('team_id', $mahasiswa['mahasiswa_team_id'])->first();


        if ($user['email'] !== $data['email'] && !empty(User::where('email', $data['email'])->first())) {
            return redirect()->back()->withErrors('Email sudah terdaftar');
        }

        if ($team['team_name'] !== $data['team_name'] && !empty(Team::where('team_name', $data['team_name'])->first())) {
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



    public function changePasswordForm()
    {
        return view('auth/passwords/change');
    }

    public function updatePassword(Request $request)
    {
        $data = $this->validate($request, [
            'old_password' => ['required', 'string'],
            'new_password' => ['required', 'string'],
            'confirmation_new_password' => ['required', 'string']
        ]);

        if ($data['new_password'] !== $data['confirmation_new_password']) {
            return redirect()->back()->withErrors('Konfirmasi password tidak sesuai');
        }

        $user = User::where('user_id', Auth::user()->user_id)->first();

        if (!Hash::check($data['old_password'], $user['password'])) {
            return redirect()->back()->withErrors('Password lama tidak sesuai');
        }

        $user['password'] = $data['new_password'];
        $user->save();

        return redirect()->back()->with('success', 'Password berhasil diubah');
    }

    private function canChangeProfile()
    {
        $sessions = Session::all()->keyBy('session_name');
        $isKti = Mahasiswa::with('category')->where('mahasiswa_nrp', Auth::user()->user_name)->first()['category']['is_kti'];

        if ($isKti) {
            return date("U") <= strtotime($sessions['kti_submit']['session_end']);
        } else {
            return date("U") <= strtotime($sessions['non_kti_submit']['session_end']);
        }
    }
}
