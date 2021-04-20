<header class="p-3 bg-dark text-white">
  <div class="container">
    <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
      <a href="/" class="d-flex align-items-center mb-2 mb-lg-0 text-white text-decoration-none">
        <svg class="bi me-2" width="40" height="32">
          <use xlink:href="#bootstrap"></use>
        </svg>
      </a>

      <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
        <li><a href="index.php" class="nav-link px-2 text-white">Home</a></li>
        <li><a href="?r=games" class="nav-link px-2 text-white">Games</a></li>
        <li><a href="?r=download" class="nav-link px-2 text-white">Download</a></li>
        <?php
      if ($_SESSION['user']->role != "visitor") {
      
      echo'  <li><a href="?r=dashboard" class="nav-link px-2 text-white">Dashboard</a></li>';
    
      }
      ?>
      </ul>

      <form class="col-12 col-lg-auto mb-3 mb-lg-0 me-lg-3">
        <input type="search" class="form-control form-control-dark" placeholder="Search...">
      </form>
      <?php
      if ($_SESSION['user']->role == "visitor") {
      ?>
        <div class="text-end">
          <button type="button" class="btn btn-outline-light me-2" data-toggle="modal" data-target="#modalLogin">Login</button>
          <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#modalSign">Sign-up</button>
        </div>
      <?php
      }else
      {
      ?>
        <div class="text-end">
          <a href="?r=logout"> <button type="button" class="btn btn-outline-light me-2" data-toggle="modal" data-target="#modalLogin">Logout</button></a>
        </div>
      <?php
      }
      ?>
    </div>
  </div>
</header>