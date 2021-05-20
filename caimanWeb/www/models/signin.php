<?php
/** BDCC
 *  -------
 *  @author Lorenzo Bauduccio <lorenzo.bdcc@eduge.ch>
 *  @file
 *  @copyright Copyright (c) 2021 BDCC
 *  @brief Class used to create a new user
 */
class Signin
{

    private $dbh = null;

    private $psInsert = null;

    private $psCheckEmail = null;

    private $psCheckUsername = null;

    public $insert_username = null;

    public $insert_password = null;

    public $insert_password_repeat = null;

    public $insert_email = null;

/**
 * default constructor
 */
    public function __construct()
    {
        if ($this->dbh == null) {
            try {
                $this->dbh = new PDO('mysql:host=' . HOST . ';dbname=' . DBNAME, USER, PASSWORD, array(
                    PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
                    PDO::ATTR_PERSISTENT => true
                ));

                // check if email alredy used
                $sqlrequestEmail = "SELECT * FROM user WHERE email = :search_email ";
                $this->psCheckEmail = $this->dbh->prepare($sqlrequestEmail);
                $this->psCheckEmail->setFetchMode(PDO::FETCH_ASSOC);

                // check if username alredy used
                $sqlRequestUsername = "SELECT * FROM user WHERE username = :search_username ";
                $this->psCheckUsername = $this->dbh->prepare($sqlRequestUsername);
                $this->psCheckUsername->setFetchMode(PDO::FETCH_ASSOC);

                $sqlInsert = "INSERT INTO user  (username, password, email, salt,apitocken)
                              VALUES (:insert_username, :insert_password, :insert_email, :insert_salt, :insert_apiTocken)";
                $this->psInsert = $this->dbh->prepare($sqlInsert);
                $this->psInsert->setFetchMode(PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                print "Erreur !: " . $e->getMessage() . "<br>";
                die();
            }
        }
    }

/**
 * add a mew user in the database
 *
 * @return void
 */
    public function newUser()
    {
        $isValid = true;
        if ($this->checkIfEmailAlreadyTaken()) {
            $_SESSION['error'] = "Email already used";
            $isValid = false;
        }
        if ($this->checkifUsernameAlreadyTaken()) {
            $_SESSION['error'] = "Username alredy used";
            $isValid = false;
        }
        if ($isValid) {

                $salt = rand(1,10000);
            try {
                $this->psInsert->execute(array(':insert_username' => $this->insert_username, ':insert_password' => md5($salt.$this->insert_password),':insert_apiTocken' => md5(microtime()), ':insert_salt' => $salt, ':insert_email' => $this->insert_email));
                $_SESSION['error'] = "Acount created";
            } catch (PDOException $e) {
                print "Erreur !: " . $e->getMessage() . "<br>";
                die();
            }
        }
    }

/**
 * check that the username is not already taken
 *
 * @return bool
 */
    public function checkIfUsernameAlreadyTaken()
    {
        $istaken = true;
        try {
            $this->psCheckUsername->execute(array(':search_username' => $this->insert_username));
            $result = $this->psCheckUsername->fetchAll();
            if ($result == null) {
                $istaken = false;
            }
        } catch (PDOException $e) {
            print "Erreur !: " . $e->getMessage() . "<br>";
            die();
        }
        return $istaken;
    }

/**
 * check that the email is not already taken
 *
 * @return bool
 */
    public function checkIfEmailAlreadyTaken()
    {
        $istaken = true;
        try {
            $this->psCheckEmail->execute(array(':search_email' => $this->insert_email));
            $result = $this->psCheckEmail->fetchAll();
            if ($result == null) {
                $istaken = false;
            }
        } catch (PDOException $e) {
            print "Erreur !: " . $e->getMessage() . "<br>";
            die();
        }
        return $istaken;
    }
}
