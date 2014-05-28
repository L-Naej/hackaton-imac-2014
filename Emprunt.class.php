<?php
require_once 'autoload.php';
require_once("enum_etatEmprunt.php");

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

	public static function change_etat_loan($id_loan,$nom_etat){
		$sql = "UPDATE LM_emprunt SET idEtat=(SELECT idEtat FROM LM_etat WHERE nomEtat='$nom_etat') WHERE  id_emprunt=$id_loan";
		
		return myPDO::getSingletonPDO()->query($sql);
	}
}

Emprunt::change_etat_loan(13,REFUSED);