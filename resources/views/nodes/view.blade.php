@extends('layouts.app')

@section('content')
<div id="wc" class="easyui-panel" title="Node Details" style="width:100%;display:flex; padding:10px 50px;gap:50px;align-items:center">

</div>
<br>
<table class="easyui-datagrid" title="Connections" style="height:250px"
        data-options="singleSelect:true,collapsible:true,url:'{{route('api.edges.get',['node_id' => $id])}}',method:'get'">
    <thead>
        <tr>
            <th data-options="field:'fromName',align:'left'">From</th>
            <th data-options="field:'descr',align:'center'">Desc</th>
            <th data-options="field:'toName',align:'right'">To</th>
            <th data-options="field:'cid'">cid</th>
        </tr>
    </thead>
</table>

<script>

$(function(){
  var request = $.ajax({
      url: "{{route('nodes.view.detail', ['id' => $id])}}",
      type: "GET",
      data: {}
    });
    
    request.done(function( data ) {
      $('#wc').html(data);
    });
    
    request.fail(function( jqXHR, textStatus ) {
      $('#wc').html(`<small style="color: red">couldn't load data</small>`);
    });
});
</script>

@endsection
