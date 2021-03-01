<?php

require_once("includes/header.php"); 

$new_user = new User();
$the_message = "";

if(isset($_POST['create'])){

    $new_user->username = $_POST['username'];
    $new_user->first_name = $_POST['first_name'];
    $new_user->last_name = $_POST['last_name'];
    $new_user->password = $_POST['password'];
    $new_user->set_file($_FILES['user_image']);
    $new_user->role = "general";

    if($new_user->username == "" || $new_user->password == ""){
        $the_message = "Please completely fill out the register form!!";
    }elseif(User::user_exists($new_user->username)){
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

if(isset($_POST['login'])){
    redirect("login.php");
}
    
?>

<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <?php include("includes/top_nav.php"); ?>
</nav>
       
<div class="col-md-4 col-md-offset-3">

    <h4 class="bg-danger"><?php echo $the_message; ?></h4>

    <form id="register-id" action="" method="post" enctype="multipart/form-data">         
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
            <input type="submit" name="create" value="Register" class="btn btn-primary">
            <input type="submit" name="login" value="Login" class="btn">
        </div>    
    </form>

</div>