<?php
    require_once('class/CreateTable.php');
    $db=new Createtable();
    $db->createUserTable();
    $db->createThreadTable();
    $db->createTopicTable();
    $db->createImageTable();
    $db->createCommentTable();
    $registration_status=404;

    require_once('class/SetValue.php');
    $setObj=new SetValue();
    if(isset($_POST['registration'])){
        $full_name=$_POST['full_name'];
        $email=$_POST['email'];
        $password=$_POST['password'];
        $password=md5($password);
        $registration_status=$setObj->setUserDetails($full_name,$email,$password);
    }
?>

<div class="col-md-4 col-md-offset-4">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">Sign Up</h3>
        </div>
        <div class="panel-body">
            <?php
                require_once('class/GetMessage.php');
                $messageObj=new GetMessage();
                if($registration_status==1){
                    $messageObj->getSuccessMessage("Registration Successfully");
                }else if($registration_status==0){
                    $messageObj->getErrorMessage("There was a problem, Try again.");
                }

            ?>
            <form accept-charset="UTF-8" role="form" method="post">
                <fieldset>
                    <div class="form-group">
                        <input class="form-control" placeholder="Fullname" name="full_name" type="text">
                    </div>
                    <div class="form-group">
                        <input class="form-control" placeholder="E-mail" name="email" type="text">
                    </div>
                    <div class="form-group">
                        <input class="form-control" placeholder="Password" name="password" type="password" value="">
                    </div>
                    <input class="btn btn-lg btn-success btn-block" type="submit" value="registration" name="registration">
                </fieldset>
                <br>
                <p>Do you have an account? <a href="?page=login">Login</a></p>
            </form>
        </div>
    </div>
</div>