<?php

include("includes/header.php"); 

if ($user = User::find_by_id($_GET['user_id'])) {

    $sql = "SELECT * FROM photos WHERE user_id= ";
    $sql .= $database->escape_string($_GET['user_id']);
    $sql .= " AND view=0";

    $photos = Photo::find_by_query($sql);
}

?>

<p class="lead">
    <?php echo $user->first_name . " " . $user->last_name . "'s photos"; ?>
</p>

<div class="row">
    <div class="col-md-12">
        <div class="thunmbails row">
            <?php foreach ($photos as $photo) : ?>
            <div class="col-xs-6 col-md-3">
                <a class="thumbnail" href="gallery.php?id=<?php echo $photo->id; ?>">
                    <img src="admin/<?php echo $photo->picture_path(); ?>" class="img-responsive home_page_photo" alt="">
                </a>
            </div>
            <?php endforeach ?>
        </div>
    </div>
</div>

<?php include("includes/footer.php"); ?>