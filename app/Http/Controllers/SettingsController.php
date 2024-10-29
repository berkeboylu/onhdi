<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SettingsController extends Controller
{

    function setEnv($name, $value)
    {
        $path = base_path('.env');
        if (file_exists($path)) {
            file_put_contents($path, str_replace(
                $name . '=' . env($name), $name . '=' . $value, file_get_contents($path)
            ));
        }
    }

    public function makeChanges(Request $req) {
        $request = $req->changes;
        $changes = json_decode($request);
        
        
                
        $theme_array =  ['black', 'bootstrap', 'default', 'gray', 'material', 'material-blue', 'material-teal', 'metro'];
        
        foreach ($changes as $value) {
            switch ($value[0]) {
                case 'App Theme':
                    if (in_array($value[1], $theme_array)){
                        $this->setEnv('THEME',$value[1]);
                    }else {
                        return response('Theme must be right!', 300);
                    }
                    break;
                case 'Use arrow':
                    if (in_array(strtolower($value[1]), ['true', 'false'])){
                        $this->setEnv('ARROW',strtolower($value[1]));
                    }else {
                        return response('Only true or false!', 300);
                    }
                    break;
                case 'License Key':
                    //return response('This application don\'t have license feature, so dont mess with license. Fyi.', 300);
                    return response('I said "ITS-ALL-FREE-:)", fyi.', 300);
                    break;
                default:
                    # code...
                    break;
            }
        }
        return response('Saksesful', 200);
    }
    
    public function getSettingsJson(Request $req){
        $_rows = [];
        
        $themes = array(
            array("id"=> "default", "desc"=> "default"),
            array('id'=> 'black', "desc"=> 'black'),
            array('id'=> 'bootstrap', "desc"=> 'bootstrap'),
            array('id'=> 'gray', "desc"=> 'gray', ),
            array('id'=> 'material', "desc"=> 'material'),
            array('id'=> 'material-blue', "desc"=> 'material-blue'),
            array('id'=> 'material-teal', "desc"=> 'material-teal'),
            array('id'=> 'metro', "desc"=> 'metro')
        );
        
        $arrow = array(
            array("id"=> "true", "desc"=> "True"),
            array("id"=> "false", "desc"=> "False"),
        );
        
        array_push($_rows, array("name" => 'Name', "value" => "boylu", "group" => "Identity", "editor" => "text"));
        array_push($_rows, array("name" => 'Address', "value" => "", "group" => "Identity", "editor" => "text"));
        array_push($_rows, array("name" => 'License Key', "value" => env('APP_LICENSE'), "group" => "Program settings", "editor" => "text"));
        array_push($_rows, array("name" => 'Email', "value" => "boylu@x.com", "group" => "Identity", "editor" => array("type" => "validatebox", "options" => array("validType" => "email"))));
        array_push($_rows, array("name" => 'App Theme', "value" => env('THEME'), "group" => "Program settings", "editor" => array("type" => "combobox", "options" => array("valueField" => "desc", "textField"=> "desc", "data" => $themes))));
        array_push($_rows, array("name" => 'Use arrow', "value" => env('ARROW'), "group" => "Program settings", "editor" => array("type" => "combobox", "options" => array("valueField" => "desc", "textField"=> "desc", "data" => $arrow))));
        
        return response()->json(array("total" => count($_rows), "rows" => $_rows));
    }

}
