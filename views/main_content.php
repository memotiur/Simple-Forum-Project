<?php
    include_once('class/GetValue.php');
    include_once('class/SetValue.php');
    include_once('class/GetMessage.php');
    $getTopics=new GetValue();
    $setObj=new SetValue();
    //Image counter=0;
    $counter=0;
    $result=$getTopics->getAllThreads();
    //Search Button
    if(isset($_POST['serach_keyword'])){
        $keywords=$_POST['serach_keyword'];
        $result=$getTopics->getSearchResults($keywords);
    }
    if(empty($result)){
        $getMessage=new GetMessage();
        $getMessage->getWraningMessage("Result is empty");
    }
    //echo(sizeof($result));//Arraysize
    if(isset($_POST['save_comment'])){
        if(empty($_SESSION['login_status'])){
            $thread_id=$_POST['get_thread_id'];
            header("location:index.php?page=login&&message=comment_err&&thread_id=$thread_id");
        }
        $comment=$_POST['comment'];
        $thread_id=$_POST['get_thread_id'];
        $upload_type="comment";
        $user_email=$_SESSION['email'];//echo$user_email;
        $last_post_id=$setObj->setComment($comment,$thread_id,$user_email);//echo$last_post_id;
        if(isset($_FILES['files'])){
            $upload_type="comment";
            $errors= array();
            foreach($_FILES['files']['tmp_name'] as $key => $tmp_name ){
                $time=date('s');
                $file_name = $time."_".$_FILES['files']['name'][$key];
                $file_size =$_FILES['files']['size'][$key];
                $file_tmp =$_FILES['files']['tmp_name'][$key];
                $file_type=$_FILES['files']['type'][$key]; //echo$file_type."<br>";

                if($file_size > 2097152){
                    $messageObj->getWraningMessage("File size must be less than 2 MB");
                    $errors[]='';
                }

                $desired_dir="images";
                if(empty($errors)==true){
                    if($file_type != "image/jpg" && $file_type != "image/png" && $file_type != "image/jpeg" && $file_type != "image/gif" ){
                        if($counter!=0){
                            $messageObj->getWraningMessage("File type is not Image");
                        }

                    }else{
                        $image_upload_stat=$setObj->setImage($file_name,$upload_type,$last_post_id); //upload type is comment or thread id
                        //echo'Success';
                    }
                    if(is_dir($desired_dir)==false){
                        mkdir("$desired_dir", 0700);		// Create directory if it does not exist
                    }
                    if(is_dir("$desired_dir/".$file_name)==false){
                        move_uploaded_file($file_tmp,$desired_dir."/".$file_name);
                    }else{									//rename the file if another one exist
                        $new_dir=$desired_dir."/".$file_name;
                        rename($file_tmp,$new_dir) ;
                    }
                    //mysql_query($query);
                }else{
                    print_r($errors);
                }
                $counter++;
            }
            if(empty($error)){
                //echo "Success";
            }
        }else{
            echo'Nothing';
        }

    }

?>

<div class="col-md-8 col-md-offset-2">
    <?php foreach($result as $thread){ ?>
    <div class="single-thread">
        <div class="row">
            <div class="col-md-2">
                <div class="row">
                    <img class="img-circle"  alt="User"src="http://placehold.it/50x50">
                </div>
                <div class="row">
                    <h5><?php echo$thread['full_name'];?></h5>
                </div>
                <div class="row">
                    <p style="font-size: 12px;"><?php if(empty($thread['update_time']))echo$thread['create_time']; else echo "Last Update: ".$thread['update_time'];?></p>
                </div>
            </div>
            <div class="col-md-10">
                <div class="row">
                    <h4><strong><?php echo$thread['title'];?></strong></h4>
                    <p><?php echo$thread['description'];?></p>
                </div>
                <div class="row col-sm-12">
                    <?php
                        //Getting Images
                        $upload_type="thread";
                        $reference_id=$thread['thread_id'];//echo$reference_id;
                        $images=$getTopics ->getImages($upload_type,$reference_id);
                        foreach($images as $img){
                    ?>
                   <div class="col-sm-6 single-image">
                       <img src="images/<?php echo$img['img_ref']?>" class="img-rounded" height="200" width="100%">
                   </div>
                    <?php } ?>
                </div>

            </div>

        </div>
        <hr>
        <div class="row col-sm-12">
            <div class="col-sm-6 pull-left">
                <i class="fa fa-tag" aria-hidden="true"></i> Topic :
                <a href="#"><span class="label label-info"><?php echo$thread['topic_name'];?> <?php //echo$res['topic_name'];?></span></a>
                <?php
                    $singlePostComments=$getTopics->getSinglePostComments($thread['thread_id']);

                ?>
                | <i class="fa fa-commenting" aria-hidden="true"></i> <a href="#"><?php echo(sizeof($singlePostComments));?> Comments</a>
            </div>
            <div class="col-sm-6 pull-right">
                <?php
                    if(!empty($_SESSION['email'])) {
                        if ($_SESSION['email'] == $thread['email']) {
                            ?>
                            <div class="pull-right">
                                <i class="fa fa-pencil-square" aria-hidden="true"></i> <a href="#" data-toggle="modal" data-target="#myModal" data-value_id="<?php echo $thread['thread_id']; ?>">Edit</a>
                                | <i class="fa fa-trash" aria-hidden="true"></i> <a
                                    href="./class/DeleteValues.php?thread_id=<?php echo $thread['thread_id']; ?>">
                                    Delete</a>
                            </div>
                        <?php
                        }
                    }
                ?>


            </div>
        </div>
        <br>
        <hr>
        <!--Comment Area-->
        <div class="row comment">
            <div class="col-md-10 pull-right">
                <form class="form" method="post" enctype="multipart/form-data">
                    <div class="row">
                        <div class="form-group">
                            <input type="text" class="form-control" id="topic" name="comment" placeholder="comments" required="" width="100%">
                        </div>
                        <div class="form-group">
                            <input type="hidden" class="form-control" id="topic"value="<?php echo$thread['thread_id'];?>" name="get_thread_id" placeholder="comments" required="" width="100%">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group">
                            <div class="col-sm-6">
                                <input type="file" name="files[]" multiple="" />
                            </div>
                            <div class="col-sm-6">
                                <button type="submit" class="btn btn-primary btn-xs pull-right" name="save_comment">Comments</button>
                            </div>
                        </div>
                    </div>
                </form>
                <br>
                <?php  foreach($singlePostComments as $comment){?>
                <div style="background: #ffffff;height: 1px;margin-bottom: 4px;margin-top: 5px;"></div>
                <div class="row">
                    <div class="col-sm-2">
                        <img class="img-circle"  alt="User"src="http://placehold.it/30x30">
                        <p><?php echo$comment['full_name']?></p>
                        <p style="font-size: 12px;"><?php echo$comment['create_time'];?></p>
                    </div>
                    <div class="col-sm-10">
                        <div class="row">
                            <p><?php echo$comment['comment'];?></p>
                        </div>
                        <div class="row">
                            <?php
                                $comment_image=$getTopics->getImages("comment",$comment['comment_id']);
                                foreach($comment_image as $com_img){
                            ?>
                            <div class="col-sm-6 single-image">
                                <img src="images/<?php echo$com_img['img_ref']?>" class="img-rounded" height="200" width="100%">
                            </div>
                            <?php } ?>
                        </div>
                        <div class="row">
                            <?php
                            if(!empty($_SESSION['email'])) {
                                if ($_SESSION['email'] == $comment['email']) {
                                    ?>
                                    <div class="pull-right">
                                        <i class="fa fa-pencil-square" aria-hidden="true"></i> <a href="#" data-toggle="modal" data-target="#myModal" data-id="'.$res['thread_id'].'">Edit</a>
                                        | <i class="fa fa-trash" aria-hidden="true"></i> <a
                                            href="./class/DeleteValues.php?comment_id=<?php echo $comment['comment_id']; ?>">
                                            Delete</a>
                                    </div>
                                <?php
                                }
                            }
                            ?>

                        </div>

                    </div>
                </div>
                <?php } ?>
            </div>
        </div>
    </div>

    <?php } ?>
</div>


<!--Edit Modal-->

<div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Create Thread</h3>
                    </div>
                    <div class="panel-body">
                        <form accept-charset="UTF-8" role="form" method="post" class="form-horizontal">
                            <fieldset>
                                <div class="form-group">
                                    <label class="control-label col-sm-2" for="email">Thread Title:</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="thread_title" placeholder="thread_title" name="thread_title" required="">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-sm-2" for="pwd">thread_details:</label>
                                    <div class="col-sm-10">
                                        <textarea rows="5" class="form-control" id="thread_details" placeholder="thread_details" name="thread_details" required=""></textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-sm-2" for="pwd">Topic:</label>
                                    <div class=" col-sm-10">
                                        <div class="form-group select-topic" style="padding: 0;margin: 0">
                                            <select class="form-control"  id="topic_name" name="topic_name">
                                                <?php
                                                include_once('class/GetValue.php');
                                                $getTopics=new GetValue();
                                                foreach($getTopics->getAllTopics() as $result){?>
                                                    <option value="<?php echo$result['topic_name'];?>"><?php echo$result['topic_name'];?></option>
                                                <?php }
                                                ?>

                                            </select>
                                        </div>
                                        <i class="fa fa-plus-circle" aria-hidden="true" ></i> <a href="#" data-toggle="modal" data-target="#myModal">Add New Topic</a>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-offset-2 col-sm-10">
                                        <input class="btn btn-md btn-success btn-block" type="submit" value="Create Thread" name="create_thread">
                                    </div>
                                </div>

                            </fieldset>
                            <br>
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal-footer">

            </div>

        </div>

    </div>
</div>

<script>
    $('#myModal').on('show.bs.modal', function(e) {
        var yourparameter = e.relatedTarget.dataset.value_id;
        alert(yourparameter);
    });
</script>