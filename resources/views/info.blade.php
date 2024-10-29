@extends('layouts.app')

@php
    $_NODES = DB::select(DB::raw('SELECT nodes.id as id, nodes.name as name, category.icon as icon FROM nodes, category WHERE nodes.category_id = category.id and nodes.active = \'on\';'));
    $_EDGES = DB::select(DB::raw('SELECT * FROM connection'));
    
    $_cn = array_unique(array_column($_EDGES, 'connectionDesc'));
    $edgeColor = array();
    foreach ($_cn as $key => $value) {
      array_push($edgeColor, ["name" => $value, "color" => '#' . str_pad(dechex(mt_rand(0, 0xFFFFFF)), 6, '0', STR_PAD_LEFT)]);
    }
    
    function getHex($i, $edge){
        foreach ($edge as $value) {
          if ($value['name'] == $i)
            return $value['color'];
        }
    }
@endphp

@section('header')
<script src="https://cdnjs.cloudflare.com/ajax/libs/vis/4.21.0/vis.min.js" integrity="sha512-XHDcSyqhOoO2ocB7sKOCJEkUjw/pQCJViP1ynpy+EGh/LggzrP6U/V3a++LQTnZT7sCQKeHRyWHfhN2afjXjCg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/vis/4.21.0/vis-network.min.css" integrity="sha512-NJXM8vzWgDcBy9SCUTJXYnNO43sZV3pfLWWZMFTuCtEUIOcznk+AMpH6N3XruxavYfMeMmjrzDMEQ6psRh/6Hw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<script type="text/javascript">
  var nodes = null;
  var edges = null;
  var network = null;
  let canberefreshable = true;
  
  let loadedNodes = [];
  var DIR = "{{asset('photo/')}}";
  var EDGE_LENGTH_MAIN = 150;
  var EDGE_LENGTH_SUB = 50;
  
  function htmlTitle(html) {
    const container = document.createElement("div");
    container.innerHTML = html;
    return container;
  }

  // Called when the Visualization API is loaded.
  function draw() {
    // Create a data table with nodes.
    nodes = [];

    // Create a data table with links.
    edges = [];

    @for($i=1; $i < 2; $i++)
    
    @foreach ($_NODES as $node)
      nodes.push({
        id: {{$i+100*$node->id}},
        label: "{{$node->name}}",
        @if(!empty($node->icon))
        shape: "image",
        image: DIR + "{{$node->icon}}",
        @endif
      });
      
      loadedNodes.push({
        id: {{$node->id}},
        label: "{{$node->name}}",
        @if(!empty($node->icon))
        shape: "image",
        image: DIR + "{{$node->icon}}",
        @endif
      });
    @endforeach
    
    @foreach ($_EDGES as $edge)
      edges.push({ from: {{$i+100*$edge->nodeFrom}}, to: {{$i+100*$edge->nodeTo}}, length: EDGE_LENGTH_MAIN, label: "{{$edge->connectionDesc}}", color: {color:'{{getHex($edge->connectionDesc, $edgeColor)}}',highlight: '#feba00'},title: "{{$edge->connectionDesc}}"});
    @endforeach
    
    @endfor

    // create a network
    var container = document.getElementById("mynetwork");
    var data = {
      nodes: nodes,
      edges: edges,
    };
    var options = {
        width: (window.innerWidth - 25) + "px",
        height: (window.innerHeight - 75) + "px",
        @if(env('ARROW') == 'TRUE')
        edges:{
          arrows: 'to'
        }
        @endif
    };
    network = new vis.Network(container, data, options);

    network.on('click', onClick);
    network.on('doubleClick', onDoubleClick);
          
    network.on("stabilizationProgress", function (params) {
      var widthFactor = params.iterations / params.total;
      $('#p').progressbar({
          value: Math.round(widthFactor * 100)
      });
    });
    network.once("stabilizationIterationsDone", function () {
      $('#p').hide();
    });

    
    network.on("afterDrawing", function(ctx) {
      var dataURL = ctx.canvas.toDataURL();
      document.getElementById('canvasImg').href = dataURL;
      $('#canvasImg').attr('href', $('#canvasImg').attr('href').replace('image/png', 'image/jpeg'));
    })
  }
  
  
  
  var doubleClickTime = 0;
  var threshold = 200;
  
  function onClick() {
      var t0 = new Date();
      if (t0 - doubleClickTime > threshold) {
          setTimeout(function () {
              if (t0 - doubleClickTime > threshold) {
                  doOnClick();
              }
          },threshold);
      }
  }
  
  function doOnClick() {
      if (network.getSelection().nodes[0] != undefined){
        $('#mnac span').html(loadedNodes.find(x => x.id == network.getSelection().nodes[0]).label);
        $('#mnac').show();
      }
      else
      $('#mnac').hide();
        
  }
  
  function onDoubleClick() {
      doubleClickTime = new Date();
      var SelectedNodeIDs = network.getSelection().nodes;
      
      if (SelectedNodeIDs[0] != undefined){
        getDescription(SelectedNodeIDs[0]);
      }
  }
  
  //Resize thing
  function debounce(func){
    var timer;
    return function(event){
      if(timer) clearTimeout(timer);
      timer = setTimeout(func,100,event);
    };
  }
  
  window.addEventListener("resize",debounce(function(e){
    (canberefreshable)?draw():'';
  }));
  
  function getDescription(int){
    $('#wdesc').window('open');
    $('#wdesc .cnt').html(`<div class="panel-loading">Loading...</div>`);
    var nodeDetails = $.ajax({
      url: "http://localhost/onhdi/public/nodes/view/detail/"+int,
      type: "GET",
      data: {}
    });
    
    nodeDetails.done(function( data ) {
      $('#wdesc .cnt').html(data);
    });
    
    nodeDetails.fail(function( jqXHR, textStatus ) {
      $('#wdesc .cnt').html(`<small style="color: red">couldn't load data</small>`);
    });
  }
  
  function connectTwo(){
    $('#wc').window('open');
  }
  
  function connectConfirm(){
    if ($('#ce-1').val() == '' || $('#ce-2').val() == ''){
      $.messager.show({
          title:'Error',
          msg:'You should select two node!',
          timeout:0,
          showType:'fade'
      });
      return;
    }
      
    var request = $.ajax({
      url: "{{route('api.edges.add')}}",
      type: "POST",
      data: { from: $('#ce-1').val(), to: $('#ce-2').val(), d: $('#ce-3').val() }
    });
    
    request.done(function( data ) {
      $.messager.show({
          title:'Success',
          msg:data,
          timeout:0,
          showType:'fade'
      });
    });
    
    request.fail(function( jqXHR, textStatus ) {
      $.messager.show({
          title:'Error',
          msg:textStatus,
          timeout:0,
          showType:'fade'
      });
    });
    
  }
  
  function menuNew(){
    $('#wn').html(`<iframe src="{{route('nodes.add')}}" title="Nodes Add" style="width: 100%; height: 100%;"></iframe>`);
    $('#wn').window('open');
  }
  
  function disableNode(){
    var request = $.ajax({
      url: "{{route('api.nodes.disable')}}",
      type: "POST",
      data: { id: network.getSelection().nodes[0] }
    });
    
    request.done(function( data ) {
      $.messager.show({
          title:'Success',
          msg:data,
          timeout:0,
          showType:'fade'
      });
    });
    
    request.fail(function( jqXHR, textStatus ) {
      $.messager.show({
          title:'Error',
          msg:textStatus,
          timeout:0,
          showType:'fade'
      });
    });
  }

</script>
@endsection

@section('body')
onload="draw()"   
@endsection

@section('content')
<a id="canvasImg" download="filename"></a>
<div id="mynetwork"><div class="vis-network" tabindex="0" style="position: relative; overflow: hidden; touch-action: pan-y; user-select: none; -webkit-user-drag: none; -webkit-tap-highlight-color: rgba(0, 0, 0, 0); width: 100%; height: 100%;"><canvas style="position: relative; touch-action: none; user-select: none; -webkit-user-drag: none; -webkit-tap-highlight-color: rgba(0, 0, 0, 0); width: 100%; height: 100%;" width="600" height="600"></canvas></div></div>
<div id="wdesc" class="easyui-window" title="Node information" data-options="modal:true,closed:true,iconCls:'icon-help',tools:'#tt'" style="width:500px;height:400px;padding:5px;display:none">
    <div class="easyui-layout" data-options="fit:true">
        <div class="cnt" data-options="region:'center'" style="padding:10px;">
            jQuery EasyUI framework help you build your web page easily.
        </div>
        <div id="tt">
            <a href="javascript:void(0)" class="icon-add" onclick="javascript:alert('add')"></a>
            <a href="javascript:void(0)" class="icon-edit" onclick="javascript:alert('edit')"></a>
            <a href="javascript:void(0)" class="icon-cut" onclick="javascript:alert('cut')"></a>
            <a href="javascript:void(0)" class="icon-help" onclick="javascript:alert('help')"></a>
        </div>
    </div>
</div>

  <div id="p" style="width: 200px; position:fixed; left:calc(50%-100px);top:50%"></div>


<div id="mm" class="easyui-menu" style="width:120px;">
  <div data-options="iconCls:'icon-add'" onclick="javascript:menuNew()">New</div>
  <div data-options="iconCls:'icon-graph'" onclick="javascript:connectTwo()">Connect</div>
  <div data-options="iconCls:'icon-reload'" onclick="javascript:location.reload()">Reload</div>
  <!--div>
      <span>Open</span>
      <div style="width:150px;">
          <div><b>Word</b></div>
          <div>Excel</div>
          <div>PowerPoint</div>
          <div>
              <span>M1</span>
              <div style="width:120px;">
                  <div>sub1</div>
                  <div>sub2</div>
                  <div>
                      <span>Sub</span>
                      <div style="width:80px;">
                          <div onclick="javascript:alert('sub21')">sub21</div>
                          <div>sub22</div>
                          <div>sub23</div>
                      </div>
                  </div>
                  <div>sub3</div>
              </div>
          </div>
          <div>
              <span>Window Demos</span>
              <div style="width:120px;">
                  <div data-options="href:'window.html'">Window</div>
                  <div data-options="href:'dialog.html'">Dialog</div>
                  <div><a href="http://www.jeasyui.com" target="_blank">EasyUI</a></div>
              </div>
          </div>
      </div>
  </div-->
  <div id="mnac" style="display: none">
    <span>Node</span>
    <div style="width:150px;">
        <div data-options="iconCls:'icon-edit'" style="color:blue">Edit</div>
        <div data-options="iconCls:'icon-no'" style="color:red" onclick="$('#dndlg').dialog('open');">Disable</div>
        <div data-options="iconCls:'icon-arrow'" style="color:" onclick="connectTwo();$('#ce-1').combobox('setText', loadedNodes.find(x => x.id == network.getSelection().nodes[0]).label);$('#ce-1').combobox('setValue', network.getSelection().nodes[0]);">Connect to</div>
        
    </div>
  </div>
  <div data-options="iconCls:'icon-save'" onclick="document.getElementById('canvasImg').click();">Save as Img</div>
  <div data-options="iconCls:'icon-print',disabled:true">Print</div>
  <div class="menu-sep"></div>
  <div>Exit</div>
</div>


<div id="wc" class="easyui-window" title="Connect Two" data-options="iconCls:'icon-graph',closed:true" style="width:500px;height:350px;padding:5px;">
  <div class="easyui-layout" data-options="fit:true">
      <div data-options="region:'center'" style="padding:10px;">
        <input id="ce-1" class="easyui-combobox" name="Select Node 1" style="width:100%;" required="true" data-options="
        url: '{{route('api.nodes.get')}}',
                    method: 'post',
                    valueField:'id',
                    textField:'name',
                    groupField:'groupname',
                    label: 'Select Node 1:',
                    labelPosition: 'top'
                    ">
                    
        <input id="ce-2" class="easyui-combobox" name="Select Node 2" style="width:100%;" required="true" data-options="
        url: '{{route('api.nodes.get')}}',
                    method: 'post',
                    valueField:'id',
                    textField:'name',
                    groupField:'groupname',
                    label: 'Select Node 2:',
                    labelPosition: 'top'
                    ">
        
        <div style="margin-bottom:20px">
          <input id="ce-3" class="easyui-textbox" label="Decsription:" labelPosition="top" required="true" style="width:100%;">
        </div>
      </div>
      <div data-options="region:'south',border:false" style="text-align:right;padding:5px 0 0;">
          <a class="easyui-linkbutton" data-options="iconCls:'icon-ok'" href="javascript:void(0)" onclick="javascript:connectConfirm();" style="width:80px">Ok</a>
          <a class="easyui-linkbutton" data-options="iconCls:'icon-cancel'" href="javascript:void(0)" onclick="javascript:$('#wc').window('close');" style="width:80px">Cancel</a>
      </div>
  </div>
</div>

<div id="wn" class="easyui-window" title="Add New" data-options="iconCls:'icon-add',closed:true" style="width:500px;height:250px;padding:5px;">
  
</div>


<div id="dndlg" class="easyui-dialog" title="Disabling Node" style="width:400px;height:200px;padding:10px"
            data-options="
                closed:true,
                iconCls: 'icon-cancel',
                buttons: [{
                    text:'Disable',
                    iconCls:'icon-ok',
                    handler:function(){
                      disableNode();
                      $('#dndlg').dialog('close');
                    }
                  },{
                    text:'Cancel',
                    handler:function(){
                      $('#dndlg').dialog('close');
                    }
                }]
            ">
        The dialog content.
    </div>
@endsection