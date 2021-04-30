<?php

/** BDCC
 *  -------
 *  @author Lorenzo Bauduccio <lorenzo.bdcc@eduge.ch>
 *  @file
 *  @copyright Copyright (c) 2021 BDCC
 *  @brief Class used to handle the page of download
 */
class DownloadController extends mainController implements iController
{
  public $download;
  private $e = null;

  /**
   * default constructor
   */
  public function __construct()
  {
    $this->download  = new Download();
  }

  /**
   * used to handle if the user has resquest something
   *
   * @return void
   */
  public function formHandler()
  {
    $_SESSION['title'] = "Caiman: Download";
    if (isset($_GET['e'])) {
      $this->e = filter_input(INPUT_GET, 'e', FILTER_SANITIZE_STRING);
    }

    if ($this->e == null) {

      if ($_SESSION['user']->idUser != -1) {
        $this->e = "user";
      } else {
        $this->e = "visitor";
      }
    }

    if ($this->e == "download") {

      if ($_SESSION['user']->idUser != -1) {
        $this->download->downloadCaiman();
      } else {
        header('?r=login');
      }
    }
  }


  /**
   * print the html for the resquested content
   * 
   *
   * @return html
   */
  public function printHTML()
  {
    $html = '<main style="margin-top:20px">
        <div class="container-md">';
    $html .= $this->errorHandler();
    if ($this->e == "user") {
      $html .= $this->htmlUserDownload();
    }

    if ($this->e == "visitor") {
      $html .= $this->htmlVisitorDownload();
    }
    $html .= "</div></main> ";
    echo $html;
  }

  /**
   * create the html to download Caiman
   *
   * @return html
   */
  private function htmlUserDownload()
  {
    $html = "";

    $html .= '
        <div class="jumbotron jumbotron-fluid DarkJumbotron " style="background-color: #161b22;">
            <div class="row py-lg-5">
              <div class="col-lg-6 col-md-8 mx-auto">
                <h1 class="fw-light greenTexte">Caiman</h1>
                <p class="lead text-muted">The easiest way to use emulators.</p>
                <p>
                  <a href="?r=download&e=download" class="btn btn-success my-2">Download for Windows (64bit)</a>
                </p>
              </div>
            </div>
        </div>';

    return $html;
  }

/**
 * create the html to explian to the user that he has to log in
 *
 * @return html
 */
  private function htmlHeadVisitor()
  {
    $html = "";

    $html .= '<div class="jumbotron  DarkJumbotron width100" style="background-color: #161b22;">
        <div class="container">';

    $html .= '<div class="container">
        <div class="row">
          <div class="col-sm">
          <p>To download the application you must create an account or log in.</p>
          </div>
        </div>
      </div>';

    $html .= '
          
        </div>
      </div>';

    return $html;
  }

  /**
   * create the html of download to a visitor
   *
   * @return html
   */
  private function htmlVisitorDownload()
  {
    $html = $this->htmlHeadVisitor();

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

  /**
   * create the form to create an account
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
   * create the form to log in
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
            <div class="form-group">
              <a href="?r=login&e=forgot" class="btn btn-success my-2">Forgot password?</a>
            </div>
          
          </form>
      </div>';

    return $html;
  }
}
