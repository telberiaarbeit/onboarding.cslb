<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Boarding Cslb') }}</title>

    <!-- Scripts -->
    {{-- <script src="{{ asset('/resources/js/app.js') }}" defer></script> --}}
    {{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script> --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link href = "{{ asset('/resources/css/fontawesome-all.css') }}" rel="stylesheet" />
    <!-- Styles -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="https://cdn.rawgit.com/tonystar/bootstrap-float-label/v4.0.1/dist/bootstrap-float-label.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.39.0/css/tempusdominus-bootstrap-4.min.css" integrity="sha512-3JRrEUwaCkFUBLK1N8HehwQgu8e23jTH4np5NHOmQOobuC4ROQxFwFgBLTnhcnQRMs84muMh0PnnwXlPq5MGjg==" crossorigin="anonymous" />
    <link href="{{ asset('resources/css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{url('resources/css/style.css')}}">
</head>
<body>
    <div id="app">
        <header id="site-header">
            <div class="container">
                <div class="navbar navbar-expand-md p-0 justify-content-between">
                    <?php
                        $user_id = Auth::id();
                        if($user_id == 1){ ?>
                        <a class="navbar-brand p-0" href="{{ url('/dashboard') }}">
                            <img src="{{url('resources//images/logo.png')}}" alt="logo-header">
                        </a>
                    <?php    }else{
                    ?>
                        <a class="navbar-brand p-0" href="{{ url('/boarding-unterlagen') }}">
                            <img src="{{url('resources//images/logo.png')}}" alt="logo-header">
                        </a>
                    <?php } ?>
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
                                <?php if(Auth::user()->id == 1 || Auth::user()->id == 22) { ?>
                                <li class="nav-item">
                                    <a class="nav-link" href="https://onboarding.cslb.at/dashboard">Admin-Dashboard</a>
                                </li>
                                <?php } ?>
                                
                                <li class="nav-item">
                                    <a class="nav-link" href="https://onboarding.cslb.at/boarding-unterlagen">Alle Online-Checklisten</a>
                                </li>

                                <?php if(Auth::user()->id == 1 || Auth::user()->id == 22) { ?>
                                <li class="nav-item">
                                    <a class="nav-link" href="https://onboarding.cslb.at/users">Benutzerliste</a>
                                </li>
                                <?php } ?>
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

                    <!-- <div class="collapse navbar-collapse" id="navbarSupportedContent"> -->
                        <!-- Left Side Of Navbar -->
                        <!-- <ul class="navbar-nav me-auto">

                        </ul>
                    </div> -->
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
{{-- <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script> --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-fQybjgWLrvvRgtW6bFlB7jaZrFsaBXjsOMm/tB9LTS58ONXgqbR9W8oWht/amnpF" crossorigin="anonymous"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.0/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.39.0/js/tempusdominus-bootstrap-4.min.js" integrity="sha512-k6/Bkb8Fxf/c1Tkyl39yJwcOZ1P4cRrJu77p83zJjN2Z55prbFHxPs9vN7q3l3+tSMGPDdoH51AEU8Vgo1cgAA==" crossorigin="anonymous"></script>
<script type="text/javascript" src="{{ asset('/resources/js/moment-timezone-with-data.js') }}"></script>
<script type="text/javascript" src="{{ asset('/resources/js/de.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.3/jspdf.min.js"></script>
<script src="https://html2canvas.hertzen.com/dist/html2canvas.js"></script>
<script src="{{ asset('/resources/js/main.js') }}" defer></script> 
<script type="text/javascript">
    jQuery(document).ready(function($){
        $(document).on('click','.select-group', function(e){
            event.preventDefault();
            var BASE_URL = {!! json_encode(url('/')) !!};
            var token = $('meta[name="csrf-token"]').attr('content');
            var group_id = $(this).attr('data-group_id');
            console.log(group_id);
            var group_name = $(this).attr('data-group_name');
            var id_user = $(this).attr('data-user_id');
            var task_id = $(this).attr('data-task_id');
            var selected = $(this).closest('li');
            var list_user_id = $('.input-group[data-id="'+task_id+'"] .current_user').val();
            var newuser = "yes";
            $.ajax({
                header:{
                    'X-CSRF-TOKEN': token
                },
                url: BASE_URL + "/load-user",
                type: 'POST',
                dataType: 'json',
                data: {
                    group_id:group_id,
                    id_user:id_user,
                    group_name:group_name,
                    task_id:task_id,
                    list_user_id: list_user_id,
                    newuser: newuser
                },
                beforeSend: function() {
                    selected.find('.loader').show();
                },
                success: function(res) {
                    if(res.load_user == 1) {
                        selected.siblings().find('.list-user').hide();
                        setTimeout(function(){
                            selected.siblings().find('.list-user').html("");
                        }, 1000);
                        selected.find('.loader').hide();
                        selected.find('.list-user').html(res.load_user_group);
                        selected.find('.list-user').slideDown();
                    }        
                },
                error: function() {
                    console.log("error");
                }
            });
        });
        $(document).on('click','.list-group .edit-user', function(e){
            event.preventDefault();
            var BASE_URL = {!! json_encode(url('/')) !!};
            var token = $('meta[name="csrf-token"]').attr('content');
            var group_id = $(this).attr('data-group-id');
            var group_name = $(this).attr('data-group_name');
            var task_id = $(this).closest('.input-group').attr('data-id');
            var selected = $('.select-group[data-group_id="'+group_id+'"]').closest('li');
            var list_user_id = $('.input-group[data-id="'+task_id+'"] .current_user').val();
            $.ajax({
                header:{
                    'X-CSRF-TOKEN': token
                },
                url: BASE_URL + "/open-user-group",
                type: 'POST',
                dataType: 'json',
                data: {
                    group_id:group_id,
                    group_name:group_name,
                    task_id:task_id,
                    list_user_id: list_user_id,
                },
                beforeSend: function() {
                },
                success: function(res) {
                    if(res.load_user_current == 1) {
                        selected.find('.list-user').html(res.load_user_group);
                        selected.find('.list-user').slideDown();
                        $('#popup-group-user').modal('show');
                    }        
                },
                error: function() {
                    console.log("error");
                }
            });
        });

    });

    // Covert HTML to PDF file
    function getPDF(){

        var HTML_Width = $("#checklist-page").width();
        var HTML_Height = $("#checklist-page").height();
        var top_left_margin = 15;
        var PDF_Width = HTML_Width+(top_left_margin*2);
        var PDF_Height = (PDF_Width*1.5)+(top_left_margin*2);
        var canvas_image_width = HTML_Width;
        var canvas_image_height = HTML_Height;

        var totalPDFPages = Math.ceil(HTML_Height/PDF_Height)-1;

        // $('.action-checklist').css('display','none');
        $('.upld').css('display','none');
        $('.nav-tab-board').css('display','none');
        html2canvas($("#checklist-page")[0],{allowTaint:true}).then(function(canvas) {
            canvas.getContext('2d');
            
            var imgData = canvas.toDataURL("image/jpeg", 1.0);
            var pdf = new jsPDF('p', 'pt',  [PDF_Width, PDF_Height]);
            pdf.addImage(imgData, 'JPG', top_left_margin, top_left_margin,canvas_image_width,canvas_image_height);
            
            
            for (var i = 1; i <= totalPDFPages; i++) { 
                pdf.addPage(PDF_Width, PDF_Height);
                pdf.addImage(imgData, 'JPG', top_left_margin, -(PDF_Height*i)+(top_left_margin*4),canvas_image_width,canvas_image_height);
            }
            
            pdf.save("Document.pdf");

            setTimeout(function(){
                location.reload();
            }, 2000);
            
        });
    };
    // Show image upload
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $(input).next('img')
                .attr('src', e.target.result)
                .width(150)
                .height(100);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
    $(".upld").change(function () {
        readURL(this);
    });

    //signature
    (function() {
        window.requestAnimFrame = (function(callback) {
            return window.requestAnimationFrame ||
                window.webkitRequestAnimationFrame ||
                window.mozRequestAnimationFrame ||
                window.oRequestAnimationFrame ||
                window.msRequestAnimaitonFrame ||
                function(callback) {
                    window.setTimeout(callback, 1000 / 60);
                };
        })();


    })();

    function draw_sign(clicked_id) {

        var canvas = document.getElementById(clicked_id);

        var ctx = canvas.getContext("2d");
        ctx.strokeStyle = "#222222";
        ctx.lineWidth = 4;

        var drawing = false;
        var mousePos = {
            x: 0,
            y: 0
        };
        var lastPos = mousePos;

        canvas.addEventListener("mousedown", function(e) {
            drawing = true;
            lastPos = getMousePos(canvas, e);
        }, false);

        canvas.addEventListener("mouseup", function(e) {
            drawing = false;
        }, false);

        canvas.addEventListener("mousemove", function(e) {
            mousePos = getMousePos(canvas, e);
        }, false);

        // Add touch event support for mobile
        canvas.addEventListener("touchstart", function(e) {

        }, false);

        canvas.addEventListener("touchmove", function(e) {
            var touch = e.touches[0];
            var me = new MouseEvent("mousemove", {
                clientX: touch.clientX,
                clientY: touch.clientY
            });
            canvas.dispatchEvent(me);
        }, false);

        canvas.addEventListener("touchstart", function(e) {
            mousePos = getTouchPos(canvas, e);
            var touch = e.touches[0];
            var me = new MouseEvent("mousedown", {
                clientX: touch.clientX,
                clientY: touch.clientY
            });
            canvas.dispatchEvent(me);
        }, false);

        canvas.addEventListener("touchend", function(e) {
            var me = new MouseEvent("mouseup", {});
            canvas.dispatchEvent(me);
        }, false);

        function getMousePos(canvasDom, mouseEvent) {
            var rect = canvasDom.getBoundingClientRect();
            return {
                x: mouseEvent.clientX - rect.left,
                y: mouseEvent.clientY - rect.top
            }
        }

        function getTouchPos(canvasDom, touchEvent) {
            var rect = canvasDom.getBoundingClientRect();
            return {
                x: touchEvent.touches[0].clientX - rect.left,
                y: touchEvent.touches[0].clientY - rect.top
            }
        }

        function renderCanvas() {
            if (drawing) {
                ctx.moveTo(lastPos.x, lastPos.y);
                ctx.lineTo(mousePos.x, mousePos.y);
                ctx.stroke();
                lastPos = mousePos;
            }
        }
        // Prevent scrolling when touching the canvas
        document.body.addEventListener("touchstart", function(e) {
            if (e.target == canvas) {
                e.preventDefault();
            }
        }, false);
        document.body.addEventListener("touchend", function(e) {
            if (e.target == canvas) {
                e.preventDefault();
            }
        }, false);
        document.body.addEventListener("touchmove", function(e) {
            if (e.target == canvas) {
                e.preventDefault();
            }
        }, false);

        (function drawLoop() {
            requestAnimFrame(drawLoop);
            renderCanvas();
        })();

        function clearCanvas() {
            canvas.width = canvas.width;
        }
    }
    function clear_canvas(current) {
        var canvas_id = current.getAttribute("data-canvas");
        var sigText_id = current.getAttribute("data-sigdataurl");
        var sigImage_id = current.getAttribute("data-sigimage");
        var canvas = document.getElementById(canvas_id);
        var sigText = document.getElementById(sigText_id);
        var sigImage = document.getElementById(sigImage_id);
        canvas.width = canvas.width;
        sigText.value = "";
        sigImage.setAttribute("src", "");
        sigImage.style.display = "none";
    }
    function submit_canvas(current) {
        var canvas_id = current.getAttribute("data-canvas");
        var sigText_id = current.getAttribute("data-sigdataurl");
        var sigImage_id = current.getAttribute("data-sigimage");
        var canvas = document.getElementById(canvas_id);
        var sigText = document.getElementById(sigText_id);
        var sigImage = document.getElementById(sigImage_id);
        var dataUrl = canvas.toDataURL();
        sigText.value = dataUrl;
        sigImage.setAttribute("src", dataUrl);
        sigImage.style.display = "block";
    }

</script>
