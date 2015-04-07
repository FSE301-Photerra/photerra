<html class="no-js" lang="en" >
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Photerra - GO EXPLORE!
    
    </title>
    <link rel="stylesheet" href="assets/css/style.css">
    <script src="assets/js/vendor/modernizr.min.js"></script>
    <script type="text/x-handlebars-template" id="nearby-template">
    <div id="content" class="map-popup">
        <div id="siteNotice">
        </div>
        <div id="bodyContent">
            <div class="row">
                <a href="#" class="th large-12 columns">
                    <img src="{{featuredImage.path}}">
                </a>
            </div>
            <div class="row">
                <a href="#" class="th large-6 columns">
                    <img src="{{trendingImage.1.path}}">
                </a>
                <a href="#" class="th large-6 columns">
                    <img src="{{trendingImage.2.path}}">
                </a>
            </div>
            <div class="row">
                <a href="#" class="th large-3 columns">
                    <img src="{{images.1.path}}">
                </a>
                <a href="#" class="th large-3 columns">
                    <img src="{{images.2.path}}">
                </a>
                <a href="#" class="th large-3 columns">
                    <img src="{{images.3.path}}">
                </a>
                <a href="#" class="th large-3 columns">
                    <img src="{{images.4.path}}">
                </a>
            </div>

            <div class="row">
                <div class="large-4 columns">
                    <a href="#" data-reveal-id="upload-modal"><i class="add-icon"></i> Add Image</a>
                </div>
            </div>
        </div>
    </div>
    </script>

    <script type="text/x-handlebars-template" id="pin-template">
    <div id="content" class="map-popup">
        <div id="siteNotice">
        </div>
        <div id="bodyContent">
            <div class="row">
                <a href="#" class="th large-12 columns">
                    <img src="{{point.image.path}}">
                </a>
            </div>
        </div>
    </div>
    </script>
  </head>
  <body>
    <nav class="top-bar" data-topbar>
        <ul class="title-area">
            <!-- Title Area -->
            <li class="name">
                <h1>
                    <a href="#" data-reveal-id="about-modal">
                        PHOTERRA
                    </a>
                </h1>
            </li>
            <li class="toggle-topbar menu-icon"><a href="#"><span>menu</span></a></li>
        </ul>

        <section class="top-bar-section">
            <!-- Right Nav Section -->
            <ul class="right">
                <li class="divider"></li>
                <li class="active">
                    <a href="#" data-reveal-id="login-modal"><i class="user-icon"></i> Login</a>
                </li>
            </ul>
        </section>
    </nav>

    <div class="map-element" id="map-canvas"></div>

    <!-- Notifications -->
    <div data-alert class="notifications">
        <p class="content"></p>
        <a href="#" class="close">x</a>
    </div>

    <!-- Login form -->
    <div id="login-modal" class="login-modal" data-reveal>
        <div data-alert class="alert-box radius">
            Please use your credentials to log in.
            If you dont have an account then click on the sign up button.
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
                    <li><a href="#" class="button" data-reveal-id="register-modal">Sign Up</a></li>
                    <li><a href="#" class="button alert" id="close-form">Close</a></li>
                </ul>
            </div>
        </form>
    </div>

    <!-- Registration form -->
    <div id="register-modal" class="register-modal" data-reveal>
        <div data-alert class="alert-box radius">
            Please provide the following information to create an account.
        </div>

        <form method="POST" action="registration_execute.php">
            <div class="row">
                <div class="large-12 columns">
                  <label>
                    First Name
                    <input type="text" name="fname">
                  </label>
                </div>
            </div>

            <div class="row">
                <div class="large-12 columns">
                  <label>
                    Last Name
                    <input type="text" name="lname">
                  </label>
                </div>
            </div>

            <div class="row">
                <div class="large-12 columns">
                  <label>
                    Email
                    <input type="text" name="email">
                  </label>
                </div>
            </div>

            <!--
            <div class="row">
                <div class="large-12 columns">
                  <label>
                    Confirm Email
                    <input type="text">
                  </label>
                </div>
            </div>
            -->

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

            <!--
            <div class="row">
                <div class="large-12 columns">
                  <label>
                    Confirm Password
                    <input type="password">
                  </label>
                </div>
            </div>
            -->

            <div class="row">
                <ul class="button-group">
                    <li><input type="submit" class="button success" value="Register"></li>
                    <li><a href="#" class="button alert" id="close-form">Close</a></li>
                </ul>
            </div>
        </form>
    </div>

    <div id="upload-modal" class="upload-modal" data-reveal>
        <form method="POST" action="imageUpload.php" enctype="multipart/form-data">
            <div class="row">
                <div class="large-12 columns">
                  <label>
                    Image Name
                 
                    <input type="text" name="imageName" id="imageName"/>
                  </label>
                </div>
            </div>
            <div class="row">
                <div class="large-12 columns">
                  <label>
                    Image File
                    <input type="file" name="fileToUpload" id="fileToUpload"/>
                  </label>
                </div>
            </div>

            <div class="row">
                <ul class="button-group">
                    <li><input type="submit" name="submit" id="submit" value="Upload" class="button success"></li>
                    <li><a href="#" class="button alert" id="close-form">Close</a></li>
                </ul>
            </div>
        </form>
    </div>

    <!-- About modal -->
    <div id="about-modal" class="about-modal" data-reveal>
        <h2>Who are we?</h2>
        <p>We are Photerra, todo.</p>
        <a href="#" class="close-reveal-modal">x</a>
    </div>

    <script src="assets/js/vendor/libraries.min.js"></script>
    <script src="assets/js/vendor/handlebars.min.js"></script>
    <script src="assets/js/vendor/foundation.min.js"></script>
    <script type="text/javascript" src="//maps.googleapis.com/maps/api/js?key=AIzaSyDPnJtesM2O892U3694ZjbtxcGMwWRtC9k"></script>
    <script src="assets/js/app.js"></script>
  </body>
</html>