@extends('layouts.private-2')

@section('content')

<div class="py-4">
    <div class="site-main user-page" id="boarding-unterlagen-page">
        <div class="container py-5 position-relative">
            <div class="row">
                <div class="col-lg-12">
                    @if ($message = Session::get('success'))
                        <div class="alert alert-success">
                            <p>{{ $message }}</p>
                        </div>
                    @endif
                </div>
                <div class="col-lg-12">
                    <div class="text-right mb-4">
                        <a class="btn btn-success" href="{{ url('/users') }}">Zurück</a>
                        <button class="btn btn-success create-new-group">Neue Gruppe hinzufügen</button>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 label-checklist text-uppercase pb-2 mb-2">
                    <div class="row">
                        <div class="checklist-id col-md-2"><strong>Id</strong></div> 
                        <div class="checklist-name col-md-5"><strong>Group Name</strong></div>
                        <div class="text-right col-md-5"><strong>Action</strong></div>                 
                    </div>
                </div>
                <div class="col-md-12 list-checklist">
                    @foreach($groupuser as $groupuser_data)
                    <div class="row mb-4 py-4 item align-items-start">
                        <div class="checklist-id col-md-2" data-label="ID">#{{$groupuser_data->group_id}}</div>
                        <div class="checklist-name col-md-5" data-label="Group Name">{{$groupuser_data->group_name}}</div>                         
                        <div class="text-right col-md-5">
                            <a class="btn btn-primary" href="{{ url('/group-user/edit') }}/{{$groupuser_data->group_id}}">Edit</a>
                            <a href="#" class="btn btn-primary delete-user-group" data-group_id="{{$groupuser_data->group_id}}">Remove</a>
                        </div>     
                    </div>
                    @endforeach
                </div>
                <div class="navigation">
                    @isset ($groupuser)
                        {!! $groupuser->links() !!}
                    @endisset
                </div>
            </div>
            <!-- Popup Delete group -->
            <div class="modal fade popup-delete" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Are you sure you want to delete this group?</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-footer">
                            <form action="{{ url('/group-user/delete-group') }}" method="POST">
                                @csrf
                                <input type="hidden" name="group_id" value="">
                                <button type="submit" class="btn btn-primary">Yes</button>
                            </form>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                        </div>
                    </div>
                </div>
            </div>
    		<!-- End Popup Delete group -->

            <!-- Modal Group User -->
           <div class="modal fade" id="create-new-group" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLongTitle">Neue Gruppe hinzufügen</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form id="form-group" class="form-group" method="post" action="{{ url('/users/create-group') }}">
                            @csrf                            
                            <div class="modal-body">
                                <div class="name-item">
                                    <div class="group-item">
                                        <div class="form-group input-group">
                                            <span class="has-float-label">
                                                <input type="text" class="form-control" id="group_name" placeholder="Group Name:" value="" required>
                                                <label for="group_name">Group Name:</label>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="user-item">
                                    <div class="select-user">
                                        <span class="label-select">Select User <i class="fas fa-caret-down"></i></span>
                                        <ul class="list-user"></ul>
                                    </div>
                                </div>
                                <div class="participants-item">
                                    <p class="modal-title mt-3 mb-2"><i class="fas fa-users"></i> <strong>Participants:</strong></p>
                                    <ul class="list-participants">                                    
                                    </ul>
                                    <input type="hidden" name="list_user" value="">
                                </div>
                            </div>
                            <div class="modal-footer">
                                <input type="submit" class="btn" id="save-group" value="Save">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- End Modal Group User -->
        </div>
    </div>
</div>
@endsection