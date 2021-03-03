<?php include("includes/header.php"); ?>

<?php

require_once("admin/includes/init.php");

if(empty($_GET['id'])){
    redirect("index.php");
}

$photo = Photo::find_by_id($_GET['id']);

$user = User::find_by_id($photo->user_id);

if(isset($_POST['submit'])){

    if($session->is_signed_in()){
        $user = User::find_by_id($_SESSION['user_id']);
        $author = " " . $user->first_name . " " . $user->last_name;
    }else{
        $author = trim($_POST['author']);
    }

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

if(isset($_POST['liked'])){

    if(!Like::find_like($photo->id, $_SESSION['user_id'])){
    
        $photo->increment_likes();

        $like = new Like();
        $like->photo_id = $_POST['photo_id'];
        $like->user_id = $_POST['user_id'];

        $like->create();
    }

}

if(isset($_POST['unliked'])){

    if(Like::find_like($photo->id, $_SESSION['user_id'])){
    
        $photo->decrement_likes();

        $like = Like::find_like($_POST['photo_id'], $_POST['user_id']);

        $like->delete();
    }

}

?>

<div class="row">
    <div class="col-lg-12">
    
        <h1><?php echo $photo->title; ?></h1>

        <p class="lead">
            <a href="user_public.php?user_id=<?php echo $user->id; ?>"><?php echo "by " . $user->first_name . " " . $user->last_name; ?></a>
        </p>

        <hr>

        <img class="img-responsive" src="admin/<?php echo $photo->picture_path(); ?>" alt="<?php echo $photo->alternate_text; ?>">

        <hr>
        
        <?php if($session->is_signed_in() && !Like::find_like($photo->id, $_SESSION['user_id'])) : ?>

            <div class="row">
                <p>
                <a href="" class="like"><span class="glyphicon glyphicon-thumbs-up"></span> Like</a>
                : <?php echo $photo->likes; ?>
                </p>
            </div>

        <?php elseif($session->is_signed_in() && Like::find_like($photo->id, $_SESSION['user_id'])) : ?>

            <div class="row">
                <p>
                <a href="" class="unlike">  <span class="glyphicon glyphicon-thumbs-down"></span> Unlike</a>
                : <?php echo $photo->likes; ?>
                </p>
            </div>

        <?php else : ?>

            <div class="row">
                <h4>Please login/register to like photos</h4>
            </div>

        <?php endif; ?>

        <hr>

        <p class="lead"><?php echo $photo->caption; ?></p>

        <p><?php echo $photo->description; ?></p>
        
        <hr>

        <div class="well">
            <h4>Leave a Comment:</h4>
            <form role="form" method="post">

                <?php if(!$session->is_signed_in()) : ?>
                <div class="form-group">
                    <label for="">Author</label>
                    <input type="text" name="author" class="form-control">
                </div>
                <?php endif; ?>

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

<?php include("includes/footer.php"); ?>

<script>
    // $(docmument).ready(function(){

        var post_id = <?php echo $photo->id; ?>;
        var user_id = <?php echo $_SESSION['user_id']; ?>;

        $('.like').click(function(){
            $.ajax({
                url:"/gallery/gallery.php?id=<?php echo $photo->id; ?>",
                type: 'post',
                data: {
                    'liked': 1,
                    'photo_id': post_id,
                    'user_id': user_id
                }
            });
        });

        $('.unlike').click(function(){
            $.ajax({
                url:"/gallery/gallery.php?id=<?php echo $photo->id; ?>",
                type: 'post',
                data: {
                    'unliked': 1,
                    'photo_id': post_id,
                    'user_id': user_id
                }
            });
        });
    // });
</script>