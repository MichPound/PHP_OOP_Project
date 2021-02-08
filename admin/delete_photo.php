<?php include("includes/init.php"); ?>

<?php if(!$session->is_signed_in()){redirect("login.php");}?>

<?php

    if(!User::find_by_id($_SESSION['user_id'])->is_admin() & $_SESSION['user_id'] != Photo::find_by_id($_GET['id'])->user_id){
        redirect("photos_user.php");
    }else{

        if(empty($_GET['role'])){
            $direct_to = "photos_user.php";
        }else{
            $direct_to = "photos.php";
        }

        if(empty($_GET['id'])){
            redirect($direct_to);
        }

        $photo = Photo::find_by_id($_GET['id']);

        if($photo){
            $photo->delete_photo();
        }

        $session->message("The photo: {$photo->title} has been deleted");
        redirect($direct_to);
    }

?>