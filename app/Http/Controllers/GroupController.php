<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Group;
use App\Patient;
use App\Quiz;
use Auth;
use Illuminate\Support\Facades\DB;

class GroupController extends Controller
{
    public function create(Request $request) {
        
        $group = new Group();
        $group->id_user = Auth::id();
        $group->name = $request->name;
        $group->resume = $request->resume;
        $group->save();

        /*
        Role 0 - teacher
        Role 1 - student
        Role 2 - patient
        */
        DB::table('group_participants')->insert(
            ['id_group' => $group->id, 'id_participant' => $group->id_user, 'role' => Auth::User()->role]
        );

        return redirect()->back();    
    }

    public function edit(Request $request) {
        
        $group = Group::find($request->id_group);
        $group->name = $request->name;
        $group->resume = $request->resume;
        $group->save();

        return redirect()->back();    
    }

    public function preview($id) {
        $group = Group::find($id);
        return view('group.preview', compact('group')); 
    }  

    public function delete($id) {
        $group = Group::find($id);
        if($group == NULL) {
            redirect()->back();
        }
        $group->delete();
        DB::table('group_participants')->where('id_group', $id)->delete();
        return redirect()->back();
    }

    public function delete_all($ids) {
        $indexes = explode('-', $ids);
        foreach($indexes as $idx) {
            GroupController::delete($idx);
        }
        return redirect()->back();
    }

    public function delete_participant($id) {
        $x = DB::table('group_participants')
        ->where('id', $id)
        ->delete();
        var_dump($x);
        //return redirect()->back();
    }  

    public function insert_participant($id_group, $id_participant, $id_role) {
        $participant = DB::table('group_participants')
        ->where('id_group', $id_group)
        ->where('id_participant', $id_participant)
        ->where('role', $id_role)->first();
        
        if($participant == NULL) {
            DB::table('group_participants')->insert(
                ['id_group' => $id_group, 'id_participant' => $id_participant, 'role' => $id_role]
            );
        }
        return redirect()->back();
    }

    public static function quizzes($id_group) {
        return DB::table('quizzes')
            ->where('id_group', $id_group)
            ->orderByRaw('name ASC')
            ->get();
    }

    public function add_user(Request $request) {
        DB::table('group_participants')->insert(
            [
                'id_group' => $request->id_group, 
                'id_participant' => $request->id_user, 
                'level' => $request->level
            ]
        );
        return redirect()->back();
    }

    // Search participants based on group and action
    public function search_participants_add($id_group) {
        $patients = DB::table('patients')->orderByRaw('name ASC')->get();
        $users = DB::table('users')->orderByRaw('name ASC')->get();
        
        $list = array('data' => array());

        /*foreach($patients as $patient) {
            $actions = "
                <a href='".route('group.insert.participant', [$id_group, $patient->id, 2])."'>
                    <i class='fa fa-plus'></i>
                </a>
            ";
            
            array_push($list['data'], array($patient->name, 'Paciente', $actions));
        }*/
        foreach($users as $user) {
            $actions = "
                <form method='POST' action='".route('group.add.user')."'>
                    <input type='hidden' name='_token' value='".csrf_token()."'>
                    <input type='hidden' name='id_user' value='".$user->id."'/>
                    <input type='hidden' name='id_group' value='".$id_group."'/>
                    <select name='level'>
                        <option value='0'>Leitor</option>
                        <option value='1'>Monitor</option>
                        <option value='2'>Editor</option>
                    </select>
                    <button class='btn btn-secondary btn-sm' type='submit'>Adicionar</button>
                </form>
            ";
            /*if($user->role  == 0) {
                array_push($list['data'], array($user->name, 'Professor', $actions));
            }
            else {
                array_push($list['data'], array($user->name, 'Estudante', $actions));  
            }*/
            array_push($list['data'], array($user->name, $user->email, $actions));  
        }
        return json_encode($list);
    }

    // Search participants based on group 
    public function search_participants($id_group) {
        $participants = DB::table('group_participants')->where('id_group', $id_group)->get();
        $group = Group::find($id_group);
        $list = array('data' => array());

        foreach($participants as $participant) {
            if($group->id_user == $participant->id_participant) {
                $level = 'Dono';
                $delete = '';
            }
            else {
                $delete= "
                    <a href='".route('group.delete.participant', $participant->id)."'>
                        <i class='fa fa-times'></i>
                    </a>
                "; 
                if($participant->level == 0) {
                    $level = 'Leitor';
                }
                else if($participant->level == 1) {
                    $level = 'Monitor';
                }
                else {
                    $level = 'Editor';
                }
            }
            // teacher or user
            $user = DB::table('users')
            ->where('id', $participant->id_participant)
            ->first();
            if($user != NULL) {
                // Data for participant teacher
                if($user->role  == 0) {
                    $name = "
                        <a href='".route('teacher.edit.view', $user->id)."'>
                            ".$user->name." <i class='fa fa-eye'></i>
                        </a>
                    ";
                }
                else { // Data for participant student
                    $name = "
                        <a href='".route('student.edit.view', $user->id)."'>
                            ".$user->name." <i class='fa fa-eye'></i>
                        </a>
                    ";
                }
                array_push($list['data'], array($name, $level, $delete));
                
            }
            
        }
        return json_encode($list);
    }

    public function included_groups($id_participant) {
        return DB::table('groups')
            ->rightjoin('group_participants', 'groups.id', '=', 'group_participants.id_group')
            ->where('id_participant', Auth::id())
            ->where('id_user', '!=', Auth::id())
            ->get();
    }

    public static function get_owner($id) {
        $group = Group::find($id);
        return $group->id_user;
    }

    public function all_categories() {
        $categories = DB::table('categories')
        ->where('id_user', Auth::id())
        ->orderByRaw('name ASC')->get();
        return $categories;
    }

    public function included_categories() {
        //Included in a group and needs to get categories
        $participants = DB::table('group_participants')
        ->where('id_participant', Auth::id())->get();

        $categories = array();

        foreach($participants as $participant) {
            $id_owner = GroupController::get_owner($participant->id_group);
            $categorys = DB::table('categories')
            ->where('id_user', $id_owner)
            ->orderByRaw('name ASC')->get()->toArray();
            if($categorys != NULL and $id_owner != Auth::id()) {
                foreach($categorys as $category) {
                    array_push($categories, $category); 
                }
            }
        }
        return $categories;
    }

    public static function groups_user($id_user) {
        $groups_all = array();

        $group_includeds = DB::table('group_participants')
            ->join('groups', 'group_participants.id_group', '=', 'groups.id')
            ->where('id_participant', $id_user)
            ->where('id_user', '!=', $id_user)
            ->get();

        $groups = Group::where('id_user', $id_user)->get();

        foreach($groups as $group) {
            array_push($groups_all, $group);
        }
        foreach($group_includeds as $group) {
            array_push($groups_all, $group);
        }

        return $groups_all;
    }

}