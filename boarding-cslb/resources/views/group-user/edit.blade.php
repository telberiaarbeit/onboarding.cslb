@extends('layouts.private-2')
@section('content')
<main class="site-main wrap-login user-page" id="edit-group">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 mt-1 mr-1">
                <div class="float-left">
                    <a class="btn btn-primary" href="{{ url('/group-user') }}">Zurück</a>
                </div>
            </div>
        </div>
        <div class="card mt-3">
            <div class="card-header">
                <h5>Edit Group</h5>
            </div>
            <div class="card-body">
                <div class="row mt-2">
                    <div class="col-lg-12">
                        @if ($message = Session::get('success'))
                            <div class="alert alert-success">
                                <p>{{ $message }}</p>
                            </div>
                        @endif
                        @if ($message = Session::get('error'))
                            <div class="alert alert-danger">
                                <p>{{ $message }}</p>
                            </div>
                        @endif
                    </div>
                    <div class="col-lg-12">
                        @if ($errors->any())

                        <div class="alert alert-danger">
                                <strong>Whoops!</strong> There were some problems with your input.<br><br>
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <form action="{{ url('/group-user/update') }}/{{$group_id}}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong class="pb-2">Name Group:</strong>
                                        <input type="text" name="group_name" class="form-control" placeholder="Name Group:" value="{{$group_name}}">
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong class="pb-2">List User</strong>
                                        <ul class="list-user-edit">
                                            @foreach($users as $user)
                                            <li>
                                                <div class="custom-control custom-checkbox col-lg-12">
                                                    @if(!empty($user->group_id))
                                                        <input class="custom-control-input check-user-group" data-ondb="1" type="checkbox" checked value="{{$user->id}}" id="{{$user->group_id}}_{{$user->id}}" name="check_{{$user->group_id}}_{{$user->id}}">
                                                    @else
                                                        <input class="custom-control-input check-user-group" data-ondb="0" type="checkbox" value="{{$user->id}}" id="{{$user->group_id}}_{{$user->id}}" name="check_{{$user->group_id}}_{{$user->id}}">
                                                    @endif
                                                    @if(!empty($user->full_name))
                                                        <label class="custom-control-label pt-1" for="{{$user->group_id}}_{{$user->id}}">{{$user->full_name}}</label>
                                                    @else
                                                        <label class="custom-control-label pt-1" for="{{$user->group_id}}_{{$user->id}}">{{$user->name}}</label>
                                                    @endif
                                                </div>
                                            </li>
                                            @endforeach
                                        </ul>
                                        <input type="hidden" name="list_user" value="">
                                        <input type="hidden" name="disable_user" value="">
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                                    <button type="submit" class="btn btn-success">Update</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection

