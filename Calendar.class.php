<?php
	require_once('autoload.php');
	require_once("enum_etatEmprunt.php");

	class Calendar{

		static public function getAllLoans($date_limit_begin=NULL, $date_limit_end = NULL){
			//if null : all
			$query = " SELECT * FROM LM_emprunt NATURAL JOIN LM_user NATURAL JOIN LM_set WHERE 1=1  ";
			if($date_limit_begin != NULL) {
				try{
					$date_begin = new DateTime($date_limit_begin, new DateTimeZone('Europe/Paris'));
					$date_begin_timestamp = $date_begin_timestamp->getTimeStamp();
					$query .=" AND date_debut >= $date_begin_timestamp ";
				}
				catch(Exception $e){}
			}

			if($date_limit_end != NULL) {
				try{
					$date_limit_end = new DateTime($date_limit_end, new DateTimeZone('Europe/Paris'));
					$date_limit_end_timestamp = $date_begin_time_stamp->getTimeStamp();
					$query .=" AND date_fin_prevue <= $date_limit_end_timestamp ";
				}
				catch(Exception $e){}
			}

			$stmt = myPDO::getSingletonPDO()->query($query);
			$stmt->setFetchMode(PDO::FETCH_CLASS, 'Emprunt');
			$res = array();

			$res = $stmt->fetchAll(PDO::FETCH_CLASS, 'Emprunt');

			$stmt->closeCursor();
			return $res;	
		}

	 	static public function getAllLoansJSON($date_limit_begin=NULL, $date_limit_end = NULL){
	 		// $res_init = getAllLoans($date_limit_begin,$date_limit_end);
	 		// $res_array = array(); 

			// $i = 0;
	 		// foreach ($res_init as $value) {
				
				// $res_array[$i] = array(
					// 'title' => "".echo $value['nom']."", 
					// 'start' => "".echo $value['date_debut']."",
					// 'end' => "".echo $value['date_fin_prevue']."",
					// 'url' => "www.google.com",
					// 'backgroundColor' => "#d92405"
				// );
				// $i++;
	 		// }
		 $res_array = array(
	
			array(
				'id' => 111,
				'title' => "Event 45",
				'start' => "2014-05-10",
				'url' => "http://yahoo.com/",
				'color' => "#d92405"
			),
			
			array(
				'id' => 222,
				'title' => "Event2",
				'start' => "2014-05-20",
				'end' => "2014-05-22",
				'url' => "http://yahoo.com/",
				'info' => "set n° 145875565" 
			)
		
		);
			
			return $res_array;
	 	}


		static public function getLoansBySet($id_set){
			$state_on = ON;
			$query= " 	SELECT * FROM LM_emprunt,LM_etat 
						WHERE LM_emprunt.id_set = :id_set AND
						LM_etat.idEtat = LM_emprunt.idEtat AND
						LM_etat.nomEtat = '$state_on'";

			$stmt = myPDO::getSingletonPDO()->prepare($query);
			$stmt->setFetchMode(PDO::FETCH_CLASS, 'Emprunt');
			$stmt->execute(array(':id_set'=>$id_set));
			$res=$stmt->fetchAll(PDO::FETCH_CLASS, 'Emprunt');
			$stmt->closeCursor();
			return $res;	
		}

		static public function getLoansByUser($id_user){
			$query= " 	SELECT * FROM LM_emprunt,LM_etat 
						WHERE LM_emprunt.id_user = :id_user AND
						LM_etat.idEtat = LM_emprunt.idEtat";

			$stmt = myPDO::getSingletonPDO()->prepare($query);
			$stmt->setFetchMode(PDO::FETCH_CLASS, 'Emprunt');
			$stmt->execute(array(':id_user'=>$id_user));
			$res=$stmt->fetchAll(PDO::FETCH_CLASS, 'Emprunt');
			$stmt->closeCursor();
			return $res;	
		}


		static public function setLoan($set, $date_begin, $date_end, $id_borrower, $array_id_group){
			$date_begin = new DateTime($date_begin, new DateTimeZone('Europe/Paris'));
			$date_begin = $date_begin->getTimeStamp();

			$date_end = new DateTime($date_end, new DateTimeZone('Europe/Paris'));
			$date_end = $date_end->getTimeStamp();

			$state_on = ON;

			$query=" INSERT INTO LM_emprunt (id_set, id_user, date_debut, date_fin_prevue, idEtat)
					 VALUES ($set->id_set, $id_borrower, FROM_UNIXTIME($date_begin), FROM_UNIXTIME($date_end), (SELECT idEtat FROM LM_etat WHERE nomEtat = '$state_on' LIMIT 1) )";

			$stmt = myPDO::getSingletonPDO()->query($query);
			$lastId = myPDO::getSingletonPDO()->lastInsertId();
			$stmt->closeCursor();
			foreach ($array_id_group as $value) {
				$stmt = myPDO::getSingletonPDO()->query("INSERT INTO LM_grouper (id_emprunt, id_user) VALUES ($lastId, $value)");
				$stmt->closeCursor();                                                                                                          
			}
		}
	}