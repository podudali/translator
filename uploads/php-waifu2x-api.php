<?php
/* php-waifu2x-api by michioxd */
error_reporting(0);
$PATH = __DIR__ . "/INPUT";
$OUT = __DIR__ . "/OUTPUT";
$LOG_FILE = __DIR__ . "/exportLog.log";
$API_KEY = "cbea37a8-37d4-47d1-a9ba-688999b8cf20";
if (file_exists($PATH) == false) {
    echo "INPUT path doesn't exist, using " . __DIR__ . "\INPUT folder\n";
    mkdir(__DIR__ . "/INPUT");
    $PATH = __DIR__ . "/INPUT";
}
if (file_exists($OUT) == false) {
    echo "OUTPUT path doesn't exist, using " . __DIR__ . "\OUTPUT folder\n";
    mkdir(__DIR__ . "/OUTPUT");
    $OUT = __DIR__ . "/OUTPUT";
}
echo "
=================================================
                 php-waifu2x-api
   UPSCALEEEEE YOURRRR WAIFUUUWUWUWUWUWUWUWUWU
             by michioxd
    https://github.com/michioxd/php-waifu2x-api
=================================================
Option: scan - scan in your dir (your dir: " . $PATH . ")
        start - 2x your waifu in folder " . $PATH . "
        exit - see u next time :<
Your option: ";
$date = date("Y-m-d H:i:s");
$_ROOT = scandir($PATH);
$_GET_OPTION = readline();
if ($_GET_OPTION == "scan") {
    if ($API_KEY == null || $API_KEY == "") {
        echo "\nHmm your API KEY is empty :((
Paste your API key here and enter: ";
        $API_KEY = readline();
    }
    $fi = new FilesystemIterator($PATH, FilesystemIterator::SKIP_DOTS);
    $count = iterator_count($fi);
    echo "
=================================================
SCAN DIR
=================================================
File name + Mimetype  (total " . $count . " file(s))
";
    foreach ($_ROOT as $file) {
        if (strpos(mime_content_type($PATH . '/' . $file), "image/") !== false) {
            echo $file . " > " . mime_content_type($PATH . '/' . $file) . "\n";
        }
    }
    exit();
} elseif ($_GET_OPTION == "exit") {
    echo "see u next time :((";
    exit();
} elseif ($_GET_OPTION == "start") {
    if ($API_KEY == null || $API_KEY == "") {
        echo "\nHmm your API KEY is empty :((
Paste your API key here and enter: ";
        $API_KEY = readline();
    }
    $fi = new FilesystemIterator($PATH, FilesystemIterator::SKIP_DOTS);
    $count = iterator_count($fi);
    echo "
=================================================
STARTING ....         [ctrl+c or ctrl+z to exit]
=================================================
Reading dir... (total " . $count . " file(s))
";
    $LoadLogFile = fopen($LOG_FILE, "a") or die("\n[" . $date . "] Unable to open log file!");
    fwrite($LoadLogFile, "\n==================================================
    php-waifu2x-api by michioxd
    Start upscale at " . $date . "
    Input: " . $PATH . "
    Output: " . $OUT . "
    Total file in input folder: " . $count . "
==================================================\n");
    foreach ($_ROOT as $file) {
        if (strpos(mime_content_type($PATH . '/' . $file), "image/") !== false) {
            echo "\n[" . $date . "] Preparing file [" . $file . "] -> ";
            fwrite($LoadLogFile, "[" . $date . "][" . $file . "] Preparing file \n");
            $url = "https://api.deepai.org/api/waifu2x";
            $ch = curl_init($url);
            $target_file = curl_file_create($PATH . '/' . $file);
            $data_string = array('image' => $target_file);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Api-Key: ' . $API_KEY));
            $output   = curl_exec($ch);
            $decoded = json_decode($output, TRUE);
            if ($decoded['status'] !== null) {
                echo "[ERROR] Error with status: " . $decoded['status'];
                fwrite($LoadLogFile, "[" . $date . "][" . $file . "][ERROR] Error with status: " . $decoded['status'] . "\n");
                fclose($LoadLogFile);
                echo "\nExitting...";
                exit();
            } elseif ($decoded['err'] !== null) {
                echo "[ERROR] Error: " . $decoded['err'];
                fwrite($LoadLogFile, "[" . $date . "][" . $file . "][ERROR] Error: " . $decoded['err'] . "\n");
                fclose($LoadLogFile);
                echo "\nExitting...";
                exit();
            } elseif ($decoded['output_url'] !== null) {
                if (file_put_contents($OUT . "/[OUTPUT] " . $file, file_get_contents($decoded['output_url']))) {
                    echo "[DONE] Saved!";
                    fwrite($LoadLogFile, "[" . $date . "][" . $file . "][DONE] Saved!\n");
                } else {
                    echo "[FAILED] Cannot save this file :((";
                    fwrite($LoadLogFile, "[" . $date . "][" . $file . "][FAILED] Cannot save this file :((\n");
                }
            } else {
                echo "[FAILED] Cannot upload this file :((";
                fwrite($LoadLogFile, "[" . $date . "][" . $file . "][FAILED] Cannot upload this file :((\n");
                fclose($LoadLogFile);
                echo "\nExitting...";
                exit();
            }
        }
    }
    fwrite($LoadLogFile, "[" . $date . "] Complete!\n");
    fclose($LoadLogFile);
    echo "\n[" . $date . "] Done!";
    exit();
}
