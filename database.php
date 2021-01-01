<?php 

$url = parse_url(getenv("CLEARDB_DATABASE_URL"));
$server = $url["host"];
$username = $url["user"];
$password = $url["pass"];
$db = substr($url["path"], 1);

define(DB_NAME, $db);
define(DB_SERVER, $server);
define(USERNAME, $username);
define(PASSWORD, $password);
define(CHARSET,"utf8mb4");
$options= [
	PDO::ATTR_EMULATE_PREPARES =>false
];

try {

	$dsn="mysql:host=".DB_SERVER.";dbname=".DB_NAME.";charset=".CHARSET;
	$pdo = new PDO($dsn,USERNAME,PASSWORD,$options);
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $e) {
	echo "there was some problem connecting to the database".$e->getMessage();
}
 ?>