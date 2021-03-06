<?php include("includes/header.php"); ?>

<?php if(!$session->is_signed_in()){redirect("login.php");}?>

<?php 

    if(empty($_GET['user_id'])){
        $comments = User::find_by_id($_SESSION['user_id'])->comments();
    }elseif(User::find_by_id($_SESSION['user_id'])->is_admin()){
        $comments = User::find_by_id($_GET['user_id'])->comments();
    }else{
        redirect("user_stats.php");
    }

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
                            Comments                         
                        </h1>
                        <p class="bd-success"><?php echo $message; ?></p>
                        <div class="col-md-12">
                            <table class="table table-hover">
                                <thead>                                
                                    <tr>
                                        <th>Photo</th>
                                        <th>Author</th>
                                        <th>Body</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($comments as $comment) : ?>
                                            <tr>
                                                <td>
                                                    <?php
                                                    $photo = Photo::find_by_id($comment->photo_id);
                                                    if(empty($photo->title)){
                                                        $title = $photo->filename;
                                                    }else{
                                                        $title = $photo->title;
                                                    }
                                                    ?>
                                                    <a href="../gallery.php?id=<?php echo $photo->id; ?>"><?php echo $title; ?></a>
                                                </td>
                                                <td><?php echo $comment->author ?></td>
                                                <td>
                                                    <?php echo $comment->body ?>
                                                    <div class="action_links">
                                                        <a href="delete_comment.php?id=<?php echo $comment->id; ?>&role=admin" class="delete_link">Delete</a>
                                                    </div>
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