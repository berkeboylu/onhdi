<!DOCTYPE html>
<!-- saved from url=(0086)https://visjs.github.io/vis-network/examples/network/nodeStyles/imagesWithOpacity.html -->
<html lang="en"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <link rel="stylesheet" type="text/css" href="{{asset('themes/'.Auth::user()->getPreference('theme').'/easyui.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('themes/icon.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('src/demo.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('themes/color.css')}}">
    <script type="text/javascript" src="{{asset('src/jquery.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('src/jquery.easyui.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('src/jquery.portal.js')}}"></script>
    <link rel="icon" type="image/x-icon" href="{{asset('favicon.ico')}}">
  @yield('header')
</head>
<body @yield('body')>

@yield('content')

<script>
$(function(){
            $(document).bind('contextmenu',function(e){
                e.preventDefault();
                $('#mm').menu('show', {
                    left: e.pageX,
                    top: e.pageY
                });
            });
        });
        
        
$( document ).on( "ajaxStart", function() {
    $.messager.progress({
                title:'Please waiting',
                msg:'Loading data...'
            });
});

$( document ).ajaxStop(function() {
    $.messager.progress('close');
});
</script>
</body>
</html>