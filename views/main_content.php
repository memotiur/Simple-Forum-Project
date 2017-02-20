<?php
    include_once('class/GetValue.php');
    $getTopics=new GetValue();
    $result=$getTopics->getAllThreads();
?>
<!--Content Here-->
<?php foreach($result as $res){?>
    <div class="single-thread row">
        <div class="row">
            <h4><strong><a href="#"><?php echo$res['title']?></a></strong></h4>
        </div>
        <div class="row">
            <p><?php echo$res['description'];?></p>
        </div>
        <div class="row">
            <div class="pull-left">
                <i class="fa fa-user" aria-hidden="true"></i> By <a href="#">Motiur Rahaman</a>
                | <i class="fa fa-calendar" aria-hidden="true"></i> Sept 16th, 2012
                | <i class="fa fa-commenting" aria-hidden="true"></i> <a href="#">3 Comments</a>
                | <i class="fa fa-tag" aria-hidden="true"></i> Topic :
                <a href="#"><span class="label label-info"><?php echo$res['topic_name'];?></span></a>
            </div>
            <?php if($login_status==0){?>
                <div class="pull-right">
                    <i class="fa fa-pencil-square" aria-hidden="true"></i> <a href="#"> Edit</a>
                    | <i class="fa fa-trash" aria-hidden="true"></i> <a href="#"> Delete</a>
                </div>
            <?php } ?>
        </div>
    </div>
    <hr>
<?php } ?>
<!-- Content End here-->
