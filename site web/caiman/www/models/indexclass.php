<?php
class Index {
    public $aMemberVar = 'aMemberVar Member Variable';
    public $aFuncName = 'aMemberFunc';
   
    public function printHTML()
    {
        echo "Index";
    }
   
    function aMemberFunc() {
        print 'Inside `aMemberFunc()`';
    }
}