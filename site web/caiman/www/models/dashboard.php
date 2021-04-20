<?php
class Dashboard {
    public $aMemberVar = 'aMemberVar Member Variable';
    public $aFuncName = 'aMemberFunc';
   
    public function printHTML()
    {
        $_SESSION['user']->printInfos();
    }
    function aMemberFunc() {
        print 'Inside `aMemberFunc()`';
    }
}