<?php
class SigninController
{
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
        if ($this->e == "signin") {
            if (isset($_POST['username'])) {
                $this->signin->insert_username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_SPECIAL_CHARS);
            }
            if (isset($_POST['password'])) {
                $this->signin->insert_password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_SPECIAL_CHARS);
            }
            if (isset($_POST['passwordRepeat'])) {
                $this->signin->insert_password_repeat = filter_input(INPUT_POST, 'passwordRepeat', FILTER_SANITIZE_SPECIAL_CHARS);
            }
            if (isset($_POST['email'])) {
                $this->signin->insert_email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
            }


            if (isset($this->signin->insert_password) && isset($this->signin->insert_username) && isset($this->signin->insert_password_repeat) && isset($this->signin->insert_email)) {

                if ($this->signin->insert_password != $this->signin->insert_password_repeat) {
                    //header('Location: ?r=signin&e=1');
                    //exit;
                    echo "les mots de passe sont dif";
                }


                $this->signin->newUser();

                //header('Location: ?r=signin&e=0');
                //exit;
            } else {
                echo "champs non rempli";
                //header('Location: ?r=signin&e=2');
                //exit;
            }
        }
    }
    public function printHTML()
    {
    }
}
