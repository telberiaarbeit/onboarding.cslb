<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Session;
use App\Models\User;
use App\Models\GroupUser;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class GroupController extends Controller
{
    public function index()
    {
        $groupuser = GroupUser::paginate(10)->appends(request()->all());
        return view('group-user/index',['groupuser' => $groupuser])->with('i', (request()->input('page', 1) - 1) * 10);
    }    
    public function edit($group_id)
    {
        $group_name = GroupUser::where('group_id', $group_id)->value('group_name');
        $users = User::get();
        $data = [
            'group_id' => $group_id,
            'group_name' => $group_name,
            'users' => $users
        ];
        return view('group-user/edit', $data);
    }
    public function update(Request $request, $group_id)
    {
        $request->validate([
            'group_name' => 'required',
        ]);
        $data = [            
            'group_id' => $group_id,
            'group_name' => $request->group_name, 
        ];
        $list_user = $request->list_user;
        $disable_user = $request->disable_user;
        $count_group = count(GroupUser::whereNotIn('group_id', [$group_id])->where('group_name',$request->group_name)->get());      
        if($count_group > 0 ) {
            return back()->with('error','Gruppenname existiert bereits!');
        } else {
            GroupUser::where('group_id',$group_id)->update($data);
            if(!empty($list_user)){ 
                $arg_user = explode(",", $list_user);
                foreach(User::whereIn('id', $arg_user)->get() as $user_in) {
                    $user_current_group = explode(',',$user_in->group_id);
                    array_push($user_current_group,$group_id);
                    User::where('id', $user_in->id)->update(['group_id' => implode(',',$user_current_group)]);
                } 
            }
            if(!empty($disable_user)){ 
                $arg_disable_user = explode(",", $disable_user);
                foreach(User::whereIn('id', $arg_disable_user)->get() as $user_dis) {
                    $user_current_group = explode(',',$user_dis->group_id);
                    unset($user_current_group[array_search($group_id, $user_current_group)]);
                    User::where('id', $user_dis->id)->update(['group_id' => implode(',',$user_current_group)]);
                } 
            }
            return back()->with('success','Speichern Erfolgreich!');
        }
    }
    public function delete_group(Request $request)
    {
        $group_id = $request->group_id;
        GroupUser::where('group_id',$group_id)->delete();
        User::where('group_id', $group_id)->update(['group_id' => null]);
        return back()->with('success','Erfolgreich Löschen!');
    }
}
