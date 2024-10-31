@extends('layouts.auth')

@section('content')
<div style="position: absolute;  left: 50%;
  top: 50%;
  margin-left: -200px;
  margin-top: -200px;">

    <div class="easyui-panel" title="Login" style="width:100%;max-width:400px;padding:30px 60px;">
        <h1 style="text-align:center">onHDI</h1>
        <form id="ff" method="POST" action="{{ route('login') }}">
            @csrf
            <div style="margin-bottom:20px">
                <input class="easyui-textbox" style="width:100%" data-options="required:true" prompt="Email" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus style="width:100%;height:37px !important;padding:10px">
            </div>
            <div style="margin-bottom:20px">
                <input class="easyui-passwordbox @error('password') is-invalid @enderror" name="password" data-options="required:true" required autocomplete="current-password" prompt="Password" iconWidth="28" style="width:100%;height:34px;padding:10px">
            </div>
            <div class="row mb-0">
                <div class="col-md-8 offset-md-4">
                    <div style="text-align:center;padding:5px 0">
                        <button class="easyui-linkbutton" type="submit" style="width:80px">Submit</button>
                    </div>
                </div>
            </div>
            
            
        </form>
    </div>
</div>

@error('email')
<script>
$(function(){
    setTimeout(() => {
        $.messager.show({
        title:'Error',
        msg:'{{ $message }}',
        timeout:5000,
        showType:'slide'
    });
    }, 100);
});
</script>
@enderror

@endsection
