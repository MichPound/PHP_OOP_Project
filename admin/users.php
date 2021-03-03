<?php include("includes/header.php"); ?>

<?php if(!$session->is_signed_in()){redirect("login.php");}?>

<?php if(!User::find_by_id($_SESSION['user_id'])->is_admin()){redirect("user_stats.php");}?>

<?php 
    $users = User::find_all();
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
                            Users                           
                        </h1>
                        <p class="bg-success"><?php echo $message; ?></p>
                        <a href="add_user.php" class="btn btn-primary">Add User</a>
                            
                        <div class="col-md-12">
                            <table class="table table-hover">
                                <thead>                                
                                    <tr>
                                        <th>Id</th>
                                        <th>Photo</th>
                                        <th>Username</th>
                                        <th>Role</th>
                                        <th>First Name</th>
                                        <th>Last Name</th>
                                        <th>Photos</th>
                                        <th>Likes</th>
                                        <th>Comments</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($users as $user) : ?>
                                            <tr>
                                                <td><?php echo $user->id ?></td>
                                                <td><img src="<?php echo $user->image_path_and_placeholder(); ?>" class="admin-user-thumbnail user_image" alt=""></td>
                                                
                                                <td>
                                                    <?php echo $user->username ?>
                                                    <div class="action_links">
                                                        <a href="delete_user.php?role=admin&id=<?php echo $user->id; ?>" class="delete_link">Delete</a>
                                                        <a href="edit_user.php?id=<?php echo $user->id; ?>">Edit</a>
                                                    </div>
                                                </td>
                                                <td><?php echo $user->role ?></td>
                                                <td><?php echo $user->first_name ?></td>
                                                <td><?php echo $user->last_name ?></td>
                                                <td>
                                                    <?php echo $user->count_users_photos() ?>
                                                    <div class="action_links">
                                                        <a href="photos_user.php?user_id=<?php echo $user->id; ?>">View</a>
                                                    </div>
                                                </td>
                                                <td>
                                                    <?php echo $user->count_users_likes() ?>
                                                    <div class="action_links">
                                                        <a href="likes_user.php?user_id=<?php echo $user->id; ?>">View</a>
                                                    </div>
                                                </td>
                                                <td>
                                                    <?php echo $user->count_users_comments() ?>
                                                    <div class="action_links">
                                                        <a href="comments_user.php?user_id=<?php echo $user->id; ?>">View</a>
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