<?php
class User {

    public $username;
    public $email;
    public $role;
   
   
    public function __construct(string $usernamep,string $emailp, string $idRolep)
    {

        $this->username = $usernamep;
        $this->email = $emailp;
        $this->role = $idRolep;
        
    }

    public function printInfos()
    {
        echo "username: " . $this->username . "<br>";
        echo "email: " . $this->email . "<br>";
        echo "role: " . $this->role . "<br>";
    }

    public function getInfosUser()
    {
        echo "lol";
    }
}