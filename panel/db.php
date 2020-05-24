<?php 

	date_default_timezone_set('America/Hermosillo');
	
	class Database
	{	
		private static $db;
		public static function getConnection(){

			if(empty(self::$db)){
				$pdo=new PDO(

				'mysql:host=localhost;dbname=verbeisbol;charset:utf8','root','');
				$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE,PDO::FETCH_OBJ);
				$pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
				// Borra lo de abajo
    			
				self::$db=$pdo;	
			}
			return self::$db;
		}	
	}

