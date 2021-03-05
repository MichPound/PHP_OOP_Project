<?php

if($session->is_signed_in()){
    $user = User::find_by_id($_SESSION['user_id']);
    $name = " " . $user->first_name . " " . $user->last_name;
}else{
    $name = "";
}

?>

<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    
        <div class="navbar-header">
            <a class="navbar-brand" href="index.php?page=1">Gallery</a>
            <a class="navbar-brand" href="admin/user_stats.php">Home</a>
        </div>
    
    <?php if($session->is_signed_in()) : ?>
    <ul class="nav navbar-right top-nav">
        <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i><?php echo $name ?><b class="caret"></b></a>
            <ul class="dropdown-menu">
                <li class="divider"></li>
                <li>
                    <a href="/gallery/admin/logout.php"><i class="fa fa-fw fa-power-off"></i> Log Out</a>
                </li>
            </ul>
        </li>
    </ul>
    <?php endif ?>
</nav>
