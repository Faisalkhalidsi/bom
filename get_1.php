<?php

/**
 * Returns an authorized API client.
 * @return Google_Client the authorized client object
 */
require __DIR__ . '/vendor/autoload.php';

function getClient() {
    $client = new Google_Client();
    $client->setApplicationName('Google Sheets API PHP Quickstart');
    $client->setScopes(Google_Service_Sheets::SPREADSHEETS);
    $client->setAuthConfig('client_secret.json');
    $client->setAccessType('offline');

    // Load previously authorized credentials from a file.
    $credentialsPath = expandHomeDirectory('credentials.json');
    if (file_exists($credentialsPath)) {
        $accessToken = json_decode(file_get_contents($credentialsPath), true);
    } else {
        // Request authorization from the user.
        $authUrl = $client->createAuthUrl();
        printf("Open the following link in your browser:\n%s\n", $authUrl);
        print 'Enter verification code: ';
        $authCode = trim(fgets(STDIN));

        // Exchange authorization code for an access token.
        $accessToken = $client->fetchAccessTokenWithAuthCode($authCode);

        // Store the credentials to disk.
        if (!file_exists(dirname($credentialsPath))) {
            mkdir(dirname($credentialsPath), 0700, true);
        }
        file_put_contents($credentialsPath, json_encode($accessToken));
        printf("Credentials saved to %s\n", $credentialsPath);
    }
    $client->setAccessToken($accessToken);

    // Refresh the token if it's expired.
    if ($client->isAccessTokenExpired()) {
        $client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());
        file_put_contents($credentialsPath, json_encode($client->getAccessToken()));
    }
    return $client;
}

/**
 * Expands the home directory alias '~' to the full path.
 * @param string $path the path to expand.
 * @return string the expanded path.
 */
function expandHomeDirectory($path) {
    $homeDirectory = getenv('HOME');
    if (empty($homeDirectory)) {
        $homeDirectory = getenv('HOMEDRIVE') . getenv('HOMEPATH');
    }
    return str_replace('~', realpath($homeDirectory), $path);
}

function add($letter) {
    //  more than one character
    if (strlen($letter) > 1) {
        $temp = "";
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

// iterator date
$fileCurdate = 'curDate.txt';
$currentDate = file_get_contents($fileCurdate);

if ($currentDate == '') {
    $currentDate = 'D';
} else {
   $currentDate = add($currentDate);
}
$startCount = $currentDate;

$endCount = 7;
for ($i = 0; $i <= $endCount; $i++) {
    $currentDate = add($currentDate);

    if ($i == $endCount) {
        file_put_contents($fileCurdate, $currentDate);
    }
}

// Concate for range values 
$tab = "'NOSS_MENU (APPS)'!";
$value = "" . $startCount . "1:" . $currentDate . "1";
$range = $tab . $value;
echo $range;

//// Get the API client and construct the service object.
$client = getClient();
$service = new Google_Service_Sheets($client);

$spreadsheetId = '1KHCOoB_3smFwx4CsQhJZvkQQVxn6S_nMMY4IRQI--nY';

$rows = $service->spreadsheets_values->get($spreadsheetId, $range, ['majorDimension' => 'ROWS']);
$values = $rows->getValues();

//get value
print_r($values[0][0]);
// print_r(sizeof($rows['values'][0]));



//// iterator to get value
//$file = 'current.txt';
//$current = file_get_contents($file);
//
//if ($current == '') {
//    $current = 'D';
//}
//$startStep=$current;
//
//$endStep =0;
//for ($i = 0; $i <= $endStep; $i++) {
//    $current = add($current);
//    
//    if($i == $endStep){
//        file_put_contents($file, $current);
//    }
//}
//
//
//// Concate for range values 
//$tab = "'NOSS_MENU (APPS)'!";
//$value = "".$startStep."3:".$current."3";
//$range = $tab . $value;
//
//// Get the API client and construct the service object.
//$client = getClient();
//$service = new Google_Service_Sheets($client);
//
//$spreadsheetId = '1KHCOoB_3smFwx4CsQhJZvkQQVxn6S_nMMY4IRQI--nY';
//
//$rows = $service->spreadsheets_values->get($spreadsheetId, $range, ['majorDimension' => 'ROWS']);
//$values = $rows->getValues();
//
////get value
//print_r($values[0][1]);
//// print_r(sizeof($rows['values'][0]));
//// $i=0;
//// while ( $i < sizeof($rows['values'][0])) {
////     echo $rows['values'][0][$i]."<br>";
////     $i++;
////     # code...
//// }
//
//
