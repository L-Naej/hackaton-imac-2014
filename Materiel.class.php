<?php
require_once('autoload.php');

class Materiel
{
	public $id_materiel;
	public $nom_materiel;
	public $description;
	public $reference_campus;
	public $id_set;
	public $id_type_mat;
	public $id_marque;


	public static function getInstance($id_materiel)
	{

		// Requête préparée
		$req = myPDO::getSingletonPDO()->prepare('SELECT * FROM LM_materiel WHERE id_materiel = :id_materiel');
		$req->bindParam(':id_materiel', $id_materiel, PDO::PARAM_INT);

		$req -> setFetchMode( PDO::FETCH_CLASS, 'Materiel');
		//Execution de la requête
		$req->execute();

		//Traitement des résultats
		return $req->fetch(PDO::FETCH_CLASS);
	}


	public static function updateMateriel($id_materiel, $nom_materiel, $description, $reference_campus, $id_set, $id_type_mat, $id_marque){

		// Requête préparée
		$req = myPDO::getSingletonPDO()->prepare('UPDATE LM_materiel SET nom_materiel = :nom_materiel, description = :description, reference_campus = :reference_campus, id_set = :id_set, id_type_mat = :id_type_mat,  id_marque = :id_marque WHERE id_materiel = :id_materiel');
		$req->bindParam(':id_materiel', $id_materiel, PDO::PARAM_INT);
		$req->bindParam(':nom_materiel', $nom_materiel, PDO::PARAM_STR);
		$req->bindParam(':description', $description, PDO::PARAM_STR);
		$req->bindParam(':reference_campus', $reference_campus, PDO::PARAM_STR);
		$req->bindParam(':id_set', $id_set, PDO::PARAM_INT);
		$req->bindParam(':id_type_mat', $id_type_mat, PDO::PARAM_INT);
		$req->bindParam(':id_marque', $id_marque, PDO::PARAM_INT);

		//Execution de la requête
		return $req->execute();
	}
}



Materiel::updateMateriel(3, 'test3', 'test3', 'test3', 1, 1, 1);

$matos= Materiel::getInstance(3);

var_dump($matos);
