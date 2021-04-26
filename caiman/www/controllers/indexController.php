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
        <div class="jumbotron jumbotron-fluid DarkJumbotron width100" style="background-color: #161b22;">
            <div class="row py-lg-5">
              <div class="col-lg-6 col-md-8 mx-auto">
                <h1 class="fw-light greenTexte">Caiman</h1>
                <p class="lead text-muted">The easiest way to use emulators.</p>
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

}
