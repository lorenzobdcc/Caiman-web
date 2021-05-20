<?php

/** BDCC
 *  -------
 *  @author Lorenzo Bauduccio <lorenzo.bdcc@eduge.ch>
 *  @file
 *  @copyright Copyright (c) 2021 BDCC
 *  @brief Class use to manage user
 */
class User
{

    public $username;
    public $email;
    public $role;
    public $idUser;
    public $salt;
    
    /**
     * default constructor
     *
     * @param string $usernamep
     * @param string $emailp
     * @param string $idRolep
     * @param integer $idUserp
     */
    public function __construct(string $usernamep, string $emailp, string $idRolep, int $idUserp,string $saltp)
    {

        $this->username = $usernamep;
        $this->email = $emailp;
        $this->role = $idRolep;
        $this->idUser = $idUserp;
        $this->salt = $saltp;
    }

    /**
     * update the user password in the database
     *
     * @param string $newPassword
     * @param string $newPasswordRepeat
     * @param string $oldPassword
     * @return int
     */
    public function updatePassword(string $newPassword, string $newPasswordRepeat, string $oldPassword)
    {
        $dbh = new PDO('mysql:host=' . HOST . ';dbname=' . DBNAME, USER, PASSWORD, array(
            PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
            PDO::ATTR_PERSISTENT => true
        ));

        $hasBeenUpdated = 1;
        if (md5($_SESSION['user']->salt.$oldPassword) == $this->getUserPassword()) {

            if ($newPasswordRepeat == $newPassword) {
                try {
                    $salt = rand(1,10000);
                    $sqlUpdatePassword = "UPDATE user  SET password = :update_password, salt = :update_salt WHERE id = :id_user";
                    $psUpdatePassword = $dbh->prepare($sqlUpdatePassword);
                    $psUpdatePassword->execute(array(':update_password' => md5($salt.$newPassword), ':id_user' => $this->idUser, ':update_salt' => $salt));

                    $hasBeenUpdated = 0;
                } catch (PDOException $e) {
                    print "Erreur !: " . $e->getMessage() . "<br>";
                    die();
                }
            } else {
                $hasBeenUpdated = 2;
            }
        } else {
            $hasBeenUpdated = 4;
        }

        return $hasBeenUpdated;
    }
    
    /**
     * update if the account is private or not
     *
     * @return void
     */
    public function updatePrivateAccount()
    {
        $dbh = new PDO('mysql:host=' . HOST . ';dbname=' . DBNAME, USER, PASSWORD, array(
            PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
            PDO::ATTR_PERSISTENT => true
        ));

        $userisPrivate = $this->getPrivateAccount();

        if ($userisPrivate == 0) {
            $userSetPrivateTo = 1;
        } else {
            $userSetPrivateTo = 0;
        }

        try {
            $sqlUpdatePrivateAccount = "UPDATE user  SET privateAccount = :update_private_account WHERE id = :id_user";
            $psUpdatePrivateAccount = $dbh->prepare($sqlUpdatePrivateAccount);
            $psUpdatePrivateAccount->execute(array(':update_private_account' => $userSetPrivateTo, ':id_user' => $this->idUser));
        } catch (PDOException $e) {
            print "Erreur !: " . $e->getMessage() . "<br>";
            die();
        }
    }

    /**
     * use to know if the account is privat or not
     *
     * @return bool
     */
    public function getPrivateAccount()
    {
        $dbh = new PDO('mysql:host=' . HOST . ';dbname=' . DBNAME, USER, PASSWORD, array(
            PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
            PDO::ATTR_PERSISTENT => true
        ));

        try {
            $sqlGetPrivateAccount = "SELECT privateAccount FROM user WHERE id = :id_user";
            $psGetPrivateAccount = $dbh->prepare($sqlGetPrivateAccount);
            $psGetPrivateAccount->setFetchMode(PDO::FETCH_ASSOC);
            $psGetPrivateAccount->execute(array(':id_user' => $this->idUser));
            $result = $psGetPrivateAccount->fetchAll();
        } catch (PDOException $e) {
            print "Erreur !: " . $e->getMessage() . "<br>";
            die();
        }

        return $result[0]['privateAccount'];
    }

    /**
     * user to get the user password
     *
     * @return string
     */
    private function getUserPassword()
    {
        $dbh = new PDO('mysql:host=' . HOST . ';dbname=' . DBNAME, USER, PASSWORD, array(
            PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
            PDO::ATTR_PERSISTENT => true
        ));

        try {
            $sqlGetUserPassword = "SELECT password FROM user WHERE id = :id_user";
            $psGetUserPassword = $dbh->prepare($sqlGetUserPassword);
            $psGetUserPassword->setFetchMode(PDO::FETCH_ASSOC);
            $psGetUserPassword->execute(array(':id_user' => $this->idUser));
            $result = $psGetUserPassword->fetchAll();
        } catch (PDOException $e) {
            print "Erreur !: " . $e->getMessage() . "<br>";
            die();
        }

        return $result[0]['password'];
    }
}
