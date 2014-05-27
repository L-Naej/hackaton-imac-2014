<?php
	require_once('autoload.php');
	class Calendar{

		static public function getAllLoans($date_limit_begin=NULL, $date_limit_end = NULL){
			//if null : all
			$stmt = myPDO::getSingletonPDO()->query("SELECT * FROM LM_materiel");
			$res = $stmt->fetch(PDO::FETCH_CLASS);
			$stmt->closeCursor();
			return $res;
		}
	}

	var_dump(Calendar::getAllLoans());