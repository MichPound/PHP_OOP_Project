<?php include("includes/init.php"); ?>

<?php if(!$session->is_signed_in()){redirect("login.php");}?>

<?php 
    if(!User::find_by_id($_SESSION['user_id'])->is_admin() & $_SESSION['user_id'] != $_GET['id']){
        redirect("user_stats.php");
    }else{

        if(empty($_GET['role']) & empty($_GET['id'])){
            redirect("user_stats.php");
        }else if(empty($_GET['id'])){
            redirect("users.php");
        }

        $user = User::find_by_id($_GET['id']);
        $current_user = User::find_by_id($_SESSION['user_id']);

        if($user){
            $user->delete_photo();
        }

        if($user == $current_user){
            redirect("logout.php");
        }else{
            $session->message("The user: {$user->username} has been deleted");
            redirect("users.php");
        }
    }

?>