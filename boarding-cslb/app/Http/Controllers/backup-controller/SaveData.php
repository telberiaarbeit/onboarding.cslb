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

class SaveData extends Controller
{
    public function save_new_form(){
        $form_data =  $_POST['form_data'];
        $arg_deadline = array();
        $form_id;
        $manager_id;
        foreach($form_data as $form_data) {
            $val = $form_data['name'];
            $val_arg = explode( '_', $val );
            if(in_array("deadline", $val_arg)) {
                $cat_id = $val_arg[1];
                $arg_deadline[$cat_id] = $form_data['value'];
            }
            if($form_data['name'] == "form_id") {
                $form_id = $form_data['value'];
            } 
            if($form_data['name'] == "manager_id") {
                $manager_id = $form_data['value'];
            }     
        }
        $data_deadline = json_encode($arg_deadline);
        
        DB::table('form_data')->where('form_id',$form_id) ->update([
            'form_status' => "publish",
            'manage_id' => $manager_id,
            'group_deadline' => $data_deadline
        ]);

        return response()->json(['success'=> '1']);

    }
}