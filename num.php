<?php

$summer = add("A");
echo $summer;

function add($letter) {
    //  more than one character
    if (strlen($letter) > 1) {
        $temp="";
        $last = substr($letter, -1);
        if ($last == "Z") {
            $res = "AA";
        } else {
            //next alphabet
            $res = multiAdd($letter);
        }
        
        //  take every character before the last
        $i = 0;
        $data = str_split($letter);
        
        while ($i < strlen($letter) - 1) {
            $temp .= $data[$i];
            $i++;
        }
        
        //  combine 
        $end = $temp . "" . $res;
        return $end;
        
    //  Only one chrachter
    } else {
        if ($letter == "Z") {
            $end = "AA";
        } else {
            //next aplphabet
            $end = multiAdd($letter);
        }
        return $end;
    }
}

function multiAdd($letter) {
    $last = substr($letter, -1);
    $inc = ord($last) + 1;
    $res = chr($inc);
    return $res;
}

?>
