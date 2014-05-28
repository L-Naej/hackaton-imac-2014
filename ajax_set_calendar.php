<?php
	require_once('autoload.php');
	$idSet = $_POST['idSet'];
	$res_array = Calendar::getAllDatesSet($idSet);
	
	foreach($res_array as $d){
		echo $d;
		echo",";
	}
	$taille = sizeof($res_array);
	echo "-------:::-------" . $taille;

