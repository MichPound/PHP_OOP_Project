<?php include("includes/header.php"); ?>

<?php if(!$session->is_signed_in()){redirect("login.php");}?>

<?php $users = User::find_all(); ?>

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
                            All Users                           
                        </h1>
                            
                        <div class="col-md-6">
                            <table class="table table-hover">
                                <thead>                                
                                    <tr>
                                        <th>Photo</th>
                                        <th>Username</th>
                                        <th>Name</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($users as $user) : ?>
                                            <tr class='clickable-row' data-href='../user_public.php?user_id=<?php echo $user->id; ?>' >
                                                <td><img src="<?php echo $user->image_path_and_placeholder(); ?>" class="admin-user-thumbnail user_image" alt=""></td>
                                                
                                                <td>
                                                    <?php echo $user->username ?>
                                                    <div class="action_links">
                                                        <a href="../user_public.php?user_id=<?php echo $user->id;?>&view=public">Public</a>
                                                        <a href="../user_public.php?user_id=<?php echo $user->id;?>&view=private">Private</a>
                                                    </div>
                                                </td>

                                                <td> <?php echo $user->first_name . ' ' . $user->last_name; ?> </td>

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