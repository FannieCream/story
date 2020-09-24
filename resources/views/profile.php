<?php include 'database.php';?>
<?php session_start();?>
<?php
  $query = "SELECT `source` FROM `links`";
  $result_s = $mysqli->query($query) or die ($mysqli->error.__LINE__);
  $s=array();
  while($row = mysqli_fetch_array($result_s))
  {
    array_push($s, intval($row['source']));
  }
  // print_r($s);
  // $s_arr =array ('source'=>$s);
  // $s_final = json_encode($s_arr);
  // echo $s_final
?>
<?php
  $query = "SELECT `target` FROM `links`";
  $result_t = $mysqli->query($query) or die ($mysqli->error.__LINE__);
  $t=array();
  while($row = mysqli_fetch_array($result_t))
  {
    array_push($t, intval($row['target']));
  }
?>
<?php
  $query = "SELECT `weight` FROM `links`";
  $result_w = $mysqli->query($query) or die ($mysqli->error.__LINE__);
  $w=array();
  while($row = mysqli_fetch_array($result_w))
  {
    array_push($w, intval($row['weight']));
  }
?>
<?php
  $query = "SELECT `name` FROM `nodes2`";
  $result_n = $mysqli->query($query) or die ($mysqli->error.__LINE__);
  $n=array();
  while($row = mysqli_fetch_array($result_n))
  {
    array_push($n, strval($row['name']));
  }
  // $n_arr =array ('source'=>$n);
  // $n_final = stripslashes(json_encode($n_arr));
  // $n_final = json_encode($n_arr,JSON_UNESCAPED_SLASHES);
  // echo $n_final;
?>
<?php
  $query = "SELECT `name` FROM `nodes2`";
  $result_n = $mysqli->query($query) or die ($mysqli->error.__LINE__);
  $n=array();
  while($row = mysqli_fetch_array($result_n))
  {
    array_push($n, str_replace("\"","'",strval($row['name'])));
  }
?>
<?php
  $query = "SELECT `count` FROM `nodes2`";
  $result_c = $mysqli->query($query) or die ($mysqli->error.__LINE__);
  $c=array();
  while($row = mysqli_fetch_array($result_c))
  {
    array_push($c, str_replace("\"","'",strval($row['count'])));
  }
?>
<?php
  $query = "SELECT `group` FROM `nodes2`";
  $result_g = $mysqli->query($query) or die ($mysqli->error.__LINE__);
  $g=array();
  while($row = mysqli_fetch_array($result_g))
  {
    array_push($g, str_replace("\"","'",strval($row['group'])));
  }
?>
<?php
  $query = "SELECT `Title` FROM `nodes2`";
  $result_title = $mysqli->query($query) or die ($mysqli->error.__LINE__);
  $title=array();
  while($row = mysqli_fetch_array($result_title))
  {
    array_push($title, str_replace("\"","'",strval($row['Title'])));
  }
  // print_r($title);
?>
<?php
  $query = "SELECT `Allegiance` FROM `nodes2`";
  $result_al = $mysqli->query($query) or die ($mysqli->error.__LINE__);
  $al=array();
  while($row = mysqli_fetch_array($result_al))
  {
    array_push($al, str_replace("\"","'",strval($row['Allegiance'])));
  }
?>
<?php
  $query = "SELECT `Culture` FROM `nodes2`";
  $result_cul = $mysqli->query($query) or die ($mysqli->error.__LINE__);
  $cul=array();
  while($row = mysqli_fetch_array($result_cul))
  {
    array_push($cul, str_replace("\"","'",strval($row['Culture'])));
  }
?>
<?php
  $query = "SELECT `Born` FROM `nodes2`";
  $result_born = $mysqli->query($query) or die ($mysqli->error.__LINE__);
  $born=array();
  while($row = mysqli_fetch_array($result_born))
  {
    array_push($born, str_replace("\"","'",strval($row['Born'])));
  }
?>
<?php
  $query = "SELECT `Books` FROM `nodes2`";
  $result_book = $mysqli->query($query) or die ($mysqli->error.__LINE__);
  $book=array();
  while($row = mysqli_fetch_array($result_book))
  {
    array_push($book, str_replace("\"","'",strval($row['Books'])));
  }
?>
<?php
  $query = "SELECT `Died` FROM `nodes2`";
  $result_died = $mysqli->query($query) or die ($mysqli->error.__LINE__);
  $died=array();
  while($row = mysqli_fetch_array($result_died))
  {
    array_push($died, str_replace("\"","'",strval($row['Died'])));
  }
?>
<?php
  $query = "SELECT `Spouse` FROM `nodes2`";
  $result_spouse = $mysqli->query($query) or die ($mysqli->error.__LINE__);
  $spouse=array();
  while($row = mysqli_fetch_array($result_spouse))
  {
    array_push($spouse, str_replace("\"","'",strval($row['Spouse'])));
  }
?>
<?php
  $query = "SELECT `Issue` FROM `nodes2`";
  $result_issue = $mysqli->query($query) or die ($mysqli->error.__LINE__);
  $issue=array();
  while($row = mysqli_fetch_array($result_issue))
  {
    array_push($issue, str_replace("\"","'",strval($row['Issue'])));
  }
?>
<?php
  $query = "SELECT `PlayedBy` FROM `nodes2`";
  $result_pb = $mysqli->query($query) or die ($mysqli->error.__LINE__);
  // print_r($result_pb->num_rows);
  $pb=array();
  while($row = mysqli_fetch_array($result_pb))
  {
    array_push($pb, str_replace("\"","'",strval($row['PlayedBy'])));
  }
  // $pb_arr =array ('source'=>$pb);
  // print_r($pb_arr);
  // $pb_final = json_encode($pb_arr,JSON_UNESCAPED_UNICODE);
  // $pp = str_replace("'", "\'", $pb_final);
  
  // echo $pp;
?>
<?php
  $query = "SELECT `TVSeries` FROM `nodes2`";
  $result_tvs = $mysqli->query($query) or die ($mysqli->error.__LINE__);
  // print_r($result_tvs->num_rows);
  $tvs=array();
  while($row = mysqli_fetch_array($result_tvs))
  {
    array_push($tvs, str_replace("\"","'",strval($row['TVSeries'])));
  }
?>
<?php
  $query = "SELECT `Alias` FROM `nodes2`";
  $result_alias = $mysqli->query($query) or die ($mysqli->error.__LINE__);
  $alias=array();
  while($row = mysqli_fetch_array($result_alias))
  {
    array_push($alias, str_replace("\"","'",strval($row['Alias'])));
  }
?>
<?php
  $query = "SELECT `Race` FROM `nodes2`";
  $result_race = $mysqli->query($query) or die ($mysqli->error.__LINE__);
  $race=array();
  while($row = mysqli_fetch_array($result_race))
  {
    array_push($race, str_replace("\"","'",strval($row['Race'])));
  }
?>
<?php
  $query = "SELECT `Reign` FROM `nodes2`";
  $result_reign = $mysqli->query($query) or die ($mysqli->error.__LINE__);
  $reign=array();
  while($row = mysqli_fetch_array($result_reign))
  {
    array_push($reign, str_replace("\"","'",strval($row['Reign'])));
  }
?>
<?php
  $query = "SELECT `FullName` FROM `nodes2`";
  $result_fn = $mysqli->query($query) or die ($mysqli->error.__LINE__);
  $fn=array();
  while($row = mysqli_fetch_array($result_fn))
  {
    array_push($fn, str_replace("\"","'",strval($row['FullName'])));
  }
?>
<?php
  $query = "SELECT `Predecessor` FROM `nodes2`";
  $result_pdc = $mysqli->query($query) or die ($mysqli->error.__LINE__);
  $pdc=array();
  while($row = mysqli_fetch_array($result_pdc))
  {
    array_push($pdc, str_replace("\"","'",strval($row['Predecessor'])));
  }
?>
<?php
  $query = "SELECT `Heir` FROM `nodes2`";
  $result_hr = $mysqli->query($query) or die ($mysqli->error.__LINE__);
  $hr=array();
  while($row = mysqli_fetch_array($result_hr))
  {
    array_push($hr, str_replace("\"","'",strval($row['Heir'])));
  }
?>
<?php
  $query = "SELECT `Successor` FROM `nodes2`";
  $result_scsor = $mysqli->query($query) or die ($mysqli->error.__LINE__);
  $scsor=array();
  while($row = mysqli_fetch_array($result_scsor))
  {
    array_push($scsor, str_replace("\"","'",strval($row['Successor'])));
  }
?>
<?php
  $query = "SELECT `Queen` FROM `nodes2`";
  $result_q = $mysqli->query($query) or die ($mysqli->error.__LINE__);
  $q=array();
  while($row = mysqli_fetch_array($result_q))
  {
    array_push($q, str_replace("\"","'",strval($row['Queen'])));
  }
?>
<?php
  $query = "SELECT `Father` FROM `nodes2`";
  $result_father = $mysqli->query($query) or die ($mysqli->error.__LINE__);
  $father=array();
  while($row = mysqli_fetch_array($result_father))
  {
    array_push($father, str_replace("\"","'",strval($row['Father'])));
  }
?>
<?php
  $query = "SELECT `Mother` FROM `nodes2`";
  $result_m = $mysqli->query($query) or die ($mysqli->error.__LINE__);
  $m=array();
  while($row = mysqli_fetch_array($result_m))
  {
    array_push($m, str_replace("\"","'",strval($row['Mother'])));
  }
?>
<?php
  $query = "SELECT `PersonalArms` FROM `nodes2`";
  $result_psa = $mysqli->query($query) or die ($mysqli->error.__LINE__);
  $psa=array();
  while($row = mysqli_fetch_array($result_psa))
  {
    array_push($psa, str_replace("\"","'",strval($row['PersonalArms'])));
  }
?>
<?php 
  $o_arr =array ('links'=>array('source'=>$s,'target'=>$t,'value'=>$w),
                  'nodes'=>array('name'=>$n,'group'=>$g,'nodesize'=>$c,'title'=>$title,'allegiance'=>$al,'culture'=>$cul,'bornin'=>$born,'book'=>$book,'diedin'=>$died,'spouse'=>$spouse,'issue'=>$issue,'playedby'=>$pb,
                          'tvseries'=>$tvs,'alias'=>$alias,'race'=>$race,'reign'=>$reign,'fullname'=>$fn,'predecessor'=>$pdc,'heir'=>$hr,'successor'=>$scsor,'queen'=>$q,'father'=>$father,'mother'=>$m,'personalarms'=>$psa),
                  'options'=>array('NodeID'=>'name',"Group"=>"group","colourScale"=>"d3.scaleOrdinal(d3.schemeCategory20);","fontSize"=>20,"fontFamily"=>"Sans-serif","clickTextSize"=>50,"linkDistance"=>50,"linkfirstopacity"=>0.1,"linkWidth"=>"function(d) {return Math.sqrt(d.value*2); }",
                          "charge"=>-300,"opacity"=>1,"nodefirstopacity"=>0.85,"zoom"=>true,"legend"=>true,"arrows"=>false,"nodesize"=>true,"radiusCalculation"=>"d.nodesize/3","bounded"=>false,"opacityNoHover"=>1,"clickAction"=>null));
  $final_arr = array('x'=>$o_arr,'evals'=>[],'jsHooks'=>[]);
  $final_final = json_encode($final_arr,JSON_UNESCAPED_UNICODE);
  $ff = str_replace("'", "\'", $final_final);
  echo $ff;
?>



