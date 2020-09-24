<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


class NetDefineController extends Controller
{
    public function netupload(){
        return view("/netupload");
    }

    public function process(Request $request){
        if($request->isMethod("POST")){
            // 获取得到文件
            $myfile_links = $request->file("myfile_links");
            $myfile_nodes = $request->file("myfile_nodes");

        }

    }

    public function upload($file) {
        if($file->isValid()){
            // 扩展名
            $ext = $file->getClientOriginalExtension();
            $realPath = $file->getRealPath();
            $filename = uniqid().'.'.$ext;
            $bool = Storage::disk("uploads")->put($filename, file_get_contents($realPath));
            if($bool){
                echo "success";
            }else{
                echo "fail";
            }
        }
        else{
            $bool = false;
        }
        return $bool;
    }

    public function importLinks($file) {
        // 获取上传边文件内容
        $file_content = file_get_contents($file);
        $file_content = iconv("gb2312", "utf-8", $file);
        $file_content_arr = explode("\r", $file_content);
        $file_row_count = count($file_content_arr);
        // 判断表是否存在
        Schema::connection('mysql_self')->dropIfExists('links');
        Schema::connection('mysql_self')->create('links', function($table){
            $table->integer("source");
            $table->integer("target");
            $table->integer("weight");
        });

        // 写入数据库
        for($i=1; $i<$file_row_count; $i++){
            DB::connection('mysql_self')->insert('insert into links (source, target, weight) values (?,?,?)',
             [$file_content_arr[$i][0], $file_content_arr[$i][1], $file_content_arr[$i][2]]);
        }
    }

    public function importNodes($file) {
        // 获取上传文件内容
        $file_content = file_get_contents($file);
        $file_content = iconv("gb2312", "utf-8", $file);
        $file_content_arr = explode("\r", $file_content);
        $file_row_count = count($file_content_arr);
        // 判断表是否存在
        Schema::connection('mysql_self')->dropIfExists('nodes');
        Schema::connection('mysql_self')->create('links', function($table){
            $table->integer("source");
            $table->integer("target");
            $table->integer("weight");
        });

        // 写入数据库
        for($i=1; $i<$file_row_count; $i++){
            DB::connection('mysql_self')->insert('insert into links (source, target, weight) values (?,?,?)',
             [$file_content_arr[$i][0], $file_content_arr[$i][1], $file_content_arr[$i][2]]);
        }
    }
}
