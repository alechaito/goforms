<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Patient;
use App\Quiz;
use App\Block;
use Illuminate\Support\Facades\DB;  

class PatientController extends Controller
{
    public function create_post(Request $request) {
        
        $patient = new Patient();
        $patient->name = $request->name;
        $patient->document = $request->document;
        $patient->age = $request->age;
        $patient->sex = $request->sex;
        $patient->save();

        return redirect()->route('patient.create.get');    
    }

    public function create_get() {
        return view('patient.create');   
    }

    public function evaluate_get($id_patient, $id_quiz) {
        $patient = Patient::find($id_patient);
        $quiz = Quiz::find($id_quiz);

        return view('patient.evaluate', compact('patient', 'quiz'));   
    }

    public function evaluate_post(Request $request) {
        $quiz = Quiz::find($request->id_quiz);
        // select all questions from each block
        $infos = DB::table('blocks')
            ->join('questions', 'questions.id_block', '=', 'blocks.id')
            ->where('id_quiz', $request->id_quiz)
            ->get();
        
        // inserting values in database based on input fields
        foreach($infos as $info) {
            DB::table('evaluates')->insert(
                [
                    'block_name' => $info->name, 
                    'question_name' => $info->question, 
                    'question_type' => $info->type,
                    'question_response' => $request->input($info->id),
                    'patient_id' => $request->id_patient,
                    'quiz_id' => $request->id_quiz
                ]
            );
        }
        return view('quiz.view', compact('quiz')); 
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

    // FIND PATIENT API - ajax return
    // receive id from quiz to evaluate patient
    public function find_get($id_quiz) {
        $patients = DB::table('patients')->get();
        $list = array('data' => array());

        foreach($patients as $patient) {
            $name = "
                <a href='".route('patient.edit.view', $patient->id)."'>
                    ".$patient->name." <i class='fa fa-eye'></i>
                </a>
            ";
            $evaluate = "
                <a href='".route('patient.evaluate.get', [$patient->id, $id_quiz])."'>
                    <button class='btn btn-secondary'>Avaliar</button>
                </a>
            ";
            array_push($list['data'], array($name, $patient->age, $patient->document, $evaluate));  
        }
        return json_encode($list);
    }

}
