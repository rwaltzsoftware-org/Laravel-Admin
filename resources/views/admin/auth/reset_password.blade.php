<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title>{{ $site_settings['site_name'] or '' }} Admin Login</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <!-- Place favicon.ico and apple-touch-icon.png in the root directory -->
        <!--base css styles-->
        <link rel="stylesheet" href="{{ url('/') }}/assets/bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="{{ url('/') }}/assets/font-awesome/css/font-awesome.min.css">

        <!--page specific css styles-->
        <link rel="stylesheet" type="text/css" href="{{ url('/') }}/assets/chosen-bootstrap/chosen.min.css">

        <!--flaty css styles-->
        <link rel="stylesheet" href="{{ url('/') }}/css/admin/flaty.css">
        <link rel="stylesheet" href="{{ url('/') }}/css/admin/flaty-responsive.css">

        <link rel="shortcut icon" href="{{ url('/') }}/img/favicon.png">

        <style type="text/css">
        .error
        {
            color: red;
        }
       .login-page:before{background: none!important}
        #form-reset_password
        {
            box-shadow    : 13px 21px 70px #000;
            border-radius : 15px;
        }

        

        .login-page_quedemonos {
            padding: 80px 0;
        }
        .login-page_quedemonos:before {
            content: "";
            position: fixed;
            top: 0;
            bottom: 0;
            width: 100%;
            z-index: 1;
        }
        .login-page_quedemonos .login-wrapper {
            position: relative;
            z-index: 2;
        }
        .login-page_quedemonos .login-wrapper form {
            background-color: #fff;
            padding: 20px;
            width: 340px;
            margin: 0 auto;
        }
        .login-page_quedemonos form h3 {
            font-size: 25px;
            font-weight: 300;
        }
        .login-page_quedemonos form input {
            border: 0;
            background-color: #f5f6f7;
        }
        .login-page_quedemonos form input[type="text"],
        .login-page_quedemonos form input[type="password"],
        .login-page_quedemonos form button {
            padding: 15px 10px !important;
            height: auto !important;
            font-size: 16px;
        }
        .login-page_quedemonos form button {
            margin-top: 25px;
        }
        .login-page_quedemonos .hidden {
            display: none;
        }
        .login-page_quedemonos .login-wrapper form p.clearfix {
            white-space: nowrap;
        }
        </style>

    </head>
    <body class="login-page" style='background-image: url("{{url('/')}}/images/admin/4.jpg") !important;background-repeat:repeat-x;background-size: 100%;' id="background">



        <!-- BEGIN Main Content -->
        <div class="login-wrapper">
            <!-- BEGIN Login Form -->

            {!! Form::open([ 'url' => $admin_panel_slug.'/reset_password',
                                 'method'=>'POST',
                                 'id'=>'form-reset_password'
                                ]) !!}

                    @if (Session::has('flash_notification.message'))
                        <div class="alert alert-{{ Session::get('flash_notification.level') }}">

                            {!! Session::get('flash_notification.message') !!}
                        </div>
                    @endif

            	 {{ csrf_field() }}

                 <center>
                    {{-- <img src="{{url('/').'/images/front/logo.png'}}" width="60%" height="170%"> --}}
                    <h4> RESET PASSWORD</h4>
                    <br/>
                    <!-- <b>Login Your Account</b> -->
                 </center>

                <!-- <h3>Login to your account</h3> -->
                <hr/>
                <div class="form-group ">
                    <div class="controls">
                        {!! Form::password('password',['class'=>'form-control','id'=>'new_password',
                                        'data-rule-required'=>'true','data-rule-minlength'=>'6',
                                        'placeholder'=>'Password']) !!}

                        <span class="error">{{ $errors->first('password') }} </span>
                    </div>
                </div>
                <div class="form-group">
                    <div class="controls">


                        {!! Form::password('confirm_password',['class'=>'form-control',
                                        'data-rule-required'=>'true','data-rule-minlength'=>'6','data-rule-equalto'=>'#new_password',
                                        'placeholder'=>'Confirm Password']) !!}

                        <span class="error">{{ $errors->first('confirm_password') }} </span>
                    </div>
                </div>
                <div class="form-group">
                    <div class="controls">
                        <input type="hidden" name="enc_id" value="{{ $enc_id or '' }}" />
                        <input type="hidden" name="enc_reminder_code"  value="{{ $enc_reminder_code or '' }}"/>

                         <button type="submit" class="btn btn-info form-control">Change Password</button>
                    {{-- {!! Form::Submit('Sign In',['class'=>'btn btn-primary form-control']) !!}         --}}
                    </div>
                </div>
            </form>
            <!-- END Login Form -->




        <!--basic scripts-->
        <script>window.jQuery || document.write('<script src="{{ url('/') }}/assets/jquery/2.1.4/jquery.min.js"><\/script>')</script>
       <script type="text/javascript">
        var images       = ['1.jpg', '2.jpg', '3.jpg', '4.jpg', '5.jpg'];
        
        var randomNumber = Math.floor((Math.random() * images.length)+1);
        
        var randomImage  = "{{url('/')}}/images/admin/" + randomNumber + ".jpg";
            console.log(randomImage);

           $('#background').css({'background-image': 'url(' + randomImage + ')' }).addClass('loaded');

        </script>
        <script>window.jQuery || document.write('<script src="{{ url('/') }}/assets/jquery/jquery-2.1.4.min.js"><\/script>')</script>
        <script src="{{ url('/') }}/assets/bootstrap/js/bootstrap.min.js"></script>
        <script src="{{ url('/') }}/assets/jquery-slimscroll/jquery.slimscroll.min.js"></script>
        <script src="{{ url('/') }}/assets/jquery-cookie/jquery.cookie.js"></script>


        <script type="text/javascript" src="{{ url('/') }}/assets/jquery-validation/dist/jquery.validate.min.js"></script>
		<script type="text/javascript" src="{{ url('/') }}/assets/jquery-validation/dist/additional-methods.min.js"></script>
        <script type="text/javascript" src="{{ url('/') }}/assets/chosen-bootstrap/chosen.jquery.min.js"></script>


        <!--flaty scripts-->
        <script src="{{ url('/') }}/js/admin/flaty.js"></script>
        <script src="{{ url('/') }}/js/admin/flaty-demo-codes.js"></script>
        <script src="{{ url('/') }}/js/admin/validation.js"></script>

        <script type="text/javascript">
            $(function()
            {
                applyValidationToFrom($("#form-reset_password"))
            });

        </script>
    </body>
</html>
