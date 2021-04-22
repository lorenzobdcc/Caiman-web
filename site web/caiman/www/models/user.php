<?php
class User
{

    public $username;
    public $email;
    public $role;
    public $idUser;




    public function __construct(string $usernamep, string $emailp, string $idRolep, int $idUserp)
    {

        $this->username = $usernamep;
        $this->email = $emailp;
        $this->role = $idRolep;
        $this->idUser = $idUserp;

    }

    public function printInfos()
    {
        echo "username: " . $this->username . "<br>";
        echo "email: " . $this->email . "<br>";
        echo "role: " . $this->role . "<br>";
        echo "idUser: " . $this->idUser . "<br>";
    }

    public function updatePassword(string $newPassword, string $newPasswordRepeat, string $oldPassword)
    {
        $dbh = new PDO('mysql:host=' . HOST . ';dbname=' . DBNAME, USER, PASSWORD, array(
            PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
            PDO::ATTR_PERSISTENT => true
        ));

        $hasBeenUpdated = 1;
        if ($newPasswordRepeat == $newPassword) {
            try {
                $sqlUpdatePassword = "UPDATE user  SET password = :update_password WHERE id = :id_user";
                $psUpdatePassword = $dbh->prepare($sqlUpdatePassword);
                $psUpdatePassword->execute(array(':update_password' => password_hash($newPassword,PASSWORD_DEFAULT), ':id_user' => $this->idUser));
                
                $hasBeenUpdated = 0;
            } catch (PDOException $e) {
                print "Erreur !: " . $e->getMessage() . "<br>";
                die();
            }
        } else {
            $hasBeenUpdated = 2;
        }

        return $hasBeenUpdated;
    }


    
}
