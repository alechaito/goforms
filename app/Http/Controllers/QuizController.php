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

    public function chart_get($id) {
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

        return view('quiz.chart', compact('quiz', 'blocks')); 
    }

    public function get_data_chart($id_quiz,  $id_question) {
        return DB::table('quizzes')
        ->join('blocks', 'blocks.id_quiz', '=', 'quizzes.id')
        ->join('questions', 'questions.id_block', '=', 'blocks.id')
        ->where('quizzes.id', $id_quiz)
        ->where('questions.id',  $id_question)
        ->first();
    }

    public function count_data_chart($id_quiz, $id_question) {
        $data = QuizController::get_data_chart($id_quiz,  $id_question);
        $stack = array();
   
        $keys = DB::table('evaluates')
        ->select('question_response')
        ->where('question_id', $data->id)
        ->distinct()
        ->get(); # [a,b,c]

        $x_axis = array();
        $y_axis = array();
        foreach($keys as $key) {
            $count = DB::table('evaluates')
            ->where('question_id', $data->id)
            ->where('question_response', $key->question_response)
            ->count();
            array_push($x_axis, $key->question_response);
            array_push($y_axis, $count);
        }
        
        return array($x_axis, $y_axis);
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
