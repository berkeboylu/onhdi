<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class MainController extends Controller
{

    public function getAllItems(Request $req) {
        
        $_count = 200;
        if (empty($req->page)){
            $PAGE = 0;
            $ROWS = $_count;
        }else {
            $PAGE = $req->page-1;
            $ROWS = $req->rows;
        }

        
        $START_WITH = $PAGE * $ROWS;
        
        $MAX = (($START_WITH + $ROWS) >= $_count)?$_count:($START_WITH + $ROWS);
        
        $array = [];
        
        for ($i=$START_WITH; $i < $MAX; $i++) { 
            array_push($array, 
                [
                    "inv" => $i,
                    "date" => date("Y-m-d H:i:s",rand(1262055681,1262055681)),
                    "name" => 'Blabla',
                    "category" => 'bla31',
                    "connections" => rand(0, $i),
                ]);
        }
        
        return response()->json(array("total" => $_count, "rows" => $array), 200);
    }
    
    public function getAllItemsNew(Request $req) {
        
        $Nodes = DB::table('nodes')->select('nodes.*', DB::raw('(select count(*) from connection where nodeTo = nodes.id or nodeFrom = nodes.id) as connection'), 'category.name as category_name')
        ->leftJoin('category', 'category.id', 'nodes.category_id')
        ->where('nodes.active', 'on')
        ->get();

        $array = [];
        
        foreach ($Nodes as $key => $value) {
            array_push($array, 
                [
                    "inv" => $value->id,
                    "date" => $value->created_at,
                    "name" => $value->name,
                    "category" => $value->category_name,
                    "connections" => $value->connection,
                ]);
        }      

        return response()->json(array("total" => count($array), "rows" => $array), 200);
    }
    
    public function addCategory(Request $req){
        $_r = $req->all();
        
        if (empty($_r)){
            return response('Values can not be null!', 300);
        }
            
        try {
            DB::table('category')->insert($_r);
        } catch (Exception $e) {
            return response($e->getMessage(), 300);
        }
        
        return response('Succesfully added.', 200);
    }
    
    public function addNode(Request $req){
       
        $isExist = DB::table('nodes')->select('name')->get()->pluck('name')->toArray();

        if (in_array($req->name, $isExist))
            return response('Already exist. You should edit it!', 300);
        
        $_r = $req->all();
        
        if (empty($_r)){
            return response('Values can not be null!', 300);
        }
            
        try {
            DB::table('nodes')->insert($_r);
        } catch (Exception $e) {
            return response($e->getMessage(), 300);
        }
        
        return response('Succesfully added.', 200);
    }
    
    public function getTree(){
        $tree = array();
        $categoryTree = [array("text" => "Add New Node", "iconCls" => "icon-add", "url" => route('nodes.add'))];
        $categories = DB::table('category')->select('name', 'id')->get();
            
        //Items tree
        foreach ($categories as $value) {
            $_t = [];
            $_i = DB::table('nodes')->where('category_id', $value->id)->get();
            foreach ($_i as $it) {
                array_push($_t, ["text" => $it->name, "url" => route('view.node.id', ['id' => $it->id]), "iconCls" => ($it->active == 'off')?'icon-cancel':'icon-file']);
            }
            $_ch = [];
            array_push($categoryTree, array("text"=>$value->name, "children" => $_t, "state"=>(empty($_t))?'open':'closed'));
        }
           
            
        array_push($tree, array("id"=> 1, "text"=> "Items", "iconCls" => "icon-tip", "children" => $categoryTree, "state"=>"closed"));
        array_push($tree, array("id"=> 2, "text"=> "Graphs", "iconCls" => "icon-graph","url"=> route('view.graph')));
        //array_push($tree, array("id"=> 3, "text"=> "Nodes", "iconCls" => "icon-add"));
        array_push($tree, array("id"=> 4, "text"=> "Settings", "iconCls" => "icon-settings", "url" => route('view.settings')));
        
        return $tree;
        
        
        
    }
    
    public function getNode(Request $r){
        $_NODES = DB::select(DB::raw('SELECT nodes.id as id, nodes.name as name, category.icon as icon, category.name as groupname FROM nodes, category WHERE nodes.category_id = category.id and nodes.active = \'on\';'));
        return response()->json($_NODES, 200);
    }
    
    public function disableNode(Request $r){
        if (empty($r->id))
            return response("Id can not be null!", 300);
            
        DB::table('nodes')->where('id', $r->id)->update(["active" => "off"]);
        return response('Success', 200);
    }
    
    public function addEdge(Request $req){
        $from = $req->from;
        $to = $req->to;
        
        if (!is_numeric($from))
            return response('"From" node selected wrongly.', 300);
            
        if (!is_numeric($to))
            return response('"To" node selected wrongly.', 300);

        DB::table('connection')->insert([
            "nodeFrom" => $from,
            "nodeTo" => $to,
            "connectionDesc" => $req->d
        ]);
        
        return response('Success',200);
    }
    
    public function getEdge($node_id){
        
        $_d = DB::table('connection')
        ->select(
            DB::raw('(select name from nodes where id = connection.nodeFrom limit 1) as fromName'),
            DB::raw('(select name from nodes where id = connection.nodeTo limit 1) as toName'),
            DB::raw('connection.connectionDesc as descr'),
            DB::raw('connection.id as cid'),
            )
        ->where('nodeFrom', $node_id)->orWhere('nodeTo', $node_id)
        ->get();
        
        return response()->json($_d, 200);
    }
    
    public function ViewNode($i){
        return view('nodes.view', ['id' => $i]);
    }  
    
    public function InfoNode($i){
        return view('info', ['id' => $i]);
    } 
    
    public function dashboard(){
        $data = DB::select('SELECT 
            (select COUNT(*) from nodes) as _node,
            (select COUNT(*) from connection) as _connection,
            (select COUNT(*) from category) as _category;');
    
        return response()->json($data[0], 200);
    }  
    
    
    public function getNodeView($i){
        $data = DB::table('nodes')->select('*', 'nodes.name as node', 'nodes.id as node_id')->join('category', 'category.id', 'nodes.category_id')->where('nodes.id', $i)->first();
        return view('partial.nodeview', ['data' => $data]);
    }
    
}
