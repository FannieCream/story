<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;

class LongMarchController extends Controller
{

    public function index(){
        return view("/longmarch");
    }

    public function posdata(){
        $pos_data = array();
        $positions = DB::table('longmarch_position')->get();
        foreach($positions as $position){
            $cur_value = array("name"=>$position->position, "value"=>array((float)$position->pos_x, (float)$position->pos_y));
            if(array_key_exists($position->person, $pos_data)){
                $value = $pos_data[$position->person];
                array_push($value, $cur_value);
            }
            else{
                $value = array($cur_value);
            }
            $pos_data[$position->person] = $value;
        }
        return $pos_data;
    }

    public function eventdata(){
        
    }


    public function timedata(){
        $time_data = array();
        $all_data = DB::table('longmarch_event')->get();
        foreach($all_data as $data){
            $cur_time_array = explode("/", $data->time);
            // echo $cur_time_array;
            $cur_time = $cur_time_array[0] . "-" . $cur_time_array[1];
            $cur_group = $data->person;
            $cur_pos = array("name"=>$data->position, "value"=>array((float)$data->pos_x, (float)$data->pos_y),"event"=>$data->event,"detail"=>$data->detail);
            if(array_key_exists($cur_time, $time_data)){
                $cur_time_value = $time_data[$cur_time];
                if(array_key_exists($cur_group, $cur_time_value)){
                    $cur_group_value = $cur_time_value[$cur_group];
                    array_push($cur_group_value, $cur_pos);
                    $cur_time_value[$cur_group] = $cur_group_value;
                }
                else{
                    $cur_time_value[$cur_group] = array($cur_pos);
                }
                $time_data[$cur_time] = $cur_time_value;
            }
            else{
                $value = array();
                $value[$cur_group] = array($cur_pos);
                $time_data[$cur_time] = $value;
            }
        }
        // echo $time_data;
        return $time_data;
        // return $cur_time_array;
    }
}
