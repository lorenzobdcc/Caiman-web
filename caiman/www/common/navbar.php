<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
<a class="navbar-brand" href="index.php"><span class="greenTexte">Caiman</span></a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo02" aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
    <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
    <li><a href="index.php" class="nav-link px-2 text-white">Home</a></li>
        <li><a href="?r=games" class="nav-link px-2 text-white">Games</a></li>
        <li><a href="?r=download" class="nav-link px-2 text-white">Download</a></li>
        <li><a href="?r=users" class="nav-link px-2 text-white">Users</a></li>
    </ul>
    <form class="form-inline my-2 my-lg-0" action="?r=games&e=requestGame" method="post">
      <input class="form-control mr-sm-2" type="search" placeholder="Search games" name="gameName">
    </form>
    <?php
    if ($_SESSION['user']->role == -1) {
      ?>
        <div class="text-end">
          <button type="button" class="btn btn-outline-light me-2" data-toggle="modal" data-target="#modalLogin">Login</button>
          <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#modalSign">Sign-up</button>
        </div>
      <?php
      } else {
      ?>
        <div class="text-end">
        <?php
        if ($_SESSION['user']->role == 1) {

          echo '<a href="?r=administrator"> <button type="button" class="btn btn-outline-warning me-2">Dashboard admin</button></a>';
        }
        ?>
          <a href="?r=dashboard"> <button type="button" class="btn btn-outline-warning me-2">Dashboard</button></a>
          <a href="?r=logout"> <button type="button" class="btn btn-outline-danger me-2">Logout</button></a>
        </div>
      <?php
      }
      ?>
  </div>
</nav>