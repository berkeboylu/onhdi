@extends('layouts.app')


@section('header')

@endsection

@section('body')  
@endsection

@section('content')
<table id="pg"></table>
</table>
<small><i>if you change theme, you should reload the pages.</i></small>
<br>
<a class="easyui-linkbutton" data-options="iconCls:'icon-ok'" href="javascript:void(0)" onclick="javascript:getChanges()" style="width:80px">Save</a>
<a class="easyui-linkbutton" data-options="iconCls:'icon-reload'" href="javascript:void(0)" onclick="javascript:loadTable()" style="width:80px">Reload</a>

<script type="text/javascript">

    $(function(){
        loadTable();
    });
    
    function loadTable(){
        $('#pg').propertygrid({
            url: 'http://localhost/onhdi/public/api/settings/get',
            method: 'GET',
            showGroup: true,
            scrollbarSize: 0
        });
    }

    function getChanges(){
        let changes = [];
        var s = '';
        var rows = $('#pg').propertygrid('getChanges');
        for(var i=0; i<rows.length; i++){
            changes.push([rows[i].name, rows[i].value]);
        }
        if (changes.length > 0){
          $.ajax({
            url : "{{route('api.settings.change')}}",
            type: "POST",
            data : {
              changes: JSON.stringify(changes)
            },
            success: function(data, textStatus, jqXHR)
            {
              $.messager.show({
                title:'Success',
                msg:'Succesfully updated.',
                showType:'show'
              });
            },
            error: function (data)
            {
              $.messager.alert('Warning',data.responseText);
              loadTable();
            }
          });
        }
    }
</script>
@endsection