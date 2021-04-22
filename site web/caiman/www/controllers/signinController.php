<?php
class SigninController {
    public $signin;
    private $e = null;


    public function __construct()
    {
        $this->signin = new Signin();
    }
   
    public function formHandler()
    {
        if (isset($_GET['e'])) {
            $this->e = filter_input(INPUT_GET, 'e', FILTER_SANITIZE_SPECIAL_CHARS);
        }

        if ($this->e == "singin") {
          
            if (isset($_POST['username'])) {
                $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_SPECIAL_CHARS);
            }
            if (isset($_POST['password'])) {
                $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_SPECIAL_CHARS);
            }
            if (isset($_POST['passwordRepeat'])) {
                $passwordRepeat = filter_input(INPUT_POST, 'passwordRepeat', FILTER_SANITIZE_SPECIAL_CHARS);
            }
            if (isset($_POST['email'])) {
                $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
            }
            
            if (isset($password) && isset( $username) && isset($passwordRepeat) ) {
            
                if ($password != $passwordRepeat) {
                    header('Location: ?r=signin&e=1');
                    exit;
                }
                $this->signin->insert_username = $username;
                $this->signin->insert_password = $password;
                $this->signin->insert_email = $email;
            
                $this->signin->newUser();
            
            }else
            {
                echo "les champs ne sont pas renmpli";
            }
        }
    }
    public function printHTML()
    {
        
    }
    function aMemberFunc() {
        print 'Inside `aMemberFunc()`';
    }
}
$signin = new Signin();
