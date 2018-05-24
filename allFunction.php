<?php

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

function expandHomeDirectory($path) {
    $homeDirectory = getenv('HOME');
    if (empty($homeDirectory)) {
        $homeDirectory = getenv('HOMEDRIVE') . getenv('HOMEPATH');
    }
    return str_replace('~', realpath($homeDirectory), $path);
}

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
                $data[1] = $a + 1;
            } else {
                $end = multiAdd($last);
                $data[0] = $temp . $end;
                $data[1] = $a;
            }
            return $data;
        }
    } else {
        $end = multiAdd($last);
        $data[0] = $temp . $end;
        $data[1] = $a;
        return $data;
    }
}

function multiAdd($letter) {
    return chr(ord(substr($letter, -1)) + 1);
}

function sequence($currentDate) {
    if ($currentDate == '') {
        $currentDate = 'D';
    } else {
        $hasil = recursive($currentDate, 0);
        $add = "";
        $i = 0;
        while ($i < $hasil[1]) {
            $add .= "A";
            $i++;
        }
        $currentDate = $hasil[0] . $add;
    }
    return $currentDate;
}

function forDate($currentDate, $fileCurdate, $loop) {
    $init = $currentDate;
    if ($init != 'D') {
        $currentDate = sequence($currentDate);
        $init = $currentDate;
    }

    for ($aa = 0; $aa <= $loop; $aa++) {
        $currentDate = sequence($currentDate);
    }

    file_put_contents($fileCurdate, $currentDate);

    $data['start'] = $init . "1";
    $data['end'] = $currentDate . "1";
    return $data;
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

function singleLoop($current, $file) {
    if ($current == '') {
        $current = 'D';
    }
    $startStep = $current;

    $endStep = 0;
    for ($i = 0; $i <= $endStep; $i++) {
        $current = add($current);

        if ($i == $endStep) {
            file_put_contents($file, $current);
        }
    }
    return $current;
}

function simpleDateQuery($range) {
//    $tab = "'NOSS_MENU (APPS)'!";
//    $value = $getDate['start'] . ":" . $getDate['end'];
//    $range = $tab . $value;

    // Get the API client and construct the service object.
    $client = getClient();
    $service = new Google_Service_Sheets($client);
    $spreadsheetId = '1KHCOoB_3smFwx4CsQhJZvkQQVxn6S_nMMY4IRQI--nY';
    $rows = $service->spreadsheets_values->get($spreadsheetId, $range, ['majorDimension' => 'ROWS']);
    $values = $rows->getValues();

    // get date value
    $realDate = explode(" ", $values[0][0]);
    $resultDate = date_format(date_create($realDate[1]), "Y-m-d");
    return $resultDate;
}

function simpleQuery($range) {
//    $tab = "'NOSS_MENU (APPS)'!";
//    $value = $realData;
//    $range = $tab . $realData;

    //// Get the API client and construct the service object.
    $client = getClient();
    $service = new Google_Service_Sheets($client);
    $spreadsheetId = '1KHCOoB_3smFwx4CsQhJZvkQQVxn6S_nMMY4IRQI--nY';
    $rows = $service->spreadsheets_values->get($spreadsheetId, $range, ['majorDimension' => 'ROWS']);
    $values = $rows->getValues();

    $resultHour = ($values[0][0]);
    return $resultHour;
}
