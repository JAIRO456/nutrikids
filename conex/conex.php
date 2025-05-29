<?php
class database {
    private $hostname = "localhost";
    private $username = "root";
    private $password = "";
<<<<<<< HEAD
    private $database = "nutrikids2";
    private $charset = "utf8mb4";

    function conectar()
=======
    private $database = "nutrikids";
    private $charset = "utf8mb4";

    function conectar()         
>>>>>>> 445ed401a5f306f3c2b0b9e88e67d6a8e6bd8c57
    {
        try{
            $conex = "mysql:host=" . $this->hostname . "; dbname=". $this->database . "; charset=" . $this->charset;
            $op = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, 
                PDO::ATTR_EMULATE_PREPARES => false, 
            ];

            $PDO = new PDO($conex, $this->username, $this->password, $op);
            return $PDO;
        }
        
        catch(PDOException $e) {
            echo "Error de conxion: " . $e->getMessage();
            exit;
        }
    }
}

?>