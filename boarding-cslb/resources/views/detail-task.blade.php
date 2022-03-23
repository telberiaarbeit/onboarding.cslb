<?php use Illuminate\Support\Facades\Auth; ?>
@guest   
    <?php header("Location: https://www.telberia.com/projects/boarding-cslb");
    exit(); ?> 
@else
    @extends('layouts.public')
    @section('content')
    <?php $data_task = \App\Custom\DataDemo::getTask();
    $task_id = $_GET['id'];
     ?>
    <div class="dashboard detail-page">
        <div class="container">
            <?php foreach($data_task as $task_details) { 
                if($task_id == $task_details['task_id']) {
                    $status_task = true;
                    foreach($task_details['task_user'] as $task_user) {
                        if(empty($task_user['end_date'])) {
                            $status_task = false;
                            break;
                        }
                    } ?>
                    <div class="row">
                        <div class="col-md-12 d-flex flex-wrap align-items-start mb-5">
                            <h2 class="top-title mr-3 mb-2">Einzelheiten</h2>
                            <?php if( $status_task == false ) {
                                echo '<span class="task-status"><span class="incomplete status">Unvollständig</span></span>';
                            } else {
                                echo '<span class="task-status"><span class="status complete">Done</span></span>';
                            } ?>
                            
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-12 pb-3 mb-3">
                                    <strong>Verantwortlicher für den Task: </strong>
                                    <span class="border-style "><?php echo $task_details['responsible_person']; ?></span>
                                </div>
                                <div class="col-md-6 pb-3 mb-3">
                                    <strong>Aufgabenerstellungsdatum: </strong>
                                    <span class="border-style"><?php echo $task_details['task_start_date']; ?></span>
                                </div>
                                <div class="col-md-6 pb-3 mb-3">
                                    <strong>Deadline: </strong>
                                    <span class="border-style"><?php echo $task_details['task_dealine']; ?></span>
                                </div>
                                <div class="col-md-12 pb-3 mb-3">
                                    <strong>Formular Name: </strong>
                                    <span class="border-style"><?php echo $task_details['form_name']; ?></span>
                                </div>
                                <div class="col-md-12 recipient-email-list">
                                    <p><strong>Empfängerliste: </strong></p>
                                    <div class="email-list">                 
                                        <ul id="email-added">
                                            <?php foreach($task_details['task_user'] as $task_user_detail) { 
                                                echo '<li class="item" data-id="'.$task_user_detail['id'].'">';
                                                echo '<strong>'.DB::table('users')->where('id', $task_user_detail['id'])->value('name').'</strong>';
                                                echo '<a href="#" class="email">'.DB::table('users')->where('id', $task_user_detail['id'])->value('email').'</a>';
                                                if(empty($task_user_detail['end_date'])) {
                                                    echo '<span class="task-status"><span class="status">Unvollständig</span></span>';
                                                } else {
                                                    echo '<span class="task-status"><span class="status complete">Done</span></span>';
                                                }
                                                echo '<button class="send-mail">E-Mail senden <i class="fas fa-envelope"></i></button>';
                                                echo '</li>';
                                                ?>
                                            <?php } ?>
                                        </ul>  

                                        <div class="item-add-email">
                                            <button class="add-email">
                                                <i class="far fa-plus"></i>
                                            </button>
                                            <div class="email-list" id="list-to-add" style="display: none;">
                                                <ul>
                                                    <?php 
                                                    foreach(DB::table('users')->get() as $users_data) {
                                                        $added = false;
                                                        foreach($task_details['task_user'] as $task_user_detail) { 
                                                            if($users_data->id == $task_user_detail['id']) {
                                                                $added = true;
                                                                break;
                                                            }
                                                        }
                                                        if($added == false) {
                                                            echo '<li class="item" data-id="'.$users_data->id.'">';
                                                        } else echo '<li class="item" data-id="'.$users_data->id.'" style="opacity: 0.5;pointer-events: none;">';
                                                        echo '<strong>'.$users_data->full_name.'</strong>';
                                                        echo '<span class="item-email"><a href="#" class="email">'.$users_data->email.'</a><button class="add-item"><i class="far fa-plus"></i></button></span>';
                                                        echo '</li>';

                                                    } ?>
                                                </ul>
                                                <!-- <div class="col-md-12 wrap-pagination">
                                                    <nav aria-label="...">
                                                        <ul class="pagination pagination-sm">
                                                            <li class="page-item disabled">
                                                              <a class="page-link" href="#" tabindex="-1">1</a>
                                                            </li>
                                                            <li class="page-item"><a class="page-link" href="#">2</a></li>
                                                            <li class="page-item"><a class="page-link" href="#">3</a></li>
                                                        </ul>
                                                    </nav>
                                                </div> -->
                                                
                                            </div>
                                        </div>                                
                                    </div> 
                                    <input type="hidden" name="" id="added_email_detail" value="1,2,3,4,5">
                                    <p>
                                        <button class="button-main send-all">E-Mail an alle</button>
                                        <button class="button-main save">Speichern Sie</button>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
            <?php break;
                }
            } ?>
        </div>
    </div>
        
    @endsection
@endguest