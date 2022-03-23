<?php use Illuminate\Support\Facades\Auth; ?>
@guest   
    <?php header("Location: https://www.telberia.com/projects/boarding-cslb");
    exit(); ?> 
@else
    @extends('layouts.public')
    @section('content')
    <?php $home_link = "https://www.telberia.com/projects/boarding-cslb";
    $data = \App\Custom\DataDemo::getTask();
    $current_id = Auth::id();
     ?>
        <div class="site-main" id="boarding-unterlagen-page">
            <div class="container py-5">
                <h2 class="top-title mb-5">Übersicht</h2>
                <div class="row mb-5">
                    <div class="col-md-8">
                        <a href="https://www.telberia.com/projects/boarding-cslb/online-checkliste-create?id=1&form_id=10" class="button-main">New Employee Onboarding</a>
                    </div>
                    <!-- <div class="group-item col-md-4">
                        <div class="form-group input-group">
                            <span class="has-float-label">
                                <select class="form-select form-control" id="floatingFilter" aria-label="Sortiermöglichkeit nach:">
                                    <option value="0" selected="">Alle</option>
                                    <option value="intern">Verantwortlicher</option>
                                    <option value="extern">System</option>
                                    <option value="contingent-worker">Fälligkeitsperiode/datum</option>
                                </select>
                                <label for="floatingFilter">Sortiermöglichkeit nach:</label>
                            </span>
                        </div>
                    </div> -->
                </div>
                <div class="row">
                    <div class="col-md-12 label-checklist text-uppercase pb-2 mb-2">
                        <div class="row">
                            <div class="checklist-id col-lg-2" data-label="AUFGABE NAME"><strong>AUFGABE NAME</strong></div> 
                            <div class="checklist-name col-lg-4" data-label="Name Mitarbeiter"><strong>Name Mitarbeiter</strong></div> 
                            <div class="entry-date col-lg-3" data-label="Eintritt Datum"><strong>Eintritt Datum</strong></div> 
                            <div class="checklist-action col-md-3"></div>                 
                        </div>
                    </div>
                    <?php foreach ($data as $data) {
                        $task_id = $data['task_id'];
                        $task_name = $data['task_name'];
                        $form_id = $data['form_id'];
                        if( $current_id == '1') {
                            foreach ($data['task_user'] as $data_form ) { ?>
                                <div class="col-md-12 list-checklist">
                                    <div class="row mb-4 py-4 item align-items-center">
                                        <div class="checklist-id col-lg-2" data-label="AUFGABE NAME"><?php echo $task_name; ?></div> 
                                        <div class="checklist-name col-lg-4" data-label="Name Mitarbeiter"><?php echo DB::table('users')->where('id', $data_form['id'])->value('full_name'); ?></div>
                                        <div class="entry-date col-lg-3" data-label="Eintritt Datum"><?php echo $data_form['start_date'] ?></div>
                                        <div class="checklist-action col-lg-3 text-right">
                                            <a href="https://www.telberia.com/projects/boarding-cslb/online-checkliste?task_id=<?php echo $task_id; ?>&id=<?php echo $data_form['id']; ?>&form_id=<?php echo $form_id; ?>"class="edit-checklist">Edit</a>
                                        </div>                 
                                    </div>
                                </div>
                            <?php }
                        } else {
                            foreach ($data['task_user'] as $data_form ) { 
                                if($data_form['id'] == $current_id ) { ?>
                                    <div class="col-md-12 list-checklist">
                                        <div class="row mb-4 py-4 item align-items-center">
                                            <div class="checklist-id col-lg-2" data-label="AUFGABE NAME"><?php echo $task_name; ?></div> 
                                            <div class="checklist-name col-lg-4" data-label="Name Mitarbeiter"><?php echo DB::table('users')->where('id', $data_form['id'])->value('full_name'); ?></div>
                                            <div class="entry-date col-lg-3" data-label="Eintritt Datum"><?php echo $data_form['start_date'] ?></div>
                                            <div class="checklist-action col-lg-3 text-right">
                                                <a href="https://www.telberia.com/projects/boarding-cslb/online-checkliste?task_id=<?php echo $task_id; ?>&id=<?php echo $data_form['id']; ?>&form_id=<?php echo $form_id; ?>"class="edit-checklist">Edit</a>
                                            </div>                 
                                        </div>
                                    </div>
                                <?php }   
                            }                         
                        }
                    } ?>
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
    @endsection
@endguest