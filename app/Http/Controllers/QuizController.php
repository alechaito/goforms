<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Quiz;
use App\Group;
use App\Block;
use App\Patient;
use App\Question;
use Illuminate\Support\Facades\DB;
use Auth;

use Symfony\Component\HttpFoundation\StreamedResponse;


class QuizController extends Controller
{

    // Quizzes
    public function create(Request $request) {
        $quiz = new Quiz();
        $quiz->id_user = Auth::id();
        $quiz->id_group = $request->id_group;
        $quiz->name = $request->name;
        $quiz->save();
        return redirect()->route('group.view.get', $request->id_group);     
    }   

    public function delete(Request $request) {
        $quiz = Quiz::find($request->id_quiz);
        $quiz->delete();
        return redirect()->route('group.view.get', $request->id_group); 
    }

    public function edit_get($id) {
        $quiz = Quiz::find($id);
        return view('quiz.edit', compact('quiz')); 
    } 

    public function chart_get($id_quiz) {
        $quiz = Quiz::find($id_quiz);
        return view('quiz.chart', compact('quiz'));   
        #$result = QuizController::count_data_text($id_quiz);
    }

    public function get_data_multiple_choices($id_quiz) {
        return DB::table('quizzes')
        ->join('blocks', 'blocks.id_quiz', '=', 'quizzes.id')
        ->join('questions', 'questions.id_block', '=', 'blocks.id')
        ->join('multiple_choices', 'multiple_choices.id_question', '=', 'questions.id')
        ->where('quizzes.id', $id_quiz)
        ->where('questions.type', 2)
        ->get();
    }

    public function get_data_text($id_quiz) {
        return DB::table('quizzes')
        ->join('blocks', 'blocks.id_quiz', '=', 'quizzes.id')
        ->join('questions', 'questions.id_block', '=', 'blocks.id')
        ->where('quizzes.id', $id_quiz)
        ->get();
    }

    public function count_data_text($id_quiz) {
        $datas = QuizController::get_data_text($id_quiz);
        $stack = array();

        foreach($datas as $data) {
            if($data->type == 1 or $data->type == 3) {
                $choices = DB::table('evaluates')
                ->select('question_response')
                ->where('question_id', $data->id)
                ->distinct()
                ->get();
                $qest_data_aux = array();
                foreach($choices as $choice) {
                    $count = DB::table('evaluates')
                    ->where('question_id', $data->id)
                    ->where('question_response', $choice->question_response)
                    ->count();
                    array_push($qest_data_aux, array(
                            'question' => $data->question, 
                            'id_question' => $data->id, 
                            'choice' => $choice->question_response, 
                            'total' => $count
                        )
                    );
                }
                array_push($stack, $qest_data_aux);
            }
        }
        return $stack;
    }

    public function count_data_multiple_choices($id_quiz) {
        $datas = QuizController::get_data_multiple_choices($id_quiz);
        $stack = array();

        foreach($datas as $data) {
            $choices = QuestionController::question_choices($data->id_question);
            $qest_data_aux = array();
            foreach($choices as $choice) {
                $count = DB::table('evaluates')
                ->where('question_id', $data->id_question)
                ->where('question_response', $choice)
                ->count();
                array_push($qest_data_aux, array(
                        'question' => $data->question, 
                        'id_question' => $data->id_question, 
                        'choice' => $choice, 
                        'total' => $count
                    )
                );
            }
            array_push($stack, $qest_data_aux);
        }
        return $stack;
    }

    public function make_data_for_choice($data) {
        $opts = array();
        $totals = array();
        foreach($data as $each) {
            $opt = $each['choice'];
            $total = $each['total'];
            array_push($opts, $opt);
            array_push($totals, $total);
        }
        $totals = json_encode($totals);
        $graph_key = $data[0]['id_question'];
        $question = $data[0]['question'];

        return array($totals, $graph_key, $question, $opts);
    }

    public function make_data_for_text($data) {
        $opts = array();
        $totals = array();
        foreach($data as $each) {
            $opt = $each['choice'];
            $total = $each['total'];
            array_push($opts, $opt);
            array_push($totals, $total);
        }
        $totals = json_encode($totals);
        $graph_key = $data[0]['id_question'];
        $question = $data[0]['question'];

        return array($totals, $graph_key, $question, $opts);
    }


    public function chart_get_data($id_quiz) {
        return DB::table('evaluates')
        ->join('patients', 'evaluates.patient_id', '=', 'patients.id')
        ->where('quiz_id', $id_quiz)
        ->select('patient_id', 'age', 'sex')
        ->distinct('patient_id')
        ->get();
    }

    public function export_csv($id_quiz){
        $evaluates = DB::table('evaluates')->where('quiz_id', $id_quiz)->get();
        $filename = 'avaliacoes.csv';

        $headers = array(
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$filename",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        );

        $columns = array('Questao', 'Resposta');

        $callback = function() use($evaluates, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($evaluates as $evaluate) {
                $row['Questao']  = $evaluate->question_name;
                $row['Resposta'] = $evaluate->question_response;;

                fputcsv($file, array($row['Questao'], $row['Resposta']));
            }

            fclose($file);
        };

        return (new StreamedResponse($callback, 200, $headers))->sendContent();
    }

    public function export_get($id) {
        $quiz = Quiz::find($id);
        return view('quiz.export', compact('quiz')); 
    } 

    // Function to edit settings of a quiz
    public function edit_post(Request $request) {
        $quiz = Quiz::find($request->id_quiz);
        $quiz->name = $request->name;
        $quiz->save();
        return redirect()->route('quiz.edit.get', $request->id_quiz); 
    } 

    // Function to display view from analyze quiz
    public function analyze_get($id) {
        $quiz = Quiz::find($id);
        return view('quiz.analyze', compact('quiz')); 
    } 

    // view the quiz in our end result
    public function preview_get($id) {
        $quiz = Quiz::find($id);
        $blocks = array();

        // Getting blocks from quiz
        if($quiz->block_index != NULL) {
            $indexes_block = explode(',', $quiz->block_index);
            foreach($indexes_block as $idx) {
                $block = Block::find($idx);
                if($block != NULL) {

                    array_push($blocks, $block);
                }
            }
        }

        return view('quiz.preview', compact('quiz', 'blocks')); 
    }  

    // view the content of the quiz with multiple actions to do
    public function view_get($id) {
        $quiz = Quiz::find($id);
        return view('quiz.view', compact('quiz')); 
    }  

    public function quiz_apply($id) {
        $quiz = Quiz::find($id);
        $patients = Patient::All();
        $array = array();
        foreach($patients as $patient) {
            array_push($array, $patient->name);
        }

        $indexes_block = explode(',', $quiz->block_index);

        return view('quiz.apply', compact('quiz', 'array', 'indexes_block')); 
    }


}
