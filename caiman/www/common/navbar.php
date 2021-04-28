<header class="p-2 bg-dark text-white">
  <div class="container">
    <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">

      <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
        <li><a href="index.php" class="nav-link px-2 text-white">Home</a></li>
        <li><a href="?r=games" class="nav-link px-2 text-white">Games</a></li>
        <li><a href="?r=download" class="nav-link px-2 text-white">Download</a></li>
        <li><a href="?r=users" class="nav-link px-2 text-white">Users</a></li>
      </ul>

      <form class="col-12 col-lg-auto mb-3 mb-lg-0 me-lg-3" action="?r=games&e=requestGame" method="post">
        <input type="search" class="form-control form-control-dark" placeholder="Search games" name="gameName">
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
  </div>
</header>