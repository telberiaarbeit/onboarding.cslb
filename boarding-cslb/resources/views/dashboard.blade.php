@extends('layouts.public')
@section('content')
    <main class="dashboard">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="top-title">Dashboard Onboarding</h2>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    {{-- <div class="group-item col-md-4">
                        <label>
                            <input type="radio" name="status" value="1">
                            Done
                        </label>
                        <label>
                            <input type="radio" name="status" value="0">
                            Unvollständig
                        </label>
                    </div> --}}
                </div>
                <div class="group-item col-md-4">
                    <div class="floatingFilter-wrap">
                        <select class="form-select form-control floatingFilter" id="floatingFilter-group" aria-label="Sortiermöglichkeit nach Gruppen:">
                            <option value="0">Alle</option>
                            @foreach($group_open as $group)
                                <option {{ $group_id == $group['group_id'] ? 'selected' : '' }} value="{{ $group['group_id'] }}">{{ $group['group_name'] }}</option>
                            @endforeach
                        </select>
                        <label>Sortiermöglichkeit nach Gruppen:</label>
                    </div>
                </div>
                <div class="group-item col-md-4">
                    <div class="floatingFilter-wrap">
                        <select class="form-select form-control floatingFilter" id="floatingFilter" aria-label="Sortiermöglichkeit nach Benutzer:">
                            <option value="0">Alle</option>
                            @foreach ($user_open as $users)
                                <option {{ $user_id == $users['id'] ? 'selected' : '' }} value="{{ $users['id'] }}">{{ $users['name'] }}</option>
                            @endforeach
                        </select>
                        <label>Sortiermöglichkeit nach Benutzer:</label>
                    </div>
                </div>

            </div>
            <div class="row">
                <div class="col-md-12 pb-2 mb-2">
                    <div class="row label-task text-uppercase">
                        <div class="task-name col-lg-4"><strong>Aufgabe Name</strong></div>
                        <div class="task-status col-lg-2"><strong>Status</strong></div>
                        <div class="responsible-person col-lg-2"><strong>Mitarbeiter</strong></div>
                        {{-- <div class="entry-date col-lg-3"><strong>Aufgabenerstellungsdatum</strong></div> --}}
                        <div class="deadline col-lg-2"><strong>Deadline</strong></div>
                        <div class="col-lg-2"></div>
                    </div>
                    <div class="row list-checklist">
                        <div class="col-md-12">

                            @foreach ($tasks as $v)
                                @if($v->confirmed != 1)
                                <div class="row mb-4 py-4 item align-items-center">
                                    <div class="task-name col-lg-4" data-label="Aufgabe Name">{{ $v->task_name }}</div>
                                    <div class="task-status col-lg-2" data-label="Status">
                                        <span
                                            class="{{ $v->confirmed === 1 ? 'complete' : 'incomplete' }}  status">{{ $v->confirmed === 1 ? 'Done' : 'Unvollständig' }}</span>
                                    </div>
                                    <div class="responsible-person col-lg-2" data-label="Mitarbeiter">{{ $v->user_name }}</div>
                                    {{-- <div class="entry-date col-lg-3" data-label="Aufgabenerstellungsdatum">{{ !empty($v->deadline) ? $v->deadline : '-' }}</div> --}}
                                    <div class="deadline col-lg-2" data-label="Deadline">
                                        {{ !empty($v->deadline) ? $v->deadline : '-' }}</div>
                                    <div class="custom-control custom-checkbox col-lg-2">
                                        <input class="custom-control-input check-task" type="checkbox"
                                            {{ $v->confirmed === 1 ? 'checked disabled' : '' }}
                                            value="{{ $v->confirmed }}" data-task_id="{{ $v->id }}"
                                            name="check_{{ $v->form_id . '_' . $v->task_id }}"
                                            id="{{ $v->form_id . '_' . $v->task_id .'_' . $v->user_id }}">
                                        <label class="custom-control-label pt-1"
                                            for="{{ $v->form_id . '_' . $v->task_id .'_' . $v->user_id }}">{{ $v->user_name }} <br>( 
                                                @php
                                                $arg = [];
                                                foreach(DB::table('group_users')->whereIn('group_id',explode(',',$v->group_id))->get() as $item_group) {
                                                    $arg[] = $item_group->group_name;
                                                }
                                                echo implode(' / ',$arg);
                                                @endphp )</label>
                                    </div>
                                </div>
                                @endif
                            @endforeach


                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <!-- Popup Confirm -->
    <div class="modal fade" id="popup-confirm" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body text-center py-5">
                    <h2 class="modal-title py-3 font-weight-bold">Haben Sie die Aufgabe wirklich erledigt? </h2>
                </div>
                <div class="modal-footer justify-content-center">
                    <button type="button" class="btn text-white button-red confirm" data-task_id="">Ja</button>
                    <button type="button" class="btn text-white button-red" data-dismiss="modal"
                        aria-label="Close">Nein</button>
                </div>
            </div>
        </div>
    </div>
    <!-- End Popup Confirm -->
    <script type="text/javascript">
        jQuery(document).ready(function($) {
            //floatingFilter-group
            $('#floatingFilter-group').on('change', function() {
                if (this.value !== '0') {
                    window.location = '/dashboard?g=' + this.value;
                } else {
                    window.location = '/dashboard';
                }
            });

            $('#floatingFilter').on('change', function() {
                if (this.value !== '0') {
                    window.location = '/dashboard?u=' + this.value;
                } else {
                    window.location = '/dashboard';
                }
            });

            $('.check-task').change(function(e) {
                if ($(this).is(':checked')) {
                    $(this).prop('checked', false);
                } else {
                    $(this).prop('checked', true);
                }
                $('#popup-confirm .confirm').attr('data-task_id', $(this).data('task_id'));
                $('#popup-confirm').modal('show');
            });
            $('#popup-confirm .confirm').click(function(e) {
                var task_id = $(this).attr('data-task_id');
                var check = $('.check-task[data-task_id="' + task_id + '"]');
                var status_check = $(check).is(':checked');
                if (status_check) {
                    $(check).prop('checked', false);
                    var confirmed = 0;
                } else {
                    $(check).prop('checked', true);
                    var confirmed = 1;
                }
                if (task_id) {
                    $.ajax({
                        url: "{{ url('/dashboard/update/') }}",
                        method: "post",
                        data: {
                            confirmed: confirmed,
                            task_id: task_id
                        },
                        success: function(task) {
                            var status = check.parents('.item ').find('.task-status .status');
                            if (task.msg == 'Update success' && confirmed) {
                                status.removeClass('incomplete');
                                status.addClass('complete').html('Done');
                            } else {
                                status.removeClass('complete');
                                status.addClass('incomplete').html('Unvollständig');
                            }
                            setTimeout(function(){
                                location.reload();
                            }, 1000)
                        }
                    });
                }
                $('#popup-confirm').modal('hide');
            })
        });
    </script>
@endsection
