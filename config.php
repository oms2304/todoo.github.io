<?php
$ini = @parse_ini_file(".env");

if($ini && isset($ini["DB_URL"])){
    // Load local .env file
    $url = $ini["DB_URL"];
    $db_url = parse_url($url);
} else {
    // Load from Heroku environment variables
    $url = getenv("DB_URL");
    $db_url = parse_url($url);
}

if (!$db_url || count($db_url) === 0) {
    $matches;
    $pattern = "/mysql:\/\/(\w+):(\w+)@([^:]+):(\d+)\/(\w+)/i";
    preg_match($pattern, $url, $matches);
    $db_url["host"] = $matches[3];
    $db_url["user"] = $matches[1];
    $db_url["pass"] = $matches[2];
    $db_url["path"] = "/" . $matches[5];
}

$dbhost   = $db_url["host"];
$dbuser = $db_url["user"];
$dbpass = $db_url["pass"];
$dbdatabase = substr($db_url["path"], 1);

// Create PDO database connection
try {
    $db = new PDO("mysql:host=$dbhost;dbname=$dbdatabase;charset=utf8mb4", $dbuser, $dbpass);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    exit();
}
?>
