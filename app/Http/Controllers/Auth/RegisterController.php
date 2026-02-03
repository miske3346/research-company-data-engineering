<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Ville;
use App\Organisation;
use App\Donneur;
use App\Group;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;

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
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/blood';

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
         * Show the application registration form.
         *
         * @return \Illuminate\Http\Response
         */
        public function showRegistrationForm()
        {
            $villes = Ville::whereNull('parent_id')->with('childs')->get();
            $groups = Group::all();

            return view('auth.register', compact(['villes','groups']));

        }

        public function register(Request $request) {
        
            $fileName = null;
            if (request()->hasFile('ri7ab')) {
                $file = request()->file('ri7ab');
                $fileName = md5($file->getClientOriginalName() . time()) . "." . $file->getClientOriginalExtension();
                $file->move(public_path('/storage/users'), $fileName);
            }

            dd($fileName);
            
            // Prepare Linear User Values :p
            $data = [
                'phone' => $request['phone'],
                'role' => $request['role'],
                'picture' => $fileName,
                'password' => Hash::make($request['password'])
            ];

            if($request['role'] == 'don') {

                // Append the Final Name value :p
                $data['name'] = $request['first_name'].' '.$request['last_name'];

                $user = User::create($data);

                $doner = Donneur::create([
                    'prenom' => $request['first_name'],
                    'nom' => $request['last_name'],
                    'nni' => 2021,
                    'gender' => $request['sex'],
                    'group_id' => $request['blood'],
                    'date_naissance' => $request['birth_date'],
                    'place_naissance' => $request['birth_place'],
                    'contact_methode' => $request['contact_method'],
                    'contact_time' => $request['contact_time'],
                    'user_id' => $user->id
                ]);

            }elseif($request['role'] == 'org'){

                // Append the Final Name value :)
                $data['name'] = $request['societe_nom'];

                $user = User::create($data);

                $org = Organisation::create([
                    'titre' => $data['name'],
                    'nif' => $request['nif'],
                    'description' => $request['about'],
                    'address' => $request['address'],
                    'ville_id' => $request['location'],
                    'user_id' => $user->id
                ]);
               
            }

            return redirect('/blood');

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
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'integer', 'unique:users'],
            'ri7ab' => 'required|image|mimes:jpg,jpeg,png,gif',
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
/*

    protected function create(array $data)
    {
        
        if($data['role'] == 'don'){
            $data['name'] = $data['first_name'].' '.$data['last_name'];
        }
        else if($data['form'] == 'org'){
            $data['name'] = $data['titre']; 
        }

        return User::create([
            'name' => $data['name'],
            'phone' => $data['phone'],
            'password' => Hash::make($data['password']),
        ]);

    }
    */
}
