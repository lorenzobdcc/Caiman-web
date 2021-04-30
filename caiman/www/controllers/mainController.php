<?php

/** BDCC
 *  -------
 *  @author Lorenzo Bauduccio <lorenzo.bdcc@eduge.ch>
 *  @file
 *  @copyright Copyright (c) 2021 BDCC
 *  @brief main class of the controller used to implement basic function
 */
class MainController
{

    /**
     * default constructor
     */
    public function __construct()
    {
    }

    /**
     * used to set the acces of a page you need to give the the list of role who can acces the page
     *
     * @param [type] $allowAccessToId
     * @return void
     */
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

    /**
     * create the html of an error
     *
     * @return html
     */
    public function errorHandler()
    {
        $html = "";
        if (isset($_SESSION['error']) && $_SESSION['error'] != null) {

            $html .= '
          <div class=" warningJumbotron errorMessageDiv" style="background-color: #161b22; ">

                  <h5>' . $_SESSION['error'] . '</h5>

          </div>';
            $_SESSION['error'] = null;
        }
        return $html;
    }
}
