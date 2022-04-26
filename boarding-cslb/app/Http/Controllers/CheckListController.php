<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
use App\Models\Checklist;
use Session;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class CheckListController extends Controller
{
    public function index(){
       
        $data = [];

        $current_id = Auth::id();
        if(Auth::check() && Auth::user()->is_admin == 1) {
            $list_data = Checklist::all();
        } else {
            $list_data = Checklist::where('user_id', $current_id)->get();
        }
        
        if(!empty($list_data)) {
            foreach($list_data as $item) {
                $data[] = [
                    'id' => $item['id'],
                    'name' => $item['name'],
                    'name_vorgesetzter' => $item['name_vorgesetzter'],
                    'created_at' => $item['created_at']->format('Y-m-d'),
                ];
            }   
        }
        $collection = collect($data);

        $sorted = $collection->sortByDesc('id');   

        $sorted->all();

        $all_data = $this->paginate($sorted);

        $all_data->withPath(url('/boarding-unterlagen'));

        return view('online-checklist/index', ['current_id' => $current_id, 'data' => $all_data]);
    }

    public function paginate($items, $perPage = 10, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }

    public function create(){
        $current_id = Auth::id();
        $user_info = DB::table('users')->where('id', $current_id)->select('abbreviations', 'full_name')->first();

        $list_category = DB::table('category')->get();
        $list_tab_form = DB::table('tab_form')->get();
        $list_position = DB::table('position')->get();

        $list_group_users = [];
        $group_users = DB::table('group_users')->get();
        if(!empty($group_users)){
            foreach($group_users as $group_user){
                $list_group_users[$group_user->group_id] = [
                    'id' => $group_user->group_id,
                    'name' => $group_user->group_name,
                ];

                $user_id_group = DB::table('users')->where('group_id', $group_user->group_id)->get();
                if($user_id_group) {
                    foreach($user_id_group as $user_id){
                        $list_group_users[$group_user->group_id]['users'][] = $user_id->id;
                    }    
                }
                
            }
        }

        $list_task = [];
        $tasks = DB::table('list_task')->get();
        if(!empty($tasks)){
            foreach($tasks as $task){
                $list_task[$task->category_id][] = [
                    'id' => $task->id,
                    'name' => $task->name,
                    'category_id' => $task->category_id,
                ];
            }
        }

        $data = [
            'abbreviations' => $user_info->abbreviations,
            'full_name' => $user_info->full_name,
            'list_group_users' => $list_group_users,
            'list_category' => $list_category,
            'list_tab_form' => $list_tab_form,
            'list_position' => $list_position,
            'list_task' => $list_task,
        ];
        return view('online-checklist/create', $data);
    }

    public function store(Request $request)
    {
        $user = Auth::user();
       
        $validator = Validator::make($request->all(), [
            'floatingName' => 'required',
            'floatingSelect' => 'required',
            'name_vorgesetzter'=> 'required'
        ]);

        if ($validator->fails()) {
            $messages = $validator->messages();
            return redirect('boarding-unterlagen')->withErrors($messages);
        } else {
            
            $name = $request->input('floatingName');
            $position_id = $request->input('floatingSelect');
            $name_vorgesetzter = $request->input('name_vorgesetzter');

            $data = [
                'name' => $name,
                'user_id' => Auth::id(),
                'position_id' => $position_id,
                'name_vorgesetzter' => $name_vorgesetzter,
            ];

            if ($request->has('category_date_detail')) {
                $category_date_detail = $request->input('category_date_detail');
                $data['category_date_detail'] = json_encode($category_date_detail);
            }

            if ($request->has('category_sub_detail')) {
                $category_sub_detail = $request->input('category_sub_detail');
                $data['category_sub_detail'] = json_encode($category_sub_detail);
            }

            if ($request->has('task_detail')) {
                $task_detail = [];
                $request->collect('task_detail')->each(function ($task) use(&$task_detail) {
                    if(isset($task["group_task"]) && !empty($task["group_task"])) {
                        $task_detail[$task["group_task"]] = $task;
                        $task_detail[$task["group_task"]]["datetime"] = date('d.m.Y');
                    }
                });
                $data['task_detail'] = json_encode($task_detail);
            }

           

            if ($request->has('note_detail')) {
                $note_detail = $request->input('note_detail');
                $data['note_detail'] = json_encode($note_detail);
            }

            if ($request->has('signature_detail')) {
                $signature_detail = $request->input('signature_detail');
                $data['signature_detail'] = json_encode($signature_detail);
            }

            $create = Checklist::create($data);
            if($create) {
                $msg_create = [
                    'msg' => 'Schaffen Sie Erfolg!',
                    'code' => 200
                ];
            } else {
                $msg_create = [
                    'msg' => 'Schaffe Misserfolg!',
                    'code' => 400
                ];
            }
            
            return redirect('boarding-unterlagen')->with('msg_create', $msg_create);
        }
    }

    public function update(Request $request, $id)
    {
        $user = Auth::user();
       
        $validator = Validator::make($request->all(), [
            'floatingName' => 'required',
            'floatingSelect' => 'required',
            'name_vorgesetzter'=> 'required'
        ]);

        if ($validator->fails()) {
            $messages = $validator->messages();
            return redirect('boarding-unterlagen')->withErrors($messages);
        } else {

            $name = $request->input('floatingName');
            $position_id = $request->input('floatingSelect');
            $name_vorgesetzter = $request->input('name_vorgesetzter');

            $data = [
                'name' => $name,
                'position_id' => $position_id,
                'name_vorgesetzter' => $name_vorgesetzter,
            ];

            if ($request->has('category_date_detail')) {
                $category_date_detail = $request->input('category_date_detail');
                $data['category_date_detail'] = json_encode($category_date_detail);
            }

            if ($request->has('category_sub_detail')) {
                $category_sub_detail = $request->input('category_sub_detail');
                $data['category_sub_detail'] = json_encode($category_sub_detail);
            }

            if ($request->has('task_detail')) {
                $task_detail = [];
                $request->collect('task_detail')->each(function ($task) use(&$task_detail) {

                    if(isset($task["group_task"]) && !empty($task["group_task"])) {
                        $task_detail[$task["group_task"]] = $task;
                        if($task["datetime"]) {
                            $set_datetime = $task["datetime"];
                        } else {
                            $set_datetime = date('d.m.Y');
                        }
                        $task_detail[$task["group_task"]]["datetime"] = $set_datetime;
                    }
                });
                $data['task_detail'] = json_encode($task_detail);
            }
            

            if ($request->has('note_detail')) {
                $note_detail = $request->input('note_detail');
                $data['note_detail'] = json_encode($note_detail);
            }

            if ($request->has('signature_detail')) {
                $signature_detail = $request->input('signature_detail');
                $data['signature_detail'] = json_encode($signature_detail);
            }
  
            $update = Checklist::where(['id' => $id])->update($data);
            if($update) {
                $msg_update = [
                    'msg' => 'Speichern erfolgreich!',
                    'code' => 200
                ];
            } else {
                $msg_update = [
                    'msg' => 'Speichern erfolgreich!',
                    'code' => 400
                ];
            }
            
            return redirect('boarding-unterlagen')->with('msg_update', $msg_update);
        }
    }

    public function destroy(Request $request, $id)
    {

    }

    public function edit($id)
    {
        if(!empty($id)) {

            $current_id = Auth::id();

            $user_info = DB::table('users')->where('id', $current_id)->select('abbreviations', 'full_name')->first();

            $checklist = Checklist::where('id', $id)->first();

            $list_category = DB::table('category')->get();
            $list_tab_form = DB::table('tab_form')->get();
            $list_position = DB::table('position')->get();

            $list_task = [];
            $tasks = DB::table('list_task')->get();
            if(!empty($tasks)){
                foreach($tasks as $task){
                    $list_task[$task->category_id][] = [
                        'id' => $task->id,
                        'name' => $task->name,
                        'category_id' => $task->category_id,
                    ];
                }
            }

            $group_users_task = [];
            $task_detail = json_decode($checklist->task_detail, true);
            if($task_detail) {
                foreach($task_detail as $key => $task){
                    $list_ids = explode(',', $task["ids"]);
                    foreach($list_ids as $user_id_task) {
                        $first_user_info = DB::table('users')->where('id', $user_id_task)->select('full_name', 'group_id')->first();
                        if(isset($first_user_info->group_id)){
                            $user_group_id = $first_user_info->group_id;
                            $first_user_group = DB::table('group_users')->where('group_id', $user_group_id)->first();
                            if(!empty($first_user_info) && !empty($first_user_group)) {
                                $group_users_task[$key][] = [
                                    'sub_user_id' => $user_id_task,
                                    'sub_full_name' => $first_user_info->full_name,
                                    'sub_group_id' => $first_user_group->group_id ? $first_user_group->group_id : '',
                                    'sub_group_name' => $first_user_group->group_name ? $first_user_group->group_name : '',
                                ];
                            }
                        } 
                    }
                }
            }
            
            $list_group_users = [];
            $group_users = DB::table('group_users')->get();
            if(!empty($group_users)){
                foreach($group_users as $group_user){
                    $list_group_users[$group_user->group_id] = [
                        'id' => $group_user->group_id,
                        'name' => $group_user->group_name,
                    ];

                    $user_id_group = DB::table('users')->where('group_id', $group_user->group_id)->get();
                    if($user_id_group) {
                        foreach($user_id_group as $user_id){
                            $list_group_users[$group_user->group_id]['users'][] = $user_id->id;
                        }    
                    }
                    
                }
            }
            
            
            $data = [
                'form_id' => $id,
                'name_checklist' => $checklist->name,
                'abbreviations' => $user_info->abbreviations,
                'name_vorgesetzter' => $checklist->name_vorgesetzter,
                'list_category' => $list_category,
                'list_tab_form' => $list_tab_form,
                'list_position' => $list_position,
                'list_task' => $list_task,
                'list_group_users' => $list_group_users,
                'group_users_task' => $group_users_task,
                'checklist' => $checklist,
            ];

            return view('online-checklist/edit', $data);
        } else {
            return redirect('boarding-unterlagen')->with('msg_edit', 'Cannot be edited, please check again.');
        }
    }

    public function dashboard() {
        $current_id = Auth::id();

        $list_data = Checklist::all();
        $tasks = [];
        if(!empty($list_data)) {
            foreach($list_data as $data) {
                $task_details = json_decode($data->task_detail, true);
                $category_sub_detail = json_decode($data->category_sub_detail, true);
                if(!empty($task_details)) {
                    foreach($task_details as $detail) {
                        if(isset($detail["ids"]) && !empty($detail["ids"])) {
                            $ids = explode(",",$detail["ids"]); 

                            $cat_id = preg_replace('/\D/', '', $detail['cat_id']);
                            $sub_id = $cat_id.'_'.$detail['tab_form'];
                            if(isset($category_sub_detail[$sub_id]) && !empty($category_sub_detail[$sub_id])) {
                                $deadline = $category_sub_detail[$sub_id];
                            } else {
                                $deadline = '';
                            }

                            foreach($ids as $id) {
                                $user = DB::table('users')->where('id', $id)->select('full_name')->first();
                                $user_task = DB::table('list_task')->where('id', $detail["task_id"])->select('name')->first();
                                $tasks[] = [
                                    'user_id' => $id,
                                    'user_full_name' => $user->full_name,
                                    'datetime' => $detail["datetime"],
                                    'task_id' => $detail["task_id"],
                                    'task_name' => trim($user_task->name),
                                    'tab_form' => $detail["tab_form"],
                                    'cat_id' => $cat_id,
                                    'deadline' => $deadline,
                                    'created_at' => $data->created_at,
                                ]; 
                            }
                        }
                    }
                }
            }
        }

        $data = [
            'tasks' => $tasks
        ];
        return view('dashboard', $data);
    }
}