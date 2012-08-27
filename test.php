<?php

$one = array(0=>"two", 1=>"five", 2=>"six");
$two = array(0=>"one", 1=>"two", 2=>"three", 3=>"four", 4=>"five", 5=>"six", 6=>"seven");

$three = array_merge($one, $two);
$three = array_unique( $three );
print_r($one);
print_r($two);
print_r($three);



function fullArrayDiff($left, $right)
{
    return array_diff(array_intersect($left, $right), array_merge($left, $right));
} 


function array_intersect_fixed($array1, $array2) {
    $result = array();
    foreach ($array1 as $val) {
      if (($key = array_search($val, $array2, TRUE))!==false) {
         $result[] = $val;
         unset($array2[$key]);
      }
    }
    return $result;
} 



function array_diff_($old_array,$new_array) {
        foreach($new_array as $i=>$l){
                if($old_array[$i] != $l){
                        $r[$i]=$l;
                }
        }

        //adding deleted values
        foreach($old_array as $i=>$l){
                if(!$new_array[$i]){
                        $r[$i]="";
                }
        }
        return $r;
} 

?>

