<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <title>{{ config('app.name',$pageTitle) }}</title>
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/fontawesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/data-table.min.css?v='.time()) }}">
    <link rel="stylesheet" href="{{ asset('css/confirm.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/toast.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css?v='.time()) }}">
</head>
@include('components.header')
<body class="bg-light" id="main-holder">
<main class="container-fluid my-5 pt-3 pb-4 mx-3" style="width: 98%;">
    <div class="row">
        <div class="col-12">
            <div class="card border-0">
                <div class="card-body p-0 border-none">
                    @yield('content')
                </div>
            </div>
        </div>
    </div>
</main>
<script src="{{ asset('js/jquery.min.js?v='.time()) }}"></script>
<script src="{{ asset('js/popper.min.js?v='.time()) }}"></script>
<script src="{{ asset('js/bootstrap.min.js?v='.time()) }}"></script>
<script src="{{ asset('js/data-table.min.js?v='.time()) }}"></script>
<script src="{{ asset('js/confirm.min.js?v='.time()) }}"></script>
<script src="{{ asset('js/toast.min.js?v='.time()) }}"></script>
<script src="{{ asset('js/script.js?v='.time()) }}"></script>
<script>
</script>
@yield('pageScript')
</body>
</html>

