<?php include("includes/header.php"); ?>

<?php if(!$session->is_signed_in()){redirect("login.php");}?>

    <!-- Navigation -->
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <!-- Brand and toggle get grouped for better mobile display -->
        <?php include("includes/top_nav.php"); ?>
        <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
        <?php include("includes/side_nav.php"); ?>
        <!-- /.navbar-collapse -->
    </nav>

    <div id="page-wrapper">

<?php

    $current_user = User::find_by_id($_SESSION['user_id']);

    $count_photos = $current_user->count_users_photos();

    $count_likes = $current_user->count_users_likes();

    $count_comments = $current_user->count_users_comments();

?>

<div class="container-fluid">

    <!-- Page Heading -->
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">
                My Statistics
            </h1>
            <p><?php echo $message; ?></p>
            <div class="row">

                <div class="col-md-4">
                    <div class="panel panel-green">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-photo fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge"><?php echo $count_photos ?></div>
                                    <div>Photos</div>
                                </div>
                            </div>
                        </div>
                        <a href="photos_user.php">
                            <div class="panel-footer">
                                <span class="pull-left">Your Photos in Gallery</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-users fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge"><?php echo $count_likes; ?></div>
                                    <div>Likes</div>
                                </div>
                            </div>
                        </div>
                        <a href="likes_user.php">
                            <div class="panel-footer">
                                <span class="pull-left">Total Likes on your Photos</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="panel panel-red">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-support fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge"><?php echo $count_comments; ?></div>
                                    <div>Comments</div>
                                </div>
                            </div>
                        </div>
                        <a href="comments_user.php">
                            <div class="panel-footer">
                                <span class="pull-left">Total Comments on your Photos</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>

            </div> <!--First Row-->

        </div>

    </div>
    <!-- /.row -->

</div>
<!-- /.container-fluid -->


</div>
        <!-- /#page-wrapper -->

  <?php include("includes/footer.php"); ?>