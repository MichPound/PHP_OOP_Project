<?php include("includes/header.php"); ?>
<?php include("includes/photo_library_modal.php"); ?>

<?php if(!$session->is_signed_in()){redirect("login.php");}?>

<?php 

    if(!User::find_by_id($_SESSION['user_id'])->is_admin() & $_SESSION['user_id'] != User::find_by_id($_GET['id'])->id){
        redirect("users.php");
    }else{

        if(empty($_GET['id'])){
            redirect("users.php");
        }

        $user_to_update = User::find_by_id($_GET['id']);

        if(isset($_POST['update'])){

            if($user_to_update){
                // $user_to_update->username = $user_to_update->username;
                $user_to_update->first_name = $_POST['first_name'];
                $user_to_update->last_name = $_POST['last_name'];
                $user_to_update->password = $_POST['password'];

                if(User::find_by_id($_SESSION['user_id'])->role == "admin"){
                    $user_to_update->role = $_POST['role'];
                }else{
                    $user_to_update->role = "general";
                }

                if(empty($_FILES['user_image'])){
                    $user_to_update->save();
                    $session->message("The user: {$user_to_update->username} has been updated");
                }else{
                    $user_to_update->set_file($_FILES['user_image']);
                    $user_to_update->upload_photo();
                    $user_to_update->save();
                    $session->message("The user: {$user_to_update->username} has been updated");
                }
                redirect("users.php");
            }

        }

        if(isset($_POST['delete'])){
            $user_to_update->delete();
        }
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
                    User
                    <small><?php echo $user_to_update->username; ?></small>
                </h1>

                <div class="col-md-6 user_image_box">
                    <a href="#" data-toggle="modal" data-target="#photo-library"><img src="<?php echo $user_to_update->image_path_and_placeholder(); ?>" class="img-responsive img-thumbnail" alt=""></a>
                </div>

                <form action="" method="post" enctype="multipart/form-data">                            
                    <div class="col-md-6">
                        <div class="form-group">                                    
                            <input type="file" name="user_image">
                        </div>

                        <?php

                        if(User::find_by_id($_SESSION['user_id'])->role == "admin"){

                            if($user_to_update->role == "admin"){
                                $first = "<option value='admin'>admin</option>";
                                $second = "<option value='general'>general</option>";
                            }else{
                                $first = "<option value='general'>general</option>";
                                $second = "<option value='admin'>admin</option>";
                            }

                            echo "
                            <div class='form-group'>  
                                <label>Role</label>
                                <select class='form-control' id='' name='role'>
                                    {$first}
                                    {$second}
                                </select>
                            </div>
                            ";
                        }

                        ?>

                        <div class="form-group">
                            <label for="first name">First Name</label>
                            <input type="text" name="first_name" class="form-control" value="<?php echo $user_to_update->first_name; ?>">
                        </div>
                        <div class="form-group">
                            <label for="last name">Last Name</label>
                            <input type="text" name="last_name" class="form-control" value="<?php echo $user_to_update->last_name; ?>">
                        </div>
                        <div class="form-group">
                            <label for="password">Current Password</label>
                            <input type="password" name="password" class="form-control">
                        </div>     
                        <div class="form-group">
                            <label for="new_password">New Password</label>
                            <input type="password" name="new_password" class="form-control">
                        </div>     
                        <div class="form-group">   
                            <a id="user-id" href="delete_user.php?id=<?php echo $user_to_update->id; ?>" class="btn btn-danger delete_link"">Delete</a>                             
                            <input type="submit" name="update" class="btn btn-primary pull-right" value="Update">
                        </div>                                                  
                    </div>

                </form>
            
            </div>

        </div>
        <!-- /.row -->

    </div>
    <!-- /.container-fluid -->

</div>
<!-- /#page-wrapper -->

  <?php include("includes/footer.php"); ?>