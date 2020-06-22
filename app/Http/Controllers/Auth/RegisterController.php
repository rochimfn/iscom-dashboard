<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\User;
use App\Mahasiswa;
use App\Team;
use App\CompetitionCategory;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Override default Show the application registration form.
     *
     * @return \Illuminate\View\View
     */
    public function showRegistrationForm()
    {
        $competitionCategories = CompetitionCategory::all();
        return view('auth.register')->with('competitionCategories', $competitionCategories);
    }

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'user_name' => ['required', 'alpha_dash', 'max:255', 'unique:App\User,user_name'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:App\User,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'mahasiswa_name' => ['required', 'string'],
            'team_name' => ['required', 'string', 'unique:App\Team,team_name'],
            'competition_category' => ['required', 'string']
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        $category = CompetitionCategory::where('competition_category_abbreviation', $data['competition_category'])->first();

        $team = Team::create([
           'team_name' => $data['team_name'],
           'team_competition_category_id' => $category->competition_category_id
        ]);
        $team->save();

        Mahasiswa::create([
            'mahasiswa_name' => $data['mahasiswa_name'],
            'mahasiswa_nrp' => $data['user_name'],
            'mahasiswa_team_id' => $team->team_id,
            'is_team_leader' => true
        ]);

        return User::create([
            'user_name' => $data['user_name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'user_role_id' => 2, // Mahasiswa
        ]);
    }
}
