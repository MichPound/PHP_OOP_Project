            <div class="collapse navbar-collapse navbar-ex1-collapse">
                <ul class="nav navbar-nav side-nav">
                    <li>
                        <a href="user_stats.php"><i class="fa fa-fw fa-dashboard"></i>My Statistics</a>
                    </li>
                    <li>
                        <a href="upload.php"><i class="fa fa-fw fa-table"></i>Upload</a>
                    </li>
                    <li>
                        <a href="photos_user.php"><i class="fa fa-fw fa-table"></i>My Photos</a>
                    </li>
                    <li>
                        <a href="comments_user.php"><i class="fa fa-fw fa-edit"></i>My Comments</a>
                    </li>
                
                    <?php

                    $user = USER::find_by_id($_SESSION['user_id']);

                    if($user->is_admin()){
                        echo "
                            <li>
                                <a href='#'>Administration</a>
                            </li>
                            <li>
                                <a href='index.php'><i class='fa fa-fw fa-dashboard'></i>Site Statistics</a>
                            </li>
                            <li>
                                <a href='users.php'><i class='fa fa-fw fa-table'></i>All Users</a>
                            </li>
                            <li>
                                <a href='photos.php'><i class='fa fa-fw fa-table'></i>All Photos</a>
                            </li>
                            <li>
                                <a href='comments.php'><i class='fa fa-fw fa-table'></i>All Comments</a>
                            </li>
                        ";
                    }
                    ?>

                </ul>
            </div>