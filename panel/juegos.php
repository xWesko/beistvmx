<?php

	class Juegos
	{
		private $pdo;
		public function __construct()
		{
			$this->pdo=Database::getConnection();
		}

		public function listar_juegos():array{
			$resp=[];
			try{
				$sql="SELECT * FROM vb_juegos";
				$smt=$this->pdo->prepare($sql);
				$smt->execute();
				$resp=$smt->fetchALL();
			}catch (Eception $e){
				echo $e->getMessage();
			}
			return $resp;
		}
	
		public function guardar_juego($pk) {
			$sql="INSERT INTO vb_juegos (pk) VALUE (?)";
			try{
				$smt=$this->pdo->prepare($sql);
				$smt->execute(array($pk));
			}catch(Eception $e){
				echo $e->getMessage();
			}
		}
		
		public function guardar_foto($foto,$pk) {
			$sql="UPDATE vb_juegos SET foto=? WHERE pk=?";
			try{
				$smt=$this->pdo->prepare($sql);
				$smt->execute(array(
						$foto,$pk
					));
			}catch(Eception $e){
				echo $e->getMessage();
			}
		}

		public function actualizar($stream,$stream_hd,$pk) {

			$sql="UPDATE vb_juegos SET stream_sd=?, stream_hd=? WHERE pk=?";
			try{
				$smt=$this->pdo->prepare($sql);
				$smt->execute(array(
						$stream,$stream_hd,$pk
					));
			}catch(Eception $e){
				echo $e->getMessage();
			}
		}

		public function obtener_id($pk):array{
			$result=[];
			$sql="SELECT * FROM vb_juegos WHERE pk=?";
			try{
				$smt=$this->pdo->prepare($sql);
				$smt->execute(array(
					$pk
				));
				$result =$smt->fetchALL();
			}catch (Exception $e){
				echo $e->getMessage();
			}
			return $result;
		}

	
	}
