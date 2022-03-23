<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta name="description" content="Simple CMS" />
        <meta name="author" content="Sheikh Heera" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">
        <link rel="stylesheet" type="text/css" href="https://cdn.rawgit.com/tonystar/bootstrap-float-label/v4.0.1/dist/bootstrap-float-label.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.39.0/css/tempusdominus-bootstrap-4.min.css" integrity="sha512-3JRrEUwaCkFUBLK1N8HehwQgu8e23jTH4np5NHOmQOobuC4ROQxFwFgBLTnhcnQRMs84muMh0PnnwXlPq5MGjg==" crossorigin="anonymous" />
        <title>boarding-cslb.at</title>
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
        <link href = "{{ asset('/resources/css/fontawesome-all.css') }}" rel="stylesheet" />
        <link href = "{{ asset('/resources/css/app.css') }}" rel="stylesheet" />
    </head>
    <?php $home_link = "https://www.telberia.com/projects/boarding-cslb"; ?>
    <body class="antialiased">
        @guest
        @endguest
        @auth
        <header id="site-header">
            <div class="container">
                <div class="wrap-header">
                    <div class="logo">
                        <a href="#"><img src="{{ asset('resources/images/logo.png') }}" alt="logo-header"></a>
                    </div>
                </div>
            </div>
        </header>
        @endauth