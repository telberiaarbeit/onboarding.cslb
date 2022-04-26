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
        $users = User::whereNull('group_id')->orWhere('group_id', $group_id)->get();
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
                User::whereIn('id', $arg_user)->update(['group_id' => $group_id]);
            }
            if(!empty($disable_user)){ 
                $arg_disable_user = explode(",", $disable_user);
                User::whereIn('id', $arg_disable_user)->update(['group_id' => null]);
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
