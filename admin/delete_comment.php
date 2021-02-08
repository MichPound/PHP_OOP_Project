<?php include("includes/init.php"); ?>

<?php if(!$session->is_signed_in()){redirect("login.php");}?>

<?php

    if(!User::find_by_id($_SESSION['user_id'])->is_admin() & $_SESSION['user_id'] != Comment::find_by_id($_GET['id'])->find_user_id()){
        redirect("comments_user.php");
    }else{

        if(empty($_GET['role'])){
            $direct_to = "comments_user.php";
        }else{
            $direct_to = "users.php";
        }

        if(empty($_GET['id'])){
            redirect($direct_to);
        }

        $comment = Comment::find_by_id($_GET['id']);

        if($comment){
            $comment->delete();
        }

        $session->message("The comment by {$comment->author} has been deleted");
        redirect($direct_to);
    }
?>