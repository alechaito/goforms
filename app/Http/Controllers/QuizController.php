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


class QuizController extends Controller
{

    // Quizzes
    public function create(Request $request) {
        $quiz = new Quiz();
        $quiz->id_user = Auth::id();
        $quiz->id_group = $request->id_group;
        $quiz->name = $request->name;
        $quiz->save();
        return redirect()->route('group.preview.view', [$request->id_group, 'quizzes']);     
    }   

    public function delete(Request $request) {
        $quiz = Quiz::find($request->id_quiz);
        $quiz->delete();
        return redirect()->route('group.preview.view', [$request->id_group, 'quizzes']); 
    }

    public function update(Request $request) {
        $quiz = Quiz::find($request->id_quiz);
        $quiz->name = $request->name;
        $quiz->save();
        return redirect()->route('quiz.edit.view', $request->id_quiz); 
    } 

    public function preview($id) {
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

    public function edit($id, $tab) {
        $quiz = Quiz::find($id);
        return view('quiz.edit', compact('quiz', 'tab')); 
    }  

    public function changestatus(Request $request) {
        $quiz = Quiz::find($request->id_quiz);
        $quiz->status = $request->status;
        $quiz->save();
        return redirect()->route('quiz.edit.view', $request->id_quiz); 
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

    public function copy_block($id_quiz, $oldblock) {
        //Copy and create new block with old block
        $block = new Block();
        $block->id_user = $oldblock->id_user;
        $block->id_quiz = $id_quiz;
        $block->name = $oldblock->name;
        $block->question_index = NULL;
        $block->save();

        echo "Bloco antigo foi copiado para o id:".$block->id;
        echo "<hr>";
        
        //Updating index from new quiz
        $newquiz = Quiz::find($id_quiz);
        if($newquiz->block_index != NULL) {
            $indexes = explode(',', $newquiz->block_index);
            array_push($indexes, $block->id);
            DB::table('quizzes')
            ->where('id', $newquiz->id)
            ->update(['block_index' => implode(",", $indexes)]); 
        }
        else {
            DB::table('quizzes')
            ->where('id', $newquiz->id)
            ->update(['block_index' => $block->id]);  
        }

        // Call function to copy questions
        $indexes_qest = explode(',', $oldblock->question_index);
        foreach($indexes_qest as $index_qest) {
            $oldquestion = Question::find($index_qest);
            QuizController::copy_question($block->id, $oldquestion);
        }
        return true;
    }

    public function copy_question($id_block, $oldquestion) {
        // Creating a new question with the new block id
        $question = new Question();
        $question->id_block = $id_block; // new block id send from copy_block
        $question->question = $oldquestion->question;
        $question->type = $oldquestion->type;
        $question->save();

        // 
        if($question->type == 2) {
            //selecting choices to move to new question
            $choice = DB::table('multiple_choices')->where('id_question', $oldquestion->id)->first();
            //Creating choices base on oldquestion to new question
            DB::table('multiple_choices')->insert(
                ['id_question' => $question->id, 'choices' => $choice->choices]
            );
        }
        // Adding the new questions ids to question block indexes
        $block = Block::find($id_block);
        if($block->question_index != NULL) {
            $indexes = explode(',', $block->question_index);
            array_push($indexes, $question->id);
            DB::table('blocks')
            ->where('id', $block->id)
            ->update(['question_index' => implode(",", $indexes)]); 
        }
        else {
            DB::table('blocks')
            ->where('id', $block->id)
            ->update(['question_index' => $question->id]); 
        }
        return true;
    }

    public function move($id, $id_group) {
        $quiz = Quiz::find($id);

        $newquiz = new Quiz();
        $newquiz->id_user = $quiz->id_user;
        $newquiz->id_group = $id_group; //moving to new group
        $newquiz->name = $quiz->name;
        $newquiz->status = 0;
        $newquiz->block_index = NULL;
        $newquiz->save();
        //echo "id novo quiz e:".$newquiz->id;
        //echo "<hr>";
        $blocks = explode(',', $quiz->block_index);
        foreach($blocks as $id_block) {
            $block = Block::find($id_block);
            //echo "Bloco antigo id:".$id_block;
            //echo "<hr>";
            QuizController::copy_block($newquiz->id, $block);
        }

    }

}
