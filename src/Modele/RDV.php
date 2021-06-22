<?php

class RDV
{
    private $conn;
    private $table = 'appointments';
    public $subject;
    public $login_number;
    public $time;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function read()
    {
        $query = 'SELECT *  FROM '.$this->table.' WHERE login_number = :login_number';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':login_number', $this->login_number);
        $stmt->execute();

        return $stmt;
    }

    public function gettime($sa)
    {
        $query = "SELECT times FROM appointments WHERE DATE(times) = '$sa'";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt;
    }

    public function insertrdv()
    {
        try {
            $query = 'INSERT INTO '.$this->table.'(`login_number`, `subject`, `times`) VALUES ( :login_number, :subject, :times);';
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':login_number', $this->login_number);
            $stmt->bindParam(':subject', $this->subject);
            $stmt->bindParam(':times', $this->times);
            $stmt->execute();

            return true;
        } catch (Exception $e) {
            echo 'Exception reçue : ',  $e->getMessage(), "\n";

            return false;
        }
    }

    public function del($s)
    {
        try {
            $query = "DELETE FROM appointments WHERE id = '$s'";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();

            return true;
        } catch (Exception $e) {
            echo 'Exception reçue : ',  $e->getMessage(), "\n";

            return false;
        }
    }
}
