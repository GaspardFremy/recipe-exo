<?php
class Database
{
    private $conn;

    //Db connection
    public function connect()
    {
        $this->conn = null;

        try {
            $this->conn = new PDO('mysql:host=localhost;dbname=recipe', 'root', 'root');
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOExeption $e) {
            echo 'Connection Error :' . $e->getMessage();
        }

        return $this->conn;
    }
}
