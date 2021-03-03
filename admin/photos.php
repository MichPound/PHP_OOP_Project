<?php include("includes/header.php"); ?>

<?php if(!$session->is_signed_in()){redirect("login.php");}?>

<?php if(!User::find_by_id($_SESSION['user_id'])->is_admin()){redirect("photos_user.php");}?>

<?php 
    $photos = Photo::find_all();
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
                        <p class="bg-success"><?php echo $message ?></p>
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
                                        <th>Likes</th>
                                        <th>Comments</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($photos as $photo) : ?>
                                    <tr class='clickable-row' data-href="../gallery.php?id=<?php echo $photo->id; ?>">
                                        <td>
                                            <img src="<?php echo $photo->picture_path(); ?>" class="admin-photo-thumbnail" alt="">

                                            <div class="action_links">
                                                <a href="delete_photo.php?id=<?php echo $photo->id; ?>&role=admin" class="delete_link">Delete</a>
                                                <a href="edit_photo.php?id=<?php echo $photo->id; ?>">Edit</a>
                                                <!-- <a href="../gallery.php?id=<?php echo $photo->id; ?>">View</a> -->
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
                                            <?php $likes = Like::find_the_likes($photo->id); ?>
                                            <a href="like_photo.php?id=<?php echo $photo->id; ?>"><?php echo count($likes); ?></a>
                                        </td>
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