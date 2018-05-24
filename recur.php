<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function recursive($num, $a) {
    $i = 0;
    $temp = "";
    $data = str_split($num);

    while ($i < strlen($num) - 1) {
        $temp .= $data[$i];
        $i++;
    }
    $last = substr($num, -1);

    if ($last == "Z") {
        if (strlen($temp) > 0) {
            $a++;
            return recursive($temp, $a);
        } else {
            // if not Z and only one character
            if (strlen($temp) == 0) {     
                $data[0] = "A";
                $data[1] = $a+1;
            } else {
                $end = multiAdd($last);
                $data[0] = $temp.$end;
                $data[1] = $a;
            }
            return $data;
        }
    } else {
        $end = multiAdd($last);
        $data[0] = $temp.$end;
        $data[1] = $a;
        return $data;
    }
}

function multiAdd($letter) {
    $last = substr($letter, -1);
    $inc = ord($last) + 1;
    $res = chr($inc);
    return $res;
}


$startNum = "ZZZ";
//Call our recursive function.
$hasil = recursive($startNum, 0);

$add ="";
$i=0;
while ($i<$hasil[1]){
    $add.="A";
    $i++;
}
$hasil =$hasil[0].$add;
echo $hasil;