<!DOCTYPE html>
<!-- saved from url=(0086)https://visjs.github.io/vis-network/examples/network/nodeStyles/imagesWithOpacity.html -->
<html lang="en"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>onHDI Main</title>

    <style type="text/css">
      #mynetwork {
        width: 100%;
        height: 100%;
      }
    </style>
    <link rel="stylesheet" type="text/css" href="{{asset('themes/'.env('THEME', 'default').'/easyui.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('themes/color.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('themes/icon.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('src/demo.css')}}">
    <script type="text/javascript" src="{{asset('src/jquery.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('src/jquery.easyui.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('src/jquery.portal.js')}}"></script>
    <link rel="icon" type="image/x-icon" href="{{asset('favicon.ico')}}">
    
    
    <style>
      .header{
          background: #2d3e50;
          color: #fff;
          direction: ltr;
      }
      .header .navbar{
          margin-bottom: 0;
          display: inline-block;
          vertical-align: middle;
      }
      .header a,.header a:hover{
          color: #fff;
          line-height: 50px;
      }
      .header .content{
          padding: 0.5em 4.5%;
      }
      .content{
          padding: 2em;
          padding-left: 5%;
          padding-right: 5%;
          max-width: 1230px;
          margin: 0 auto;
      }
      .hmenu{width:900px;margin:0 auto;font-size:22px;}
      .foot{text-align:center;font-size:12px;height:20px;padding:5px;}

      .left{padding:10px;}
  </style>
  
  <script>
		$(function(){
			$('#pp').portal({
				border:false,
				fit:true,
				onStateChange: function(panel) {
				  console.log(panel);
				}
			});
		});

		function remove(){
			$('#pp').portal('remove',$('#pgrid'));
			$('#pp').portal('resize');
		}
	</script>

  <script>

$(function(){
  $('#menu').tree({
    //TODO: Burayı api ile al ve nodeları kapsıyor olmalı.
      //url: '{{asset('temp/tree.json')}}',
      url: '{{route('api.tree.get')}}',
      loadFilter: function(data){
          if (data.d){
              return data.d;
          } else {
              return data;
          }
      },
      formatter:function(node){
                        var s = node.text;
                        if (node.children){
                            s += '&nbsp;<span style=\'color:#feba00\'>(' + node.children.length + ')</span>';
                        }
                        return s;
                    },
      animate: true,
      onClick: function(node){
         // alert(node.url);
          openTab(node);
         // alert(node.attributes.url);  // alert node text property when clicked
      }
  });
})


function openTab(node){
  if(node.url==undefined){
      return;
  }
  if($("#tabs").tabs("exists",node.text)){
      $("#tabs").tabs("select",node.text);
  }else{
      var content="<iframe frameborder=0 scrolling='no' style='width:100%;height:100%' src='"+node.url+"'></iframe>"
      $("#tabs").tabs("add",{
          title:node.text,
          iconCls:node.iconCls,
          closable:true,
          content:content
      });
  }
}

$(function(){
  $('#tabs').tabs({
    //onBeforeClose: function(title){
  	// return confirm(`Are you sure you want to close ${title}?`);
    //},
    onUpdate: function(title){
      document.title = `${title} - onHDI`;
    },
    onSelect: function(title){
      document.title = `${title} - onHDI`;
    }
  });
  
  var request = $.ajax({
      url: "{{route('api.main.dashboard')}}",
      type: "GET",
      data: {}
    });
    
    request.done(function( data ) {
      $('#mdas').html(`<b style="font-size: 25px;color: red">${data._node} node</b><br><small style="color: green">${data._connection} connection</small><br><small style="color: blue">${data._category} category</small>`);
    });
    
    request.fail(function( jqXHR, textStatus ) {
      $('#mdas').html(`<small style="color: red">couldn't load data</small>`);
    });
});

function collapseAll(){
  $('#menu').tree('collapseAll');
}
function expandAll(){
  $('#menu').tree('expandAll');
}
function animateLove(){
  $('love').show('slow');
  setTimeout(() => {
  $('love').hide('slow');
    
  }, 300);
}

function getAll(){
  $('#loadTable').remove();
  $('#pgrid').css('display', 'block');
  $('#dg').datagrid({
      url:"{{route('api.main.get.items')}}",
      columns:[[
          {field:'inv',title:'Item',width:100},
          {field:'date',title:'CreatedAt',width:100},
          {field:'name',title:'Name',width:100},
          {field:'category',title:'Category',width:100},
          {field:'connections',title:'Connections',width:100}
      ]]
  });

}

</script>

</head>
<body class="easyui-layout">
<div data-options="region:'north',border:false" style="height:20px;" class="header">
&nbsp;<small onclick="animateLove()"><img src="{{asset('favicon.png')}}" style="width: 10px; filter:brightness(100)"> <b title="Onhouse App Diagrams aka onHDI" class="easyui-tooltip">onHDI</b> - <i style="color: gray">made with ❤️ by <span title="https://github.com/berkeboylu" class="easyui-tooltip">boylu</span></i> </small>
<love style="display: none; position: fixed;top: 50%;
left: 50%;
transform: translate(-50%, -50%) scale(50); transition: transform 2s">❤️</love>
</div>

<div data-options="region:'center'">
  <div class="easyui-layout" data-options="fit:true">
      <div data-options="region:'west',collapsed:false" style="width:180px">
          <div  class="left">
          <div>
              <a href="javascript:void(0)" class="easyui-linkbutton" onclick="collapseAll()">Collapse</a>
              <a href="javascript:void(0)" class="easyui-linkbutton"  onclick="expandAll()">Expand</a>
          </div>
          <hr>
          <div id="menu"></div>
          </div>
      </div>
      <div data-options="region:'center'" >

       <div id="tabs" class="easyui-tabs" style="width:100%;height:100%">

           <div title="Main" style="padding:10px;">
            <h3>Hoşgeldin, berke!</h3>
            <div id="pp" style="position:relative">
              <div style="width:30%;">
                <div title="Clock" style="text-align:center;background:#f3eeaf;height:150px;padding:5px;display:flex;align-items:center;justify-content:center;"><iframe src="https://free.timeanddate.com/clock/i9lvldc4/n107/tltr28/fn6/fs16/fcfeba00/tc000/ftbi/bas2/bat1/bacfff/pa8/tt0/tw1/tm1/td1/th1/tb4" frameborder="0" width="154" height="58"></iframe>
                </div>
                
                <div title="Current" style="height:200px;background:#f5f3cc;padding:5px;display: flex;justify-content: center;align-items: center;">
                    <div id="mdas">
                      <div class="panel-loading">Loading...</div>
                    </div>
                </div>
              </div>
              <div style="width:40%;">
                <div id="pgrid" title="Nodes" closable="true" maximizable="true" style="height:200px;display:flex;justify-content:center;align-items:center;">
                  <table id="dg"></table>
                  <a class="easyui-linkbutton c1" id="loadTable" href="javascript:void(0)" onclick="javascript:getAll()">Load All Nodes</a>
                </div>
              </div>
              <div style="width:30%;">
                <div title="Searching" iconCls="icon-search" closable="true" style="height:80px;padding:10px;">
                  <input class="easyui-searchbox" style="width:100%">
                </div>
              </div>
            </div>
          </div>
       </div>
      </div>
  </div>
</div>
</body>
</html>