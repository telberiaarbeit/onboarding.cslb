@extends('layouts.public')
@section('content')
<style type="text/css">
    .group-item .custom-control-label {
        top: -6px;
    }
</style>
<form action="{{ route('store.checklist') }}" method="post" id="new-form">
    {{ csrf_field() }}
    <div class="site-main wrap-checklist" id="checklist-page">
        <div class="container">
            <!-- Infor setion -->
            <div class="row block-title">
                <div class="col-md-12">
                    <div class="row inner-block-title">
                        <!-- Name Mitarbeiter -->
                        <div class="group-item col-md-6">
                            <div class="form-group input-group">
                                <span class="has-float-label">
                                    <input type="text" class="form-control" name="floatingName" id="floatingName" placeholder="" value="{{ $full_name }}">
                                    <label for="floatingName">Name Mitarbeiter:</label>
                                </span>
                            </div>
                        </div>
                        <!-- end Name Mitarbeiter -->

                        <!-- Name Vorgesetzter -->
                        <div class="group-item col-md-6">
                            <div class="form-group input-group">
                                <span class="has-float-label">
                                    <input type="text" class="form-control" name="name_vorgesetzter" id="floatingSuperior" placeholder="" value="{{ $full_name }}">                                              
                                    <label for="floatingName">Name Vorgesetzter:</label>
                                </span>
                            </div>
                        </div>
                        <!-- end Name Vorgesetzter -->
                        <!-- Position -->
                        <div class="group-item col-md-6">
                            <div class="form-group input-group">
                                <span class="has-float-label">
                                    <select class="form-select form-control" name="floatingSelect" id="floatingSelect" aria-label="Funktion/Job title:">
                                        @if( $list_position )
                                            @foreach( $list_position as $position )
                                                <option value="{{ $position->id }}">{{ $position->name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                    <label for="floatingSelect">Funktion/Job title:</label>
                                </span>
                            </div>
                        </div>
                        <!-- end position -->

                        <div class="group-item col-md-6">
                            <div class="form-group input-group">
                                <span class="has-float-label">
                                    <input type="text" class="form-control" name="description" id="description" placeholder="" value="">                                              
                                    {{-- <label for="floatingName">Description:</label> --}}
                                </span>
                            </div>
                        </div>   
                    </div>
                </div>
            </div> 
            <!-- end Infor setion -->

            <!-- Tab setion -->
            <div class="row block-content">
                <div class="col-md-12">

                    <!-- Tab Nav -->
                    <div class="nav-tab-board row mb-5">
                        <ul class="nav nav-pills col-md-12" id="pills-tab" role="tablist">
                            @if( $list_tab_form )
                                @foreach( $list_tab_form as $tab_form)
                                    <li class="nav-item" role="presentation">
                                        @if( $loop->index == 0 )
                                        <a class="nav-link active" id="{{ $tab_form->key }}-tab" data-toggle="pill" href="#{{ $tab_form->key }}" role="tab" aria-controls="{{ $tab_form->key }}" aria-selected="true">{{ $tab_form->name }}</a>
                                        @else
                                        <a class="nav-link" id="{{ $tab_form->key }}-tab" data-toggle="pill" href="#{{ $tab_form->key }}" role="tab" aria-controls="{{ $tab_form->key }}" aria-selected="false">{{ $tab_form->name }}</a>
                                        @endif
                                    </li>
                                @endforeach
                            @endif
                        </ul>
                    </div>
                    <!-- End Tab Nav -->


                    <!-- Tab Content -->
                    <div class="tab-content" id="pills-tabContent">
                        @if( $list_tab_form )
                            @foreach( $list_tab_form as $tab_form)
                                @if( $loop->index == 0 )
                                <div class="tab-pane fade active show" id="{{ $tab_form->key }}" role="tabpanel" aria-labelledby="{{ $tab_form->key }}-tab">
                                @else
                                <div class="tab-pane fade" id="{{ $tab_form->key }}" role="tabpanel" aria-labelledby="{{ $tab_form->key }}-tab">
                                @endif

                                    <!-- Field date -->
                                    <div class="row date-field">
                                        @if( $loop->index == 0 )
                                            <div class="group-item col-md-6 mb-5">
                                                <div class="input-group align-items-end">
                                                    <div class="custom-control custom-checkbox mr-sm-2 form-check">
                                                        @if($tab_form->tab_id == 1)
                                                        <input type="checkbox" name="category_date_detail[cat_1][eintritt][checkbox]" class="custom-control-input" value="1" id="entry_date_onboarding" checked>
                                                        <label class="custom-control-label" for="entry_date_onboarding">Eintritt Datum</label>
                                                        @else
                                                        <input type="checkbox" name="category_date_detail[cat_1][eintritt][checkbox]" class="custom-control-input" value="" id="entry_date_onboarding">
                                                        <label class="custom-control-label" for="entry_date_onboarding">Eintritt Datum</label>
                                                        @endif
                                                    </div>
                                                        @if($tab_form->tab_id == 1)
                                                            <input type="text" class="form-control datetimepicker-input datetimepicker" data-toggle="datetimepicker" name="category_date_detail[cat_1][eintritt][datetime]" value="{{date('d.m.Y')}}" style="padding-right: 15px; text-align: left; padding-left: 15px;">
                                                        @else                                                        
                                                            <input type="text" class="form-control datetimepicker-input datetimepicker" data-toggle="datetimepicker" name="category_date_detail[cat_1][eintritt][datetime]" value="" style="padding-right: 15px; text-align: left; padding-left: 15px;">
                                                        @endif
                                                </div>
                                            </div>
                                        @elseif($loop->index == 1 )
                                            <div class="group-item col-md-6 mb-5">
                                                <div class="input-group align-items-end">
                                                    <div class="custom-control custom-checkbox mr-sm-2 form-check">
                                                        <input type="checkbox" name="category_date_detail[cat_2][austritt][checkbox]" class="custom-control-input" value="" id="exit_date_offboarding">
                                                        <label class="custom-control-label" for="exit_date_offboarding">Austritt Datum</label>
                                                    </div>
                                                    <input type="text" class="form-control datetimepicker-input datetimepicker" data-toggle="datetimepicker" name="category_date_detail[cat_2][austritt][datetime]" value="" style="padding-right: 15px; text-align: left; padding-left: 15px;">    
                                                </div>
                                            </div>
                                        @else
                                            <div class="group-item col-md-6 mb-5">
                                                <div class="input-group align-items-end">
                                                    <div class="custom-control custom-checkbox mr-sm-2 form-check">
                                                        <input type="checkbox" name="category_date_detail[cat_3][eintritt][checkbox]" class="custom-control-input" value="" id="entry_date_maternity-leave">
                                                        <label class="custom-control-label" for="entry_date_maternity-leave">Datum Maternity</label>
                                                    </div>
                                                    <input type="text" class="form-control datetimepicker-input datetimepicker" data-toggle="datetimepicker" name="category_date_detail[cat_3][eintritt][datetime]" value="" style="padding-right: 15px; text-align: left; padding-left: 15px;">
                                                </div>
                                            </div>
                                            <div class="group-item col-md-6 mb-5">
                                                <div class="input-group align-items-end">
                                                    <div class="custom-control custom-checkbox mr-sm-2 form-check">
                                                        <input type="checkbox" name="category_date_detail[cat_3][austritt][checkbox]" class="custom-control-input" value="" id="exit_date_maternity-leave">
                                                        <label class="custom-control-label" for="exit_date_maternity-leave">Datum Wiedereintritt</label>
                                                    </div>
                                                    <input type="text" class="form-control datetimepicker-input datetimepicker" data-toggle="datetimepicker" name="category_date_detail[cat_3][austritt][datetime]" value="" style="padding-right: 15px; text-align: left; padding-left: 15px;">    
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                    <!-- End Field date -->

                                    <!-- Checklist -->
                                    <div class="mb-5 tab-field">
                                        <h2 class="top-title">{{ $tab_form->name }}</h2>
                                        @foreach( $list_category as $category)
                                            @if($category->tab_id == $tab_form->tab_id)
                                            <div class="mb-5">
                                                <!-- Sub category -->
                                                <div class="row">
                                                    <div class="col-md-4 mb-3 d-none d-md-block">
                                                        @if( $category->name != 'Nach Probezeit' )
                                                            <h3 class="title-h3">Datum und Name erledigt</h3>
                                                        @endif
                                                    </div>
                                                    <div class="col-md-8 d-flex align-items-start justify-content-between">
                                                        <h3 class="title-h3">{{ $category->name }}</h3>
                                                        <div class="group-item">
                                                            <input type="text" 
                                                            class="form-control datetimepicker-input datetimepicker" 
                                                            data-toggle="datetimepicker" 
                                                            data-target="#datetimepicker-deadline" aria-label="Deadline" 
                                                            style="padding-left: 15px;pointer-events: auto;" 
                                                            placeholder="Bitte w??hlen Sie eine Frist" name="category_sub_detail[{{ $category->id }}_{{ $tab_form->tab_id }}]" value="">
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Task  -->
                                                @isset( $list_task[$category->id] )  
                                                    @foreach( $list_task[$category->id] as $task)   
                                                        <div class="row group-item  <?php if($task['id'] == 116) { echo 'wrap-date-group'; } ?>">  
                                                            <div class="col-md-4 mb-3 wrap-datetimepicker">
                                                                <input type="text" class="form-control datetimepicker-input" name="task_detail[{{ $task['id'] }}_{{ $tab_form->tab_id }}][datetime]" value="">
                                                                <input type="text" name="task_detail[{{ $task['id'] }}_{{ $tab_form->tab_id }}][abbreviation]" data-val="{{ $abbreviations }}" value="{{ $abbreviations }}" class="form-control input-abbreviation">
                                                            </div>
                                                            <div class="col-md-8 mb-3 d-flex align-items-end <?php if($task['id'] == 8) { echo 'tage-group'; } elseif($task['id'] == 116) { echo 'task-date-group'; } ?>">
                                                                <div class="input-group" 
                                                                data-id="{{ $task['id'] }}">
                                                                    <div class="custom-control custom-checkbox form-check">
                                                                        <input class="custom-control-input" 
                                                                        type="checkbox" value="0" id="{{ $category->id }}_{{ $task['id'] }}" name="task_detail[{{ $task['id'] }}_{{ $tab_form->tab_id }}][checkbox]">
                                                                        <label class="custom-control-label" for="{{ $category->id }}_{{ $task['id'] }}">
                                                                        </label>
                                                                        <span>{{ $task['name'] }}
                                                                            @if( $task['id'] == 8 ) 
                                                                                <select class="form-select tage-select form-control" name="task_detail[{{ $task['id'] }}_{{ $tab_form->tab_id }}][tage]" id="tage-select">
                                                                                    <option value=""></option>
                                                                                    <option value="20">20</option>
                                                                                    <option value="25">25</option>
                                                                                    <option value="30">30</option>
                                                                                </select>
                                                                            @endif  
                                                                            @if( $task['id'] == 116 ) 
                                                                                <input type="text" class="form-control task_date datetimepicker" data-toggle="datetimepicker" data-target="#datetimepicker-deadline"  placeholder="Bitte ausw??hlen" name="task_detail[{{ $task['id'] }}_{{ $tab_form->tab_id }}][task_date]" value="">
                                                                            @endif      
                                                                            @isset( $group_users_task[$task['id']] ) 
                                                                                <span class="list-group has-group">
                                                                                    @foreach( $group_users_task[$task['id']] as $user_group)
                                                                                        <span class="edit-user" data-group-id="{{ $user_group['sub_group_id'] }}" data-group_name="{{ $user_group['sub_group_name'] }}" data-id_user="{{ $user_group['sub_user_id'] }}">{{ $user_group['sub_full_name'] }}<i class="far fa-plus"></i></span>
                                                                                    @endforeach 
                                                                                </span> 
                                                                            @else 
                                                                                @if(!empty($task['user_defaults']))
                                                                                <span class="list-group has-group">
                                                                                    @foreach($task['group_user_default'] as $group_user_default)
                                                                                        <span class="edit-user" data-group-id="{{ $group_user_default['id'] }}">
                                                                                            {{ $group_user_default['name'] }}
                                                                                            <i class="far fa-plus"></i>
                                                                                        </span>
                                                                                    @endforeach 
                                                                                </span> 
                                                                                @else                                                                                
                                                                                <span class="list-group"></span>
                                                                                @endif
                                                                            @endisset    
                                                                        </span>
                                                                        <span class="add-group ml-2" style="cursor: pointer;" data-add="{{ $task['id'] }}">
                                                                            <i class="far fa-plus"></i>
                                                                        </span>
                                                                    </div>
                                                                    <input type="hidden" name="task_detail[{{ $task['id'] }}_{{ $tab_form->tab_id }}][cat_id]" id="{{ $task['id'] }}_group" class="current_group" value="{{ $category->id }}">
                                                                    <input type="hidden" name="task_detail[{{ $task['id'] }}_{{ $tab_form->tab_id }}][ids]" id="{{ $task['id'] }}_user" class="current_user" value="{{ $task['user_defaults'] }}">
                                                                    <input type="hidden" name="task_detail[{{ $task['id'] }}_{{ $tab_form->tab_id }}][task_id]" id="{{ $task['id'] }}_id" class="current_task" value="{{ $task['id'] }}">
                                                                    <input type="hidden" name="task_detail[{{ $task['id'] }}_{{ $tab_form->tab_id }}][tab_form]" id="{{ $task['id'] }}_tab" class="current_task" value="{{ $tab_form->tab_id }}">
                                                                    <input type="hidden" name="task_detail[{{ $task['id'] }}_{{ $tab_form->tab_id }}][group_task]" id="{{ $task['id'] }}_group_task" class="current_task" value="{{ $task['id'] }}_{{ $tab_form->tab_id }}">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach  
                                                @endisset      
                                            </div>
                                            @endif
                                        @endforeach
                                    </div>
                                    <!-- End Checklist -->

                                    <!-- Signature -->
                                    <div class="mb-5">
                                        <div class="row">
                                            <div class="col-md-4 mb-3">
                                                <h3 class="title-h3">VERMERKE</h3>
                                            </div>
                                        </div>
                                        <!-- Note -->
                                        @if( $tab_form->tab_id != 2 ) 
                                        <div class="row group-item note-field">
                                            <div class="col-md-12">
                                                <textarea class="form-control" name="note_detail[{{ $tab_form->tab_id }}]"></textarea>
                                            </div>
                                        </div>
                                        @endif
                                        <div class="row">
                                            <div class="col-md-4 mb-3 group-item mb-0">
                                            @if( $tab_form->tab_id == 2)
                                                <textarea class="form-control" style="min-height:100%" name="note_detail[{{ $tab_form->tab_id }}]"></textarea>
                                            @endif
                                            </div>
                                            <div class="col-md-8">
                                                <div class="row">
                                                @if( $tab_form->tab_id == 2 )                                        
                                                    <div class="col-lg-12 mb-3 file-group">
                                                        <div class="e-signature">
                                                            <div class="group mb-3 wrap-diplay-image">
                                                                <canvas onmouseenter="draw_sign(this.id)" id="canvas_employee-{{ $tab_form->tab_id }}"  class="border border-dark canvas_employee-signature" width="290px" height="200px"> 
                                                                </canvas>
                                                            </div>
                                                            <div class="group mb-3">
                                                                <button type="button" class="button-red" 
                                                                    onclick="submit_canvas(this)" 
                                                                    data-user_id = "{{ Auth::id() }}" 
                                                                    data-user_name = "{{ Auth::user()->name }}"
                                                                    data-canvas="canvas_employee-{{ $tab_form->tab_id }}" 
                                                                    data-sigimage="sigimage_employee-{{ $tab_form->tab_id }}" 
                                                                    data-sigdataurl="sigUrl_employee-{{ $tab_form->tab_id }}"
                                                                    data-tabID="{{ $tab_form->tab_id }}"
                                                                    data-user_sign = "use_employee-{{ $tab_form->tab_id }}">
                                                                    Einreichen
                                                                </button>
                                                                <button type="button" class="button-red" 
                                                                    id="sigclear_employee-{{ $tab_form->tab_id }}" 
                                                                    onclick="clear_canvas(this)" 
                                                                    data-canvas="canvas_employee-{{ $tab_form->tab_id }}" 
                                                                    data-sigimage="sigimage_employee-{{ $tab_form->tab_id }}" 
                                                                    data-sigdataurl="sigUrl_employee-{{ $tab_form->tab_id }}"
                                                                    data-sigimage_exits ="sigimage_employee-diplay-{{ $tab_form->tab_id }}">
                                                                    L??schen
                                                                </button>
                                                            </div>
                                                            <input type="hidden" name="signature_detail[{{ $tab_form->tab_id }}][0]" id="sigUrl_employee-{{ $tab_form->tab_id }}" class="form-control" rows="5" />
                                                            <img id="sigimage_employee-{{ $tab_form->tab_id }}" src="" style="display: none;">                                                                  
                                                        </div>
                                                        <label class="my-4 d-block">
                                                            <strong>Unterschrift Mitarbeiter</strong>
                                                        </label>
                                                        <label class="my-4 d-block sign_employee">
                                                            <strong id="user-sign-name-{{ $tab_form->tab_id }}" class="name-user"></strong>
                                                            <input type="hidden" value="" class="user_sign_staff"  name="signature_detail[{{ $tab_form->tab_id }}][3]" id="user_staff_id_{{ $tab_form->tab_id }}">
                                                        </label>
                                                    </div>
                                                    <div class="col-lg-12 mb-3 file-group">
                                                        <div class="e-signature">
                                                            <div class="group mb-3 wrap-diplay-image">
                                                                <canvas onmouseenter="draw_sign(this.id)" id="canvas_manager-{{ $tab_form->tab_id }}" class="border border-dark canvas_manager-signature" width="290px" height="200px"> 
                                                                </canvas>
                                                            </div>
                                                            <div class="group mb-3">
                                                                <button type="button" class="button-red" 
                                                                    onclick="submit_canvas(this)" 
                                                                    data-canvas="canvas_manager-{{ $tab_form->tab_id }}" 
                                                                    data-sigimage="sigimage_manager-{{ $tab_form->tab_id }}" 
                                                                    data-sigdataurl="sigUrl_manager-{{ $tab_form->tab_id }}"
                                                                    data-user_sign = "use_manager-{{ $tab_form->tab_id }}"
                                                                    data-user_id = "{{ Auth::id() }}" 
                                                                    data-user_name = "{{ Auth::user()->name }}"
                                                                    data-tabID="{{ $tab_form->tab_id }}">
                                                                    Einreichen
                                                                </button>
                                                                <button type="button" class="button-red" 
                                                                    id="sigclear_manager-{{ $tab_form->tab_id }}" 
                                                                    onclick="clear_canvas(this)" 
                                                                    data-canvas="canvas_manager-{{ $tab_form->tab_id }}" 
                                                                    data-sigimage="sigimage_manager-{{ $tab_form->tab_id }}" 
                                                                    data-sigdataurl="sigUrl_manager-{{ $tab_form->tab_id }}"
                                                                    data-sigimage_exits ="{{ $signature_detail[$tab_form->tab_id][1] ?? '' }}">
                                                                    L??schen
                                                                </button>
                                                            </div>
                                                            <input type="hidden" name="signature_detail[{{ $tab_form->tab_id }}][1]" id="sigUrl_manager-{{ $tab_form->tab_id }}" class="form-control" rows="5" />
                                                            <img id="sigimage_manager-{{ $tab_form->tab_id }}" src="" style="display: none;">
                                                        </div>
                                                        <label class="my-4 d-block">
                                                            <strong>Unterschrift Manager</strong>
                                                        </label>
                                                        <label class="my-4 d-block sign_manager">                                                                
                                                            <strong id="user-sign-manager-name-{{ $tab_form->tab_id }}" class="name-user"></strong>
                                                            <input type="hidden" value="" class="user_sign_manager"  name="signature_detail[{{ $tab_form->tab_id }}][4]" id="user_manager_id_{{ $tab_form->tab_id }}">
                                                        </label>
                                                    </div>
                                                @else                                                          
                                                    <div class="col-lg-6 mb-3 file-group">
                                                        <div class="e-signature">
                                                            <div class="group mb-3 wrap-diplay-image">
                                                                <canvas onmouseenter="draw_sign(this.id)" id="canvas_employee-{{ $tab_form->tab_id }}"  class="border border-dark canvas_employee-signature" width="290px" height="200px"> 
                                                                </canvas>
                                                            </div>
                                                            <div class="group mb-3">
                                                                <button type="button" class="button-red" 
                                                                    onclick="submit_canvas(this)" 
                                                                    data-user_id = "{{ Auth::id() }}" 
                                                                    data-user_name = "{{ Auth::user()->name }}"
                                                                    data-canvas="canvas_employee-{{ $tab_form->tab_id }}" 
                                                                    data-sigimage="sigimage_employee-{{ $tab_form->tab_id }}" 
                                                                    data-sigdataurl="sigUrl_employee-{{ $tab_form->tab_id }}"
                                                                    data-tabID="{{ $tab_form->tab_id }}"
                                                                    data-user_sign = "use_employee-{{ $tab_form->tab_id }}">
                                                                    Einreichen
                                                                </button>
                                                                <button type="button" class="button-red" 
                                                                    id="sigclear_employee-{{ $tab_form->tab_id }}" 
                                                                    onclick="clear_canvas(this)" 
                                                                    data-canvas="canvas_employee-{{ $tab_form->tab_id }}" 
                                                                    data-sigimage="sigimage_employee-{{ $tab_form->tab_id }}" 
                                                                    data-sigdataurl="sigUrl_employee-{{ $tab_form->tab_id }}"
                                                                    data-sigimage_exits ="sigimage_employee-diplay-{{ $tab_form->tab_id }}">
                                                                    L??schen
                                                                </button>
                                                            </div>
                                                            <input type="hidden" name="signature_detail[{{ $tab_form->tab_id }}][0]" id="sigUrl_employee-{{ $tab_form->tab_id }}" class="form-control" rows="5" />
                                                            <img id="sigimage_employee-{{ $tab_form->tab_id }}" src="" style="display: none;">
                                                                                                                    
                                                        </div>
                                                        <label class="my-4 d-block">
                                                            <strong>Unterschrift Mitarbeiter</strong>
                                                        </label>
                                                        <label class="my-4 d-block sign_employee">
                                                            <strong id="user-sign-name-{{ $tab_form->tab_id }}" class="name-user"></strong>
                                                            <input type="hidden" value="" class="user_sign_staff"  name="signature_detail[{{ $tab_form->tab_id }}][3]" id="user_staff_id_{{ $tab_form->tab_id }}">
                                                        </label>
                                                    </div>
                                                    <div class="col-lg-6 mb-3 file-group">
                                                        <div class="e-signature">
                                                            <div class="group mb-3 wrap-diplay-image">
                                                                <canvas onmouseenter="draw_sign(this.id)" id="canvas_manager-{{ $tab_form->tab_id }}" class="border border-dark canvas_manager-signature" width="290px" height="200px"> 
                                                                </canvas>
                                                            </div>
                                                            <div class="group mb-3">
                                                                <button type="button" class="button-red" 
                                                                    onclick="submit_canvas(this)" 
                                                                    data-canvas="canvas_manager-{{ $tab_form->tab_id }}" 
                                                                    data-sigimage="sigimage_manager-{{ $tab_form->tab_id }}" 
                                                                    data-sigdataurl="sigUrl_manager-{{ $tab_form->tab_id }}"
                                                                    data-user_sign = "use_manager-{{ $tab_form->tab_id }}"
                                                                    data-user_id = "{{ Auth::id() }}" 
                                                                    data-user_name = "{{ Auth::user()->name }}"
                                                                    data-tabID="{{ $tab_form->tab_id }}">
                                                                    Einreichen
                                                                </button>
                                                                <button type="button" class="button-red" 
                                                                    id="sigclear_manager-{{ $tab_form->tab_id }}" 
                                                                    onclick="clear_canvas(this)" 
                                                                    data-canvas="canvas_manager-{{ $tab_form->tab_id }}" 
                                                                    data-sigimage="sigimage_manager-{{ $tab_form->tab_id }}" 
                                                                    data-sigdataurl="sigUrl_manager-{{ $tab_form->tab_id }}"
                                                                    data-sigimage_exits ="{{ $signature_detail[$tab_form->tab_id][1] ?? '' }}">
                                                                    L??schen
                                                                </button>
                                                            </div>
                                                            <input type="hidden" name="signature_detail[{{ $tab_form->tab_id }}][1]" id="sigUrl_manager-{{ $tab_form->tab_id }}" class="form-control" rows="5" />
                                                            <img id="sigimage_manager-{{ $tab_form->tab_id }}" src="" style="display: none;">
                                                                                                                        
                                                        </div>
                                                        <label class="my-4 d-block">
                                                            <strong>Unterschrift Manager</strong>
                                                        </label>
                                                        <label class="my-4 d-block sign_manager">                                                                
                                                            <strong id="user-sign-manager-name-{{ $tab_form->tab_id }}" class="name-user"></strong>
                                                            <input type="hidden" value="" class="user_sign_manager"  name="signature_detail[{{ $tab_form->tab_id }}][4]" id="user_manager_id_{{ $tab_form->tab_id }}">
                                                        </label>
                                                    </div>
                                                @endif
                                                </div>
                                            </div>
                                        </div>
                                        
                                    </div>
                                    <!-- EndSignature -->
                                </div>
                            @endforeach
                        @endif
                    </div>
                    <!-- End Tab Content -->
                </div>
            </div>
            <!-- end Tab setion -->

            <div class="action-checklist text-end">
                <input type="submit" id="save" name="save_db" class="button-red" value="Speichern">
                <button onclick="getPDF()" id="export-pdf" class="button-red">PDF-Export <i class="fas fa-file-export"></i></button>
            </div>
        </div>
    </div>
</form>


    <!-- Modal Group User -->
    <div class="modal fade" id="popup-group-user" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">
                <ul>
                    @if( $list_group_users )
                        @foreach( $list_group_users as $group_users)
                            <li>
                                <div class="select-action">
                                    <div class="select-group" data-task_id="" data-group_id="{{ $group_users['id'] }}" data-group_name="{{ $group_users['name'] }}" data-user_id="@isset($group_users['users']){{ implode(',', $group_users['users']) }}@endisset">
                                        {{ $group_users['name'] }}
                                        <span class="loader" style="display:none;"></span>
                                    </div>
                                </div>
                                <div class="list-user" style="display:none"></div>
                            </li>
                        @endforeach
                    @endif
                </ul>
                <div class="na-check">
                    <label class="user-task-na">
                        <span class="name-user">N/A</span>
                        <input type="checkbox" class="" name="user_id" data-task_id="1" data-group_id="" data-group_name="" data-user_name="" value="0">
                    </label> 
                </div>
            </div>
        </div>
        </div>
    </div>
    <!-- End Modal Group User -->        
  
    <script>
        $( document ).ready(function() {
            $(document).on('click', '.custom-checkbox.form-check', function(){
                let checkbox_custom = $(this).find('.custom-control-input');
                if(checkbox_custom.prop("checked")) {
                    checkbox_custom.attr('checked', 'checked');
                    checkbox_custom.val(1);
                } else {
                    checkbox_custom.removeAttr('checked');
                    checkbox_custom.val(0);
                }
            });
        });
    </script>
@endsection
