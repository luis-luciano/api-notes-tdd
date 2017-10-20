<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    {{-- Token --}}
    <meta name="csrf-token" id="token" content="{{ csrf_token() }}">
    <title>Notas</title>
    <!-- Material Design Icons -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
    <!-- Bootstrap core CSS -->
    <link href="../MDB_Free/css/bootstrap.min.css" rel="stylesheet">
    <!-- Material Design Bootstrap -->
    <link href="../MDB_Free/css/mdb.min.css" rel="stylesheet">
    <link href="../MDB_Free/css/style.min.css" rel="stylesheet">
</head>
<body>
    @yield('content')

    @yield('scripts')
</body>
</html>
