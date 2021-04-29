<?php

/** BDCC
 *  -------
 *  @author Lorenzo Bauduccio <lorenzo.bdcc@eduge.ch>
 *  @file
 *  @copyright Copyright (c) 2021 BDCC
 *  @brief Class use to manage user data
 */
class UserData
{
    private $dbh = null;

    private $psGetUsersByUsername = null;

    private $psGetDataUser = null;

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
    /**
     * get users by their username
     *
     * @param [type] $username
     * @return void
     */
    public function getUsersByUsername($username)
    {
        try {
            $this->psGetUsersByUsername->execute(array(':search_username' => '%' . $username . '%'));
            $result = $this->psGetUsersByUsername->fetchAll();
        } catch (PDOException $e) {
            print "Erreur !: " . $e->getMessage() . "<br>";
            die();
        }
        return $result;
    }
    /**
     * get data of a specific user
     *
     * @param [type] $iduser
     * @return void
     */
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
