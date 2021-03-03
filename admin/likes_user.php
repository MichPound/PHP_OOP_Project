<?php include("includes/header.php"); ?>

<?php if(!$session->is_signed_in()){redirect("login.php");}?>

<?php 

    if(empty($_GET['user_id'])){
        $likes = User::find_by_id($_SESSION['user_id'])->likes();
    }elseif(User::find_by_id($_SESSION['user_id'])->is_admin()){
        $likes = User::find_by_id($_GET['user_id'])->likes();
    }else{
        redirect("user_stats.php");
    }

?>

        <!-- Navigation -->
        <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
            <!-- Brand and toggle get grouped for better mobile display -->
            <?php include("includes/top_nav.php"); ?>
            <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
            <?php include("includes/side_nav.php"); ?>
            <!-- /.navbar-collapse -->
        </nav>

        <div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Likes                       
                        </h1>
                        <p class="bd-success"><?php echo $message; ?></p>
                        <div class="col-md-12">
                            <table class="table table-hover">
                                <thead>                                
                                    <tr>
                                        <th>Id</th>
                                        <th>Photo</th>
                                        <th>User</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($likes as $like) : ?>
                                            <tr>
                                                <td><?php echo $like->id ?></td>
                                                <td>
                                                    <?php
                                                    $photo = Photo::find_by_id($like->photo_id);

                                                    if(empty($photo->title)){
                                                        $title = $photo->filename;
                                                    }else{
                                                        $title = $photo->title;
                                                    }
                                                    ?>
                                                    <a href="../gallery.php?id=<?php echo $like->photo_id; ?>"><?php echo $title; ?></a>
                                                </td> 
                                                <td>
                                                    <?php
                                                    $user = User::find_by_id($like->user_id);
                                                    $name = $user->first_name . ' ' . $user->last_name;
                                                    ?>
                                                    <a href="../user_public.php?user_id=<?php echo $user->id; ?>"><?php echo $name; ?></a>
                                                </td>                             
                                            </tr>    
                                    <?php endforeach ?>                            
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
                <!-- /.row -->

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

  <?php include("includes/footer.php"); ?>