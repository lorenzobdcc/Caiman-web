<?php
class UserData {
    private $dbh = null;

    private $psGetUsersByUsername = null;

    private $psGetDataUser = null;


    public function __construct()
    {
        if ($this->dbh == null) {
            try {
                $this->dbh = new PDO('mysql:host=' . HOST . ';dbname=' . DBNAME, USER, PASSWORD, array(
                    PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
                    PDO::ATTR_PERSISTENT => true
                )); 

                // get list of user by username
                $sqlRequestUsers = "SELECT * FROM user WHERE username LIKE :search_username AND privateAccount = 0";
                $this->psGetUsersByUsername = $this->dbh->prepare($sqlRequestUsers);
                $this->psGetUsersByUsername->setFetchMode(PDO::FETCH_ASSOC);

                // get list of user by username
                $sqlGetDataUser = "SELECT * FROM user WHERE id =:search_idUser";
                $this->psGetDataUser = $this->dbh->prepare($sqlGetDataUser);
                $this->psGetDataUser->setFetchMode(PDO::FETCH_ASSOC);


            } catch (PDOException $e) {
                print "Erreur !: " . $e->getMessage() . "<br>";
                die();
            }
        }
    }
   
    public function getUsersByUsername($username)
    {
        try {
            $this->psGetUsersByUsername->execute(array(':search_username' => '%'.$username.'%'));
            $result = $this->psGetUsersByUsername->fetchAll();
        } catch (PDOException $e) {
            print "Erreur !: " . $e->getMessage() . "<br>";
            die();
        }
        return $result;
    }

    public function getUserData($iduser)
    {
        try {
            $this->psGetDataUser->execute(array(':search_idUser' => $iduser));
            $result = $this->psGetDataUser->fetchAll();
        } catch (PDOException $e) {
            print "Erreur !: " . $e->getMessage() . "<br>";
            die();
        }
        return $result;
    }
}