<?php
class MainController {

    public function __construct()
    {
    }

    public function allowAccessTo($allowAccessToId)
    {
        
        $isValid = false;
        foreach ($allowAccessToId as $key => $validId) {
            if ($validId == $_SESSION['user']->role) {
                $isValid = true;
            }
        }

        if ($isValid == false) {
            header('Location: index.php');
            $_SESSION['error'] = "You can't access this page!";
            exit;
        }
    }

    public function errorHandler()
    {
      $html = "";
      if (isset($_SESSION['error']) && $_SESSION['error'] != null) {

          $html .= '
          <div class=" warningJumbotron errorMessageDiv" style="background-color: #161b22; ">

                  <h5>'.$_SESSION['error'].'</h5>

          </div>';
          $_SESSION['error'] = null;
      }
        return $html;
 
    }
   
}
