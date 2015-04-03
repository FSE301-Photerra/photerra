<!DOCTYPE html>
<html class="no-js" lang="en" >
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Photerras - GO EXPLORE!</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <script src="assets/js/vendor/modernizr.min.js"></script>
  </head>
  <body>
    <nav class="top-bar" data-topbar>
        <ul class="title-area">
            <!-- Title Area -->
            <li class="name">
                <h1>
                    <a href="home.php">
                        PHOTERRAS
                    </a>
                </h1>
            </li>
            <li class="toggle-topbar menu-icon"><a href="#"><span>menu</span></a></li>
        </ul>
    </nav>

    <?php if(isset($_GET['remarks'])) : ?>
        <?php if($_GET['remarks'] == 'failure') : ?>
            <div data-alert class="alert-box alert radius">
                Unable to login with the provided credentials.
            </div>
        <?php elseif($_GET['remarks'] == 'success') : ?>
            <div data-alert class="alert-box success radius">
                Successfully created an account.
            </div>
        <?php endif; ?>
    <?php endif; ?>

    <div data-alert class="alert-box radius">
        Please use your credentials to log in.
        If you don't have an account then click on the sign up button.
    </div>

    <form method="POST" action="check.php">
        <div class="row">
            <div class="large-12 columns">
              <label>
                Username
                <input type="text" name="username">
              </label>
            </div>
        </div>

        <div class="row">
            <div class="large-12 columns">
              <label>
                Password
                <input type="password" name="password">
              </label>
            </div>
        </div>

        <div class="row">
            <ul class="button-group">
                <li><input type="submit" class="button success" value="Login"></li>
                <li><a href="register.php" class="button">Sign Up</a></li>
            </ul>
        </div>
    </form>

    <script src="assets/js/vendor/libraries.min.js"></script>
    <script src="assets/js/vendor/foundation.min.js"></script>
    <script type="text/javascript" src="//maps.googleapis.com/maps/api/js?key=AIzaSyDPnJtesM2O892U3694ZjbtxcGMwWRtC9k"></script>
    <script src="assets/js/app.js"></script>
  </body>
</html>
