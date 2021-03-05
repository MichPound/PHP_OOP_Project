<?php

    // echo "<h1>comparator</h1>";

    if(empty($_POST['comparator'])){
        $comparator = 'author_comparator';
    }else{
        $comparator = $_POST['comparator'];
    }

    usort($photos, $comparator);

    load_images($page, $items_per_page, $items_total_count, $photos);



// load_images($page, $items_per_page, $items_total_count, $photos);


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