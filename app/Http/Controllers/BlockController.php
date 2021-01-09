<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Quiz;
use App\Group;
use App\Block;
use App\Question;
use Illuminate\Support\Facades\DB;
use Auth;


class BlockController extends Controller
{

    // Blocks

    public function create(Request $request) {
        $block = new Block();
        $block->id_user = Auth::id();
        $block->id_quiz = $request->id_quiz;
        $block->name = $request->name;
        $block->save();

        $quiz = Quiz::find($request->id_quiz);
        if($quiz->block_index != NULL) {
            $indexes = explode(',', $quiz->block_index);
            array_push($indexes, $block->id);
            DB::table('quizzes')
            ->where('id', $request->id_quiz)
            ->update(['block_index' => implode(",", $indexes)]); 
        }
        else {
            DB::table('quizzes')
            ->where('id', $request->id_quiz)
            ->update(['block_index' => $block->id]);  
        }
        return redirect()->route('quiz.edit.view', $request->id_quiz); 
    }


    public function delete($id) {
        $block = Block::find($id);
        if($block == NULL) {
            return redirect()->back();
        }
        $quiz = Quiz::find($block->id_quiz);

        $indexes = explode(',', $quiz->block_index);
        if (($key = array_search($block->id, $indexes)) !== false) {
            unset($indexes[$key]);
        }
        // refreshing index list
        $quiz->block_index = implode(",", $indexes);
        $quiz->save();

        //deleting questions of blocks
        DB::table('questions')
            ->where('id_block', $block->id)->delete();

        $block->delete();
        return redirect()->back();
    }

    public function delete_all($ids) {
        $indexes = explode('-', $ids);
        foreach($indexes as $idx) {
            BlockController::delete($idx);
        }
        return redirect()->back();
    }

    public function update_name(Request $request) {
        $block = Block::find($request->id_block);
        $block->name = $request->name;
        $block->save();
        return redirect()->route('block.edit.view', $request->id_block); 
    } 

    public function preview($id) {
        $block = Block::find($id);
        //$question = Question::where('id_block', $id)->first();
        //$question_model::where('id_block', $block->id)->get();
        return view('block.preview', compact('block')); 
    } 

    // View block and many actions included
    public function view_get($id) {
        $block = Block::find($id);
        $questions = Question::where('id_block', $id)->get();
        return view('block.view', compact('block', 'questions')); 
    } 

    public function preview_block_question($id_block, $id_question) {
        $block = Block::find($id_block);
        $question = Question::find($id_question);
        return view('block.preview', compact('block', 'question')); 
    }

    public function update_index(Request $request) {
        $quiz = Quiz::find($request->id_quiz);
        // Generate first index of questions
        if($quiz->block_index == NULL) {
            $indexes = Block::where('id_quiz', $quiz->id)->get()->pluck('id')->toArray();
            DB::table('quizzes')
                ->where('id', $quiz->id)
                ->update(['block_index' => implode(",", $indexes)]); 
        }
        $quiz = Quiz::find($request->id_quiz);
        if($request->type == 0) { //move question up
            $indexes = explode(',', $quiz->block_index);
            $index_block = array_search($request->id_block, $indexes);
            if( $index_block != 0) {
                $aux_old = $indexes[ $index_block - 1]; // aux to storage old value of index
                $indexes[ $index_block - 1] = $indexes[ $index_block]; // moving question to new index
                $indexes[ $index_block] = $aux_old; // moving old value to new index
            }
        }
        else { //move question down
            $indexes = explode(',', $quiz->block_index);
            $index_block = array_search($request->id_block, $indexes);
            
            if( $index_block< sizeof($indexes)-1 ) {
                $aux_old = $indexes[ $index_block + 1]; // aux to storage old value of index
                $indexes[$index_block + 1] = $indexes[$index_block]; // moving question to new index
                $indexes[$index_block] = $aux_old; // moving old value to new index
            }
        }

        // updating quiz where the block indexes are stored to change order
        DB::table('quizzes')
                ->where('id', $quiz->id)
                ->update(['block_index' => implode(",", $indexes)]); 

        return redirect()->route('quiz.edit.view', $quiz->id); 
        
    }

}
