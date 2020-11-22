@extends('layouts.app')

@section('main-content')
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <div id="app">
        <Navbar></Navbar>
        <div class="container pb-5">
            <Bus></Bus>
        </div>
    </div>
    <script src=" {{ mix('/js/app.js')  }} "></script>
@endsection