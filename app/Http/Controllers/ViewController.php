<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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

}
