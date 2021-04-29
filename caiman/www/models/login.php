<?php
/** BDCC
 *  -------
 *  @author Lorenzo Bauduccio <lorenzo.bdcc@eduge.ch>
 *  @file
 *  @copyright Copyright (c) 2021 BDCC
 *  @brief Class used to connect an user
 */
class Login {

    private $dbh = null;

    private $psLogin = null;

    public $search_username = null;

    public $search_password = null;

    public $arrayInfo = null;

    public function __construct()
    {
        if ($this->dbh == null) {
            try {
                $this->dbh = new PDO('mysql:host=' . HOST . ';dbname=' . DBNAME, USER, PASSWORD, array(
                    PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
                    PDO::ATTR_PERSISTENT => true
                )); 

                $sqllogin = "SELECT * FROM user WHERE username = :search_username ";

                $this->psLogin = $this->dbh->prepare($sqllogin);
                $this->psLogin->setFetchMode(PDO::FETCH_ASSOC);


            } catch (PDOException $e) {
                print "Erreur !: " . $e->getMessage() . "<br>";
                die();
            }
        }
    }
    /**
     * check if there is a match
     *
     * @return bool 
     */
    public function checkLogin()
    {
        $returnArray = null;
        try{
            $this->psLogin->execute(array(':search_username' => $this->search_username));
            $result = $this->psLogin->fetchAll();
            if ($result != null) {
                if (password_verify( $this->search_password,$result[0]["password"])   ) {
                    $returnArray = $result;
                    $_SESSION['error'] = "Welcome back: ". $result[0]['username'];
                }else
                {
                    $_SESSION['error'] = "Invalid log in";
                }
            }

        }catch (PDOException $e) {
            print "Erreur !: " . $e->getMessage() . "<br>";
            die();
        }
        return $returnArray;
    }
}