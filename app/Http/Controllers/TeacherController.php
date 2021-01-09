<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Patient;
use App\User;


class TeacherController extends Controller
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
        $teacher = User::find($id);
        return view('teacher.edit', compact('teacher'));
    }

    public function edit_post(Request $request) {
        $teacher = User::find($request->id_teacher);
        $teacher->name = $request->name;
        $teacher->email = $request->email;
        $teacher->save();
        return redirect()->back()->with('message-data', 'Dados atualizados com sucesso!');
    }

    public function edit_password(Request $request) {
        if($request->password == $request->confirm_password) {
            $teacher = User::find($request->id_teacher);
            $teacher->password = Hash::make($request->password);
            $teacher->save();
            return redirect()->back()->with('message-password', 'Senha atualizada com sucesso!');
        }
        return redirect()->back()->with('message-password-error', 'Senhas nao coincidem!');
    }

}
