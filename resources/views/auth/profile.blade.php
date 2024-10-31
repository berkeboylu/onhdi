@extends('layouts.auth')

@section('content')
<div class="easyui-panel" title="Profile" style="width:100%;padding: 30px 15px" data-options="footer:'#footer'">
    
    <p><b>Name: </b> {{Auth::user()->name}}</p>
    <p><b>Email </b> {{Auth::user()->email}}</p>
    <hr>
    <p><b>Current Theme: </b> {{env('THEME')}}</p>
    
        
</div>
<div id="footer" style="padding:5px;">
        <a href="javascript:void(0)" class="easyui-linkbutton c3">Delete Account</a>
        <a href="javascript:void(0)" class="easyui-linkbutton c1">Reset Account</a>

</div>

<form id="logoutForm" action="{{route('logout')}}" method="POST">@csrf</form>


<script>
function logout(){
  $('#logoutForm').submit();  
}
</script>
@endsection
