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

<table id="tt"style="width:90%;height:400px;"></table>
    <br>
    <a class="easyui-linkbutton c1" data-options="iconCls:'icon-arrow'" href="javascript:void(0)" onclick="javascript:view()">View Graph</a>
    <a class="easyui-linkbutton c4" data-options="iconCls:'icon-graph'" href="javascript:void(0)" onclick="javascript:viewAll()">View All Nodes</a>

    <script>
    $(function(){
        $('#tt').datagrid({
            url:"{{route('api.main.get.items')}}",
            method: "POST",
            columns:[[
                {field:'inv',title:'ItemNo',width:100,sortable:true},
                {field:'date',title:'CreatedAt',width:100,sortable:true},
                {field:'name',title:'Name',width:100,sortable:true},
                {field:'category',title:'Category',width:100,sortable:true},
                {field:'connections',title:'Connections',width:100,sortable:true}
            ]],
            title:"Select Node",
            iconCls:"icon-graph",
            rownumbers:"true",
            pagination:"true",
            singleSelect:"true",
            onDblClickRow: function(index,row){
        		location.href = `http://localhost/onhdi/public/info/`+row.inv;
        	}
        });
    });
    
    function view(){
      var row = $('#tt').datagrid('getSelected');
      if (row){
          location.href = `http://localhost/onhdi/public/info/`+row.inv;
      }else {
        $.messager.alert('Warning','You must select a row!','error');
      }
    }
    
    function viewAll(){
        if ($('#tt').datagrid('getData').total > 100){
            if (confirm(`Node count is ${$('#tt').datagrid('getData').total}, is higher than 100. Are you ok to view all?`) == true) {
                location.href = `http://localhost/onhdi/public/info`;
            }
        }else {
            location.href = `http://localhost/onhdi/public/info`;
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