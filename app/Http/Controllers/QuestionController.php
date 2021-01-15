<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Quiz;
use App\Group;
use App\Block;
use App\Category;
use App\Question;
use App\StoreQuestion;
use Illuminate\Support\Facades\DB;
use Auth;


class QuestionController extends Controller
{
    // view the content of the quiz with multiple actions to do
    public function create_get($id) {
        $block = Block::find($id);
        return view('question.create', compact('block')); 
    }

    public function create_choices($question_id, $choices) {
        DB::table('multiple_choices')->insert(
            ['id_question' => $question_id, 'choices' => $choices, 'type' => 0]
        );
    }

    public function get_block_by_id($id_block) {
        return Block::find($id_block);
    }

    // Questions
    public function create_post(Request $request) {
        $question = new Question();
        $question->id_block = $request->id_block;
        $question->question = $request->question;
        $question->type = $request->type;
        $question->save();

        if($question->type == 2) {
            QuestionController::create_choices($question->id, $request->choices);
        }

        $block = QuestionController::get_block_by_id($request->id_block);

        // Refreshing indexes of questions of block
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
        
        return redirect()->back();
    }

    public function delete($id) {
        $question = Question::find($id);
        if($question == NULL) {
            return true;
        }
        $block = Block::find($question->id_block);

        $indexes = explode(',', $block->question_index);
        if (($key = array_search($question->id, $indexes)) !== false) {
            unset($indexes[$key]);
        }

        // refreshing index list
        $block->question_index = implode(",", $indexes);
        $block->save();

        $question->delete();
        return redirect()->back();
    }

    public function delete_all($ids) {
        $indexes = explode('-', $ids);
        foreach($indexes as $idx) {
            QuestionController::delete($idx);
        }
        return redirect()->back();
    }

    public function question_choices($id_question) {
        $choices = DB::table('multiple_choices')->where([
            ['id_question', '=', $id_question]
        ])->first();
        return explode(",", $choices->choices);
    }

    public function preview($id) {
        $question = Question::find($id);
        $block = Block::find($question->id_block);
        $content = "";
        
        if($question->type == 1) {
            $content = "<input type='text' class='form-control'>
            (somente letras permitidas)";
        }
        elseif($question->type == 2) {
            $choices = QuestionController::question_choices($question->id);
            $content = "Selecione uma alternativa:
            <ul style='list-style-type:none;'>";
            foreach($choices as $choice) {
                if($choice != "") {
                    $content .= "<li><input type='radio'>".$choice."</li>";
                }
            }
            $content .= "</ul>";
        }
        elseif($question->type == 3) {
            $content = "<input type='text' class='form-control'>
            (somente numeros permitidos)";
        }
        elseif($question->type == 4) {
            $content = " Selecione uma alternativa:
            <ul style='list-style-type:none;'>
                <li><input type='radio'> Sim</li>
                <li><input type='radio'> Nao</li>
            </ul>";
        }

        return ['question' => $question->question, 'content' => $content];
    }

    public function move($id) {
        $question = Question::find($id);
        $block = Block::find($question->id_block);

        $storequestion = new StoreQuestion();
        $storequestion->id_user = $block->id_user;
        $storequestion->question = $question->question;
        $storequestion->type = $question->type;
        // Searching if have category with same name of block
        $category = DB::table('categories')->where('name', $block->name)->first();
        if($category == NULL) { //not find, need create
            $category = new Category();
            $category->id_user = $block->id_user;
            $category->name = $block->name;
            $category->save();
        }
        $storequestion->id_category = $category->id;
        $storequestion->save();
        //return redirect()->back();
    }

    public function edit_get($id) {
        $question = Question::find($id);
        $block = Block::find($question->id_block);
        return view('question.edit', compact('block', 'question')); 
    }

    public function edit_post(Request $request) {
        $block = Block::find($request->id_block);
       
        $question = Question::find($request->id_question);
        $question->question = $request->question;
        if($question->id_block != $request->id_block) { //need to be updated
            $question->id_block = $newblock->id;
            // Removing index of old block
            $block = Block::find($question->id_block);
            $indexes = explode(',', $block->question_index);

            if (($key = array_search($question->id, $indexes)) !== false) {
                unset($indexes[$key]); // removing from old
                $block->question_index = implode(",", $indexes); // refreshing index
                $block->save();
            }
            // Refreshing indexes of questions of the new block
            $newblock = Block::find($request->id_block);

            if($newblock->question_index != NULL) {
                $indexes = explode(',', $newblock->question_index);
                array_push($indexes, $question->id);
                DB::table('blocks')
                ->where('id', $newblock->id)
                ->update(['question_index' => implode(",", $indexes)]); 
            }
            else {
                DB::table('blocks')
                ->where('id', $newblock->id)
                ->update(['question_index' => $question->id]); 
            }
        }
        $question->save();

        $block = Block::find($question->id_block);
        return view('question.edit', compact('block', 'question')); 
    }

    public function update_index($id_question, $type) {
        $question = Question::find($id_question);
        $block = Block::find($question->id_block);

        // Generate first index of questions
        if($block->question_index == NULL) {
            $indexes = Question::where('id_block', $block->id)->get()->pluck('id')->toArray();
            DB::table('blocks')
                ->where('id', $block->id)
                ->update(['question_index' => implode(",", $indexes)]); 
        }
        //Getting block again updated
        $block = Block::find($question->id_block);

        if($type == 0) { //move question up
            $indexes = explode(',', $block->question_index);
            $index_question = array_search($question->id, $indexes);
            if($index_question != 0) {
                $aux_old = $indexes[$index_question - 1]; // aux to storage old value of index
                $indexes[$index_question - 1] = $indexes[$index_question]; // moving question to new index
                $indexes[$index_question] = $aux_old; // moving old value to new index
            }
        }
        else { //move question down
            $indexes = explode(',', $block->question_index);
            $index_question = array_search($question->id, $indexes);
            
            if($index_question < sizeof($indexes)-1 ) {
                $aux_old = $indexes[$index_question + 1]; // aux to storage old value of index
                $indexes[$index_question + 1] = $indexes[$index_question]; // moving question to new index
                $indexes[$index_question] = $aux_old; // moving old value to new index
            }
        }

        DB::table('blocks')
                ->where('id', $block->id)
                ->update(['question_index' => implode(",", $indexes)]); 

        $questions = Question::where('id_block', $block->id)->get();
        return redirect()->back();
        
    }


}
