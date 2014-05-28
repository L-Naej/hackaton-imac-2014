<?php
require_once 'autoload.php';

class Emprunt {
	public $id_emprunt;	
	public $date_debut;
	public $date_fin_prevue;
	public $date_fin_reelle;
	public $id_user;
	public $id_set;
	public $id_etat;

	public static function checkDispo($id, $date_begin, $date_end) {
		$sql = "SELECT COUNT (*) FROM Emprunt WHERE  id_set = $id->id_set AND (date_debut > $date_begin AND date_debut < $date_end) 
		OR (date_fin_prevue > $date_begin AND date_fin_prevue < $date_end))";
		
		$stmt = myPDO::getSingletonPDO()->query($sql);

		$result = $stmt->fetchColumn();
	}

	public static function newReservation ($id_user, $id_set, $date_debut, $date_fin){

		try{
			$date_debut_temp = new DateTime($date_debut, new DateTimeZone('Europe/Paris'));
			var_dump($date_debut_temp);
		}
		catch(Exception $e){}

		try{
			$date_fin_temp = new DateTime($date_fin, new DateTimeZone('Europe/Paris'));
		}
		catch(Exception $e){}
		
		$stmt = myPDO::getSingletonPDO()->prepare("INSERT INTO LM_emprunt (date_debut, date_fin_prevue, id_user, id_set, idEtat) VALUES(:date_debut, :date_fin, :id_user, :id_set, 4)");

		return $stmt->execute(array(':date_debut'=>$date_debut_temp->getTimeStamp(), 
									':date_fin'=>$date_fin_temp->getTimeStamp(),
									':id_user'=>$id_user,
									':id_set'=>$id_set));
	}
}

Emprunt::newReservation (1, 1, '2014-02-15', '2014-06-25');