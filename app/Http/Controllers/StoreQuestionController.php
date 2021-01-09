<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Quiz;
use App\Group;
use App\Block;
use App\Question;
use App\StoreQuestion;
use Illuminate\Support\Facades\DB;
use Auth;


class StoreQuestionController extends Controller
{

    // Questions
    public function create(Request $request) {
        $question = new StoreQuestion();
        $question->id_user = Auth::id();
        $question->id_category = $request->id_category;
        $question->question = $request->question;
        $question->type = $request->type;
        $question->save();

        // 
        if($request->type == 2) {
            //Choices query
            DB::table('multiple_choices')->insert(
                ['id_question' => $question->id, 'choices' => $request->choices, 'type' => 1]
            );
        }
        return redirect()->route('home', 'storequestions');
    }

    public function create_category(Request $request) {
        DB::table('categories')->insert(
            ['id_user' => Auth::id(), 'name' => $request->name]
        );
        
        return view('storequestion.category');
    }


    public function delete($id) {
        $question = StoreQuestion::find($id);
        $question->delete();
        return redirect()->route('home', 'storequestions');
    }

    public function category_delete($id) {
        DB::table('categories')->where('id', $id)->delete();
        return view('storequestion.category'); 
    }

    public function preview($id) {
        $question = StoreQuestion::find($id);
        return view('storequestion.preview', compact('question')); 
    }

    public function edit($id) {
        $question = StoreQuestion::find($id);
        return view('storequestion.edit', compact('question')); 
    }

    public function category_view() {
        return view('storequestion.category'); 
    }

    public function edit_post(Request $request) {
        $question = StoreQuestion::find($request->id_question);
        $question->id_category = $request->id_category;
        $question->question = $request->question;
        $question->save();

        if($question->type == 2) {
            //Choices query
            DB::table('multiple_choices')->insert(
                ['id_question' => $question->id, 'choices' => $request->choices, 'type' => 1]
            );
            DB::table('multiple_choices')
              ->where('id_question', $question->id)
              ->update(['choices' => $request->choices]);
        }
        return redirect()->back(); 
    }

    public function copy($id) {
        $question = StoreQuestion::find($id);
        $new_qest = new StoreQuestion();
        $new_qest->id_user = Auth::id();
        $new_qest->id_category = $question->id_category;
        $new_qest->question = $question->question;
        $new_qest->type = $question->type;
        $new_qest->save();

        // 
        if($new_qest->type == 2) {
            //Choices query
            DB::table('multiple_choices')->insert(
                ['id_question' => $new_qest->id, 'choices' => $request->choices, 'type' => 1]
            );
        }
        return redirect()->route('home', 'storequestions');
    }

    // Table data for storequestion.home view
    public function tabledata($questions, $list) {

        foreach($questions as $qest) {
            $checkbox = "<input class='delete-storequestion' value='".$qest->id."' type='checkbox'>";
            $category = DB::table('categories')->where('id', $qest->id_category)->first();
            $name = "<a href='".route('storequestion.edit.get', $qest->id)."'>
                    ".$qest->question." <i class='fa fa-eye'></i>
                </a>";
            $actions = "
                <a href='".route('storequestion.preview', $qest->id)."'>
                    <i class='fa fa-search'></i>
                </a>
                <a href='".route('storequestion.copy', $qest->id)."'>
                    <i class='fa fa-copy'></i>
                </a>
                <a id='".$qest->id."' href='#' onclick='delete_storequestion(this)'>
                    <i class='fa fa-times'></i>
                </a>
            ";
            $user = Auth::User()->find($qest->id_user);
            $date = date('d-m-y h:m:s', strtotime($qest->created_at));
            $info_created = $user->name."</br> <font color='gray' size='2px'>".$date."</font>";
            array_push($list['data'], array($checkbox, $name, $info_created, $category->name ?? '', $actions));
        }
        return $list;
    }


    // Mounting table data to show in block
    // Include a store question to block
    public function tabledata_block($questions, $list, $id_block) {
        foreach($questions as $qest) {
            $checkbox = "<input id='".$id_block."' class='move-storequestion' value='".$qest->id."' type='checkbox'>";
            $category = DB::table('categories')->where('id', $qest->id_category)->first();
            $user = Auth::User()->find($qest->id_user);
            if($qest->type == 1) {
                $type = "texto";
            }
            elseif($qest->type == 2) {
                $type = "multipla escolha";
            }
            elseif($qest->type == 3) {
                $type = "numerico";
            }
            else {
                $type = "sim/nao";
            }
            $name = "<a href='".route('storequestion.edit.get', $qest->id)."' target='_blank'>
                    ".$qest->question." <i class='fa fa-eye'></i>
                </a>";
            $actions = "
                <a href='".route('storequestion.move', [$qest->id, $id_block])."'>
                    <i class='fa fa-plus'></i>
                </a>   
            ";
            array_push($list['data'], array($checkbox, $name, $user->name, $category->name ?? '', $actions));
        }
        return $list;
    }

    public function search_storequestion() {
        $questions = DB::table('group_participants')
        ->join('store_questions', 'group_participants.id_participant', '=', 'store_questions.id_user')
        ->select('store_questions.*')
        ->distinct()->get();

        $list = array('data' => array());

        $list = StoreQuestionController::tabledata($questions, $list);
        
        return json_encode($list);
    }

    // Return table data of store questions to insert in a block
    public function search_storequestion_block($id_block) {
        $questions = DB::table('group_participants')
        ->join('store_questions', 'group_participants.id_participant', '=', 'store_questions.id_user')
        ->select('store_questions.*')
        ->distinct()->get();

        $list = array('data' => array());

        $list = StoreQuestionController::tabledata_block($questions, $list, $id_block);
        
        return json_encode($list);
    }



    public function tablecategory($categories, $list) {
        foreach($categories as $category) {
            $actions = "
                <a href='".route('storequestion.category.delete', $category->id)."'>
                    <i class='fa fa-times'></i>
                </a>
             ";
            array_push($list['data'], array($category->name, $actions));
        }
        return $list;
    }


    public function search_categories() {
        $categories = DB::table('group_participants')
        ->join('categories', 'group_participants.id_participant', '=', 'categories.id_user')
        ->select('categories.name', 'categories.id')
        ->distinct()->get();

        $list = array('data' => array());

        //Old query
        //$categories = DB::table('categories')->where('id_user', Auth::id())->orderByRaw('name ASC')->get();

        $list = StoreQuestionController::tablecategory($categories, $list);

        return json_encode($list);
    }

    // Add store question to block
    // Receiving id storequestion and id block
    public function move($id, $id_block) {
        $storequestion = StoreQuestion::find($id);
        if($storequestion == NULL) {
            return redirect()->back();
        }

        $question = new Question();
        $question->id_block = $id_block;
        $question->question = $storequestion->question;
        $question->type = $storequestion->type;
        $question->save();

        // 
        if($storequestion->type == 2) {
            //Choices query
            $choice =  DB::table('multiple_choices')
                        ->where('id_question', $storequestion->id)
                        ->first();
            DB::table('multiple_choices')->insert(
                [
                    'id_question' => $question->id, 
                    'choices' => $choice->choices, 
                    'type' => 0
                ]
            );
        }

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
        
        return redirect()->back();
    }

    public function move_all($ids, $id_block) {
        $indexes = explode('-', $ids);
        foreach($indexes as $idx) {
            StoreQuestionController::move($idx, $id_block);
        }
        return redirect()->back();
    }

}
