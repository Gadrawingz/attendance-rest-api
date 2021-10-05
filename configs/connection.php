<?php
class DBConnection {
    public    $host = "localhost";
    protected $dbase= "attendance_db";
    private   $user = "root";
    private   $pass = "";
    public    $con;

    public function connect(){
        try {
            $dsn= "mysql:host=$this->host; dbname=$this->dbase";
            $this->con = new PDO($dsn, $this->user, $this->pass );
            return $this->con;

        } catch(PDOException $error) {
            echo "OOPS! ERROR OCCURED".$error->getMessage();
        }
    }
}
?>  