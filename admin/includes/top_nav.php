<?php
    if($session->is_signed_in()){
        $user = User::find_by_id($_SESSION['user_id']);
        $name = " " . $user->first_name . " " . $user->last_name;
    }else{
        $name = "Undefined";
    }
    

?>

<div class="navbar-header">
    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
    </button>
    <a class="navbar-brand" href="../index.php">Visit Home Page</a>
</div>



<!-- Top Menu Items -->
<ul class="nav navbar-right top-nav">
    <li class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i><?php echo $name ?><b class="caret"></b></a>
        <ul class="dropdown-menu">
            <li>
                <a href="edit_user.php?id=<?php echo $user->id; ?>"><i class="fa fa-fw fa-user"></i> Profile</a>
            </li>
            <li class="divider"></li>
            <li>
                <a href="logout.php"><i class="fa fa-fw fa-power-off"></i> Log Out</a>
            </li>
        </ul>
    </li>
</ul>
