<?php
class Games {
    public $aMemberVar = 'aMemberVar Member Variable';
    public $aFuncName = 'aMemberFunc';
   
    public function printHTML()
    {
        echo "Games";
    }
    function aMemberFunc() {
        print 'Inside `aMemberFunc()`';
    }
}