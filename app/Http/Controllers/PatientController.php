<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Patient;
use App\Quiz;
use App\Block;
use App\Http\Controllers\QuestionController;
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
            $response = $request->input($info->id);
            if($response != NULL) {
                if($info->type == 2 ) {
                    $choices = QuestionController::question_choices($info->id);
                    $response = $choices[$response];
                }
                DB::table('evaluates')->insert(
                    [
                        'question_id' => $info->id, 
                        'question_name' => $info->question, 
                        'question_response' => $response,
                        'patient_id' => $request->id_patient,
                        'quiz_id' => $request->id_quiz
                    ]
                );
            }
        }
        return view('quiz.view', compact('quiz')); 
    }

    public function search_get($id_quiz) {
        $quiz = Quiz::find($id_quiz);
        return view('patient.search', compact('quiz')); 
    }

    public function edit_all_get() {
        return view('patient.all');
    }

    public function edit_get($id) {
        $patient = Patient::find($id);
        return view('patient.edit', compact('patient'));
    }

    public function edit_post(Request $request) {
        $patient = Patient::find($request->id_patient);
        $patient->name = $request->name;
        $patient->document = $request->document;
        $patient->age = $request->age;
        $patient->sex = $request->sex;
        $patient->save();
        return view('patient.edit', compact('patient'));
    }

    public function delete_get($id) {
        $patient = Patient::find($id);
        $patient->delete();
        return redirect()->route('home');  
    }


    public function make_table_evaluate($id_quiz) {
        $patients = DB::table('patients')->get();
        $list = array('data' => array());

        foreach($patients as $patient) {
            $name = "
                <a href='".route('patient.edit.get', $patient->id)."'>
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

    public function make_table_edit() {
        $patients = DB::table('patients')->get();
        $list = array('data' => array());

        foreach($patients as $patient) {
            $name = "
                <a href='".route('patient.edit.get', $patient->id)."'>
                    ".$patient->name." <i class='fa fa-eye'></i>
                </a>
            ";
            array_push($list['data'], array($name, $patient->age, $patient->document));  
        }
        return json_encode($list);
    }

}
