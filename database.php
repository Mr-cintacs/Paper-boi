<?php 

define(DB_NAME, "paperboiDB");
define(DB_SERVER,"localhost");
define(USERNAME,"root");
define(PASSWORD,"123456");
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