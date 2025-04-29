<?php
$csv = array_map('str_getcsv', file('driver_standings.csv'));
$win_array = [];
for($i = 1; $i < count($csv); $i++){
    if($csv[$i][6] > 0){
        array_push($win_array, $csv[$i]);
    }
}

$csv = array_map('str_getcsv', file('drivers.csv'));

for($i = 0; $i < count($csv); $i++){
    for($x = 0; $x < count($win_array); $x++){
        if($win_array[$x][2] == $csv[$i][0]){
            array_push($win_array[$x], $csv[$i][7]);
        }
    }
    
}

for($i = 0; $i < count($csv); $i++){
    $win_array[$i][2] = $csv[$win_array[$i][2]][4]." ".$csv[$win_array[$i][2]][5];
}

$occurances = [];
for($i = 0; $i < count($win_array); $i++){
    array_push($occurances, $win_array[$i][7]);
}
$unsorted_results = array_count_values($occurances);
arsort($unsorted_results);
$sorted_array = [];
foreach($unsorted_results as $key=>$val){
    for($i = 0; $i < $val; $i++){
        $sorted_array[] = $key;
    }
}

$result = array_count_values($sorted_array);
$json = json_encode($result, JSON_FORCE_OBJECT);
$obj = json_decode($json);

foreach($obj as $key => $value){
    echo "<li>";
    echo "<em>".$key."</em>";
    echo "<span>".$value."</span>";
    echo "</li>";
}

?>