<?php
	require_once("autoload.php");

	class User{
		public $identifiant;
		public $type_personne;


		public function __construct($identifiant){
			$this->identifiant = $identifiant;
			$this->type_personne = self::getTypePersonne($identifiant);
		}
		public static function getTypePersonne($identifiant){
			$res = false;
			
			$stmt = myPDO::getSingletonPDO()->prepare("SELECT * FROM LM_admin WHERE id_user = (SELECT id_user FROM LM_user WHERE identifiant = :identifiant)");
			$stmt->execute(array(':identifiant'=>$identifiant));
			$res = $stmt->fetch() ? true :false;

			$stmt->closeCursor();

			if($res)
				return 'admin';

			$stmt = myPDO::getSingletonPDO()->prepare("SELECT * FROM LM_emprunteur WHERE id_user id_user = (SELECT id_user FROM LM_user WHERE identifiant = :identifiant)");
			$stmt->execute(array(':identifiant'=>$identifiant));
			$res = $stmt->fetch() ? true :false;
			$stmt->closeCursor();

			return $res ? 'emprunteur' : false;
		}

		public static function getUserFromLoginMdp($login, $mdp){ // return obj
			$stmt = myPDO::getSingletonPDO()->prepare("SELECT * FROM LM_user WHERE identifiant = :login AND mdp = :mdp");
			$stmt->execute(array(':login'=>$login, ':mdp'=>sha1($mdp)));

			$user = NULL;
			if($user = $stmt->fetch())
				$user = new User($user['identifiant']);

			$stmt->closeCursor();
			return $user;
		}

		public static function isExistFromIdentifiant($identifiant){
			$stmt = myPDO::getSingletonPDO()->prepare("SELECT * FROM LM_user WHERE identifiant = :login");
			$stmt->execute(array(':login'=>$login));
			$isExist = $stmt->fetch() ? true : false;
			$stmt->closeCursor();
			return $isExist;
		}
	}
