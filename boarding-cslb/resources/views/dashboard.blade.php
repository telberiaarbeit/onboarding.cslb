<?php use Illuminate\Support\Facades\Auth; ?>
@guest   
    <?php header("Location: https://www.telberia.com/projects/boarding-cslb");
    exit(); ?> 
@else
    @extends('layouts.public')
    @section('content')
    <?php 
    $task_data = \App\Custom\DataDemo::getTask();
    ?>
    <main class="dashboard">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="top-title">Dashboard</h2>
                </div>
            </div>
            <div class="row">
                <div class="col-md-8">
                    <a href="https://www.telberia.com/projects/boarding-cslb/new-task" class="button-main">Neue Aufgabe anlegen</a>
                </div>
                <div class="group-item col-md-4">
                    <div class="form-group input-group">
                        <span class="has-float-label">
                            <select class="form-select form-control" id="floatingFilter" aria-label="Sortiermöglichkeit nach:">
                                <option value="0" selected>Alle</option>
                                <option value="intern">Verantwortlicher</option>
                                <option value="extern">System</option>
                                <option value="contingent-worker">Fälligkeitsperiode/datum</option>
                            </select>
                            <label for="floatingFilter">Sortiermöglichkeit nach:</label>
                        </span>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 pb-2 mb-2">
                    <div class="row label-task text-uppercase">
                        <div class="task-name col-lg-2"><strong>Aufgabe Name</strong></div> 
                        <div class="task-status col-lg-2"><strong>Status</strong></div>
                        <div class="responsible-person col-lg-2"><strong>Verantwortliche</strong></div> 
                        <div class="entry-date col-lg-3"><strong>Aufgabenerstellungsdatum</strong></div> 
                        <div class="deadline col-lg-1"><strong>Deadline</strong></div>
                        <div class="col-md-2"></div>                 
                    </div>
                    <div class="row list-checklist">
                        <div class="col-md-12">
                            <?php 
                            foreach($task_data as $task_data) {
                                echo '<div class="row mb-4 py-4 item align-items-center">';
                                    echo '<div class="task-name col-lg-2" data-label="Aufgabe Name">'.$task_data['task_name'].'</div>';
                                        echo '<div class="task-status col-lg-2" data-label="Status">';
                                            $incomplete = 0;
                                            $total_user = 0;
                                            foreach($task_data['task_user'] as $task_user) {
                                                $total_user++;
                                                if(empty($task_user['end_date'])) {
                                                    $incomplete++;
                                                }
                                            } 
                                            if($incomplete == 0) {
                                                echo '<span class="complete status">Done</span>';
                                                echo '<span class="list-user"><i class="fas fa-users"></i>'.$total_user.'/'.$total_user.'</span>';
                                            } else {
                                                echo '<span class="incomplete status">Unvollständig</span>';
                                                echo '<span class="list-user"><i class="fas fa-users"></i>'.$incomplete.'/'.$total_user.'</span>';
                                            }   
                                        echo '</div>';
                                    echo '<div class="responsible-person col-lg-2" data-label="Verantwortliche">'.$task_data['responsible_person'].'</div> ';
                                    echo '<div class="entry-date col-lg-3" data-label="Aufgabenerstellungsdatum">'.$task_data['task_start_date'].'</div>';
                                    echo '<div class="deadline col-lg-1" data-label="Deadline">'.$task_data['task_dealine'].'</div>';
                                    echo '<div class="col-md-2">
                                        <a href="https://www.telberia.com/projects/boarding-cslb/detail?id='.$task_data['task_id'].'" class="button-main">Mehr lesen</a>
                                    </div> ';
                                echo '</div>';

                            } ?>
                        </div>
                    </div>
                </div>
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
    </main>
        
    @endsection
@endguest