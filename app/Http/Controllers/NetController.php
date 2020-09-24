<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;

class NetController extends Controller
{
    public function index(){
        return view('/net');
    }

    public function prodata(){
        $source_arr = array();
        $target_arr = array();
        $value_arr = array();
        $links = DB::table('links')->get();
        foreach($links as $link){
            array_push($source_arr, (int)$link->source);
            array_push($target_arr, (int)$link->target);
            array_push($value_arr, (int)$link->weight);
        }
        $links_arr = array('source'=>$source_arr, 'target'=>$target_arr, 'value'=>$value_arr);

        $nodes = DB::table('nodes2')->get();
        $name_arr = array();
        $count_arr = array();
        $group_arr = array();
        $title_arr = array();
        $al_arr = array();
        $cul_arr = array();
        $born_arr = array();
        $book_arr = array();
        $died_arr = array();
        $spouse_arr = array();
        $issue_arr = array();
        $pb_arr = array();
        $tvs_arr = array();
        $alias_arr = array();
        $race_arr = array();
        $reign_arr = array();
        $fn_arr = array();
        $pdc_arr = array();
        $hr_arr = array();
        $successor_arr = array();
        $queen_arr = array();
        $father_arr = array();
        $mother_arr = array();
        $psa_arr = array();
        foreach($nodes as $node){
            array_push($name_arr, str_replace("\"","'",strval($node->name)));
            array_push($count_arr, str_replace("\"","'",strval($node->count)));
            array_push($group_arr, str_replace("\"","'",strval($node->group)));
            array_push($title_arr, str_replace("\"","'",strval($node->Title)));
            array_push($al_arr, str_replace("\"","'",strval($node->Allegiance)));
            array_push($cul_arr, str_replace("\"","'",strval($node->Culture)));
            array_push($born_arr, str_replace("\"","'",strval($node->Born)));
            array_push($book_arr, str_replace("\"","'",strval($node->Books)));
            array_push($died_arr, str_replace("\"","'",strval($node->Died)));
            array_push($spouse_arr, str_replace("\"","'",strval($node->Spouse)));
            array_push($issue_arr, str_replace("\"","'",strval($node->Issue)));
            array_push($pb_arr, str_replace("\"","'",strval($node->PlayedBy)));
            array_push($tvs_arr, str_replace("\"","'",strval($node->TVSeries)));
            array_push($alias_arr, str_replace("\"","'",strval($node->Alias)));
            array_push($race_arr, str_replace("\"","'",strval($node->Race)));
            array_push($reign_arr, str_replace("\"","'",strval($node->Reign)));
            array_push($fn_arr, str_replace("\"","'",strval($node->FullName)));
            array_push($pdc_arr, str_replace("\"","'",strval($node->Predecessor)));
            array_push($hr_arr, str_replace("\"","'",strval($node->Heir)));
            array_push($successor_arr, str_replace("\"","'",strval($node->Successor)));
            array_push($queen_arr, str_replace("\"","'",strval($node->Queen)));
            array_push($father_arr, str_replace("\"","'",strval($node->Father)));
            array_push($mother_arr, str_replace("\"","'",strval($node->Mother)));
            array_push($psa_arr, str_replace("\"","'",strval($node->PersonalArms)));
        }
        $nodes_arr = array('name'=>$name_arr, 'group'=>$group_arr, 'nodesize'=>$count_arr, 'title'=>$title_arr, 'allegiance'=>$al_arr,
    'culture'=>$cul_arr, 'born'=>$born_arr, 'book'=>$book_arr, 'diedin'=>$died_arr, 'spouse'=>$spouse_arr, 'issue'=>$issue_arr, 'playedby'=>$pb_arr,
    'tvseries'=>$tvs_arr, 'alias'=>$alias_arr, 'race'=>$race_arr, 'reign'=>$reign_arr, 'fullname'=>$fn_arr, 'predecessor'=>$pdc_arr, 'heir'=>$hr_arr,
    'successor'=>$successor_arr, 'queen'=>$queen_arr, 'father'=>$father_arr, 'mother'=>$mother_arr, 'personalarms'=>$psa_arr);

        // $option_arr = array('NodeID'=>'name',"Group"=>"group","colourScale"=>"d3.scaleOrdinal(d3.schemeCategory20);",
        // "fontSize"=>20,"fontFamily"=>"Sans-serif","clickTextSize"=>50,"linkDistance"=>50,"linkfirstopacity"=>0.1,
        // "linkWidth"=>"function(d) {return Math.sqrt(d.value*2); }","charge"=>-300,"opacity"=>1,"nodefirstopacity"=>0.85,"zoom"=>true,
        // "legend"=>true,"arrows"=>false,"nodesize"=>true,"radiusCalculation"=>"d.nodesize/3","bounded"=>false,"opacityNoHover"=>1,"clickAction"=>null);

        $option_arr = array('NodeID'=>'name',"Group"=>"group","colourScale"=>"d3.scaleOrdinal(d3.schemeCategory20);","fontSize"=>20,"fontFamily"=>"Sans-serif","clickTextSize"=>50,"linkDistance"=>50,"linkfirstopacity"=>0.1,"linkWidth"=>"function(d) {return Math.sqrt(d.value*2); }",
                          "charge"=>-300,"opacity"=>1,"nodefirstopacity"=>0.85,"zoom"=>true,"legend"=>true,"arrows"=>false,"nodesize"=>true,"radiusCalculation"=>"d.nodesize/3","bounded"=>false,"opacityNoHover"=>1,"clickAction"=>null);

        $combine_arr = array('links'=>$links_arr, 'nodes'=>$nodes_arr, 'options'=>$option_arr);
        $final_arr = array('x'=>$combine_arr, 'evals'=>[], 'jsHooks'=>[]);
        $final_arr_json = json_encode($final_arr, JSON_UNESCAPED_UNICODE);
        $ff = str_replace("'", "\'", $final_arr_json);
        return $ff;
    }   
}
