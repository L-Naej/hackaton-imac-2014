<?php
	require_once('autoload.php');


$array = Calendar::getAllLoansJSON();


echo json_encode($array);

?>