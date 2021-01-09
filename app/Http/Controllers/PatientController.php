<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Patient;
use Illuminate\Support\Facades\DB;  

class PatientController extends Controller
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
        $patient = Patient::find($id);
        return view('patient.edit', compact('patient'));
    }

    public function edit_post(Request $request) {
        $patient = Patient::find($request->id_patient);
        $patient->name = $request->name;
        $patient->birthday = $request->birthday;
        $patient->age = $request->age;
        $patient->sex = $request->sex;
        $patient->save();
        return view('patient.edit', compact('patient'));
    }

    public function delete($id) {
        $patient = Patient::find($id);
        $patient->delete();
        return redirect()->back();
    }

    public function search_patients() {
        $patients = DB::table('patients')->orderByRaw('name ASC')->get();
        $list = array('data' => array());

        foreach($patients as $patient) {
            $actions = "
                <a href='".route('storequestion.category.delete', $patient->id)."'>
                    <i class='fa fa-times'></i>
                </a>
             ";
            array_push($list['data'], array($patient->name, $actions));
        }
        return json_encode($list);
    }

}
