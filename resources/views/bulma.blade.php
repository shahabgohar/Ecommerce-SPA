<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script>
        window.csrf_token= <?php
        echo json_encode(['csrfToken' => csrf_token()])

        ?>
    </script>
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{asset("css/IMageSlider.css")}}">
     <link rel="stylesheet" href="{{asset('css/app.css')}}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.8.0/css/bulma.min.css">
    <title>Document</title>
</head>
<body>
    <div id="apps">
     <navbar @showsignupcomponent="ShowSignUp" @closesignupcommentshowlogin="CloseSignUpShowLogIn" @showmaincomponent="ShowMain" :loggedin="userlog"></navbar>
        <vue-page-transition name="fade-in-right">
    <mian-component ref="maincomp" v-if="MainComponentDisplay"></mian-component>
        </vue-page-transition>
        <vue-page-transition name="fade-in-right">
                <sign-up-component v-if=" SignUp" @userloggedin="responselogged"></sign-up-component>
        </vue-page-transition>
        <vue-page-transition nam="fade-in-right">
        <sign-in-component v-if="LogIn" @userloggedin="UserSignIn"></sign-in-component>
        </vue-page-transition>

    <footercomp></footercomp>
</div>



</body>
<script src="{{asset('js/app.js')}}">

</script>
</html>
