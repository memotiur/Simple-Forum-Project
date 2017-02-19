<?php
        include_once('class/GetValue.php');
        include_once('class/SetValue.php');
        $getTopics=new GetValue();
        $setObj=new SetValue();
        //Image counter=0;
        $counter=0;
        $result=$getTopics->getAllThreads();
        echo(sizeof($result));//Arraysize
        if(isset($_POST['save_comment'])){
        $comment=$_POST['comment'];
        $thread_id=$_POST['get_thread_id'];
        $upload_type="comment";
        $user_email=$_SESSION['email'];echo$user_email;
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

        $desired_dir="img";
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
<!--Content Here-->

<?php foreach($result as $res){?>
<div class="single-thread row">
    <div class="row">
        <h4><strong><?php echo$res['title']?></strong></h4>
    </div>
    <div class="row">
        <p><?php echo$res['description'];?></p>

        <?php
                //Getting Images
                $upload_type="thread";
                $reference_id=$res['thread_id'];//echo$reference_id;
                $images=$getTopics ->getImages($upload_type,$reference_id);
                foreach($images as $img){?>
        <div class="col-sm-4 thread-image">
            <img src="img/<?php echo$img['img_ref']?>" class="" height="150px">
        </div>
        <?php }
                ?>
    </div>
    <hr>
    <div class="row">
        <div class="pull-left">
            <i class="fa fa-user" aria-hidden="true"></i> By <a href="#"><?php echo$res['full_name'];?></a>
            | <i class="fa fa-calendar" aria-hidden="true"></i> <?php if(empty($res['update_time']))echo$res['create_time']; else echo "Last Update: ".$res['update_time'];?>
            | <i class="fa fa-commenting" aria-hidden="true"></i> <a href="#">3 Comments</a>
            | <i class="fa fa-tag" aria-hidden="true"></i> Topic :
            <a href="#"><span class="label label-info"><?php echo$res['topic_name'];?></span></a>
        </div>
        <?php if($_SESSION['email']==$res['email']){?>
        <div class="pull-right">
            <i class="fa fa-pencil-square" aria-hidden="true"></i> <a href="#" data-toggle="modal" data-target="#myModal" data-id="'.$res['thread_id'].'"> Edit</a>
            | <i class="fa fa-trash" aria-hidden="true"></i> <a href="./class/DeleteValues.php?thread_id=<?php echo$res['thread_id'];?>"> Delete</a>
        </div>
        <?php } ?>
    </div>
    <hr>
    <!--Comment here-->
    <div class="row comment">
        <div class="col-md-11 col-md-offset-1 pull-right">
            <form class="form" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <input type="text" class="form-control" id="topic" name="comment" placeholder="comments" required="" width="100%">
                </div>
                <div class="form-group">
                    <input type="hidden" class="form-control" id="topic"value="<?php echo$res['thread_id'];?>" name="get_thread_id" placeholder="comments" required="" width="100%">
                </div>
                <div class="form-group">
                    <input type="file" name="files[]" multiple="" />
                    <button type="submit" class="btn btn-primary btn-xs pull-right" name="save_comment">Comments</button>
                </div>
            </form>
            <div class="comments">
                <?php
                        $singlePostComments=$getTopics->getSinglePostComments($res['thread_id']);
                        foreach($singlePostComments as $comment){
                        ?>
                <div class="row">
                    <div class="">
                        <img class="img-circle"  alt="User"src="http://placehold.it/35x35"><?php echo$comment['full_name'];?>
                    </div>
                    <div class="col-sm-12">
                        <p><?php echo$comment['comment']?></p>
                    </div>

                </div>
                <div class="row">
                    <?php

                            ?>
                    <div class="col-md-4 image-thumbnail">
                        <img src="img/<?php echo$img['img_ref']?>" class="img-thumbnail img-responsive"  width="100" height="100">
                    </div>


                </div>
                <div class="row">
                    <?php if($_SESSION['email']==$res['email']){?>
                    <div class="pull-right">
                        <i class="fa fa-pencil-square" aria-hidden="true"></i> <a href="#" data-toggle="modal" data-target="#myModal" data-id="'.$res['thread_id'].'"> Edit</a>
                        | <i class="fa fa-trash" aria-hidden="true"></i> <a href="./class/DeleteValues.php?thread_id=<?php echo$res['thread_id'];?>"> Delete</a>
                    </div>
                    <?php } ?>
                </div>

            </div>
            <?php
                    }
                    ?>
        </div>
    </div>
    <!--Comment End here-->
</div>
        </div>
<br>


<?php } ?>

<!-- Content End here-->


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
