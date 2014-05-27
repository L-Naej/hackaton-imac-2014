<?php

class Emprunt {
	public $id_emprunt;	
	public $date_debut;
	public $date_fin_prevue;
	public $date_fin_reelle;
	public $id_user;
	public $id_set;
	public $id_etat;

	public function checkDispo($set, $date_begin, $date_end) {
		$sql = "SELECT COUNT(*) FROM Emprunt WHERE  id_set = $id->id_set AND (date_debut > $date_begin AND date_debut < $date_end) 
		OR (date_fin_prevue > $date_begin AND date_fin_prevue < $date_end))";

		
		$stmt = myPDO::getSingletonPDO()->query($sql);

		$result = $stmt->fetchColumn();
		echo($result);
	}
}

?>