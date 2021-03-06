@extends('layouts.public')
@section('content')

    <div class="site-main" id="boarding-unterlagen-page">
        <div class="container py-5">
            <h2 class="top-title mb-5">Übersicht Onboarding CSLB Austria</h2>
            <div class="row mb-2">
                <div class="col-md-12 error">
                    @if ( $errors->count() > 0 )
                    <p>The following errors have occurred:</p>
                    <ul>
                        @foreach( $errors->all() as $message )
                        <li class="alert alert-warning">{{ $message }}</li>
                        @endforeach
                    </ul>
                    @endif

                    @if (session('msg_create'))
                        @if (session('msg_create')['code'] == 200)
                            <div class="alert alert-success">
                                {{ session('msg_create')['msg'] }}
                            </div>
                        @else
                            <div class="alert alert-warning">
                                {{ session('msg_create')['msg'] }}
                            </div>
                        @endif
                    @endif

                    @if (session('msg_update'))
                        @if (session('msg_update')['code'] == 200)
                            <div class="alert alert-success">
                                {{ session('msg_update')['msg'] }}
                            </div>
                        @else
                            <div class="alert alert-warning">
                                {{ session('msg_update')['msg'] }}
                            </div>
                        @endif
                    @endif
                </div>
            </div>
            <div class="row mb-5">
                <div class="col-md-12">
                    <a href="{{ url('/boarding-unterlagen/create') }}" class="button-main">Neuer Mitarbeiter</a>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 label-checklist text-uppercase pb-2 mb-2">
                    <div class="row">
                        <div class="checklist-id col-lg-1" data-label="ID"><strong>ID</strong></div> 
                        <div class="checklist-name col-lg-4" data-label="Name Mitarbeiter"><strong>Name Mitarbeiter</strong></div>
                        <div class="col-lg-2" data-label="Status"><strong>Status</strong></div>
                        <div class="entry-date col-lg-3" data-label="Eintritts Datum"><strong>Eintritts Datum</strong></div> 
                        <div class="checklist-action col-md-2"></div>                 
                    </div>
                </div>
                @if( $data )
                    @foreach( $data as $item )
                        <div class="col-md-12 list-checklist">
                            <div class="row mb-4 py-4 item align-items-center">
                                <!-- <div class="checklist-id col-lg-2" data-label="ID">#{{ $item['name'] }}</div>  -->
                                <div class="checklist-id col-lg-1" data-label="ID">#{{ $item['id'] }}</div> 
                                <div class="checklist-name col-lg-4" data-label="Name Mitarbeiter">{{ $item['name'] }}</div>
                                <div class="col-lg-2" data-label="Status">{{ $item['done_task'] }}/{{ $item['total_task'] }}</div>
                                <div class="entry-date col-lg-3" data-label="Eintritts Datum">{{ $item['created_at'] }}</div>
                                <div class="checklist-action col-lg-2 text-right">
                                    <a href="{{ url('/boarding-unterlagen/edit') }}/{{ $item['id'] }}" class="edit-checklist">Edit</a>
                                </div>                 
                            </div>
                        </div>
                    @endforeach
                @endif
                <div class="navigation col-md-12 pt-2">
                    @isset ($data)
                        {!! $data->links() !!}
                    @endisset
                </div>
            </div>
        </div>
    </div>
@endsection
