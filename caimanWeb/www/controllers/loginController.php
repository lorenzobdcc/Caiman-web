<?php

/** BDCC
 *  -------
 *  @author Lorenzo Bauduccio <lorenzo.bdcc@eduge.ch>
 *  @file
 *  @copyright Copyright (c) 2021 BDCC
 *  @brief Class used to handle request for the login page
 */
class LoginController extends mainController implements iController
{
  public $login;
  private $e = "";

  /**
   * default constructor
   */
  public function __construct()
  {
    $this->login  = new Login();
  }

  /**
   * used to handle if the user has resquest something
   *
   * @return void
   */
  public function formHandler()
  {
    if (isset($_GET['e'])) {
      $this->e = filter_input(INPUT_GET, 'e', FILTER_SANITIZE_STRING);
    }

    if ($this->e == "login") {
      $_SESSION['title'] = "Caiman: Login";
      if (isset($_POST['username'])) {
        $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
      }
      if (isset($_POST['password'])) {
        $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
      }

      if (isset($password) && isset($username)) {
        $this->login->search_username = $username;
        $this->login->search_password = $password;

        $usersInfos = $this->login->checkLogin($password);
        
        if (isset($usersInfos)) {
          $_SESSION['user'] = new User($usersInfos[0]['username'], $usersInfos[0]['email'], $usersInfos[0]['idRole'], $usersInfos[0]['id'],$usersInfos[0]['salt']);
          header('Location:' . $_SERVER['HTTP_REFERER']);
          exit;
        }
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

    $html = '<main  style="margin-top:20px ">
        <div class="container-md">';
    $html .= $this->errorHandler();
    $html .= $this->htmlFormHead();

    $html .= "</div></main> ";

    echo $html;
  }

/**
 * create the form of login
 *
 * @return html
 */
  private function htmlFormLogin()
  {
    $html = "";

    $html = ' 
        <div style="width: 70%; margin: auto;">
        <h2>Login</h2>
        <form action="?r=login&e=login" method="post">
              <div class="form-group">
                <label for="username">Username</label>
                <input type="texte" name="username" class="form-control" id="username" aria-describedby="username" placeholder="Enter username">
              </div>
              <div class="form-group">
                <label for="password">Password</label>
                <input type="password" name="password" class="form-control" id="password" placeholder="Password">
              </div>
              <div class="form-group">
              <button type="submit" class="btn btn-success">Log in</button>
            </div>

          
          </form>
      </div>';

    return $html;
  }

  /**
   * create the form of sign in
   *
   * @return html
   */
  private function htmlFormSignin()
  {
    $html = "";

    $html = '
        <div style="width: 70%; margin: auto;">
        <h2>Sign In</h2>
        <p>Sign-Up to Caiman to play and discover old games.</p>
        <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#modalSign">Sign-up</button>
      </div>';

    return $html;
  }

  /**
   * create the head of the page
   *
   * @return html
   */
  private function htmlFormHead()
  {
    $html = "";

    $html .= '<div class="jumbotron jumbotron-fluid DarkJumbotron width100" style="background-color: #161b22;"">
        <div class="container">';

    $html .= '<div class="container">
        <div class="row">
          <div class="col-sm">
          ';
    $html .= $this->htmlFormLogin();
    $html .= '
          </div>
          <div class="col-sm">
          ';
    $html .= $this->htmlFormSignin();
    $html .= '
          </div>
        </div>
      </div>';

    $html .= '
          
        </div>
      </div>';

    return $html;
  }
}
