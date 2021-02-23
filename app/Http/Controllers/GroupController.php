<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Group;
use App\Patient;
use App\Quiz;
use App\User;
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
            ['id_group' => $group->id, 'id_participant' => $group->id_user]
        );

        return redirect()->back();    
    }

    public function participants_get($id) {
        $group = Group::find($id);
        return view('group.participants', compact('group')); 
    }  

    public function edit(Request $request) {
        
        $group = Group::find($request->id_group);
        $group->name = $request->name;
        $group->resume = $request->resume;
        $group->save();

        return redirect()->back();    
    }

    public function view_get($id) {
        $group = Group::find($id);
        return view('group.view', compact('group')); 
    }  

    // delete group and our content
    public function delete_get($id) {
        // finally delete group
        $group = Group::find($id);
        $group->delete();

        // find group participants and delete
        DB::table('group_participants')->where('id_group', $id)->delete();

        return view('home'); 
    }

    public function delete_participant($id) {
        $x = DB::table('group_participants')
        ->where('id', $id)
        ->delete();
        return view('home'); 
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
                'id_participant' => $request->id_user
            ]
        );
        return redirect()->back();
    }

    // Search participants based on group and action
    public function search_participants_add($id_group) {
        $group = Group::find($id_group);

        $users = DB::table('users')
        ->where('id', '!=', $group->id_user)
        ->orderByRaw('name ASC')->get();

        $list = array('data' => array());

        foreach($users as $user) {
            $actions = GroupController::make_form_add_participant($user->id, $id_group);
            array_push($list['data'], array($user->name, $user->email, $actions));  
        }

        return json_encode($list);
    }

    public function make_form_add_participant($id_user, $id_group) {
        return "<form method='POST' action='".route('group.add.user')."'>
            <input type='hidden' name='_token' value='".csrf_token()."'>
            <input type='hidden' name='id_user' value='".$id_user."'/>
            <input type='hidden' name='id_group' value='".$id_group."'/>
            <button class='btn btn-secondary btn-sm' type='submit'>Adicionar</button>
        </form>";
    }

    public function is_owner($id_participant, $id_group) {
        $group = Group::find($id_group);
        if($group->id_user == $id_participant) {
            return true;
        }

        return false;
    }

    // Search participants based on group 
    public function participants_search($id_group) {
        $participants = DB::table('group_participants')->where('id_group', $id_group)->get();
        $group = Group::find($id_group);
        $list = array('data' => array());

        foreach($participants as $participant) {

            if(GroupController::is_owner($participant->id_participant, $group->id)){
                $level = ' (Dono)';
                $delete = '';
            }
            else {
                $level = '';
                $delete= "
                    <a href='".route('group.delete.participant', $participant->id)."'>
                        <i class='fa fa-times'></i>
                    </a>
                "; 

            }
            // users

            $user = User::find($participant->id_participant);

            if($user != NULL) {
                array_push($list['data'], array($user->name.$level, $delete));
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


    public static function get_own_and_included_groups($id_user) {
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