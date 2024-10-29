@extends('layouts.app')


@section('header')
<script type="text/javascript" src="https://www.jeasyui.com/easyui/datagrid-bufferview.js"></script>

<script>

</script>
@endsection

@section('body') 
@endsection

@section('content')
<h3>Select one node to view graph</h3>

<table id="tt" class="easyui-datagrid" style="width:90%;height:400px;"
            url="{{route('api.main.get.items')}}"
            title="Select Node" iconCls="icon-graph"
            sortName="inv" sortOrder="asc"
            rownumbers="true" pagination="true" singleSelect="true">
        <thead>
            <tr>
                <th field="inv" width="20%">Item No</th>
                <th field="date" width="20%">CreatedAt</th>
                <th field="name" width="20%">Name</th>
                <th field="category" width="20%">Category</th>
                <th field="connections" width="20%">Connections</th>
            </tr>
        </thead>
    </table>
    <br>
    <a class="easyui-linkbutton c1" data-options="iconCls:'icon-view'" href="javascript:void(0)" onclick="javascript:view()">View Graph</a>

    
    <script>
    function view(){
      var row = $('#tt').datagrid('getSelected');
      if (row){
          location.href = `http://localhost/onhdi/public/info`;
      }else {
        $.messager.alert('Warning','You must select a row!','error');
      }
    }
    
    function progress(){
        var win = $.messager.progress({
            title:'Please waiting',
            msg:'Loading data...'
        });
        setTimeout(function(){
            $.messager.progress('close');
        },5000)
    }
    </script>
@endsection