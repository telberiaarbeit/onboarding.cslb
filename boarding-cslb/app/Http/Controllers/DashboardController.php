<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Models\Dashboard;
use App\Models\DateDetail;
use App\Models\SubDetail;
use App\Models\TaskDetail;
use App\Models\NoteDetail;
use App\Models\SignatureDetail;
use Session;
use Mail;

class DashboardController extends Controller
{
    public function index()
    {

        $data = [];

        $current_id = Auth::id();
        //if (Auth::check() && Auth::user()->is_admin == 1) {
            $list_data = Dashboard::all();
        // } else {
        //     $list_data = Dashboard::where('user_id', $current_id)->get();
        // }

        if (!empty($list_data)) {
            foreach ($list_data as $item) {
                $form_id = $item['id'];
                $total_task = 0;
                $done_task = 0;
                $arg_date_details = [];
                foreach(DB::table('category_date_detail')->where('form_id',$form_id)-> where('confirmed','=','1')->get() as $date_detail) {
                    if(!in_array($date_detail->tab_id,$arg_date_details)) {
                        array_push($arg_date_details,$date_detail->tab_id);
                    }
                }
                if(count($arg_date_details) > 0) {               
                    $total_task = DB::table('task_detail')->where('form_id',$form_id)->whereIn('tab_id',$arg_date_details)->where('user_id','>',0)->count();
                    $done_task = DB::table('task_detail')->where('form_id',$form_id)->whereIn('tab_id',$arg_date_details)->where('user_id','>',0)->whereNotNull('user_confirmed')->count();
                }
                $data[] = [
                    'id' => $item['id'],
                    'name' => $item['name'],
                    'total_task' => $total_task,
                    'done_task' => $done_task,
                    'name_vorgesetzter' => $item['name_vorgesetzter'],
                    'created_at' => $item['created_at']->format('Y-m-d'),
                ];
            }

            $collection = collect($data);

            $sorted = $collection->sortByDesc('id');

            $sorted->all();

            $all_data = $this->paginate($sorted);

            $all_data->withPath(url('/boarding-unterlagen'));
        }

        return view('online-checklist/index', ['current_id' => $current_id, 'data' => $all_data]);
    }

    public function paginate($items, $perPage = 10, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }

    public function create()
    {
        $current_id = Auth::id();
        $user_info = DB::table('users')->where('id', $current_id)->select('abbreviations', 'full_name')->first();

        $list_category = DB::table('category')->get();
        $list_tab_form = DB::table('tab_form')->get();
        $list_position = DB::table('position')->get();

        $list_group_users = [];
        $group_users = DB::table('group_users')->get();
        if (!empty($group_users)) {
            foreach ($group_users as $group_user) {
                $list_group_users[$group_user->group_id] = [
                    'id' => $group_user->group_id,
                    'name' => $group_user->group_name,
                ];

                $user_id_group = DB::table('users')->where('group_id', $group_user->group_id)->get();
                if ($user_id_group) {
                    foreach ($user_id_group as $user_id) {
                        $list_group_users[$group_user->group_id]['users'][] = $user_id->id;
                    }
                }
            }
        }

        $list_task = [];
        $tasks = DB::table('list_task')->orderBy('order')->get();
        if (!empty($tasks)) {
            foreach ($tasks as $task) {
                if(!empty($task->group_default) && $task->group_default != NULL) {
                    $group_default = explode(',',$task->group_default);
                    $list_user_default = [];
                    $arg_group_user_default = [];
                    $list_group_user = [];
                    $name_group_user_default = [];
                    foreach($group_default as $group_default_id) {
                        foreach( DB::table('users')->where('group_id','LIKE', '%'. $group_default_id.'%')->get() as $user_id_default) {
                            if(!in_array($user_id_default->id,$list_user_default)) {
                                array_push($list_user_default,$user_id_default->id);
                            }
                            if(count(explode(',',$user_id_default->group_id))>0) {
                                foreach(explode(',',$user_id_default->group_id) as $current_group) {
                                    if(in_array($current_group,$group_default) && !in_array($current_group,$arg_group_user_default)) {
                                        array_push($arg_group_user_default,$current_group);
                                        $list_group_user[] = [
                                            'id' => $current_group,
                                            'name' => DB::table('group_users')->where('group_id',$current_group)->value('group_name'),
                                        ];
                                    }
                                }

                            }
                        }
                    }
                    $str_user_default = implode(',',$list_user_default);
                } else {
                    $str_user_default = "";
                }

                $list_task[$task->category_id][] = [
                    'id' => $task->id,
                    'name' => $task->name,
                    'category_id' => $task->category_id,
                    'user_defaults' => $str_user_default,
                    'group_user_default' => $list_group_user,
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
            'name_vorgesetzter' => 'required'
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

            
            $description = $request->input('description');
            if(!empty($description)) {
                $data['description'] = $description;
            }

            $form_id = Dashboard::create($data);
            if ($form_id) {
                if ($request->has('category_date_detail')) {
                    $category = [];
                    $category_date_detail = $request->input('category_date_detail');
                    foreach ($category_date_detail as $key => $category_date) {
                        $tab_id = explode('_', $key);
                        foreach ($category_date as $key_cat => $date) {

                            if (isset($date['checkbox']) && !empty($date['checkbox'])) {
                                $confirmed = 1;
                            } else {
                                $confirmed = 0;
                            }

                            $category = [
                                'form_id' => $form_id->id,
                                'tab_id' => (int)$tab_id[1],
                                'type' => $key_cat,
                                'confirmed' => $confirmed,
                            ];

                            if (isset($date['datetime']) && !empty($date['datetime'])) {
                                $category['created'] = date("Y-m-d", strtotime($date['datetime']));
                            }

                            $create_category = DateDetail::create($category);
                        }
                    }
                }

                if ($request->has('category_sub_detail')) {
                    $sub = [];
                    $category_sub_detail = $request->input('category_sub_detail');
                    foreach ($category_sub_detail as $key => $category_sub) {
                        $category_id = explode('_', $key);

                        $sub = [
                            'form_id' => $form_id->id,
                            'tab_id' => (int)$category_id[1],
                            'category_id' => (int)$category_id[0],
                        ];

                        if (isset($category_sub) && !empty($category_sub)) {
                            $sub['created'] = date("Y-m-d", strtotime($category_sub));
                        }

                        $create_sub = SubDetail::create($sub);
                    }
                }

                if ($request->has('task_detail')) {
                    $task = [];
                    $tasks_detail = $request->input('task_detail');
                    
                    foreach ($tasks_detail as $task_detail) {
                        
                        if (isset($task_detail['checkbox']) && !empty($task_detail['checkbox'])) {
                            $task['confirmed'] = 1;
                            $task['user_confirmed'] = Auth::id();
                        } else {
                            $task['confirmed'] = 0;
                            unset($task['user_confirmed']);
                        }

                        if (isset($task_detail['datetime']) && !empty($task_detail['datetime'])) {
                            $task['created'] = date("Y-m-d", strtotime($task_detail['datetime']));
                        }
                        if($task_detail['ids'] == null) {
                            if($task['confirmed'] = 1) {
                                $ids = [-1];
                            }
                        } elseif(isset($task_detail['ids']) && !empty($task_detail['ids'])) {
                            $ids = explode(',', $task_detail['ids']);
                        } elseif(isset($task_detail['ids']) && $task_detail['ids'] == 0) {
                            $ids = explode(',', $task_detail['ids']);
                        } 
                        
                        if(isset($ids) && count($ids) > 0) {
                            foreach ($ids as $id) {

                                $task['form_id'] = $form_id->id;
                                $task['tab_id'] = $task_detail['tab_form'];
                                $task['category_id'] = $task_detail['cat_id'];
                                $task['task_id'] = $task_detail['task_id'];
                                $task['user_id'] = $id;

                                if($task_detail['task_id'] == 8 && !empty($task_detail['tage'])) {
                                    $task['tage'] = $task_detail['tage'];
                                }

                                if($task_detail['task_id'] == 116 && !empty($task_detail['task_date'])) {
                                    $task['task_date'] = date("Y-m-d", strtotime($task_detail['task_date']));
                                } else {
                                    unset($task['task_date']);
                                }
                                
                                $create_sub = TaskDetail::create($task);
                            }   
                        }

                    }
                }

                if ($request->has('note_detail')) {
                    $note = [];
                    $notes_detail = $request->input('note_detail');
                    foreach ($notes_detail as $key => $note_detail) {
                        $note = [
                            'form_id' => $form_id->id,
                            'tab_id' => (int)$key,
                            'content' => $note_detail,
                        ];
                        $create_note = NoteDetail::create($note);
                    }
                }

                if ($request->has('signature_detail')) {
                    $signature = [];
                    $signatures_detail = $request->input('signature_detail');
                    foreach ($signatures_detail as $key => $signature_detail) {
                        $signature = [
                            'form_id' => $form_id->id,
                            'tab_id' => (int)$key,
                        ];
                        if (isset($signature_detail[0]) && !empty($signature_detail[0])) {
                            $signature['unterschrift_mitarbeiter'] = $signature_detail[0];
                        }
                        if (isset($signature_detail[1]) && !empty($signature_detail[1])) {
                            $signature['unterschrift_manager'] = $signature_detail[1];
                        }
                        if (isset($signature_detail[3]) && !empty($signature_detail[3])) {
                            $signature['user_id_mitarbeiter'] = $signature_detail[3];
                        }
                        if (isset($signature_detail[4]) && !empty($signature_detail[4])) {
                            $signature['user_id_manager'] = $signature_detail[4];
                        }
                        $create_signature = SignatureDetail::create($signature);
                    }
                }
            }

            if ($form_id) {
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
            'name_vorgesetzter' => 'required'
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

            $description = $request->input('description');
            if(!empty($description)) {
                $data['description'] = $description;
            }

            $update = Dashboard::where(['id' => $id])->update($data);

            if ($request->has('category_date_detail')) {

                $category_date_detail = $request->input('category_date_detail');
                foreach ($category_date_detail as $key => $category_date) {
                    $category = [];
                    foreach ($category_date as $key_cat => $date) {
                        if (isset($date['date_detail_id']) && !empty($date['date_detail_id'])) {
                            if (isset($date['checkbox']) && !empty($date['checkbox'])) {
                                $category['confirmed'] = 1;
                            } else {
                                $category['confirmed'] = 0;
                            }
                            if (isset($date['datetime']) && !empty($date['datetime'])) {
                                $category['created'] = date("Y-m-d", strtotime($date['datetime']));
                            }
                            if (!empty($category)) {
                                $update_category = DateDetail::where('id', $date['date_detail_id'])->update($category);
                            }
                        }
                    }
                }
            }

            if ($request->has('category_sub_detail')) {
                $category_sub_detail = $request->input('category_sub_detail');
                $sub = [];
                foreach ($category_sub_detail as $key => $category_sub) {
                    if (isset($category_sub) && !empty($category_sub)) {
                        $sub['created'] = date("Y-m-d", strtotime($category_sub));
                        $update_category = SubDetail::where('id', $key)->update($sub);
                    }
                }
            }

            if ($request->has('task_detail')) {

                $tasks_detail = $request->input('task_detail');
                foreach ($tasks_detail as $task_detail) {
                    
                    if (isset($task_detail['ids']) && !empty($task_detail['ids']) || isset($task_detail['ids']) && $task_detail['ids'] == 0) {
                        $user_ids = explode(',', $task_detail['ids']);
                        $create_arr = [];
                        foreach ($user_ids as $user_id) {

                            $task_update = [];
                            if (isset($task_detail['checkbox']) && !empty($task_detail['checkbox'])) {
                                $task_update['confirmed'] = 1;
                                $task_update['user_confirmed'] = Auth::id();
                            } else {
                                $task_update['confirmed'] = 0;
                            }

                            if (isset($task_detail['datetime']) && !empty($task_detail['datetime'])) {
                                $task_update['created'] = date("Y-m-d", strtotime($task_detail['datetime']));
                            }

                            if (isset($task_detail['tage']) && !empty($task_detail['tage'])) {
                                $task_update['tage'] = $task_detail['tage'];
                            }

                            if (isset($task_detail['task_date']) && !empty($task_detail['task_date'])) {
                                $task_update['task_date'] = date("Y-m-d", strtotime($task_detail['task_date']));
                            }

                            $task_item = TaskDetail::where(['form_id' => $id, 'user_id' => $user_id, 'task_id' => $task_detail['task_id']])->first();
                            if ($task_item) {
                                $update_task = TaskDetail::where('id', $task_item->id)->update($task_update);
                            } else {

                                $create_arr = [
                                    'form_id' => $id,
                                    'tab_id' => $task_detail['tab_form'],
                                    'category_id' => $task_detail['cat_id'],
                                    'task_id' => $task_detail['task_id'],
                                    'user_id' => $user_id,
                                ];

                                $data_create = array_merge($create_arr, $task_update);
                                $create_sub = TaskDetail::create($data_create);
                            }
                        }
                    }
                }
            }

            if ($request->has('note_detail')) {
                $notes_detail = $request->input('note_detail');
                foreach ($notes_detail as $key => $note_detail) {
                    $update_note = NoteDetail::where('id', $key)->update(['content' => $note_detail]);
                }
            }

            if ($request->has('signature_detail')) {

                $signatures_detail = $request->input('signature_detail');
                foreach ($signatures_detail as $key => $signature_detail) {
                    $signature = [];
                    if (isset($signature_detail[0]) && !empty($signature_detail[0])) {
                        $signature['unterschrift_mitarbeiter'] = $signature_detail[0];
                    }
                    if (isset($signature_detail[1]) && !empty($signature_detail[1])) {
                        $signature['unterschrift_manager'] = $signature_detail[1];
                    }
                    if (isset($signature_detail[3]) && !empty($signature_detail[3])) {
                        $signature['user_id_mitarbeiter'] = $signature_detail[3];
                    }
                    if (isset($signature_detail[4]) && !empty($signature_detail[4])) {
                        $signature['user_id_manager'] = $signature_detail[4];
                    }
                    if (isset($key) && !empty($signature)) {
                        $update_signature = SignatureDetail::where('id', $key)->update($signature);
                    }
                }
            }

            if ($update) {
                $msg_update = [
                    'msg' => 'Speichern erfolgreich!',
                    'code' => 200
                ];
            } else {
                $msg_update = [
                    'msg' => 'Fehler speichern!',
                    'code' => 400
                ];
            }

            return redirect('boarding-unterlagen')->with('msg_update', $msg_update);
        }
    }

    public function edit($id)
    {
        if (!empty($id)) {

            $current_id = Auth::id();
            $user_info = DB::table('users')->where('id', $current_id)->select('abbreviations')->first();
            $dashboard = Dashboard::where('id', $id)->first();
            $list_category = DB::table('category')->get();
            $list_tab_form = DB::table('tab_form')->get();
            $list_position = DB::table('position')->get();

            $date_detail = DateDetail::where('form_id', $id)->get();
            $sub_detail = SubDetail::where('form_id', $id)->get();
            $task_detail = TaskDetail::where('form_id', $id)->get();
            $note_detail = NoteDetail::where('form_id', $id)->get();
            $signature_detail = SignatureDetail::where('form_id', $id)->get();

            $list_task = [];
            $tasks = DB::table('list_task')->orderBy('order')->get();
            if (!empty($tasks)) {
                foreach ($tasks as $task) {
                    $ids = [];
                    $task_ids = [];
                    $created = '';
                    $tage = '';
                    $user_confirmed = '';
                    $user_na = false;
                    $task_item = TaskDetail::where(['form_id' => $id, 'category_id' => $task->category_id, 'task_id' => $task->id])->get();
                    $arg_user_group_id = [];
                    $arg_user_group_all = [];

                    if ($task_item) {
                        $group_users = [];
                        foreach ($task_item as $item) {
                          
                            if ($item->user_id) {
                                $first_user_info = DB::table('users')->where('id', $item->user_id)->select('full_name', 'group_id')->first();
                                if (isset($first_user_info->group_id) && !empty($first_user_info->group_id)) {
                                    $user_group_id = DB::table('users')->where('id', $item->user_id)->value('group_id');
                                    $first_user_group = DB::table('group_users')->where('group_id',$user_group_id)->first();
                                    if(!empty($user_group_id)) {
                                        foreach(explode(',',$user_group_id) as $item_user_group) {
                                            if(DB::table('group_users')->where('group_id', $item_user_group)->count() > 0) {
                                                $data_group_name = DB::table('group_users')->where('group_id', $item_user_group)->value('group_name');
                                                if(!in_array($item_user_group,$arg_user_group_id)) {
                                                    array_push($arg_user_group_id,$item_user_group);
                                                    $arg_user_group_all[] = [
                                                        'id' => $item_user_group,
                                                        'name' => $data_group_name
                                                    ];
                                                }
                                            }

                                        } 
                                    }
                                    if (!empty($first_user_info) && !empty($first_user_group)) {
                                        $group_users[] = [
                                            'sub_user_id' => $item->user_id,
                                            'sub_full_name' => $first_user_info->full_name,
                                            'sub_group_id' => $first_user_group->group_id ? $first_user_group->group_id : '',
                                            'sub_group_name' => $first_user_group->group_name ? $first_user_group->group_name : '',
                                        ];
                                    }
                                }
                                $ids[] = $item->user_id;
                            } else if($item->user_id == 0) {
                                $group_users[] = [
                                    'sub_user_id' => 0,
                                    'sub_full_name' => 'N/A',
                                    'sub_group_id' =>  '',
                                    'sub_group_name' => '',
                                ];
                                $user_na = true;
                                $ids[] = 0;
                            } else if($item->user_id == -1) {
                                $group_users[] = [
                                    'sub_user_id' => -1,
                                    'sub_full_name' => '',
                                    'sub_group_id' =>  '',
                                    'sub_group_name' => '',
                                ];
                                $user_na = false;
                                $ids[] = -1;
                            }
                            
                            $tage = $item->tage;
                    
                            if(isset($item->task_date) && !empty($item->task_date)) {
                                $task_date = date("d.m.Y", strtotime($item->task_date));
                            } else {
                                $task_date = '';
                            }
                            $task_ids[] = $item->id;
                            $created = $item->created;
                            $user_confirmed = $item->user_confirmed;
                        }

                        if ($user_confirmed) {
                            $task_checkbox = 1;
                            $task_checkbox_class = 'checked=checked';
                            $task_checkbox_show = 'show-name';
                            $confirmed_info = DB::table('users')->where('id', $user_confirmed)->select('abbreviations')->first();
                            $task_abbreviation = $confirmed_info->abbreviations;
                            $task_datetime = $created ? $created : '';
                        } else {
                            $task_checkbox = 0;
                            $task_checkbox_class = '';
                            $task_checkbox_show = '';
                            $task_abbreviation = $user_info->abbreviations ? $user_info->abbreviations : '';
                            $task_datetime = '';
                        }
                        
                        $list_task[$task->category_id][] = [
                            'id' => $task->id,
                            'name' => $task->name,
                            'category_id' => $task->category_id,
                            'tage' => $tage,
                            'task_date' => $task_date,
                            'ids' => implode(',', $ids),
                            'task_ids' => implode(',', $task_ids),
                            'group_users' => $group_users,
                            'created' => $created,
                            'user_confirmed' => $user_confirmed,
                            'user_na' => $user_na,
                            'task_checkbox' => $task_checkbox,
                            'task_checkbox_class' => $task_checkbox_class,
                            'task_checkbox_show' => $task_checkbox_show,
                            'task_abbreviation' => $task_abbreviation,
                            'task_datetime' => $task_datetime,
                            'arg_user_group' => $arg_user_group_all
                        ];

                    } else {
                        $list_task[$task->category_id][] = [
                            'id' => $task->id,
                            'name' => $task->name,
                            'category_id' => $task->category_id,
                            'tage' => '',
                            'task_date' => '',
                            'ids' => '',
                            'task_ids' => '',
                            'group_users' => [],
                            'created' => '',
                            'user_confirmed' => $user_confirmed,
                            'user_na' => $user_na,
                            'task_checkbox' => 0,
                            'task_checkbox_class' => '',
                            'task_checkbox_show' => '',
                            'task_abbreviation' => '',
                            'task_datetime' => '',
                            'arg_user_group' => [],
                        ];
                    }
                }
            }

            $list_group_users = [];
            $group_users = DB::table('group_users')->get();
            if (!empty($group_users)) {
                foreach ($group_users as $group_user) {
                    $list_group_users[$group_user->group_id] = [
                        'id' => $group_user->group_id,
                        'name' => $group_user->group_name,
                    ];

                    $user_id_group = DB::table('users')->where('group_id', $group_user->group_id)->get();
                    if ($user_id_group) {
                        foreach ($user_id_group as $user_id) {
                            $list_group_users[$group_user->group_id]['users'][] = $user_id->id;
                        }
                    }
                }
            }


            $data = [
                'form_id' => $id,
                'current_abbreviations' => $user_info->abbreviations,
                'dashboard' => $dashboard,
                'date_detail' => $date_detail,
                'sub_detail' => $sub_detail,
                'task_detail' => $task_detail,
                'note_detail' => $note_detail,
                'signature_detail' => $signature_detail,
                'list_category' => $list_category,
                'list_tab_form' => $list_tab_form,
                'list_position' => $list_position,
                'list_task' => $list_task,
                'list_group_users' => $list_group_users,
            ];

            return view('online-checklist/edit', $data);
        } else {
            return redirect('boarding-unterlagen')->with('msg_edit', 'Cannot be edited, please check again.');
        }
    }

    public function list()
    {
        $current_id = Auth::id();
        $list = DB::table('task_detail')
            ->where('user_id','>',0)
            ->join('users', 'users.id', '=', 'task_detail.user_id')
            ->join('list_task', 'list_task.id', '=', 'task_detail.task_id')
            ->join('group_users', 'group_users.group_id', '=', 'users.group_id')
            ->join('category_sub_detail', 'category_sub_detail.category_id', '=', 'task_detail.category_id')
            ->whereColumn('category_sub_detail.form_id', '=', 'task_detail.form_id'); //second join condition
            
        $user_id = 0;// $current_id;
        if (isset($_GET['u']) && $_GET['u'] !== 0) {
            $user_id =  $_GET['u'];
            $list->where('user_id', $user_id);
        }
       
        $group_id = 0;
        if (isset($_GET['g']) && $_GET['g'] !== 0) {
            $group_id =  $_GET['g'];
            $list->where('users.group_id', 'LIKE', '%'.$group_id.'%');           
        }


        $tasks = $list->get(['users.name as user_name', 'users.email', 'task_detail.*', 'list_task.name as task_name', 'category_sub_detail.id as category_id', 'category_sub_detail.created as deadline','group_users.group_name', 'users.group_id as group_id' ]);
        //echo '<pre>'; print_r($tasks); exit('debug');
        $user_open = [];
        $group_list = [];
        foreach (DB::table('users')->get() as $users) {
            if(count(DB::table('task_detail')->where('user_id',$users->id)->where('confirmed','!=','1')->get()) > 0 ) {
                $user_open_id = $users->id;
                if(!empty($users->full_name)) {
                    $user_open_name = $users->full_name;
                } else {
                    $user_open_name = $users->name;
                }
                $user_open[] = [
                    'id' => $user_open_id,
                    'name' => $user_open_name,
                ];
                $current_group = explode(',',$users->group_id);
                foreach($current_group as $group_item) {
                    if(!in_array($group_item,$group_list)) {
                        $group_list[] = [$group_item];
                    }
                }
            }
        }
        $group_open = [];
        foreach (DB::table('group_users')->whereIn('group_id',$group_list)->get() as $group_open_item) {
            $group_open[] = [
                'group_id' => $group_open_item->group_id,
                'group_name' => $group_open_item->group_name,
            ];
        }
        $data = [
            'tasks' => $tasks,
            'user_id' => $user_id,
            'group_id' => $group_id,
            'user_open' => $user_open,
            'group_open' => $group_open,

        ];
        return view('dashboard', $data);
    }

    public function update_task(Request $request)
    {
        $task_id = $request->task_id;
        if (!empty($task_id)) {

            $task_update = [
                'confirmed' => $request->confirmed,
                'user_confirmed' => Auth::id(),
                'created' => date("Y-m-d", strtotime('now'))
            ];

            $update_task = TaskDetail::where('id', $task_id)->update($task_update);
            if ($update_task) {
                return response()->json(['msg' => 'Update success'], 200);
            } else {
                return response()->json(['msg' => 'Update failed'], 400);
            }
        } else {
            return response()->json(['msg' => 'Cannot find the task need update'], 400);
        }
    }

    public function check_deadline()
    {
        $list = DB::table('task_detail')
            ->join('users', 'users.id', '=', 'task_detail.user_id')
            ->join('list_task', 'list_task.id', '=', 'task_detail.task_id')
            ->join('category_sub_detail', 'category_sub_detail.category_id', '=', 'task_detail.category_id')
            ->whereColumn('category_sub_detail.form_id', '=', 'task_detail.form_id') //second join condition
            ->get(['users.name as user_name', 'users.email', 'task_detail.*', 'list_task.name as task_name', 'category_sub_detail.id as category_id', 'category_sub_detail.created as deadline']);
        if ($list) {
            foreach ($list as $task) {
                //$current_date = date("Y-m-d", strtotime('now'));
                $current_date = '2022-05-05';
                if ($current_date == $task->deadline) {
                    $check_send = Mail::send('emails.deadline', ['task' => $task], function ($message) use ($task) {
                        $message->from('admin@onboarding.cslb.at', 'CSLB Onboarding');
                        $message->to($task->email, $task->user_name)->subject('Deadline task: '.$task->task_name);
                        //$message->to('jptesting3@gmail.com', $task->user_name)->subject('Deadline task: ' . $task->task_name);
                        //$this->send_email();
                    });

                    var_dump($check_send);
                }
                break;
            }
        }
    }

    public function check_confirmation()
    {
        $list = DB::table('task_detail')
            ->whereNotNull('task_date')
            ->join('users', 'users.id', '=', 'task_detail.user_id')
            ->join('list_task', 'list_task.id', '=', 'task_detail.task_id')
            ->join('category_sub_detail', 'category_sub_detail.category_id', '=', 'task_detail.category_id')
            ->whereColumn('category_sub_detail.form_id', '=', 'task_detail.form_id') //second join condition
            ->get(['users.name as user_name', 'users.email', 'task_detail.*', 'list_task.name as task_name', 'list_task.task_date as task_date', 'category_sub_detail.id as category_id', 'category_sub_detail.created as deadline']);
        if ($list) {
            foreach ($list as $task) {
                //$current_date = date("Y-m-d", strtotime('now'));
                $current_date = '2022-05-05';
                if ($current_date == $task->task_date) {
                    $check_send = Mail::send('emails.confirmation', ['task' => $task], function ($message) use ($task) {
                        $message->from('admin@onboarding.cslb.at', 'CSLB Onboarding');
                        $message->to($task->email, $task->user_name)->subject('Codemenschen Test: '.$task->task_name .$task->task_date);
                        //$message->to('jptesti= \ g3@gmail.com', $task->user_name)->subject('Deadline task: ' . $task->task_name);
                        //$this->send_email();
                    });

                    var_dump($check_send);
                }
                break;
            }
        }
    }
}
