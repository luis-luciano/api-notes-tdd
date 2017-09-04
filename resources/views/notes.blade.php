@extends('layout')

@section('content')
<!-- Start your project here-->
    <div id="app" class="container">
        <div class="col-md-8 col-md-offset-2">
            <app></app>
        </div>
    </div>
@endsection

@section('scripts')
    <!-- SCRIPTS -->
    <style type="text/css">
        .fade-transition{
            transition: all 1s ease;
            opacity: 100;
        }

        .fade-enter, .fade-leave{
            opacity: 0
        }

        .alert_container{
            font-size: 12px;
            height: 60px;
        }
    </style>
   <!-- JQuery -->
    <script type="text/javascript" src="{{ asset('MDB_Free/js/jquery.min.js') }}"></script>
    <!-- Bootstrap core JavaScript -->
    <script type="text/javascript" src="{{ asset('MDB_Free/js/bootstrap.min.js') }}"></script>
    <!-- MDB core JavaScript -->
    <script type="text/javascript" src="{{ asset('MDB_Free/js/mdb.min.js') }}"></script>
    <!-- Bootstrap tooltips -->
    <script type="text/javascript" src="{{ asset('MDB_Free/js/tether.min.js') }}"></script>
    <script src="{{ mix('/js/app.js') }}"></script>
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css">
@endsection