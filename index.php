<?php include("includes/header.php"); ?>

<?php

$page = !empty($_GET['page']) ? (int)$_GET['page'] : 1;

$items_per_page = 12;

if(!$session->is_signed_in()){
    $items_total_count = Photo::count_all_public(); 
}else{
    $items_total_count = Photo::count_all(); 
}

$paginate = new Paginate($page, $items_per_page, $items_total_count);

$sql = "SELECT * FROM photos ";
$sql .= "WHERE view=0 ";
if($session->is_signed_in()){
    $sql .= " OR view=1 ";
}
// $sql .= "LIMIT {$items_per_page} ";
// $sql .= "OFFSET {$paginate->offset()}";

function author_comparator($object1, $object2){
    $user1 = User::find_by_id($object1->user_id);
    $user2 = User::find_by_id($object2->user_id);

    if($user1->first_name == $user2->first_name){
        return 0;
    }
    return ($user1->first_name < $user2->first_name) ? -1 : 1;
}

function comments_comparator($object1, $object2){
    $comments1 = Comment::find_the_comments($object1->id);
    $comments2 = Comment::find_the_comments($object2->id);

    if(count($comments1) == count($comments2)){
        return 0;
    }
    return (count($comments1) > count($comments2)) ? -1 : 1;
}

function likes_comparator($object1, $object2){
    $likes1 = Like::find_the_likes($object1->id);
    $likes2 = Like::find_the_likes($object2->id);

    if(count($likes1) == count($likes2)){
        return 0;
    }
    return (count($likes1) > count($likes2)) ? -1 : 1;
}

$photos = Photo::find_by_query($sql);





?>
<div class="col-md-2">
    <!-- <form action="" method="post">
        <div class='form-group'>   -->
            <label>Filter</label>
            <select class='filter' name='filter'>
                <option value='author_comparator'>Author</option>
                <option value='likes_comparator'>Likes</option>
                <option value='comments_comparator'>Comments</option>
            </select>
        <!-- </div>
    </form> -->
</div>

<div class="row">
    <!-- Blog Entries Column -->
    <div class="col-md-12">
        <div class="thunmbails row">

        <!-- <div id="div1">
        <?php// include("filtered.php"); ?>
        </div> -->

        <?php
        if(isset($_POST['filtered'])){
            $comparator = $_POST['comparator'];
            usort($photos, $comparator);
        
            load_images($page, $items_per_page, $items_total_count, $photos);
        }
        ?>


        <div id="div1">
        <?php

        load_images($page, $items_per_page, $items_total_count, $photos);

        function load_images($page, $items_per_page, $items_total_count, $photos){

        for($i = ($page-1)*$items_per_page; $i<=(($items_per_page*$page)-1) && $i <=$items_total_count-1; $i++){
            echo "
            <div class='col-xs-6 col-md-3'>
                <a class='thumbnail' href='gallery.php?id={$photos[$i]->id}'>
                    <img src='admin/{$photos[$i]->picture_path()}' class='img-responsive home_page_photo'>
                </a>
            </div>
            ";
        }
        }


        ?>

        </div>





            <?php// for($i = ($page-1)*$items_per_page; $i<=(($items_per_page*$page)-1) && $i <=$items_total_count-1; $i++) : ?>
            <div class="col-xs-6 col-md-3">
                <!-- <a class="thumbnail" href="gallery.php?id=<?php// echo $photos[$i]->id; ?>"> -->
                    <!-- <img src="admin/<?php// echo $photos[$i]->picture_path(); ?>" class="img-responsive home_page_photo" alt=""> -->
                </a>
            </div>
            <?php// endfor; ?>

        </div>

        <div class="row">
            <ul class="pager">

                <?php
                    if($paginate->page_total() > 1){
                        if($paginate->has_next()){
                            echo "<li class='next'><a href='index.php?page={$paginate->next()}'>Next</a></li>";
                        }

                        for ($i=1; $i<=$paginate->page_total(); $i++) { 
                            if ($i == $paginate->current_page) {
                                echo "<li class='active'><a href='index.php?page={$i}'>{$i}</a></li>";
                            }else{
                                echo "<li><a href='index.php?page={$i}'>{$i}</a></li>";
                            }
                        }

                        if($paginate->has_previous()){
                            echo "<li class='previous'><a href='index.php?page={$paginate->previous()}'>Previous</a></li>";
                        }
                    }
                ?>
            </ul>
        </div>

    </div>

</div>
<!-- /.row -->

<?php include("includes/footer.php"); ?>

<script>
    $('.filter').change(function(){

        var data_string=$(this).val();

        $.ajax({
            url:"/gallery/index.php?page=<?php echo $page; ?>",
            type: 'POST',
            data: {
                'filtered': 1,
                'comparator': data_string,
            }
        });

        $("#div1").show();//reload??
    });
</script>
