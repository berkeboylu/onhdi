<div class="easyui-panel" title="{{$data->name}} Details" style="width:100%;display:flex; padding:10px 50px;gap:50px;align-items:center">
    <img src="{{asset('photo/')}}{{$data->icon}}" alt="Category Icon" style="width: 100px;height: 100px;">
    <div>
        <b style="margin-bottom: 10px">Node Name:</b> {{$data->node}} <br>
        <b style="margin-bottom: 10px">Category Name:</b> {{$data->name}} <br>
        <b style="margin-bottom: 10px">Description:</b> <pre>{{$data->description}}</pre> <br>
        <hr>
        <b style="margin-bottom: 10px">Icon Path:</b> <a target="_blank" rel="noopener noreferrer" href="{{asset('photo/')}}{{$data->icon}}">{{$data->icon}}</a> <br>
        <b style="margin-bottom: 10px">Created At:</b> {{$data->created_at}} <br>
        <b style="margin-bottom: 10px">Updated At:</b> {{$data->updated_at}} <br>
        <b style="margin-bottom: 10px">Active:</b> {{$data->active}} <br>
    </div>
</div>