@extends('layouts.private-2')

@section('content')

<main class="task-manager">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2 class="top-title">Task Manager</h2>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 pb-2 mb-2">
                <div class="row label-task text-uppercase">
                    <div class="task-id"><strong>Id</strong></div> 
                    <div class="task-name col-lg-4"><strong>Task name</strong></div> 
                    <div class="task-sdate col-lg-2"><strong>Start day</strong></div> 
                    <div class="task-deadline col-lg-2"><strong>Deadline</strong></div>
                    <div class="task-assigned col-lg-2"><strong>Assigned</strong></div>         
                    <div class="task-action"><strong></strong></div>        
                </div>
                <div class="row list-checklist">
                    <div class="col-md-12">
                        <div class="row py-4 item align-items-center">
                            <div class="task-id" data-label="Id">1</div> 
                            <div class="task-name col-lg-4" data-label="Task name">
                                <select class="form-select form-control" name="task-name" id="task_name">
                                    <option selected>Select Task name</option>
                                    <option value="task_1">Task name 1</option>
                                    <option value="task_2">Task name 2</option>
                                    <option value="task_3">Task name 3</option>
                                </select>
                            </div> 
                            <div class="task-sdate col-lg-2" data-label="Start day">
                                <div class="date" data-provide="datepicker" data-date-format="dd.mm.yyyy">
                                    <input type="text" class="form-control">
                                    <div class="input-group-addon">
                                        <span class="glyphicon glyphicon-th"></span>
                                    </div>
                                </div>
                            </div> 
                            <div class="task-deadline col-lg-2" data-label="Deadline">
                                <div class="date" data-provide="datepicker" data-date-format="dd.mm.yyyy">
                                    <input type="text" class="form-control">
                                    <div class="input-group-addon">
                                        <span class="glyphicon glyphicon-th"></span>
                                    </div>
                                </div>
                            </div>    
                            <div class="task-assigned col-lg-2">
                                <select class="form-select form-control" name="user-name" id="user_name">
                                    <option selected>Select user</option>
                                    <option value="user_1">Elvan Döner</option>
                                    <option value="user_2">Elvan Döner</option>
                                    <option value="user_3">Elvan Döner</option>
                                </select>
                            </div>
                            <div class="task-action"><a class="button-main" href="#">Send</a></div>             
                        </div>
                        <div class="row py-4 item align-items-center">
                            <div class="task-id" data-label="Id">2</div> 
                            <div class="task-name col-lg-4" data-label="Task name">
                                <select class="form-select form-control" name="task-name" id="task_name">
                                    <option selected>Select Task name</option>
                                    <option value="task_1">Task name 1</option>
                                    <option value="task_2">Task name 2</option>
                                    <option value="task_3">Task name 3</option>
                                </select>
                            </div> 
                            <div class="task-sdate col-lg-2" data-label="Start day">
                                <div class="date" data-provide="datepicker" data-date-format="dd.mm.yyyy">
                                    <input type="text" class="form-control">
                                    <div class="input-group-addon">
                                        <span class="glyphicon glyphicon-th"></span>
                                    </div>
                                </div>
                            </div> 
                            <div class="task-deadline col-lg-2" data-label="Deadline">
                                <div class="date" data-provide="datepicker" data-date-format="dd.mm.yyyy">
                                    <input type="text" class="form-control">
                                    <div class="input-group-addon">
                                        <span class="glyphicon glyphicon-th"></span>
                                    </div>
                                </div>
                            </div>    
                            <div class="task-assigned col-lg-2">
                                <select class="form-select form-control" name="user-name" id="user_name">
                                    <option selected>Select user</option>
                                    <option value="user_1">Elvan Döner</option>
                                    <option value="user_2">Elvan Döner</option>
                                    <option value="user_3">Elvan Döner</option>
                                </select>
                            </div>
                            <div class="task-action"><a class="button-main" href="#">Send</a></div>             
                        </div>
                        <div class="row py-4 item align-items-center">
                            <div class="task-id" data-label="Id">3</div> 
                            <div class="task-name col-lg-4" data-label="Task name">
                                <select class="form-select form-control" name="task-name" id="task_name">
                                    <option selected>Select Task name</option>
                                    <option value="task_1">Task name 1</option>
                                    <option value="task_2">Task name 2</option>
                                    <option value="task_3">Task name 3</option>
                                </select>
                            </div> 
                            <div class="task-sdate col-lg-2" data-label="Start day">
                                <div class="date" data-provide="datepicker" data-date-format="dd.mm.yyyy">
                                    <input type="text" class="form-control">
                                    <div class="input-group-addon">
                                        <span class="glyphicon glyphicon-th"></span>
                                    </div>
                                </div>
                            </div> 
                            <div class="task-deadline col-lg-2" data-label="Deadline">
                                <div class="date" data-provide="datepicker" data-date-format="dd.mm.yyyy">
                                    <input type="text" class="form-control">
                                    <div class="input-group-addon">
                                        <span class="glyphicon glyphicon-th"></span>
                                    </div>
                                </div>
                            </div>    
                            <div class="task-assigned col-lg-2">
                                <select class="form-select form-control" name="user-name" id="user_name">
                                    <option selected>Select user</option>
                                    <option value="user_1">Elvan Döner</option>
                                    <option value="user_2">Elvan Döner</option>
                                    <option value="user_3">Elvan Döner</option>
                                </select>
                            </div>
                            <div class="task-action"><a class="button-main" href="#">Send</a></div>             
                        </div>
                        <div class="row py-4 item align-items-center">
                            <div class="task-id" data-label="Id">4</div> 
                            <div class="task-name col-lg-4" data-label="Task name">
                                <select class="form-select form-control" name="task-name" id="task_name">
                                    <option selected>Select Task name</option>
                                    <option value="task_1">Task name 1</option>
                                    <option value="task_2">Task name 2</option>
                                    <option value="task_3">Task name 3</option>
                                </select>
                            </div> 
                            <div class="task-sdate col-lg-2" data-label="Start day">
                                <div class="date" data-provide="datepicker" data-date-format="dd.mm.yyyy">
                                    <input type="text" class="form-control">
                                    <div class="input-group-addon">
                                        <span class="glyphicon glyphicon-th"></span>
                                    </div>
                                </div>
                            </div> 
                            <div class="task-deadline col-lg-2" data-label="Deadline">
                                <div class="date" data-provide="datepicker" data-date-format="dd.mm.yyyy">
                                    <input type="text" class="form-control">
                                    <div class="input-group-addon">
                                        <span class="glyphicon glyphicon-th"></span>
                                    </div>
                                </div>
                            </div>    
                            <div class="task-assigned col-lg-2">
                                <select class="form-select form-control" name="user-name" id="user_name">
                                    <option selected>Select user</option>
                                    <option value="user_1">Elvan Döner</option>
                                    <option value="user_2">Elvan Döner</option>
                                    <option value="user_3">Elvan Döner</option>
                                </select>
                            </div>
                            <div class="task-action"><a class="button-main" href="#">Send</a></div>             
                        </div>
                        <div class="row py-4 item align-items-center">
                            <div class="task-id" data-label="Id">5</div> 
                            <div class="task-name col-lg-4" data-label="Task name">
                                <select class="form-select form-control" name="task-name" id="task_name">
                                    <option selected>Select Task name</option>
                                    <option value="task_1">Task name 1</option>
                                    <option value="task_2">Task name 2</option>
                                    <option value="task_3">Task name 3</option>
                                </select>
                            </div> 
                            <div class="task-sdate col-lg-2" data-label="Start day">
                                <div class="date" data-provide="datepicker" data-date-format="dd.mm.yyyy">
                                    <input type="text" class="form-control">
                                    <div class="input-group-addon">
                                        <span class="glyphicon glyphicon-th"></span>
                                    </div>
                                </div>
                            </div> 
                            <div class="task-deadline col-lg-2" data-label="Deadline">
                                <div class="date" data-provide="datepicker" data-date-format="dd.mm.yyyy">
                                    <input type="text" class="form-control">
                                    <div class="input-group-addon">
                                        <span class="glyphicon glyphicon-th"></span>
                                    </div>
                                </div>
                            </div>    
                            <div class="task-assigned col-lg-2">
                                <select class="form-select form-control" name="user-name" id="user_name">
                                    <option selected>Select user</option>
                                    <option value="user_1">Elvan Döner</option>
                                    <option value="user_2">Elvan Döner</option>
                                    <option value="user_3">Elvan Döner</option>
                                </select>
                            </div>
                            <div class="task-action"><a class="button-main" href="#">Send</a></div>             
                        </div>
                        <div class="row py-4 item align-items-center">
                            <div class="task-id" data-label="Id">6</div> 
                            <div class="task-name col-lg-4" data-label="Task name">
                                <select class="form-select form-control" name="task-name" id="task_name">
                                    <option selected>Select Task name</option>
                                    <option value="task_1">Task name 1</option>
                                    <option value="task_2">Task name 2</option>
                                    <option value="task_3">Task name 3</option>
                                </select>
                            </div> 
                            <div class="task-sdate col-lg-2" data-label="Start day">
                                <div class="date" data-provide="datepicker" data-date-format="dd.mm.yyyy">
                                    <input type="text" class="form-control">
                                    <div class="input-group-addon">
                                        <span class="glyphicon glyphicon-th"></span>
                                    </div>
                                </div>
                            </div> 
                            <div class="task-deadline col-lg-2" data-label="Deadline">
                                <div class="date" data-provide="datepicker" data-date-format="dd.mm.yyyy">
                                    <input type="text" class="form-control">
                                    <div class="input-group-addon">
                                        <span class="glyphicon glyphicon-th"></span>
                                    </div>
                                </div>
                            </div>    
                            <div class="task-assigned col-lg-2">
                                <select class="form-select form-control" name="user-name" id="user_name">
                                    <option selected>Select user</option>
                                    <option value="user_1">Elvan Döner</option>
                                    <option value="user_2">Elvan Döner</option>
                                    <option value="user_3">Elvan Döner</option>
                                </select>
                            </div>
                            <div class="task-action"><a class="button-main" href="#">Send</a></div>             
                        </div>
                        <div class="row py-4 item align-items-center">
                            <div class="task-id" data-label="Id">7</div> 
                            <div class="task-name col-lg-4" data-label="Task name">
                                <select class="form-select form-control" name="task-name" id="task_name">
                                    <option selected>Select Task name</option>
                                    <option value="task_1">Task name 1</option>
                                    <option value="task_2">Task name 2</option>
                                    <option value="task_3">Task name 3</option>
                                </select>
                            </div> 
                            <div class="task-sdate col-lg-2" data-label="Start day">
                                <div class="date" data-provide="datepicker" data-date-format="dd.mm.yyyy">
                                    <input type="text" class="form-control">
                                    <div class="input-group-addon">
                                        <span class="glyphicon glyphicon-th"></span>
                                    </div>
                                </div>
                            </div> 
                            <div class="task-deadline col-lg-2" data-label="Deadline">
                                <div class="date" data-provide="datepicker" data-date-format="dd.mm.yyyy">
                                    <input type="text" class="form-control">
                                    <div class="input-group-addon">
                                        <span class="glyphicon glyphicon-th"></span>
                                    </div>
                                </div>
                            </div>    
                            <div class="task-assigned col-lg-2">
                                <select class="form-select form-control" name="user-name" id="user_name">
                                    <option selected>Select user</option>
                                    <option value="user_1">Elvan Döner</option>
                                    <option value="user_2">Elvan Döner</option>
                                    <option value="user_3">Elvan Döner</option>
                                </select>
                            </div>
                            <div class="task-action"><a class="button-main" href="#">Send</a></div>             
                        </div>
                        <div class="row py-4 item align-items-center">
                            <div class="task-id" data-label="Id">8</div> 
                            <div class="task-name col-lg-4" data-label="Task name">
                                <select class="form-select form-control" name="task-name" id="task_name">
                                    <option selected>Select Task name</option>
                                    <option value="task_1">Task name 1</option>
                                    <option value="task_2">Task name 2</option>
                                    <option value="task_3">Task name 3</option>
                                </select>
                            </div> 
                            <div class="task-sdate col-lg-2" data-label="Start day">
                                <div class="date" data-provide="datepicker" data-date-format="dd.mm.yyyy">
                                    <input type="text" class="form-control">
                                    <div class="input-group-addon">
                                        <span class="glyphicon glyphicon-th"></span>
                                    </div>
                                </div>
                            </div> 
                            <div class="task-deadline col-lg-2" data-label="Deadline">
                                <div class="date" data-provide="datepicker" data-date-format="dd.mm.yyyy">
                                    <input type="text" class="form-control">
                                    <div class="input-group-addon">
                                        <span class="glyphicon glyphicon-th"></span>
                                    </div>
                                </div>
                            </div>    
                            <div class="task-assigned col-lg-2">
                                <select class="form-select form-control" name="user-name" id="user_name">
                                    <option selected>Select user</option>
                                    <option value="user_1">Elvan Döner</option>
                                    <option value="user_2">Elvan Döner</option>
                                    <option value="user_3">Elvan Döner</option>
                                </select>
                            </div>
                            <div class="task-action"><a class="button-main" href="#">Send</a></div>             
                        </div>
                        <div class="row py-4 item align-items-center">
                            <div class="task-id" data-label="Id">9</div> 
                            <div class="task-name col-lg-4" data-label="Task name">
                                <select class="form-select form-control" name="task-name" id="task_name">
                                    <option selected>Select Task name</option>
                                    <option value="task_1">Task name 1</option>
                                    <option value="task_2">Task name 2</option>
                                    <option value="task_3">Task name 3</option>
                                </select>
                            </div> 
                            <div class="task-sdate col-lg-2" data-label="Start day">
                                <div class="date" data-provide="datepicker" data-date-format="dd.mm.yyyy">
                                    <input type="text" class="form-control">
                                    <div class="input-group-addon">
                                        <span class="glyphicon glyphicon-th"></span>
                                    </div>
                                </div>
                            </div> 
                            <div class="task-deadline col-lg-2" data-label="Deadline">
                                <div class="date" data-provide="datepicker" data-date-format="dd.mm.yyyy">
                                    <input type="text" class="form-control">
                                    <div class="input-group-addon">
                                        <span class="glyphicon glyphicon-th"></span>
                                    </div>
                                </div>
                            </div>    
                            <div class="task-assigned col-lg-2">
                                <select class="form-select form-control" name="user-name" id="user_name">
                                    <option selected>Select user</option>
                                    <option value="user_1">Elvan Döner</option>
                                    <option value="user_2">Elvan Döner</option>
                                    <option value="user_3">Elvan Döner</option>
                                </select>
                            </div>
                            <div class="task-action"><a class="button-main" href="#">Send</a></div>             
                        </div>
                        <div class="row py-4 item align-items-center">
                            <div class="task-id" data-label="Id">10</div> 
                            <div class="task-name col-lg-4" data-label="Task name">
                                <select class="form-select form-control" name="task-name" id="task_name">
                                    <option selected>Select Task name</option>
                                    <option value="task_1">Task name 1</option>
                                    <option value="task_2">Task name 2</option>
                                    <option value="task_3">Task name 3</option>
                                </select>
                            </div> 
                            <div class="task-sdate col-lg-2" data-label="Start day">
                                <div class="date" data-provide="datepicker" data-date-format="dd.mm.yyyy">
                                    <input type="text" class="form-control">
                                    <div class="input-group-addon">
                                        <span class="glyphicon glyphicon-th"></span>
                                    </div>
                                </div>
                            </div> 
                            <div class="task-deadline col-lg-2" data-label="Deadline">
                                <div class="date" data-provide="datepicker" data-date-format="dd.mm.yyyy">
                                    <input type="text" class="form-control">
                                    <div class="input-group-addon">
                                        <span class="glyphicon glyphicon-th"></span>
                                    </div>
                                </div>
                            </div>    
                            <div class="task-assigned col-lg-2">
                                <select class="form-select form-control" name="user-name" id="user_name">
                                    <option selected>Select user</option>
                                    <option value="user_1">Elvan Döner</option>
                                    <option value="user_2">Elvan Döner</option>
                                    <option value="user_3">Elvan Döner</option>
                                </select>
                            </div>
                            <div class="task-action"><a class="button-main" href="#">Send</a></div>             
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12 wrap-pagination">
                <nav aria-label="...">
                    <ul class="pagination pagination-sm">
                        <li class="page-item disabled">
                          <a class="page-link" href="#" tabindex="-1">1</a>
                        </li>
                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</main>

@endsection