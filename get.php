<?php

require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/allFunction.php';

// for DATE
$fileCurdate = 'curDate.txt';
$currentDate = file_get_contents($fileCurdate);

// for data
$file = 'current.txt';
$current = file_get_contents($file);


//$getDate = forDate($currentDate, $fileCurdate, 7);
//
//// get from spreadseets
//// Concate for range values 
//$tab = "'NOSS_MENU (APPS)'!";
//$value = $getDate['start'] . ":" . $getDate['end'];
//$range = $tab . $value;
//
////// Get the API client and construct the service object.
//$client = getClient();
//$service = new Google_Service_Sheets($client);
//$spreadsheetId = '1KHCOoB_3smFwx4CsQhJZvkQQVxn6S_nMMY4IRQI--nY';
//$rows = $service->spreadsheets_values->get($spreadsheetId, $range, ['majorDimension' => 'ROWS']);
//$values = $rows->getValues();
//
//// get date value
//$realDate = explode(" ", $values[0][0]);
//echo date_format(date_create($realDate[1]), "Y-m-d");
//
//
//// iterator to get value
//$realData = singleLoop($current, $file);
//echo $realData;
//
if ($current == chr(ord(substr($currentDate, -1)) + 9)) {
    $getDate = forDate($currentDate, $fileCurdate, 7);
    $data = str_split($getDate['end']);
//    print_r($data);
//    echo chr(ord(substr($data[0], -1)) + 1)."|";
//    echo chr(ord(substr($data[0], -1)) + 9);
//    $getDate = forDate($data[0], $fileCurdate, 7);
//    print_r(chr(ord(substr($data[0], -1))+8));
//    $getDate = forDate($currentDate, $fileCurdate, 7);
    // get from spreadseets
    // Concate for range values 
//    $tab = "'NOSS_MENU (APPS)'!";
//    $value = $getDate['start'] . ":" . $getDate['end'];
    $value = "'NOSS_MENU (APPS)'!" . chr(ord(substr($data[0], -1)) + 1) . "1:" . chr(ord(substr($data[0], -1)) + 9) . "1";
//    $value = "'NOSS_MENU (APPS)'!" . $getDate['end'] . ":" . chr(ord(substr($data[0], -1)) + 8) . "1";
//    echo $value;
//    $range = $tab . $value;
//    $tab = "'NOSS_MENU (APPS)'!";
//    $value = $getDate['start'] . ":" . $getDate['end'];
//    $range = $tab . $value;
//    
//    
//    $realDate = explode(" ", simpleQuery($value));
//    $resultDate = date_format(date_create($realDate[1]), "Y-m-d");
//    echo $resultDate."|";
//    
//    
//    // get hour
//    $value = "'NOSS_MENU (APPS)'!" . $current . "2";
//    $hourRes = simpleQuery($value);
//    echo $hourRes . "|";
//
//
//    // get values
//    $value = "'NOSS_MENU (APPS)'!" . $current . "3";
//    $respVal = simpleQuery($value);
//    echo $respVal;

    $realData = singleLoop($data[0], $fileCurdate);
//    $new = add($file);
//    print_r($new);
//    $realData = singleLoop($data[0], $file);
//    print_r($data[0]);
//    $currentDate = chr(ord(substr($currentDate, -1)) + 9);
//    echo $currentDate;
//    $value = "'NOSS_MENU (APPS)'!" . $currentDate . "1:" . chr(ord(substr($currentDate, -1)) + 8) . "1";
//    $realDate = explode(" ", simpleQuery($value));
//    print_r($realDate);
//    $resultDate = date_format(date_create($realDate[1]), "Y-m-d");
//    echo $resultDate;
//    // Get the API client and construct the service object.
//    $client = getClient();
//    $service = new Google_Service_Sheets($client);
//    $spreadsheetId = '1KHCOoB_3smFwx4CsQhJZvkQQVxn6S_nMMY4IRQI--nY';
//    $rows = $service->spreadsheets_values->get($spreadsheetId, $range, ['majorDimension' => 'ROWS']);
//    $values = $rows->getValues();
//
//    // get date value
//    $realDate = explode(" ", $values[0][0]);
////    echo date_format(date_create($realDate[1]), "Y-m-d");
//    $resultDate = date_format(date_create($realDate[1]), "Y-m-d");
//
//    $resultDate = simpleQuery($getDate);
//    echo $resultDate;
//    // iterator to get value
//    $realData = singleLoop($current, $file);
//    echo $realData;
//} else {
}
// get date
$value = "'NOSS_MENU (APPS)'!" . $currentDate . "1:" . chr(ord(substr($currentDate, -1)) + 8) . "1";
$realDate = explode(" ", simpleQuery($value));
$resultDate = date_format(date_create($realDate[1]), "Y-m-d");
echo $resultDate . "|";

// get hour
$value = "'NOSS_MENU (APPS)'!" . $current . "2";
$hourRes = simpleQuery($value);
echo $hourRes . "|";


// get values
$value = "'NOSS_MENU (APPS)'!" . $current . "3";
$respVal = simpleQuery($value);
echo $respVal;

$realData = singleLoop($current, $file);
//}