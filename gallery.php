<?php include("includes/header.php"); ?>

<?php

require_once("admin/includes/init.php");

if(empty($_GET['id'])){
    redirect("index.php");
}

$photo = Photo::find_by_id($_GET['id']);

$user = User::find_by_id($photo->user_id);

if(isset($_POST['submit'])){
    $author = trim($_POST['author']);
    $body = trim($_POST['body']);

    $new_comment = Comment::create_comment($photo->id, $author, $body);

    if($new_comment && $new_comment->save()){            
        redirect("gallery.php?id={$photo->id}");
    }else{
        $message = "There was some problems saving";
    }
}else{
    $author = "";
    $body = "";
}

$comments = Comment::find_the_comments($photo->id);

?>

<div class="row">
    <div class="col-lg-12">
    
        <!-- Title -->
        <h1><?php echo $photo->title; ?></h1>

        <!-- Author -->
        <p class="lead">
            <!-- by <a href="#">Start Bootstrap</a> -->
            <a href="user_public.php?user_id=<?php echo $user->id; ?>"><?php echo "by " . $user->first_name . " " . $user->last_name; ?></a>
        </p>

        <hr>

        <!-- Date/Time -->
        <!-- <p><span class="glyphicon glyphicon-time"></span> Posted on August 24, 2013 at 9:00 PM</p> -->

        <!-- <hr> -->

        <!-- Preview Image -->
        <img class="img-responsive" src="admin/<?php echo $photo->picture_path(); ?>" alt="<?php echo $photo->alternate_text; ?>">

        <hr>

        <!-- Post Content -->
        <p class="lead"><?php echo $photo->caption; ?></p>
        <p><?php echo $photo->description; ?></p>
        
        <hr>

        <!-- Comments Form -->
        <div class="well">
            <h4>Leave a Comment:</h4>
            <form role="form" method="post">
                <div class="form-group">
                    <label for="">Author</label>
                    <input type="text" name="author" class="form-control">
                </div>
                <div class="form-group">
                    <textarea name="body" class="form-control" rows="3"></textarea>
                </div>
                <button type="submit" name="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>

        <hr> 

        <!-- Comments -->
        <?php foreach ($comments as $comment) : ?>                
        <div class="media">
            <a class="pull-left" href="#">
                <img class="media-object" src="http://placehold.it/64x64" alt="">
            </a>
            <div class="media-body">
                <h4 class="media-heading"><?php echo $comment->author; ?></h4>
                <?php echo $comment->body; ?>
            </div>
        </div>      
        <?php endforeach ?>

    </div>

</div>
<!-- /.row -->

<!-- Blog Sidebar Widgets Column -->
<!-- <div class="col-md-4">
    <?php //include("includes/sidebar.php"); ?>
</div> -->

<?php include("includes/footer.php"); ?>
