<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Session;
use App\Models\User;
use App\Models\CheckTask;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class UsersController extends Controller
{
    public function index()
    {
        $data = [];
        foreach(User::get() as $user_item) {
            $arg = [];
            $current_group = $user_item->group_id;
            foreach(DB::table('group_users')->whereIn('group_id',explode(',',$current_group))->get() as $item_group) {
                $arg[] = $item_group->group_name;
            }
            $data[] = [
                "id" => $user_item->id,
                "name" => $user_item->name,
                "email" => $user_item->email,
                "group_name" => implode('/',$arg),
            ];
        } 

        $all_data = $this->paginate($data);

        $all_data->withPath(url('/users'));

        return view('users/index',['users' => $all_data]);
    }

    public function paginate($items, $perPage = 10, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }
    public function create(User $user)
    {
        return view('users/create');
    }
    public function edit(User $user)
    {
        return view('users/edit',['user' => $user]);
    }    
    public function create_group(User $user)
    {    
        return back()->with('success','Erfolgreich eine Gruppe erstellt!');
    }
    public function store(Request $request, User $user){
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8'
        ]);
        $password = md5($request->password);
        $request->except(['password']);
        $request->request->add(['password' => $password]);
        $user->create($request->all());
        return back()->with('success','Benutzer erfolgreich angelegt!');
    }
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'password' => 'nullable|min:8',            
            'group_id' => 'nullable',
            'full_name' => 'nullable',
            'abbreviations' => 'nullable',
            'position' => 'nullable'
        ]);
        if(!empty($request->group_id)) {
            $list_group_id = implode(',', $request->group_id);
        } else {
            $list_group_id = null;
        }
        $data = [
            'name' => $request->name, 
            'email' => $request->email,
            'group_id' => $list_group_id,
            'full_name' => $request->full_name,
            'abbreviations' => $request->abbreviations,
            'position' => $request->position,
        ];
        if(!empty($request->password)) {
            $password = md5($request->password);
            $data['password'] = $password;
        }

        $user->update($data);
    
        return back()->with('success','Benutzer erfolgreich aktualisiert!');
    }
    
    public function delete_user(Request $request, User $user)
    {
        $user_id = $request->UserId;
        //if($user_id != 1){
            $user_query = DB::table('users')->where('id', '=', $user_id)->delete();
            return response()->json(['delete'=> '1']);
        // }else{
        //     return response()->json(['delete'=> '0']);
        // }
    }
    public function save_group(Request $request) {
        $name_group = $_POST['name_group'];
        $list_user = $_POST['list_user'];
        $arg_user = explode(",", $list_user);
        $group = DB::table('group_users')->where('group_name', '=', $name_group)->first();
        if ($group === null) {
            DB::table('group_users')->insert([
                'group_name' => $name_group,
            ]);
            $group_id = DB::table('group_users')->where('group_name', '=', $name_group)->value('group_id');
            foreach($arg_user as $arg_user) {
                $current_group_id = explode(",",DB::table('users')->where('id', $arg_user)->value('group_id'));
                array_push($current_group_id,$group_id);
                DB::table('users')->where('id', $arg_user)->update(['group_id' => implode(',',$current_group_id)]);
            }
            return response()->json(['create'=> '1']);
        } else { 
            return response()->json(['create'=> '0']);
        }
    }
    public function create_new_group(Request $request) {
        $users_html = ' ';
        foreach(DB::table('users')->get() as $user) {
            $users_html .= '<li data-id="'.$user->id.'" class="add-to-group" data-name="'.$user->full_name.'">'.$user->full_name.'</li>';
        }
        return response()->json(['new_group'=> '1', 'html'=> $users_html]);
        
    }
    public function load_group_modal(Request $request) { 
        $current_group = $_POST['current_group'];
        $group_exist = DB::table('users')->where('group_id', $current_group)->value('id');
        $group_name = DB::table('group_users')->where('group_id', $current_group)->value('group_name');

        $current_user = explode(",", $group_exist);
        $arg_current =  array();
        foreach($current_user as $current) {
            if(!empty($current)) {
                $current_html = '<li>'.DB::table('users')->where('id', $current)->value('name').'<span class="remove-item" data-id="'.$current.'"><i class="far fa-times-circle"></i></span></li>';
                array_push($arg_current,$current_html);
            }        
        }
        $user_arg = array();
        foreach (DB::table('users')->get() as $user) {
            if(in_array($user->id, $current_user)) {
                $user_html = '<li data-id="'.$user->id.'" class="add-to-group" style="pointer-events: none; opacity: 0.4;" data-name="'.$user->name.'">'.$user->name.'</li>';
            } else {
                $user_html = '<li data-id="'.$user->id.'" class="add-to-group" data-name="'.$user->name.'">'.$user->name.'</li>';
            }
            array_push($user_arg,$user_html);
        }
        $html = '<div class="name-item">
                    <div class="group-item">
                        <div class="form-group input-group">
                            <span class="has-float-label">
                                <input type="text" class="form-control" id="group_name_edit" placeholder="Group Name:" value="'.$group_name.'" disabled>
                                <label for="group_name">Group Name:</label>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="user-item">
                    <div class="select-user">
                        <span class="label-select">Select User <i class="fas fa-caret-down"></i></span>
                        <ul class="list-user">'.implode("",$user_arg).'</ul>
                    </div>
                </div>
                <div class="participants-item">
                    <p class="modal-title mt-3 mb-2"><i class="fas fa-users"></i> <strong>Participants:</strong></p>
                    <ul class="list-participants">'.implode("",$arg_current).'</ul>
                    <input type="hidden" name="list_user" value="">
                </div>';

        return response()->json(['load_modal'=> '1', 'load_edit_group'=> $html]);
    }
    public function open_user_group(Request $request) {         
        $group_id = $_POST['group_id'];
        $task_id = $_POST['task_id'];
        if(isset($_POST['list_user_id']) || $_POST['list_user_id'] == 0) {
            $list_user = $_POST['list_user_id'];
        } else {
            $list_user = "";
        }
        $group_current = $_POST['group_id'];
        $arg_user = explode(",", $list_user);
        $html = ' ';
        foreach(DB::table('group_users')->get() as $group_users) {
            $group_item = DB::table('users')->where('group_id','LIKE','%'.$group_users->group_id.'%')->get();
            $group_name = $group_users->group_name;
            $group_id = $group_users->group_id;
            $arg_group_id = false;
            $arg_user_group_id = [];
            foreach($group_item as $user_list) {
                foreach(explode(',',$user_list->group_id) as $item_group) {
                    if($item_group == $group_users->group_id) {
                        $arg_group_id = true;
                        array_push($arg_user_group_id,$user_list->id);
                    }
                }
            }
            if($arg_group_id == true ) {
                $html .= '<li class="wrap-select-user" data-group_id="'.$group_id.'">
                    <div class="select-action">
                        <div class="select-group">'.$group_name.'</div>
                    </div>
                    <div class="list-user" style="display:none;">
                        <ul class="inner">';
                        foreach(DB::table('users')->whereIn('id',$arg_user_group_id)->get() as $user_item) {
                            if(in_array($user_item->id,$arg_user)) {
                                $html .= '
                                <li>
                                    <label class="user-task">
                                        <span class="name-user">'.$user_item->name.'</span>
                                        <input type="checkbox" class="active" name="user_id" data-task_id="'.$task_id.'" data-group_id="'.$group_id.'" data-group_name="'.$group_name.'" data-user_name="'.$user_item->name.'" value="'.$user_item->id.'" checked>
                                    </label> 
                                </li>';
                            } else {
                                $html .= '
                                <li>
                                    <label class="user-task">
                                        <span class="name-user">'.$user_item->name.'</span>
                                        <input type="checkbox" name="user_id" data-task_id="'.$task_id.'" data-group_id="'.$group_id.'" data-group_name="'.$group_name.'" data-user_name="'.$user_item->name.'" value="'.$user_item->id.'">
                                    </label> 
                                </li>';

                            }
                        }

                    $html .= '
                        </ul>
                    </div>
                </li>';
            }
        }

        $na = false;
        if($list_user == '0') {
            $na = true;
        }
        return response()->json(['load_user_current'=> '1', 'load_user_group'=> $html, 'na'=> $na]); 
    }
    public function open_popup(Request $request) { 
        if(isset($_POST['list_user']) || $_POST['list_user_id'] == 0) {
            $list_user = $_POST['list_user'];
        } else {
            $list_user = "";
        }
        $task_id = $_POST['task_id'];
        $arg_user = explode(",", $list_user);
        $html = '';
        
        foreach(DB::table('group_users')->get() as $group_users) {
            $group_item = DB::table('users')->where('group_id','LIKE','%'.$group_users->group_id.'%')->get();
            $group_name = $group_users->group_name;
            $group_id = $group_users->group_id;
            $arg_group_id = false;
            $arg_user_group_id = [];
            foreach($group_item as $user_list) {
                foreach(explode(',',$user_list->group_id) as $item_group) {
                    if($item_group == $group_users->group_id) {
                        $arg_group_id = true;
                        array_push($arg_user_group_id,$user_list->id);
                    }
                }
            }
            if($arg_group_id == true ) {
                $html .= '<li class="wrap-select-user" data-group_id="'.$group_id.'">
                    <div class="select-action">
                        <div class="select-group">'.$group_name.'</div>
                    </div>
                    <div class="list-user" style="display:none;">
                        <ul class="inner">';
                        foreach(DB::table('users')->whereIn('id',$arg_user_group_id)->get() as $user_item) {
                            if(in_array($user_item->id,$arg_user)) {
                                $html .= '
                                <li>
                                    <label class="user-task">
                                        <span class="name-user">'.$user_item->name.'</span>
                                        <input type="checkbox" class="active" name="user_id" data-task_id="'.$task_id.'" data-group_id="'.$group_id.'" data-group_name="'.$group_name.'" data-user_name="'.$user_item->name.'" value="'.$user_item->id.'" checked>
                                    </label> 
                                </li>';
                            } else {
                                $html .= '
                                <li>
                                    <label class="user-task">
                                        <span class="name-user">'.$user_item->name.'</span>
                                        <input type="checkbox" name="user_id" data-task_id="'.$task_id.'" data-group_id="'.$group_id.'" data-group_name="'.$group_name.'" data-user_name="'.$user_item->name.'" value="'.$user_item->id.'">
                                    </label> 
                                </li>';

                            }
                        }

                    $html .= '
                        </ul>
                    </div>
                </li>';
            }
        }

        $na = false;
        if($list_user == '0') {
            $na = true;
        }
        return response()->json(['open_popup'=> '1', 'html'=> $html, 'na'=> $na]);
    }

    //check_task
    public function postCheckTask(Request $request)
    {
        $userId = auth()->id();
        if($request->has('tasklist') && is_array($request->tasklist)){
            foreach($request->tasklist as $tasklist){
                $tasklistObj = explode('_', $tasklist);
                if(count($tasklistObj)==2) {
                    CheckTask::create([
                        'user_id' => $userId,
                        'list_task_id' => $tasklistObj[0],
                        'category_id' => $tasklistObj[1]
                    ]);
                }
            }
        }
        return redirect()->back();
    }
        
}
