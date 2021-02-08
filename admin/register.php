<?php require_once("includes/header.php"); ?>

<?php 

    $new_user = new User();
    $the_message = "";

    if(isset($_POST['create'])){

        $new_user->username = $_POST['username'];
        $new_user->first_name = $_POST['first_name'];
        $new_user->last_name = $_POST['last_name'];
        $new_user->password = $_POST['password'];
        $new_user->set_file($_FILES['user_image']);
        $new_user->role = "general";

        if(User::user_exists($new_user->username)){
            $the_message = "That username already exists, please choose another!!";
        }else{

            $hash = '$6$';
            $salt = 'rounds=5555$thisisforsomerandomstring$';
            $hash_and_salt = $hash . $salt;
            $new_user->password = crypt($new_user->password, $hash_and_salt);

            if(empty($_FILES['user_image'])){
                $new_user->save();
            }else{
                $new_user->set_file($_FILES['user_image']);
                $new_user->upload_photo();
                $session->message("The user: {$new_user->username} has been added");
                $new_user->save();

                redirect("users.php");
            }

        }

    }
    
?>

        <div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Users
                        </h1>
                        <p class="bg-warning"><?php echo $the_message; ?></p>

                        <form action="" method="post" enctype="multipart/form-data">                            
                            <div class="col-md-6 col-md-offset-3">
                                <div class="form-group">                                    
                                    <input type="file" name="user_image">
                                </div>
                                <div class="form-group">
                                    <label for="username">Username</label>
                                    <input type="text" name="username" class="form-control" value="<?php echo htmlentities($new_user->username); ?>">
                                </div>
                                <div class="form-group">
                                    <label for="first name">First Name</label>
                                    <input type="text" name="first_name" class="form-control" value="<?php echo htmlentities($new_user->first_name); ?>">
                                </div>
                                <div class="form-group">
                                    <label for="last name">Last Name</label>
                                    <input type="text" name="last_name" class="form-control" value="<?php echo htmlentities($new_user->last_name); ?>">
                                </div>
                                <div class="form-group">
                                    <label for="password">Password</label>
                                    <input type="password" name="password" class="form-control" value="<?php echo htmlentities($new_user->password); ?>">
                                </div>        
                                <div class="form-group">                                    
                                    <input type="submit" name="create" class="btn btn-primary pull-right">
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
