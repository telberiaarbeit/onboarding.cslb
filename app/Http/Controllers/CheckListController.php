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

class CheckListController extends Controller
{
    public function index(){
       
        if(Auth::check()) {
            
            $data = [];

            $current_id = Auth::id();
            if($current_id == 1) {
                $list_data = Checklist::all();
            } else {
                $list_data = Checklist::where('user_id', $current_id)->get();
            }
            
            if(!empty($list_data)) {
                foreach($list_data as $item) {
                    $data[] = [
                        'id' => $item['id'],
                        'name' => $item['name'],
                        'full_name' => Checklist::full_name($item['user_id']),
                        'created_at' => $item['created_at'],
                    ];
                }   
            }

            return view('boarding-unterlagen', ['current_id' => $current_id, 'data' => $data]);
        } else {
            return redirect('/');
        }
    }

    public function create(){
        return view('online-checkliste-create');
    }


    public function store(Request $request)
    {
        $user = Auth::user();
        // echo '<pre>';
        // var_dump($request->all());
        // exit;

        $validator = Validator::make($request->all(), [
            'floatingName' => 'required',
            'floatingSelect' => 'required',
            'manager_id' => 'required',
        ]);

        if ($validator->fails()) {
            $messages = $validator->messages();
            return redirect('boarding-unterlagen')->withErrors($messages);
        } else {

            $name = $request->input('floatingName');
            $user_id = $request->input('manager_id');
            $position_id = $request->input('floatingSelect');

            $data = [
                'name' => $name,
                'user_id' => $user_id,
                'position_id' => $position_id,
            ];
            
            if ($request->has('status')) {
                $status = $request->input('status');
                $data['status'] = $status;
            }

            $create = Checklist::create($data);
            if($create) {
                $msg_create = 'Create success!';
            } else {
                $msg_create = 'Create failure!';
            }
            
            return redirect('boarding-unterlagen')->with('msg_create', $msg_create);
        }
    }

    public function update(Request $request, $id)
    {
        
    }

    public function destroy(Request $request, $id)
    {

    }

    public function edit($id)
    {
        
    }
}