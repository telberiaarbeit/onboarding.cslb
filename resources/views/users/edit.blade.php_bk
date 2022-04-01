@extends('layouts.private-2')

@section('content')



<main class="site-main wrap-login user-page" id="edit-user">



	<div class="container">

        <div class="row">

            <div class="col-lg-12 mt-1 mr-1">

                <div class="float-left">

                    <a class="btn btn-primary" href="{{ url('/users/') }}">Zurück</a>

                </div>

            </div>

        </div>

		<div class="card mt-3">

            <div class="card-header">

                <h5>Benutzer bearbeiten</h5>

            </div>
            
            <div class="card-body">

                <div class="row mt-2">

                    <div class="col-lg-12">

                        @if ($message = Session::get('success'))

                            <div class="alert alert-success">

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

                        

                        <form action="{{ url('/users/update') }}/{{ $user->id }}" method="POST">

                            @csrf

                            @method('PUT')

                        

                            <div class="row">

                                <div class="col-xs-12 col-sm-12 col-md-12">

                                    <div class="form-group">

                                        <strong class="pb-2">Name Mitarbeiter:</strong>

                                        <input type="text" name="name" class="form-control" placeholder="Name Mitarbeiter:" value="{{ $user->name }}">

                                    </div>

                                </div>

                                <div class="col-xs-12 col-sm-12 col-md-12">

                                    <div class="form-group">

                                        <strong class="pb-2">Email:</strong>

                                        <input type="email" name="email" class="form-control" placeholder="Email" value="{{ $user->email }}">

                                    </div>

                                </div>

                                <div class="col-xs-12 col-sm-12 col-md-12">

                                    <div class="form-group">

                                        <strong class="pb-2">Password:</strong>

                                        <input type="password" name="password" class="form-control" placeholder="Password">

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

