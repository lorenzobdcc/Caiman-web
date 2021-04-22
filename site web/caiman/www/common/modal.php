    <!-- Modal Login -->
    <div class="modal fade" id="modalLogin" tabindex="-1" role="dialog" aria-labelledby="modalLogin" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Login</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form action="?r=login&e=login" method="post">
              <div class="form-group">
                <label for="username">Username</label>
                <input type="texte" name="username" class="form-control" id="username" aria-describedby="username" placeholder="Enter username">
              </div>
              <div class="form-group">
                <label for="password">Password</label>
                <input type="password" name="password" class="form-control" id="password" placeholder="Password">
              </div>
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Log in</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          </div>
          </form>
        </div>
      </div>
    </div>

    <!-- Modal Sign in -->
    <div class="modal fade" id="modalSign" tabindex="-1" role="dialog" aria-labelledby="modalLogin" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Sign in</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form action="?r=signin&e=signin" method="post">
              <div class="form-group">
                <label for="username">Username</label>
                <input type="texte" name="username" class="form-control" id="username" aria-describedby="emailHelp" placeholder="Enter username">
              </div>
              <div class="form-group">
                <label for="email">Email address</label>
                <input type="email" name="email" class="form-control" id="email" aria-describedby="emailHelp" placeholder="Enter email">
                <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
              </div>
              <div class="form-group">
                <label for="password">Password</label>
                <input type="password" name="password" class="form-control" id="password" placeholder="Password">
              </div>
              <div class="form-group">
                <label for="exampleInputPassword1">Password repeat</label>
                <input type="password" name="passwordRepeat" class="form-control" id="passwordRepeat" placeholder="Password repeat">
              </div>
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Sign in</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          </div>
          </form>
        </div>
      </div>
    </div>