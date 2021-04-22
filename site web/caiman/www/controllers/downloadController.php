<?php
class DownloadController {
    public $download;
    public $aMemberVar = 'aMemberVar Member Variable';
    public $aFuncName = 'aMemberFunc';

    public function __construct()
    {
        $this->download  = new Download();
    }
    public function formHandler()
    {}
   
    public function printHTML()
    {
        echo "Download";
    }
    function aMemberFunc() {
        print 'Inside `aMemberFunc()`';
    }
}