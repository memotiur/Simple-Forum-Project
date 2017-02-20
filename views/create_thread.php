<?php
    if(empty($_SESSION['login_status'])){
        header("location:index.php?page=login&&message=err");
    }
    require_once('class/SetValue.php');
    $setObj=new SetValue();
    $topic_add_status=404;
    $threadCreateStatus=404;
    if(isset($_POST['create_thread'])){
        $thread_title=$_POST['thread_title'];
        $thread_details=$_POST['thread_details'];
        $std_section = $_POST['std_section'];echo$std_section;
        $email=$_SESSION['email'];
        $threadCreateStatus=$setObj->setThread($thread_title,$thread_details,topic_name,$email);
    }

    //Topic add code
    if(isset($_POST['save_topic'])){
        $topic_name=$_POST['topic'];
        $topic_add_status=$setObj->setTopic($topic_name);
        echo''.$topic_add_status;
    }



?>

<div class="col-md-8 col-md-offset-2">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">Create Thread</h3>
        </div>
        <div class="panel-body">
            <?php
                require_once('class/GetMessage.php');
                $messageObj=new GetMessage();
                if($threadCreateStatus==1){
                    $messageObj->getSuccessMessage("Registration Successfully");
                }else if($threadCreateStatus==0){
                    $messageObj->getErrorMessage("There was a problem, Try again.");
                }
                if($topic_add_status==1){
                    $messageObj->getSuccessMessage("Topic Added Successfully");
                }else if($topic_add_status==0){
                    $messageObj->getErrorMessage("There was a problem, Try again.");
                }

            ?>
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
                                <select class="form-control"  id="std_section" name="std_section">
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

<!--Topic Creation Modal-->
<div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Add Topic</h4>
            </div>
            <div class="modal-body">
                <form accept-charset="UTF-8" role="form" method="post">
                    <div class="form-group">
                        <label for="topic">Topic:</label>
                        <input type="text" class="form-control" id="topic" name="topic" placeholder="Topic Name" required="">
                    </div>

                    <input class="btn btn-md btn-success btn-block" type="submit" value="Create Thread" name="save_topic">
                </form>
            </div>
            <div class="modal-footer">

            </div>

        </div>

    </div>
</div>

<script>
    $("#success-alert").fadeTo(2000, 500).slideUp(500, function(){
        $("#success-alert").slideUp(500);
    });
</script>