<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>CSLB Onboarding</title>
    <!-- <title>{{ config('app.name', 'Boarding Cslb') }}</title> -->

    <!-- Scripts -->
    <script src="{{ url('resources/js/app.js') }}" defer></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link href = "{{ asset('/resources/css/fontawesome-all.css') }}" rel="stylesheet" />
    <!-- Styles -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="https://cdn.rawgit.com/tonystar/bootstrap-float-label/v4.0.1/dist/bootstrap-float-label.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.39.0/css/tempusdominus-bootstrap-4.min.css" integrity="sha512-3JRrEUwaCkFUBLK1N8HehwQgu8e23jTH4np5NHOmQOobuC4ROQxFwFgBLTnhcnQRMs84muMh0PnnwXlPq5MGjg==" crossorigin="anonymous" />
    <link href="{{ asset('resources/css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{url('resources/css/style.css')}}">
</head>
<body>
    <div id="app">
        <!-- <header id="site-header">
            <nav class="navbar navbar-expand-md navbar-light p-0">
                <div class="container">
                    <a class="navbar-brand p-0" href="{{ url('/') }}">
                        <img src="{{url('resources//images/logo.png')}}" alt="logo-header">
                    </a>

                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav ms-auto">
                            @guest
                                @if (Route::has('login'))
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                    </li>
                                @endif

                                @if (Route::has('register'))
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                    </li>
                                @endif
                            @else
                                <li class="nav-item dropdown">
                                    <a style="color: #fff;" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                            {{ __('Logout') }}
                                        </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </li>
                            @endguest
                        </ul>
                    </div>
                </div>
            </nav>
        </header> -->
         <header id="site-header">
            <div class="container">
                <div class="navbar navbar-expand-md p-0 justify-content-between">
                    @php $home = url('/'); @endphp
                    <a class="navbar-brand p-0" href="{{ url('/boarding-unterlagen') }}">
                        <img src="{{url('resources//images/logo.png')}}" alt="logo-header">
                    </a>
                    <!-- <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                        <span class="navbar-toggler-icon"></span>
                    </button> -->
                    <nav class="navbar">
                        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
                            <i class="far fa-bars"></i>
                        </button>
                      <div class="collapse navbar-collapse" id="navbarTogglerDemo01">

                        <!-- Right Side Of Navbar -->
                        <ul class="navbar-nav align-items-center">
                            <!-- Authentication Links -->
                            @guest
                                @if (Route::has('login'))
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                    </li>
                                @endif

                                @if (Route::has('register'))
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                    </li>
                                @endif
                            @else
                                <li class="nav-item">
                                    <a class="nav-link" href="{{$home}}/dashboard">Dashboard</a>
                                </li>
                                
                                <li class="nav-item">
                                    <a class="nav-link" href="{{$home}}/boarding-unterlagen">Alle Online-Checklisten</a>
                                </li>
                                
                                <li class="nav-item">
                                    <a class="nav-link" href="{{$home}}/users">Benutzerliste</a>
                                </li>
                                <li class="nav-item dropdown">
                                    <a class="nav-link" style="color: #fff;" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                            {{ __('Logout') }}
                                        </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </li>
                            @endguest
                        </ul>
                      </div>
                    </nav>
                </div>
            </div>
        </header>
        <main class="py-4">
            @yield('content')
        </main>
    </div>
    <script>

        $.ajaxSetup({

            headers: {

                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')

            }

        });

    </script>

    @yield('js')
</body>
</html>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-fQybjgWLrvvRgtW6bFlB7jaZrFsaBXjsOMm/tB9LTS58ONXgqbR9W8oWht/amnpF" crossorigin="anonymous"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.0/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.39.0/js/tempusdominus-bootstrap-4.min.js" integrity="sha512-k6/Bkb8Fxf/c1Tkyl39yJwcOZ1P4cRrJu77p83zJjN2Z55prbFHxPs9vN7q3l3+tSMGPDdoH51AEU8Vgo1cgAA==" crossorigin="anonymous"></script>
<script type="text/javascript" src="{{ asset('/resources/js/moment-timezone-with-data.js') }}"></script>
<script type="text/javascript" src="{{ asset('/resources/js/de.js') }}"></script>
@if(Auth::check() && Auth::user()->is_admin == 1)
<script src="https://chat.codemenschen.at/js/socket.io-v4.js"></script>
<link href="https://chat.codemenschen.at/css/codemenschen-feedback-form.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="https://chat.codemenschen.at/css/cropper.min.css">
<script type="text/javascript" src="https://chat.codemenschen.at/js/cropper.min.js"></script>
<script type="text/javascript" src="https://chat.codemenschen.at/js/html2canvas.min.js"></script>
<script type="text/javascript" src="https://chat.codemenschen.at/js/create-form.js"></script>
<script type="text/javascript">CODEMENCHENS.init(["CSL - Onboarding Client", "1929", "CSL - Onboarding", window.location.href]);CODEMENCHENS.createForm();</script>
<script type="text/javascript" src="https://chat.codemenschen.at/js/codemenschen-feedback-form.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>
<script src="{{ asset('/resources/js/main.js') }}" defer></script>
@endif
<script>
    jQuery(document).ready(function($){
        if($('.user-page').length) {
            $(".deletebtn").click(function(){
                var BASE_URL = {!! json_encode(url('/')) !!}
                var user_current = $(this).attr('id');
                var token = $('meta[name="csrf-token"]').attr('content');
                $.ajax({
                    header:{
                        'X-CSRF-TOKEN': token
                    },
                    url: BASE_URL + "/delete",
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        UserId: user_current,
                    },
                    success: function(res) {
                        $('.popup-delete').modal('hide');
                        if(res.delete == 1) {
                            alert("Delete user success!");
                            setTimeout(function(){
                                location.reload();
                            }, 1000);
                        }else{
                            // $('.popup-delete').modal('hide');
                            alert('Cant deleted User!');
                        }
                        
                    }
                });
            });
            $(".create-new-group").click(function(){
                var BASE_URL = {!! json_encode(url('/')) !!}
                var user_current = $(this).attr('id');
                var token = $('meta[name="csrf-token"]').attr('content');
                $.ajax({
                    header:{
                        'X-CSRF-TOKEN': token
                    },
                    url: BASE_URL + "/create_new_group",
                    type: 'POST',
                    dataType: 'json',
                    success: function(res) {
                        $('#create-new-group .list-user').html(res.html);
                    $('#create-new-group').modal('show');                     
                    }
                });  
            });
            $("#create-new-group #form-group").submit(function(event){
                event.preventDefault();
                var BASE_URL = {!! json_encode(url('/')) !!};
                var name_group = $('#group_name').val();
                var list_user = $('input[name="list_user"]').val();
                var token = $('meta[name="csrf-token"]').attr('content');
                if(name_group=="") {
                    $('#group_name').css('border-color','red');
                    $('#form-group .input-group').append('<p class="error" style="padding: 7px 15px;color:red;font-size: 13px;">Please enter the group name</p>');
                } else {
                    $('#form-group .input-group .error').remove();
                    $('#group_name').removeAttr('style');
                    $.ajax({
                        header:{
                            'X-CSRF-TOKEN': token
                        },
                        url: BASE_URL + "/save-group",
                        type: 'POST',
                        dataType: 'json',
                        data: {
                            name_group:name_group,
                            list_user:list_user,
                        },
                        success: function(res) {
                            if(res.create == 1) {
                                $('#create-new-group').modal('hide');
                                event.currentTarget.submit();
                            }else{
                                $('#form-group .input-group').append('<p class="error" style="padding: 7px 15px;color:red;font-size: 13px;">Group already exists</p>');
                            }          
                        },
                        error: function() {
                            console.log("error");
                        }
                    });
                }
            });

        }
    })
</script>
