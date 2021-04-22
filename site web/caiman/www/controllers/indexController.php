<?php
class IndexController {
    public $index;
    public $aMemberVar = 'aMemberVar Member Variable';
    public $aFuncName = 'aMemberFunc';

    public function __construct()
    {
        $this->index  = new Index();
    }
    public function formHandler()
    {}
   
    public function printHTML()
    {
        ?>
        <main>
        
        <section class="py-5 text-center container">
          <div class="row py-lg-5">
            <div class="col-lg-6 col-md-8 mx-auto">
              <h1 class="fw-light">Caiman</h1>
              <p class="lead text-muted">Something short and leading about the collection below—its contents, the creator, etc. Make it short and sweet, but not too short so folks don’t simply skip over it entirely.</p>
              <p>
                <a href="?r=download" class="btn btn-primary my-2">Download</a>
                <a href="?r=login" class="btn btn-secondary my-2">Create acount</a>
              </p>
            </div>
          </div>
        </section>
        
        
        </main>
        
                <?php
    }
    function aMemberFunc() {
        print 'Inside `aMemberFunc()`';
    }
}