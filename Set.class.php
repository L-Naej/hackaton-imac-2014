<?php

require_once 'autoload.php';

class Set{

	public $id_set;
	public $nom;
	public $description;
	public $url_video;
	public $id_emprunt;
	public $id_materiel;

	public static function getInstance($id_set)
	{
		// Requête préparée
		$req = myPDO::getSingletonPDO()->prepare('SELECT * FROM LM_set WHERE id_set = :id_set');
		$req->bindParam(':id_set', $id_set, PDO::PARAM_INT);

		$req -> setFetchMode( PDO::FETCH_CLASS, 'Set');
		//Execution de la requête
		$req->execute();

		//Traitement des résultats
		return $req->fetch(PDO::FETCH_CLASS);
	}
}