<?php include("includes/header.php"); ?>

<?php if(!$session->is_signed_in()){redirect("login.php");}?>

<?php 
    
    if(empty($_GET['id'])){
        redirect("photos.php");
    }

    $likes = Like::find_the_likes($_GET['id']);

?>

        <!-- Navigation -->
        <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
            <!-- Brand and toggle get grouped for better mobile display -->
            <?php include("includes/top_nav.php"); ?>
            <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
            <?php include("includes/side_nav.php"); ?>
            <!-- /.navbar-collapse -->
        </nav>

        <div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Likes                         
                        </h1>
                        <p class="bd-success"><?php echo $message; ?></p>
                        <div class="col-md-12">
                            <table class="table table-hover">
                                <thead>                                
                                    <tr>
                                        <th>Id</th>
                                        <th>User</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($likes as $like) : ?>
                                            <tr>
                                                <td><?php echo $like->id ?></td>
                                                <td>
                                                    <?php
                                                    $user = User::find_by_id($like->user_id);
                                                    $name = $user->first_name . ' ' . $user->last_name;
                                                    echo $name;
                                                    ?>
                                                    <!-- <div class="action_links"> -->
                                                        <!-- <a href="delete_comment_photo.php?id=<?php echo $comment->id; ?>" class="delete_link">Delete</a> -->
                                                    <!-- </div> -->
                                                </td>                     
                                            </tr>    
                                    <?php endforeach ?>                            
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
                <!-- /.row -->

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

  <?php include("includes/footer.php"); ?>