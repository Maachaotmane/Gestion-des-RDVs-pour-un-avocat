<?php

class Client
{
    private $conn;
    private $table = 'users';
    public $login_number;
    public $name;
    public $prenom;
    public $job;
    public $email;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function generateRandomString($length = 6)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $login_number = 'AB_';
        for ($i = 0; $i < $length; ++$i) {
            $login_number .= $characters[rand(0, $charactersLength - 1)];
        }

        return $login_number;
    }

    public function Signup()
    {
        try {
            $query = 'INSERT INTO '.$this->table.'(`login_number`, `name`, `prenom`, `job`, `email`) VALUES ( :login_number, :name, :prenom, :job ,:email);';
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':login_number', $this->login_number);
            $stmt->bindParam(':name', $this->name);
            $stmt->bindParam(':prenom', $this->prenom);
            $stmt->bindParam(':job', $this->job);
            $stmt->bindParam(':email', $this->email);
            $stmt->execute();

            return true;
        } catch (Exception $e) {
            echo 'Exception reçue : ',  $e->getMessage(), "\n";

            return false;
        }
    }

    //Authentifieri
    public function Signin()
    {
        $query = 'SELECT * FROM '.$this->table.' WHERE login_number=:login_number';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':login_number', $this->login_number);
        $stmt->execute();
        $count = $stmt->rowCount();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($count == 1 && !empty($row)) {
            return true;
        } else {
            return false;
        }
    }

    public function Read()
    {
        $query = 'SELECT * FROM  users WHERE login_number = :login_number';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':login_number', $this->login_number);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        return $row;
    }
}
