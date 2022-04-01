<?php use Illuminate\Support\Facades\Auth; ?>
@guest   
    <?php header("Location: https://www.telberia.com/projects/boarding-cslb");
    exit(); ?> 
@else
    @extends('layouts.public')
    @section('content')
    
    <div class="new-task-page">
        <div class="container">
            <div class="row">
                <div class="col-md-12 d-flex align-items-start">
                    <h2 class="top-title">Neue Aufgabe anlegen</h2>
                </div>
            </div>
            <div class="row block-title">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-12 pb-3 mb-3 group-item">
                            <div class="form-group input-group">
                                <span class="has-float-label">
                                    <input type="text" class="form-control" id="floatingName" placeholder=" " value="Elvan Döner"> 
                                    <label for="floatingName">Verantwortlicher für den Task:</label>
                                </span>
                            </div>
                        </div>
                        <div class="col-md-12 pb-3 mb-3 group-item">
                            <div class="form-group input-group">
                                <span class="has-float-label">
                                    <input type="text" class="form-control" id="floatingName" placeholder=" " value=""> 
                                    <label for="floatingName">Aufgabe Name</label>
                                </span>
                            </div>
                        </div>
                        <div class="col-md-6 pb-3 mb-3 group-item">
                            <div class="input-group align-items-end px-2">
                                <label for="entry-date">Aufgabenerstellungsdatum:</label>
                                <input type="text" class="form-control datetimepicker-input datetimepicker" id="datetimepicker-entry" data-toggle="datetimepicker" data-target="#datetimepicker-entry" aria-label="Eintritt Datum">
                             </div>
                        </div>
                        <div class="col-md-6 pb-3 mb-3 group-item">
                            <div class="input-group align-items-end px-2">
                                <label for="deadline-date">Deadline:</label>
                                <input type="text" class="form-control datetimepicker-input datetimepicker" id="datetimepicker-deadline" data-toggle="datetimepicker" data-target="#datetimepicker-deadline" aria-label="Deadline">
                             </div>
                        </div>
                        <div class="group-item col-md-12">
                            <div class="form-group input-group">
                                <span class="has-float-label">
                                    <select class="form-select form-control" id="floatingSelect" aria-label="Formular Name:">
                                        <option value="Online Checkliste" selected="">Online Checkliste</option>                                   
                                    </select>
                                    <label for="floatingSelect">Formular Name:</label>
                                </span>
                            </div>
                        </div>
                        <div class="col-md-12 recipient-email-list">
                            <p class="px-2"><strong>Empfängerliste: </strong></p> 
                            <div class="email-list">                             
                                <ul id="email-added">
                                </ul>                                
                                <div class="item-add-email">
                                    <button class="add-email">
                                        <i class="far fa-plus"></i>
                                    </button>
                                    <div class="email-list" id="list-to-add" style="display: none;">
                                        <ul>
                                            <li class="item" data-id="1">
                                                <strong>Elvan Döner 1</strong>
                                                <span class="item-email">
                                                    <a href="#" class="email">demo@gmail.com</a>
                                                    <button class="add-item"><i class="far fa-plus"></i></button>
                                                </span>
                                            </li>
                                            <li class="item" data-id="2">
                                                <strong>Elvan Döner 2</strong>
                                                <span class="item-email">
                                                    <a href="#" class="email">demo@gmail.com</a>
                                                    <button class="add-item"><i class="far fa-plus"></i></button>
                                                </span>
                                            </li>
                                            <li class="item" data-id="3">
                                                <strong>Elvan Döner 3</strong>
                                                <span class="item-email">
                                                    <a href="#" class="email">demo@gmail.com</a>
                                                    <button class="add-item"><i class="far fa-plus"></i></button>
                                                </span>
                                            </li>
                                            <li class="item" data-id="4">
                                                <strong>Elvan Döner 4</strong>
                                                <span class="item-email">
                                                    <a href="#" class="email">demo@gmail.com</a>
                                                    <button class="add-item"><i class="far fa-plus"></i></button>
                                                </span>
                                            </li>
                                            <li class="item" data-id="5">
                                                <strong>Elvan Döner 5</strong>
                                                <span class="item-email">
                                                    <a href="#" class="email">demo@gmail.com</a>
                                                    <button class="add-item"><i class="far fa-plus"></i></button>
                                                </span>
                                            </li>
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
                            <input type="hidden" name="" id="all-email-added" value="">
                            <p>
                                <button class="button-main save">Save</button>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
        
    @endsection
@endguest