<?php

/** BDCC
 *  -------
 *  @author Lorenzo Bauduccio <lorenzo.bdcc@eduge.ch>
 *  @file
 *  @copyright Copyright (c) 2021 BDCC
 *  @brief Class used to handle request to create an account
 */
class SigninController extends mainController implements iController
{
    public $signin;
    private $e = null;

/**
 * default contructor
 */
    public function __construct()
    {
        $this->signin = new Signin();
    }

      /**
   * used to handle if the user has resquest something
   *
   * @return void
   */
    public function formHandler()
    {
        if (isset($_GET['e'])) {
            $this->e = filter_input(INPUT_GET, 'e', FILTER_SANITIZE_SPECIAL_CHARS);
        }
        if ($this->e == "signin") {
            if (isset($_POST['username'])) {
                $this->signin->insert_username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_SPECIAL_CHARS);
                if($this->signin->insert_username == "")
                {
                    $_SESSION['error'] = "Username is empty";
                    header('Location:' . $_SERVER['HTTP_REFERER']);
                    exit;
                }
            }
            if (isset($_POST['password'])) {
                $this->signin->insert_password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_SPECIAL_CHARS);
                if($this->signin->insert_password == "")
                {
                    $_SESSION['error'] = "Password is empty";
                    header('Location:' . $_SERVER['HTTP_REFERER']);
                    exit;
                }
            }
            if (isset($_POST['passwordRepeat'])) {
                $this->signin->insert_password_repeat = filter_input(INPUT_POST, 'passwordRepeat', FILTER_SANITIZE_SPECIAL_CHARS);
                if($this->signin->insert_password_repeat == "")
                {
                    $_SESSION['error'] = "Password repeat is empty";
                    header('Location:' . $_SERVER['HTTP_REFERER']);
                    exit;
                }
            }
            if (isset($_POST['email'])) {
                $this->signin->insert_email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
                if($this->signin->insert_email == "")
                {
                    $_SESSION['error'] = "Email is empty";
                    header('Location:' . $_SERVER['HTTP_REFERER']);
                    exit;
                }
            }


            if (isset($this->signin->insert_password) && isset($this->signin->insert_username) && isset($this->signin->insert_password_repeat) && isset($this->signin->insert_email)) {

                if ($this->signin->insert_password != $this->signin->insert_password_repeat) {
                    $_SESSION['error'] = "Password does not match";
                    header('Location:' . $_SERVER['HTTP_REFERER']);
                    exit;
                }


                $this->signin->newUser();

                header('Location:' . $_SERVER['HTTP_REFERER']);
                exit;
            } else {
                $_SESSION['error'] = "form not completed";
                header('Location:' . $_SERVER['HTTP_REFERER']);
                exit;
            }
        }
    }
    
 /**
   * print the html for the resquested content
   * 
   *
   * @return void
   */
    public function printHTML()
    {
    }
}
