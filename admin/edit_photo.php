<?php include("includes/header.php"); ?>

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

        if(isset($_POST['update'])){

            if($photo){
                $photo->view = $_POST['view'];
                $photo->title = $_POST['title'];
                $photo->caption = $_POST['caption'];
                $photo->alternate_text = $_POST['alternate_text'];
                $photo->description = $_POST['description'];

                $photo->save();
                redirect($direct_to);
                $session->message("The photo: {$photo->title} has been updated");
            }
        }
        
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
                            Photos
                            <small>Subheading</small>
                        </h1>

                        <form action="" method="post">                            
                            <div class="col-md-8">
                                <?php
                                if($photo->view == 0){
                                    $first = "<option value=0>Public</option>";
                                    $second = "<option value=1>Private</option>";
                                }else{
                                    $first = "<option value=1>Private</option>";
                                    $second = "<option value=0>Public</option>";
                                }

                                echo "
                                <div class='form-group'>  
                                    <label>View (Anyone can see public but only other registered users can see private)</label>
                                    <select class='form-control' id='' name='view'>
                                        {$first}
                                        {$second}
                                    </select>
                                </div>
                                ";

                                ?>
                                <div class="form-group">
                                    <label for="caption">Title</label>
                                    <input type="text" name="title" class="form-control" value="<?php echo $photo->title; ?>">
                                </div>
                                <div class="form-group">
                                    <a href="#" class="thumbnail"> <img src="<?php echo $photo->picture_path(); ?>" alt=""></a>
                                </div>
                                <div class="form-group">
                                    <label for="caption">Caption</label>
                                    <input type="text" name="caption" class="form-control" value="<?php echo $photo->caption; ?>">
                                </div>
                                <div class="form-group">
                                    <label for="caption">Alternte Text</label>
                                    <input type="text" name="alternate_text" class="form-control" value="<?php echo $photo->alternate_text; ?>">
                                </div>
                                <div class="form-group">
                                    <label for="caption">Description</label>
                                    <textarea class="form-control" name="description" id="" cols="30" rows="10"><?php echo $photo->description; ?></textarea>
                                </div>                            
                            </div>

                        

                            <div class="col-md-4" >
                                <div  class="photo-info-box">
                                    <div class="info-box-header">
                                        <h4>Save <span id="toggle" class="glyphicon glyphicon-menu-up pull-right"></span></h4>
                                    </div>
                                    <div class="inside">
                                        <div class="box-inner">
                                            <p class="text ">
                                                Photo Id: <span class="data photo_id_box"><?php echo $photo->id; ?></span>
                                            </p>
                                            <p class="text">
                                                Filename: <span class="data"><?php echo $photo->filename; ?></span>
                                            </p>
                                            <p class="text">
                                                File Type: <span class="data"><?php echo $photo->type; ?></span>
                                            </p>
                                            <p class="text">
                                                File Size: <span class="data"><?php echo $photo->size; ?></span>
                                            </p>
                                        </div>
                                        <div class="info-box-footer clearfix">
                                            <div class="info-box-update pull-right ">
                                                <input type="submit" name="update" value="Update" class="btn btn-primary btn-lg ">
                                            </div>   
                                        </div>
                                    </div>          
                                </div>
                            </div>
                        </form>
                    
                    </div>

                </div>
                <!-- /.row -->

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

  <?php include("includes/footer.php"); ?>