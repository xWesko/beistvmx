<?php


class Usuarios
{
    private $pdo;
    public function __construct(){
        $this->pdo=Database::getConnection();
    }

    public function login_usuario($email, $password){

        $resp=[];
        try{

            //VERIFICAMOS SI EXISTE EL USUARIO
            $sql = "SELECT * FROM vb_usuarios WHERE email = ?";
            $smt = $this->pdo->prepare($sql);
            $smt->execute(array($email));
            $resp = $smt->fetch();

            //SI NO EXISTE MATAMOS LA OPERACIÓN
            if(!$resp) {
                echo "<script>window.location = 'index.php?e=1';</script>";
                die();
            }

        
            if(password_verify($password, $resp->pass)){
               
                $_SESSION['LOGUEADO']=true;
                $_SESSION['USUARIO'] = $resp;
                echo "<script>window.location = 'panel.php';</script>";

            }else{
                echo "<script>window.location = 'index.php?e=1';</script>";
                die();
            }
            
            
        }catch(Exception $e){
            echo $e->getMessage();
        }
        return $resp;

    }


}

