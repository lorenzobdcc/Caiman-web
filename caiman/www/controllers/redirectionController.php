<?php
class RedirectionController {

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
            exit;
        }
    }
   
}
