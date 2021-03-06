<?php
	// a faire eventuellement : tracker debogage avec singleton
	// Singleton: gere les connexions plus proprement.
	final class myPDO{
		// Singleton
		private static $mypdo 		= NULL;
		// Connexion bd
		private  	   $pdo 		= NULL;
		private static $user 		= NULL;
		private static $dsn 		= NULL;
		private static $password 	= NULL;

		private function __construct(){
			if(	is_null(self::$user) ||
				is_null(self::$dsn)  ||
				is_null(self::$password))
				throw new Exception("Construction mypdo impossible: parametres connexions absents");
			//connexion avec la bd
			try{
				$this->pdo = new PDO(self::$dsn, self::$user, self::$password);
				//mise en place du mode exception pour les erreurs de type PDO
				$this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				$this->pdo->query("SET NAMES UTF8");
				//$this->pdo->query("SET lc_time_names = 'fr FR'");
			}
			catch(Exception $e){
				die("Connexion à la base de données impossible...");
			}		
		}

		public function __destruct(){
			// si connexion deja établie ... il faut se deconnecter
			if(!is_null($this->pdo)){
				$this->pdo = NULL;
				self::$mypdo = NULL;
			}
			//deconnexion faite
		}

		//recup le singleton
		public static function getSingletonPDO(){
			if(is_null(self::$mypdo)){
				self::$mypdo = new myPDO();
			}
			return self::$mypdo->pdo;
		}

		public static function setOptionsDataBase($_dsn,$_user,$_password){
			self::$dsn = $_dsn;
			self::$user = $_user;
			self::$password=$_password;
		}

		public static function my_escape_string($string){
			$string = self::getSingletonPDO()->quote($string);
			$string = preg_replace("/^'/","", $string);
			$string = preg_replace("/'$/","", $string);
			return $string;
		}
		public function __clone(){
			throw new Exception("Clonage de myPDO interdit!");
		}

	}

	myPDO::setOptionsDataBase('mysql:host=sqletud.univ-mlv.fr;dbname=jbastide_db;charset=UTF8','jbastide','yeo8aeWd');

	// requet a faire comme cela
	// myPDO::getSingletonPDO()->query("SELECT * FROM appartement");