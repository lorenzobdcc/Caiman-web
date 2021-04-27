<?php
class Dashboard {

   
    public function printHTML()
    {
        $_SESSION['user']->printInfos();
    }

}