<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <title>Admin</title>
    <script>
        window.csrf_token= <?php
        echo json_encode(['csrfToken'=>csrf_token()])
        ?>
    </script>

  <link rel="stylesheet" href="{{asset('css/admin.css')}}">
  <link rel="stylesheet" href="{{asset('css/all.css')}}">
  <link rel="stylesheet" href="http://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <link rel="stylesheet" href="{{asset('css/adminlt.css')}}">
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>
<body class="hold-transition sidebar-mini">


<div class="wrapper">
  <div id="app">
  <admin-navigation-component></admin-navigation-component>
  <admin-aside-component></admin-aside-component>
      <vue-page-transition name="fade-in-right">
  <router-view></router-view>
      </vue-page-transition>
  </div>
</div>



<script src="{{asset('js/admin.js')}}"></script>
<script src="{{asset('js/adminlte.js')}}"></script>
<script src="{{asset('js/demo.js')}}"></script>
<script src="{{asset('js/dashboard.js')}}"></script>
</body>
</html>
