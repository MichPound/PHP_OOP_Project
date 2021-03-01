<?php include("includes/header.php"); ?>

<?php if(!$session->is_signed_in()){redirect("login.php");}?>

<?php 
    
    if(empty($_GET['user_id'])){
        $photos = User::find_by_id($_SESSION['user_id'])->photos();
    }elseif(User::find_by_id($_SESSION['user_id'])->is_admin()){
        $photos = User::find_by_id($_GET['user_id'])->photos();
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
                            Photos
                        </h1>
                        <p class="bd-success"><?php echo $message ?></p>
                        <div class="col-md-12">
                            <table class="table table-hover">
                                <thead>                                
                                    <tr>
                                        <th>Photo</th>
                                        <th>Id</th>
                                        <th>View</th>
                                        <th>File Name</th>
                                        <th>Title</th>
                                        <th>Size</th>
                                        <th>Comments</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($photos as $photo) : ?>
                                    <tr>
                                        <td>
                                            <img src="<?php echo $photo->picture_path(); ?>" class="admin-photo-thumbnail" alt="">
                                            <div class="action_links">
                                                <a href="delete_photo.php?id=<?php echo $photo->id; ?>" class="delete_link">Delete</a>

                                                <!-- <a href="edit_photo.php?id=<?php echo $photo->id; ?>">Edit</a> -->
                                                <?php
                                                if(!empty($_GET['user_id'])){
                                                    echo "<a href='edit_photo.php?id={$photo->id}&role=admin'>Edit</a>";
                                                }else{
                                                    echo "<a href='edit_photo.php?id={$photo->id}'>Edit</a>";
                                                }
                                                ?>

                                                <a href="../gallery.php?id=<?php echo $photo->id; ?>">View</a>
                                            </div>
                                            
                                        </td>
                                        <td><?php echo $photo->id ?></td>
                                        <td>
                                            <?php
                                            if($photo->view == 0){
                                                echo 'Public';
                                            }elseif($photo->view == 1){
                                                echo 'Private';
                                            }
                                            ?>
                                        </td>
                                        <td><?php echo $photo->filename ?></td>
                                        <td><?php echo $photo->title ?></td>
                                        <td><?php echo $photo->size ?></td>
                                        <td>
                                            <?php $comments = Comment::find_the_comments($photo->id); ?>
                                            <a href="comment_photo.php?id=<?php echo $photo->id; ?>"><?php echo count($comments); ?></a>
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