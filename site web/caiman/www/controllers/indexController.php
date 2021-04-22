<?php
class IndexController
{
  public $index;


  public function __construct()
  {
    $this->index  = new Index();
  }
  public function formHandler()
  {
  }

  public function printHTML()
  {
?>
    <main style="margin-top:20px ">
      <div class="container-md">
        <div class="jumbotron jumbotron-fluid">
            <div class="row py-lg-5">
              <div class="col-lg-6 col-md-8 mx-auto">
                <h1 class="fw-light">Caiman</h1>
                <p class="lead text-muted">Something short and leading about the collection below—its contents, the creator, etc. Make it short and sweet, but not too short so folks don’t simply skip over it entirely.</p>
                <p>
                  <a href="?r=download" class="btn btn-success my-2">Download</a>
                  <a href="?r=login" class="btn btn-success my-2">Create acount</a>
                  <a href="?r=games" class="btn btn-success my-2">Watch games list</a>
                </p>
              </div>
            </div>
        </div>
      </div>

    </main>

<?php
  }
  function aMemberFunc()
  {
    print 'Inside `aMemberFunc()`';
  }
}
