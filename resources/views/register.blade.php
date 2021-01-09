<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Register</title>
        <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" rel="stylesheet">
    </head>
    <body>
        <div class="container p-3">
            <div class="content" id="app">
                <p class="lead">User Registration Page</p>
                <form action="" method="post">
                    @csrf
                    <div class="form-group">
                        <label class="control-label">Name:</label>
                        <div class="col-sm-6">
                            <input class="form-control form-control-sm" name="Name" id="name" value="" required/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label">Email:</label>
                        <div class="col-sm-6">
                            <input type="email" class="form-control form-control-sm" name="Email" id="email" value="" required/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label">Postcode:</label>
                        <div class="col-sm-3">
                            <input class="form-control form-control-sm" name="Postcode" id="postcode" value="" required/>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-3">
                            <button type="submit" id="submit-btn" class="btn btn-success btn-flat">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </body>
</html>
