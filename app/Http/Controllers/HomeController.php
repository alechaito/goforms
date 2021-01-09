<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home'); 
    }

    public function logout() {
        Auth::Logout();
        return redirect()->back();
    }

    // Search participants based on group 
    public function search_allusers() {
        $users = DB::table('users')->get();
        $list = array('data' => array());

        foreach($users as $user) {
            if($user->role  == 0) {
                $name = "
                    <a href='".route('teacher.edit.view', $user->id)."'>
                        ".$user->name." <i class='fa fa-eye'></i>
                    </a>
                ";
                array_push($list['data'], array($name, $user->email, 'Professor'));
            }
            else {
                $name = "
                    <a href='".route('student.edit.view', $user->id)."'>
                        ".$user->name." <i class='fa fa-eye'></i>
                    </a>
                ";
                array_push($list['data'], array($name, $user->email, 'Estudante'));  
            }
        }

        return json_encode($list);
    }

    public function search_allpatients() {
        $patients = DB::table('patients')->get();
        $list = array('data' => array());

        foreach($patients as $patient) {
            $name = "
                <a href='".route('patient.edit.view', $patient->id)."'>
                    ".$patient->name." <i class='fa fa-eye'></i>
                </a>
            ";
            array_push($list['data'], array($name));  
        }
        return json_encode($list);
    }

    public function back() {
        return redirect()->back();
    }

    public function manifest() {
        return true;
    }

}
