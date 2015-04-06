<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title><?php echo $title; ?> </title>
        <link rel="stylesheet" type="text/css" href="/css/main.css"/>
    </head>
    <body>
        <div id="page"> 
            <div id="logo">
                <img src="/images/logo.JPG"/>
            </div>


        </div>

    </body>
    <ul id="navigation">
        <nav>
            <?php
            echo buildnavigation();
            if ($_SESSION['firstname']):
                ?>
                <a href = "?page=images" > images </a>
            <?php
            endif;

            if ($_SESSION['permission'] == 'admin'):
                ?>
                <a href = "?page=client" > client </a>
                <a href = "?page=content" > content </a>

            <?php endif; ?>

            <?php
            if ($_SESSION['firstname']):
                echo 'welcome, ' . $_SESSION['firstname'];
                ?>

                <a href ="?page=account" >  account </a>
                <a href ="?page=logout"> Logout </a>  
<?php else: ?>


                <a href ="?page=register" >  register </a>
                <a href ="?page=login"> Login </a>
<?php endif; ?>

        </nav> 

        <h2><?php echo $title; ?></h2>
        <?php
        if (isset($error)) {
            echo "<p id='error'>" . $error . "</p>";
        }
        echo $content;
        ?>
    </ul>

    <p>

    </p>
    <p>
        Welcome to Essential Oil Share. We are glad you are here. 
        Please feel free to browse around and <br> find useful essential oil handouts, business cards 
        Brochures, tear sheets, banners, and many <br> other useful tools to grow your business. <br> <br>

        If you have something amazing you would like to share register for an account. <br>Once you are 
        registered you may upload your images and links to add to the site. 

        <br>   <br>    <br>   <br>   <br>   <br>   <br>   <br>   <br>   <br>

    </p>



    <footer>
        <img src="/images/Header.jpg" 
    </footer>


</html>

