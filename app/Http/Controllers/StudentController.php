<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Patient;
use App\User;


class StudentController extends Controller
{
    public function create(Request $request) {
        
        $patient = new Patient();
        $patient->name = $request->name;
        $patient->birthday = $request->birthday;
        $patient->age = $request->age;
        $patient->sex = $request->sex;
        $patient->save();

        return redirect()->route('patient.create.view');    
    }

    public function edit($id) {
        $student = User::find($id);
        return view('student.edit', compact('student'));
    }

    public function edit_post(Request $request) {
        $student = User::find($request->id_student);
        $student->name = $request->name;
        $student->email = $request->email;
        $student->save();
        //return view('student.edit', compact('student'));
        return redirect()->back()->with('message-data', 'Dados atualizados com sucesso!');
    }

    public function edit_password(Request $request) {
        if($request->password == $request->confirm_password) {
            $student = User::find($request->id_student);
            $student->password = Hash::make($request->password);
            $student->save();
            return redirect()->back()->with('message-password', 'Senha atualizada com sucesso!');
        }
        return redirect()->back()->with('message-password-error', 'Senhas nao coincidem!');
    }


    public function delete($id) {
        $student = User::find($id);
        $student->delete();
        return redirect()->back();
    }

}
