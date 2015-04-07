<html>
<body>
<head>
    <title> Photerra </title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<nav class="top-bar" data-topbar>
        <ul class="title-area">
            <!-- Title Area -->
            <li class="name">
                <h1>
                    <a href="" data-reveal-id="about-modal">
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

 <!--look at lines 104-149 of the picture -->
<?php
 include 'connect.php';
 $member_id=$_GET['member_id'];
 $query="SELECT fname,lname,username FROM Users WHERE member_id='$member_id'";
 $result=mysqli_query($link, $query) or die(mysqli_error($link));
 while($row = mysqli_fetch_assoc($result)) {
        
    $fname=$row["fname"];
        $lname=$row["lname"];
        $username=$row["username"];

        
    }
   /*   
   firstname = "<?php echo htmlspecialchars($fname); ?>"
   lastname = "<?php echo htmlspecialchars($lname); ?>"
   username = "<?php echo htmlspecialchars($username); ?>"

    echo "hello $fname $lname";
    echo ", your username is $username"; 
    */
 ?>
<p><?php echo "Hello $fname $lname"; ?></p>
<p><?php echo "Your username is $username"; ?></p>
 </body>
 </html>