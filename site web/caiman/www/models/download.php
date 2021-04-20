<?php
class Download {
    public $aMemberVar = 'aMemberVar Member Variable';
    public $aFuncName = 'aMemberFunc';
   
    public function printHTML()
    {
        echo "Download";
    }
    function aMemberFunc() {
        print 'Inside `aMemberFunc()`';
    }
}