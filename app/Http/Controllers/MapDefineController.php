<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MapDefineController extends Controller
{
    public function mapupload(){
        return view("/mapupload");
    }

    public function upload(Request $request){
        if($request->isMethod("POST")){
            // $f_position = $request->file("f_position");
            // $f_event = $request->file("f_event");
            // $f_map = $request->input("f_map");
            // # 获取文件上传内容
            // $fp_content = file_get_contents($f_position);
            // $fp_content = iconv("gb2312", "utf-8", $fp_content);
            // $fp_content_array = explode("\r", $fp_content);
            // $fp_array = array();
            // foreach($fp_content_array as $fp_content_item){
            //     $cur_item_array = explode(",", $fp_content_item);
            //     $cur_value = array("name"=>$cur_item_array[2], "value"=>array((float)$cur_item_array[3], (float)$cur_item_array[4]));
            //     if(array_key_exists($cur_item_array[1], $fp_array)){
            //         $value = $fp_array[$cur_item_array[1]];
            //         array_push($value, $cur_value);
            //     }
            //     else{
            //         $value = array($cur_value);
            //     }
            //     $fp_array[$cur_item_array[1]]=$value;
            // }
            // $fp_json = json_encode($fp_array, JSON_UNESCAPED_UNICODE);
            // // $fe_content = file_get_contents($f_event);
            // # 处理中文乱码问题
            // // echo $fileContent;
            
            // // $fe_json = iconv("gb2312", "utf-8", $fe_content);
            // // echo $json;
            // # 整理成dict形式

            // return view("/mapdefine")->with(["f_map"=>$f_map, "fp_json"=>$fp_json]);
            return view("/longmarch");
        }
    }

    public function define(){

    }
}
