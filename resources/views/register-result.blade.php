<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Registration</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container p-3">
    <div class="content" id="app">
        @if($valid)
            <div class="alert alert-success">
                <p class="lead mb-0">Thank you {{ $vars['name'] }}, you have been registered.</p>
            </div>
        @else
            <div class="alert alert-danger">
                <p class="lead mb-0">Sorry you could not be registered:<br>
                <strong>{{ $vars['msg'] }}</strong></p>
            </div>
            <p><a href="/register">Try again</a></p>
        @endif
    </div>
</div>
</body>
</html>
