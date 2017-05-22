<?php
//ob_start();
session_start();



if(isset($_GET['user'])){
    require_once("includes/database.php");
    $db = new DatabaseIcen();
    $user = $db->quote($_GET['user']);
    
    $sql = "SELECT * FROM Utilizadores WHERE username = '".$user."'";
    echo "<script>alert($db->select($sql))</script>";

    echo "<script>alert('$user');</script>";
    
}
else{
    echo "<script>alert('null');</script>";
}

?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>OYG - <?php echo $user; ?></title>

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/second.css">
    <link href="https://fonts.googleapis.com/css?family=Oswald" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Play" rel="stylesheet">

    <!-- INSERIR SCRIPT javascript -->


</head>

<body>

    <?php include_once("includes/menu.php"); ?>
    <!-- Page Content -->
    <div class="container">
        <div class="page-header" id="banner">
        <!-- Page Heading/Breadcrumbs -->
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Profile
                </h1>
                <ol class="breadcrumb">
                    <li>Menu
                    </li>
                    <li class="active">Profile</li>
                </ol>
            </div>
        </div>
        <!-- /.row -->

        <!-- Intro Content -->
        <div class="row" style="margin-top: 10%">
                <div class="col-md-2 spacePls" style="padding-top: 15px;">
                    <img class="img-responsive" src='https://steamcdn-a.akamaihd.net/steamcommunity/public/images/avatars/1a/1ad1c47e6b2dd50a0c78b57c862423a8c187ef94_full.jpg' alt="">
                </div>
                <div class="col-md-6">
                    <h2><?php echo $user;?></h2>
                    <p>(Alguma coisa aqui)</p><br>
                </div>
        </div>
        <!-- /.row -->

        <!-- Team Members -->
        <div class="row">
            <div class="col-lg-12">
                <h2 class="page-header">Stats</h2>
            </div>
            <div class="col-md-4 text-center">
                <div class="thumbnail">
                    <img class="img-responsive" src="http://placehold.it/750x450" alt="">
                    <div class="caption">
                        <h3>K/D<br>
                          <p style="font-size:20px;color:green;">«1.07»</p>
                            <small><p>O teu KD é bom!</p></small>
                        </h3>
                        <!--<ul class="list-inline">
                            <li><a href="#"><i class="fa fa-2x fa-facebook-square"></i></a>
                            </li>
                            <li><a href="#"><i class="fa fa-2x fa-linkedin-square"></i></a>
                            </li>
                            <li><a href="#"><i class="fa fa-2x fa-twitter-square"></i></a>
                            </li>
                        </ul>-->
                    </div>
                </div>
            </div>


        </div>
        <!-- /.row -->

        <!-- Our Customers -->

        <!-- /.row -->

        <hr>

        <!-- Footer -->
    <?php include_once("includes/footer.php"); ?>
    </div>
    </div>
    <!-- /.container -->


</body>

</html>
