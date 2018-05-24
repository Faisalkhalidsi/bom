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
                $end = multiAddDate($last);
                $data[0] = $temp . $end;
                $data[1] = $a;
            }
            return $data;
        }
    } else {
        $end = multiAddDate($last);
        $data[0] = $temp . $end;
        $data[1] = $a;
        return $data;
    }
}

function multiAddDate($letter) {
    $last = substr($letter, -1);
    $inc = ord($last) + 1;
    $res = chr($inc);
    return $res;
}

$fileCurdate = 'curDate.txt';
$currentDate = file_get_contents($fileCurdate);

if ($currentDate == '') {
    $currentDate = 'D';
    $init = $currentDate;
} else {
    if ($currentDate != 'D') {
        $currentDate = multiAddDate($currentDate);
        $init = $currentDate;
    }

    for ($j = 0; $j <= 7; $j++) {
        $hasil = recursive($currentDate, 0);

        $add = "";
        $i = 0;
        while ($i < $hasil[1]) {
            $add .= "A";
            $i++;
        }
        $currentDate = $hasil[0] . $add;
    }
}
$startCount = $currentDate;

file_put_contents($fileCurdate, $currentDate);