<?php
class LoginController {
    public $login;
    private $e = "";

    public function __construct()
    {
        $this->login  = new Login();
    }

    public function formHandler()
    {
        if (isset($_GET['e'])) {
            $this->e = filter_input(INPUT_GET, 'e', FILTER_SANITIZE_STRING);
        }

        if ($this->e == "login") {
            if (isset($_POST['username'])) {
                $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
            }
            if (isset($_POST['password'])) {
                $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
            }
            
            if (isset($password) && isset( $username)) {
                $this->login->search_username = $username;
                $this->login->search_password = $password;
            
                $usersInfos = $this->login->checkLogin();
            
            if (isset($usersInfos)) {
                echo "username: ".$usersInfos[0]['username'];
            
                $_SESSION['user'] = new User($usersInfos[0]['username'],$usersInfos[0]['email'],$usersInfos[0]['idRole'],$usersInfos[0]['id']);
                header('Location: ?r=dashboard');
            }
            }
        }
    }
   
    public function printHTML()
    {
        
    }

}




?>