<?php
class Signin {

    private $dbh = null;

    private $psInsert = null;

    private $psCheckEmail = null;

    private $psChechUsername = null;

    public $insert_username = null;

    public $insert_password = null;

    public $insert_password_repeat = null;
    
    public $insert_email = null;

    public function __construct()
    {
        if ($this->dbh == null) {
            try {
                $this->dbh = new PDO('mysql:host=' . HOST . ';dbname=' . DBNAME, USER, PASSWORD, array(
                    PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
                    PDO::ATTR_PERSISTENT => true
                )); 
                
                $sqlrequestEmail = "SELECT * FROM user WHERE email = :search_email ";

                $this->psCheckEmail = $this->dbh->prepare($sqlrequestEmail);
                $this->psCheckEmail->setFetchMode(PDO::FETCH_ASSOC);

                $sqlRequestUsername = "SELECT * FROM user WHERE username = :search_username ";

                $this->psChechUsername = $this->dbh->prepare($sqlRequestUsername);
                $this->psChechUsername->setFetchMode(PDO::FETCH_ASSOC);

                $sqlInsert = "INSERT INTO user  (username, password, email)
                              VALUES (:insert_username, :insert_password, :insert_email)";
                $this->psInsert = $this->dbh->prepare($sqlInsert);
                $this->psInsert->setFetchMode(PDO::FETCH_ASSOC);


            } catch (PDOException $e) {
                print "Erreur !: " . $e->getMessage() . "<br>";
                die();
            }
        }
    }
   
    public function newUser()
    {  
        $errorCode = 0;
        if ($this->checkIfEmailAlreadyTaken() ) {
            $errorCode = 1;
        }
        if ($this->checkifUsernameAlreadyTaken()) {
            $errorCode = 2;
        }
        echo $errorCode;
        if ($errorCode == 0) {
        try{
            $this->psInsert->execute(array(':insert_username' => $this->insert_username,':insert_password' => password_hash($this->insert_password,PASSWORD_DEFAULT),':insert_email' => $this->insert_email ));
        }catch (PDOException $e) {
            print "Erreur !: " . $e->getMessage() . "<br>";
            
            die();
            
        }
    }
     return $errorCode;   
    }

    public function checkIfUsernameAlreadyTaken()
    {
        $istaken = true;
        try{
            $this->psChechUsername->execute(array(':search_username' => $this->insert_username));
            $result = $this->psChechUsername->fetchAll();
            if ($result == null) {
                $istaken = false;
            }

        }catch (PDOException $e) {
            print "Erreur !: " . $e->getMessage() . "<br>";
            die();
        }
        return $istaken;
    }

    public function checkIfEmailAlreadyTaken()
    {
        $istaken = true;
        try{
            $this->psCheckEmail->execute(array(':search_email' => $this->insert_email));
            $result = $this->psCheckEmail->fetchAll();
            if ($result == null) {
                $istaken = false;
            }

        }catch (PDOException $e) {
            print "Erreur !: " . $e->getMessage() . "<br>";
            die();
        }
        return $istaken;
    }
   
    public function printHTML()
    {
        echo "SignIn";
    }
}