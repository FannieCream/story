<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

use function Ramsey\Uuid\v1;

class MapController extends Controller
{
    
    public function index(){
        /**
         * Function: get the map page
         * @param null
         * @return map
         */

        return view("/map");
    }

    public function posdata(){
        /**
         * Function: get position information from database
         * @param null
         * @return pos_data
         */

        $pos_data = array();
        $positions = DB::table('mysql_position')->get();
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
        $event_data = array();
        $events = DB::table('mysql_event')->get();
        foreach($events as $event){
            $cur_value = array("name"=>$event->position, "value"=>array((float)$event->pos_x, (float)$event->pos_y, $event->event));
            if(array_key_exists($event->person, $event_data)){
                $value = $event_data[$event->person];
                array_push($value, $cur_value);
            }
            else{
                $value = array($cur_value);
            }
            $event_data[$event->person] = $value;
        }
        return $event_data;
    }
}
