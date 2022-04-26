@extends('layouts.public')
@section('content')
<style type="text/css">
    .group-item .custom-control-label {
        top: -6px;
    }
</style>
<form action="/boarding-unterlagen/update/{{ $form_id }}" method="post" id="new-form">
    {{ csrf_field() }}
    <div class="site-main wrap-checklist" id="checklist-page">
        <div class="container">
            <!-- Infor setion -->
            <div class="row block-title">
                <div class="col-md-12">
                    <div class="row inner-block-title">
                        <!-- Name Mitarbeiter -->
                        <div class="group-item col-md-12">
                            <div class="form-group input-group">
                                <span class="has-float-label">
                                    <input type="text" class="form-control" name="floatingName" id="floatingName" placeholder="" value="{{ $dashboard->name ?? '' }}">
                                    <label for="floatingName">Name Mitarbeiter:</label>
                                </span>
                            </div>
                        </div>
                        <!-- end Name Mitarbeiter -->
                        <!-- Position -->
                        <div class="group-item col-md-12">
                            <div class="form-group input-group">
                                <span class="has-float-label">
                                    <select class="form-select form-control" name="floatingSelect" id="floatingSelect" aria-label="Funktion/Position:">
                                        @if( $list_position )
                                            @foreach( $list_position as $position )
                                                @if( $dashboard->position_id == $position->id )
                                                    <option value="{{ $position->id }}" selected>{{ $position->name }}</option>
                                                @else
                                                    <option value="{{ $position->id }}">{{ $position->name }}</option>
                                                @endif
                                            @endforeach
                                        @endif
                                    </select>
                                    <label for="floatingSelect">Funktion/Position:</label>
                                </span>
                            </div>
                        </div>
                        <!-- end position -->
                        <!-- Name Vorgesetzter -->
                        <div class="group-item col-md-12">
                            <div class="form-group input-group">
                                <span class="has-float-label">
                                    <input type="text" class="form-control" name="name_vorgesetzter" id="floatingSuperior" value="{{ $dashboard->name_vorgesetzter ?? '' }}">                                             
                                    <label for="floatingName">Name Vorgesetzter:</label>
                                </span>
                            </div>
                        </div>
                        <!-- end Name Vorgesetzter -->         
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
                                        @foreach( $date_detail as $date_item)
                                            @if( $date_item->tab_id == $tab_form->tab_id )
                                                
                                                @if($date_item->type == 'eintritt')
                                                <div class="group-item col-md-6 mb-5">
                                                    <div class="input-group align-items-end">
                                                        @if( $date_item->confirmed)
                                                            <div class="custom-control custom-checkbox mr-sm-2 form-check">
                                                                <input type="checkbox" name="category_date_detail[cat_{{ $tab_form->tab_id }}][eintritt][checkbox]" class="custom-control-input" value="{{ date('d.m.Y', strtotime($date_item->created)) }}" id="entry_date_{{ $tab_form->key }}" checked>
                                                                <label class="custom-control-label"   for="entry_date_{{ $tab_form->key }}">                                                                    
                                                                    @if($tab_form->tab_id != 3)
                                                                    Eintritt Datum
                                                                    @else
                                                                    Datum Maternity
                                                                    @endif
                                                                </label>
                                                            </div>
                                                            <input type="text" class="form-control datetimepicker-input datetimepicker" data-toggle="datetimepicker" name="category_date_detail[cat_{{ $tab_form->tab_id }}][eintritt][datetime]" value="{{ date('d.m.Y', strtotime($date_item->created)) }}" style="padding-right: 15px; text-align: left; padding-left: 15px;">
                                                            <input type="hidden" name="category_date_detail[cat_{{ $tab_form->tab_id }}][eintritt][date_detail_id]" value="{{ $date_item->id }}">
                                                        @else
                                                            <div class="custom-control custom-checkbox mr-sm-2 form-check">
                                                                <input type="checkbox" name="category_date_detail[cat_{{ $tab_form->tab_id }}][eintritt][checkbox]"
                                                                class="custom-control-input" value="" id="entry_date_{{ $tab_form->key }}">
                                                                <label class="custom-control-label" for="entry_date_{{ $tab_form->key }}">
                                                                    @if($tab_form->tab_id != 3)
                                                                    Eintritt Datum
                                                                    @else
                                                                    Datum Maternity
                                                                    @endif
                                                                </label>
                                                            </div>
                                                            <input type="text" class="form-control datetimepicker-input datetimepicker" data-toggle="datetimepicker" name="category_date_detail[cat_{{ $tab_form->tab_id }}][eintritt][datetime]"
                                                            value="" style="padding-right: 15px; text-align: left; padding-left: 15px;">
                                                            <input type="hidden" name="category_date_detail[cat_{{ $tab_form->tab_id }}][eintritt][date_detail_id]" value="{{ $date_item->id }}">
                                                        @endif
                                                    </div>
                                                </div>
                                                @endif
                                                @if($date_item->type == 'austritt')
                                                <div class="group-item col-md-6 mb-5">
                                                    <div class="input-group align-items-end">
                                                        @if( $date_item->confirmed)
                                                            <div class="custom-control custom-checkbox mr-sm-2 form-check">
                                                                <input type="checkbox" name="category_date_detail[cat_{{ $tab_form->tab_id }}][austritt][checkbox]" class="custom-control-input" value="{{ date('d.m.Y', strtotime($date_item->created)) }}" id="exit_date_{{ $tab_form->key }}" checked>
                                                                <label class="custom-control-label" for="exit_date_{{ $tab_form->key }}">
                                                                    @if($tab_form->tab_id != 3)
                                                                    Austritt Datum
                                                                    @else
                                                                    Datum Wiedereintritt
                                                                    @endif
                                                                </label>
                                                            </div>
                                                            <input type="text" class="form-control datetimepicker-input datetimepicker" data-toggle="datetimepicker"  name="category_date_detail[cat_{{ $tab_form->tab_id }}][austritt][datetime]" value="{{ date('d.m.Y', strtotime($date_item->created)) }}" style="padding-right: 15px; text-align: left; padding-left: 15px;">
                                                            <input type="hidden" name="category_date_detail[cat_{{ $tab_form->tab_id }}][austritt][date_detail_id]" value="{{ $date_item->id }}">
                                                        @else
                                                            <div class="custom-control custom-checkbox mr-sm-2 form-check">
                                                                <input type="checkbox" name="category_date_detail[cat_{{ $tab_form->tab_id }}][austritt][checkbox]"
                                                                 class="custom-control-input" value="" id="exit_date_{{ $tab_form->key }}">
                                                                <label class="custom-control-label" 
                                                                 for="exit_date_{{ $tab_form->key }}">
                                                                    @if($tab_form->tab_id != 3)
                                                                    Austritt Datum
                                                                    @else
                                                                    Datum Wiedereintritt
                                                                    @endif
                                                                </label>
                                                            </div>
                                                            <input type="text" class="form-control datetimepicker-input datetimepicker" data-toggle="datetimepicker" 
                                                             name="category_date_detail[cat_{{ $tab_form->tab_id }}][austritt][datetime]" value="" style="padding-right: 15px; text-align: left; padding-left: 15px;">
                                                             <input type="hidden" name="category_date_detail[cat_{{ $tab_form->tab_id }}][austritt][date_detail_id]" value="{{ $date_item->id }}">
                                                        @endif
                                                    </div>
                                                </div>
                                                @endif
                                            @endif
                                        @endforeach  
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
                                                            @foreach( $sub_detail as $sub_item)
                                                                @if( $sub_item->tab_id == $tab_form->tab_id && $sub_item->category_id == $category->id)
                                                                    <input type="text" class="form-control datetimepicker-input datetimepicker"  data-toggle="datetimepicker"  data-target="#datetimepicker-deadline" aria-label="Deadline"  style="padding-left: 15px;pointer-events: auto;"  placeholder="Please select a deadline" name="category_sub_detail[{{ $sub_item->id }}]" value="@if($sub_item->created) {{ date('d.m.Y', strtotime($sub_item->created)) }} @endif">
                                                                @endif
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Task  -->
                                                @isset( $list_task[$category->id] )  
                                                    @foreach( $list_task[$category->id] as $task)  
                                                        <div class="row group-item">  
                                                            <div class="col-md-4 mb-3 wrap-datetimepicker {{ $task['task_checkbox_show'] }}">
                                                                <input type="text" class="form-control datetimepicker-input" name="task_detail[{{ $task['id'] }}_{{ $tab_form->tab_id }}][datetime]" value="{{ $task['task_datetime'] }}">
                                                                <input type="text" name="task_detail[{{ $task['id'] }}_{{ $tab_form->tab_id }}][abbreviation]" class="form-control input-abbreviation" value="{{ $task['task_abbreviation'] }}">
                                                            </div>
                                                            <div class="col-md-8 mb-3 d-flex align-items-end">
                                                                <div class="input-group" data-id="{{ $task['id'] }}">
                                                                    <div class="custom-control custom-checkbox form-check">
                                                                        <input class="custom-control-input" type="checkbox" value="{{ $task['task_checkbox'] }}" id="{{ $category->id }}_{{ $task['id'] }}" name="task_detail[{{ $task['id'] }}_{{ $tab_form->tab_id }}][checkbox]" {{ $task['task_checkbox_class'] }}>
                                                                        <!-- <label class="custom-control-label" for="{{ $category->id }}_{{ $task['id'] }}"></label> -->
                                                                        @if( !$task['user_confirmed'] )
                                                                        <label class="custom-control-label" for="{{ $category->id }}_{{ $task['id'] }}">
                                                                        </label>
                                                                        @endif
                                                                        <span>{{ $task['name'] }}
                                                                            @if( $task['group_users'] ) 
                                                                                <span class="list-group has-group">
                                                                                    @foreach( $task['group_users'] as $user_group)
                                                                                        <span class="show-user" data-group-id="{{ $user_group['sub_group_id'] }}" data-group_name="{{ $user_group['sub_group_name'] }}" data-id_user="{{ $user_group['sub_user_id'] }}">{{ $user_group['sub_full_name'] }}</span>
                                                                                    @endforeach 
                                                                                </span> 
                                                                            @else 
                                                                                <span class="list-group"></span> 
                                                                            @endif    
                                                                            
                                                                        </span>
                                                                        @if( !$task['user_confirmed'] )
                                                                        <span class="add-group ml-2" style="cursor: pointer;" data-add="{{ $task['id'] }}">
                                                                            <i class="far fa-plus"></i>
                                                                        </span>
                                                                        @endif
                                                                    </div>
                                                                    <input type="hidden" name="task_detail[{{ $task['id'] }}_{{ $tab_form->tab_id }}][cat_id]" id="{{ $task['id'] }}_group" class="current_group" value="{{ $category->id }}">
                                                                    <input type="hidden" name="task_detail[{{ $task['id'] }}_{{ $tab_form->tab_id }}][ids]" id="{{ $task['id'] }}_user" class="current_user" value="{{ $task['ids'] }}">
                                                                    <input type="hidden" name="task_detail[{{ $task['id'] }}_{{ $tab_form->tab_id }}][task_ids]" id="{{ $task['id'] }}_user" class="current_user" value="{{ $task['task_ids'] }}">
                                                                    <input type="hidden" name="task_detail[{{ $task['id'] }}_{{ $tab_form->tab_id }}][task_id]" id="{{ $task['id'] }}_id" class="current_task" value="{{ $task['id'] }}">
                                                                    <input type="hidden" name="task_detail[{{ $task['id'] }}_{{ $tab_form->tab_id }}][tab_form]" id="{{ $task['id'] }}_id" class="current_task" value="{{ $tab_form->tab_id }}">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach  
                                                @endisset      
                                            </div>
                                            @endif
                                        @endforeach
                                    </div>
                                    <!-- End Checklist   -->
                                    
                                    <!-- Signature -->
                                    <div class="mb-5">
                                        <div class="row">
                                            <div class="col-md-4 mb-3">
                                                <h3 class="title-h3">VERMERKE</h3>
                                            </div>
                                        </div>
                                        <!-- Note -->
                                        @foreach( $note_detail as $note_item)
                                            @if( $note_item->tab_id != 2 && $note_item->tab_id == $tab_form->tab_id)
                                                <div class="row group-item note-field">
                                                    <div class="col-md-12">
                                                        <textarea class="form-control" style="min-height:100%" name="note_detail[{{ $note_item->id }}]">{{ $note_item->content ?? '' }}</textarea>
                                                    </div>
                                                </div>
                                            @endif
                                        @endforeach
                                        <div class="row">
                                            <div class="col-md-4 mb-3 group-item mb-0">
                                            @foreach( $note_detail as $note_item)
                                                @if( $note_item->tab_id == 2 && $note_item->tab_id == $tab_form->tab_id)
                                                    <textarea class="form-control" style="min-height:100%" name="note_detail[{{ $note_item->id }}]">{{ $note_item->content ?? '' }}</textarea>
                                                @endif
                                            @endforeach
                                            </div>
                                            <div class="col-md-8">
                                                <div class="row"> 
                                                @foreach( $signature_detail as $signature_item)  
                                                    @if( $signature_item->tab_id == 2 && $signature_item->tab_id == $tab_form->tab_id)                                        
                                                        <div class="col-lg-12 mb-3 file-group">
                                                            <div class="e-signature">
                                                            @if( $signature_item->unterschrift_mitarbeiter ) 
                                                                <img id="sigimage_employee-{{ $tab_form->tab_id }}" src="{{ $signature_item->unterschrift_mitarbeiter ?? '' }}">
                                                                <input type="hidden" name="signature_detail[{{ $signature_item->id }}][0]" id="sigUrl_employee-{{ $tab_form->tab_id }}" class="form-control" value="{{ $signature_item->unterschrift_mitarbeiter ?? '' }}"/>
                                                            @else 
                                                                <div class="group mb-3 wrap-diplay-image">
                                                                    <img class="dislay-sign" id="sigimage_employee-diplay-{{ $tab_form->tab_id }}" style="display:none">
                                                                    <canvas onmouseenter="draw_sign(this.id)" id="canvas_employee-{{ $tab_form->tab_id }}"  class="border border-dark canvas_employee-signature" width="290px" height="200px"> 
                                                                    </canvas>
                                                                </div>
                                                                <div class="group mb-3">
                                                                    <button type="button" class="button-red" 
                                                                        onclick="submit_canvas(this)" 
                                                                        data-canvas="canvas_employee-{{ $tab_form->tab_id }}" 
                                                                        data-sigimage="sigimage_employee-{{ $tab_form->tab_id }}" 
                                                                        data-sigdataurl="sigUrl_employee-{{ $tab_form->tab_id }}">
                                                                        Einreichen
                                                                    </button>
                                                                    <button type="button" class="button-red" 
                                                                        id="sigclear_employee-{{ $tab_form->tab_id }}" 
                                                                        onclick="clear_canvas(this)" 
                                                                        data-canvas="canvas_employee-{{ $tab_form->tab_id }}" 
                                                                        data-sigimage="sigimage_employee-{{ $tab_form->tab_id }}" 
                                                                        data-sigdataurl="sigUrl_employee-{{ $tab_form->tab_id }}"
                                                                        data-sigimage_exits ="sigimage_employee-diplay-{{ $tab_form->tab_id }}">
                                                                        Löschen
                                                                    </button>
                                                                </div>
                                                                <input type="hidden" name="signature_detail[{{ $signature_item->id }}][0]" id="sigUrl_employee-{{ $tab_form->tab_id }}" class="form-control" rows="5" />
                                                                <img id="sigimage_employee-{{ $tab_form->tab_id }}" src="" style="display: none;">
                                                            @endif                                                                   
                                                            </div>
                                                            <label class="my-4">
                                                                <strong>Unterschrift Mitarbeiter</strong>
                                                            </label>
                                                        </div>
                                                        <div class="col-lg-12 mb-3 file-group">
                                                            <div class="e-signature">
                                                            @if($signature_item->unterschrift_manager)
                                                                <img id="sigimage_manager-{{ $tab_form->tab_id }}" src="{{ $signature_item->unterschrift_manager ?? '' }}">
                                                                <input type="hidden" name="signature_detail[{{ $signature_item->id }}][1]" id="sigUrl_employee-{{ $tab_form->tab_id }}" class="form-control" value="{{ $signature_item->unterschrift_manager ?? '' }}"/>
                                                            @else 
                                                                <div class="group mb-3 wrap-diplay-image">
                                                                    <img class="dislay-sign" id="sigimage_manager-{{ $tab_form->tab_id }}" src="" style="display:none">
                                                                    <canvas onmouseenter="draw_sign(this.id)" id="canvas_manager-{{ $tab_form->tab_id }}" class="border border-dark canvas_manager-signature" width="290px" height="200px"> 
                                                                    </canvas>
                                                                </div>
                                                                <div class="group mb-3">
                                                                    <button type="button" class="button-red" 
                                                                        onclick="submit_canvas(this)" 
                                                                        data-canvas="canvas_manager-{{ $tab_form->tab_id }}" 
                                                                        data-sigimage="sigimage_manager-{{ $tab_form->tab_id }}" 
                                                                        data-sigdataurl="sigUrl_manager-{{ $tab_form->tab_id }}">
                                                                        Einreichen
                                                                    </button>
                                                                    <button type="button" class="button-red" 
                                                                        id="sigclear_manager-{{ $tab_form->tab_id }}" 
                                                                        onclick="clear_canvas(this)" 
                                                                        data-canvas="canvas_manager-{{ $tab_form->tab_id }}" 
                                                                        data-sigimage="sigimage_manager-{{ $tab_form->tab_id }}" 
                                                                        data-sigdataurl="sigUrl_manager-{{ $tab_form->tab_id }}"
                                                                        data-sigimage_exits ="{{ $signature_detail[$tab_form->tab_id][1] ?? '' }}">
                                                                        Löschen
                                                                    </button>
                                                                </div>
                                                                <input type="hidden" name="signature_detail[{{ $signature_item->id }}][1]" id="sigUrl_manager-{{ $tab_form->tab_id }}" class="form-control" rows="5" />
                                                                <img id="sigimage_manager-{{ $tab_form->tab_id }}" src="" style="display: none;">
                                                            @endif                                                                       
                                                            </div>
                                                            <label class="my-4">
                                                                <strong>Unterschrift Manager</strong>
                                                            </label>
                                                        </div>
                                                    @endif
                                                    @if( $signature_item->tab_id != 2 && $signature_item->tab_id == $tab_form->tab_id) 
                                                        <div class="col-lg-6 mb-3 file-group">
                                                            <div class="e-signature">
                                                            @if( $signature_item->unterschrift_mitarbeiter ) 
                                                                <img id="sigimage_employee-{{ $tab_form->tab_id }}" src="{{ $signature_item->unterschrift_mitarbeiter ?? '' }}">
                                                                <input type="hidden" name="signature_detail[{{ $signature_item->id }}][0]" id="sigUrl_employee-{{ $tab_form->tab_id }}" class="form-control" value="{{ $signature_item->unterschrift_mitarbeiter ?? '' }}"/>
                                                            @else
                                                                <div class="group mb-3 wrap-diplay-image">
                                                                    <img class="dislay-sign" id="sigimage_employee-diplay-{{ $tab_form->tab_id }}" style="display:none">
                                                                    <canvas onmouseenter="draw_sign(this.id)" id="canvas_employee-{{ $tab_form->tab_id }}"  class="border border-dark canvas_employee-signature" width="290px" height="200px"> 
                                                                    </canvas>
                                                                </div>
                                                                <div class="group mb-3">
                                                                    <button type="button" class="button-red" 
                                                                        onclick="submit_canvas(this)" 
                                                                        data-canvas="canvas_employee-{{ $tab_form->tab_id }}" 
                                                                        data-sigimage="sigimage_employee-{{ $tab_form->tab_id }}" 
                                                                        data-sigdataurl="sigUrl_employee-{{ $tab_form->tab_id }}">
                                                                        Einreichen
                                                                    </button>
                                                                    <button type="button" class="button-red" 
                                                                        id="sigclear_employee-{{ $tab_form->tab_id }}" 
                                                                        onclick="clear_canvas(this)" 
                                                                        data-canvas="canvas_employee-{{ $tab_form->tab_id }}" 
                                                                        data-sigimage="sigimage_employee-{{ $tab_form->tab_id }}" 
                                                                        data-sigdataurl="sigUrl_employee-{{ $tab_form->tab_id }}"
                                                                        data-sigimage_exits ="sigimage_employee-diplay-{{ $tab_form->tab_id }}">
                                                                        Löschen
                                                                    </button>
                                                                </div>
                                                                <input type="hidden" name="signature_detail[{{ $signature_item->id }}][0]" id="sigUrl_employee-{{ $tab_form->tab_id }}" class="form-control" rows="5" />
                                                                <img id="sigimage_employee-{{ $tab_form->tab_id }}" src="" style="display: none;">
                                                            @endif                                                                    
                                                            </div>
                                                            <label class="my-4">
                                                                <strong>Unterschrift Mitarbeiter</strong>
                                                            </label>
                                                        </div>
                                                        <div class="col-lg-6 mb-3 file-group">
                                                            <div class="e-signature">
                                                            @if($signature_item->unterschrift_manager)
                                                                <img id="sigimage_manager-{{ $tab_form->tab_id }}" src="{{ $signature_item->unterschrift_manager ?? '' }}">
                                                                <input type="hidden" name="signature_detail[{{ $signature_item->id }}][1]" id="sigUrl_employee-{{ $tab_form->tab_id }}" class="form-control" value="{{ $signature_item->unterschrift_manager ?? '' }}"/>
                                                            @else
                                                                <div class="group mb-3 wrap-diplay-image">
                                                                    <img class="dislay-sign" id="sigimage_manager-{{ $tab_form->tab_id }}" src="" style="display: none;">
                                                                    <canvas onmouseenter="draw_sign(this.id)" id="canvas_manager-{{ $tab_form->tab_id }}" class="border border-dark canvas_manager-signature" width="290px" height="200px"> 
                                                                    </canvas>
                                                                </div>
                                                                <div class="group mb-3">
                                                                    <button type="button" class="button-red" 
                                                                        onclick="submit_canvas(this)" 
                                                                        data-canvas="canvas_manager-{{ $tab_form->tab_id }}" 
                                                                        data-sigimage="sigimage_manager-{{ $tab_form->tab_id }}" 
                                                                        data-sigdataurl="sigUrl_manager-{{ $tab_form->tab_id }}">
                                                                        Einreichen
                                                                    </button>
                                                                    <button type="button" class="button-red" 
                                                                        id="sigclear_manager-{{ $tab_form->tab_id }}" 
                                                                        onclick="clear_canvas(this)" 
                                                                        data-canvas="canvas_manager-{{ $tab_form->tab_id }}" 
                                                                        data-sigimage="sigimage_manager-{{ $tab_form->tab_id }}" 
                                                                        data-sigdataurl="sigUrl_manager-{{ $tab_form->tab_id }}"
                                                                        data-sigimage_exits ="{{ $signature_detail[$tab_form->tab_id][1] ?? '' }}">
                                                                        Löschen
                                                                    </button>
                                                                </div>
                                                                <input type="hidden" name="signature_detail[{{ $signature_item->id }}][1]" id="sigUrl_manager-{{ $tab_form->tab_id }}" class="form-control" rows="5" />
                                                                <img id="sigimage_manager-{{ $tab_form->tab_id }}" src="" style="display: none;">
                                                            @endif                                                                     
                                                            </div>
                                                            <label class="my-4">
                                                                <strong>Unterschrift Manager</strong>
                                                            </label>
                                                        </div>
                                                    @endif

                                                @endforeach
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
                <span onclick="getPDF()" id="export-pdf" class="button-red" style="cursor:pointer;">PDF-Export <i class="fas fa-file-export"></i></span>
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
