@extends('layouts.app')

@php

$_CATEGORIES = DB::table('category')->get();

@endphp


@section('content')

<div style="margin:20px 0;">
    <a href="javascript:void(0)" class="easyui-linkbutton easyui-tooltip" data-options="iconCls:'icon-cancel'" title="Clear form." onclick="clearForm()"></a>
</div>
<div class="easyui-panel" title="New Node" style="width:100%;max-width:700px;padding:30px 60px;">
    <form id="ff" method="post"  data-options="novalidate:true">
        <div style="margin-bottom:20px">
            <input class="easyui-textbox" name="name" style="width:100%" data-options="label:'Name',required:true">
        </div>
        <div style="margin-bottom:20px">
            <input class="easyui-textbox" name="description" style="width:100%;height:60px"
                data-options="label:'Desc:',multiline:true">
        </div>
        <div style="margin-bottom:20px">
                <input class="easyui-combobox" id="cc" name="category_id" style="width:85%;" data-options="
                    data: [
                        @foreach($_CATEGORIES as $ctg)
                            {value:'{{$ctg->id}}',text:'{{$ctg->name}}'},
                        @endforeach
                    ],
                    editable: false,
                    label: 'Category:',
                    required:true
                    "> <a href="javascript:void(0)" style="width: 14%" class="easyui-linkbutton easyui-tooltip" data-options="iconCls:'icon-add'" title="New Category" onclick="newCategory()"></a>
        </div>
        <div style="margin-bottom:20px">
            <input class="easyui-switchbutton" checked name="active" label="Active:" labelWidth="120">
        </div>
    </form>
    <a href="javascript:void(0)" class="easyui-linkbutton c6" iconCls="icon-ok" onclick="saveNode()" style="width:90px">Add</a>
</div>



<div id="dlg" class="easyui-dialog" style="width:400px" data-options="closed:true,modal:true,border:'thin',buttons:'#dlg-buttons'">
    <form id="fm" method="post" novalidate style="margin:0;padding:20px 50px">
        <div style="margin-bottom:10px">
            <input name="name" class="easyui-textbox" required="true" label="Name:" style="width:100%">
        </div>
        <div style="margin-bottom:10px">
            <input name="icon" class="easyui-textbox" label="Icon:" style="width:100%">
        </div>
    </form>
</div>
<div id="dlg-buttons">
    <a href="javascript:void(0)" class="easyui-linkbutton c6" iconCls="icon-ok" onclick="saveCategory()" style="width:90px">Add</a>
    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#fm').form('clear');$('#dlg').dialog('close')" style="width:90px">Cancel</a>
</div>
<script>
    function clearForm() {
        $('#ff').form('clear');
        $.messager.show({msg: "Form cleared"});
    }
    
    function newCategory(){
        $('#dlg').dialog('open').dialog('center').dialog('setTitle','New User');
    }

    function saveCategory(){
        $('#fm').form('submit',{
            url: '{{route('api.category.add')}}',
            iframe: false,
            onSubmit: function(){
                return $(this).form('validate');
            },
            success: function(data){
                $.messager.show({
                    msg: data
                });
            },
            error: function(data){
                $.messager.show({
                    title: 'Error',
                    msg: data
                });
            }
        });
    }
    
    function saveNode(){
        $('#ff').form('submit',{
            url: '{{route('api.nodes.add')}}',
            iframe: false,
            onSubmit:function(){
                    return $(this).form('enableValidation').form('validate');
            },
            success: function(data){
                $.messager.show({
                    msg: data
                });
            },
            error: function(data){
                $.messager.show({
                    title: 'Error',
                    msg: data
                });
            }
        });
    }

</script>

@endsection
