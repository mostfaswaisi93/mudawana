<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>{{ trans('admin.register') }}</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1" name="viewport" />
    <meta content="" name="author" />
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet"
        type="text/css" />
    <link href="{{ url('/') }}/design/metronic-ltr/assets/global/plugins/font-awesome/css/font-awesome.min.css"
        rel="stylesheet" type="text/css" />
    <link href="{{ url('/') }}/design/metronic-ltr/assets/global/plugins/simple-line-icons/simple-line-icons.min.css"
        rel="stylesheet" type="text/css" />
    <link href="{{ url('/') }}/design/metronic-ltr/assets/global/plugins/bootstrap/css/bootstrap.min.css"
        rel="stylesheet" type="text/css" />
    <link href="{{ url('/') }}/design/metronic-ltr/assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css"
        rel="stylesheet" type="text/css" />
    <link href="{{ url('/') }}/design/metronic-ltr/assets/global/css/components-md.min.css" rel="stylesheet"
        id="style_components" type="text/css" />
    <link href="{{ url('/') }}/design/metronic-ltr/assets/global/css/plugins-md.min.css" rel="stylesheet"
        type="text/css" />
    <link href="{{ url('/') }}/design/metronic-ltr/assets/pages/css/login.min.css" rel="stylesheet" type="text/css" />
    <link rel="shortcut icon" href="favicon.ico" />
</head>

<body class=" login">
    <div class="logo">
    </div>
    <div class="content">
        <form class="login-form" action="{{route('register')}}" method="POST">
            @csrf
            <h3 class="font-green">Sign Up</h3>
            <div class="form-group">
                <input id="name" type="text" class="form-control" name="name" value="" required=""
                    placeholder="Full name">
            </div>
            <div class="form-group">
                <input id="email" type="email" class="form-control" name="email" value="" required=""
                    placeholder="Email">
            </div>
            <div class="form-group">
                <input id="password" type="password" class="form-control" name="password" required=""
                    placeholder="Password">
            </div>
            <div class="form-group">
                <input id="password-confirm" type="password" class="form-control" name="password_confirmation"
                    required="" placeholder="Retype password">
            </div>
            <div class="form-actions">
                <button type="submit" class="btn green uppercase pull-right">Submit</button>
                <label>
                </label>
            </div>
        </form>
        <div class="create-account">
            <p>
                <a href="/login">I already have an account</a>
            </p>
        </div>
    </div>

    <!-- BEGIN CORE PLUGINS -->
    <script src="{{ url('/design/metronic-ltr/assets/global/plugins/jquery.min.js') }}" type="text/javascript"></script>
    <script src="{{ url('/design/metronic-ltr/assets/global/plugins/bootstrap/js/bootstrap.min.js') }}"
        type="text/javascript"></script>
    <script src="{{ url('/design/metronic-ltr/assets/global/plugins/js.cookie.min.js') }}" type="text/javascript">
    </script>
    <script src="{{ url('/design/metronic-ltr/assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js') }}"
        type="text/javascript"></script>
    <script src="{{ url('/design/metronic-ltr/assets/global/plugins/jquery.blockui.min.js') }}" type="text/javascript">
    </script>
    <script src="{{ url('/design/metronic-ltr/assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js') }}"
        type="text/javascript"></script>
    <script src="{{ url('/design/metronic-ltr/assets/global/plugins/jquery-validation/js/jquery.validate.min.js') }}"
        type="text/javascript"></script>
    <script src="{{ url('/design/metronic-ltr/assets/global/plugins/jquery-validation/js/additional-methods.min.js') }}"
        type="text/javascript">
    </script>
    <script src="{{ url('/design/metronic-ltr/assets/global/scripts/app.min.js') }}" type="text/javascript"></script>
    <script src="{{ url('/design/metronic-ltr/assets/pages/scripts/login.min.js') }}" type="text/javascript"></script>

</body>

</html>