<?php
    $login_status=-1;
    $page_redirect_status=-1;
    if(isset($_GET['message'])){
        if($_GET['message']=="thread_err"){
            $login_status=3;
            $page_redirect_status=1;
        }else if($_GET['message']=="comment_err"){
            $login_status=4;
            $page_redirect_status=2;
        }

    }
    require('class/GetValue.php');
    $loginObj=new GetValue();
    if(isset($_POST['login'])){
        $email=$_POST['email'];
        $password=$_POST['password'];
        $password=md5($password);
        $login_status=$loginObj->loginCheck($email,$password,$status);
    }
?>

<div class="col-md-4 col-md-offset-4">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">Please sign in</h3>
        </div>
        <div class="panel-body">
            <?php
                require_once('class/GetMessage.php');
                $messageObj=new GetMessage();
                if($login_status==1){
                    $messageObj->getSuccessMessage("Logging");
                }else if($login_status==0){
                    $messageObj->getErrorMessage("Username or password is wrong.");
                }else if($login_status==2){
                    $messageObj->getErrorMessage("There was a problem try again later.");
                }else if($login_status==3){

                    $messageObj->getWraningMessage("Please login first to write Thread.");
                }else if($login_status==4){

                    $messageObj->getWraningMessage("Please login first to write Comment.");
                }

            ?>
            <form accept-charset="UTF-8" role="form" method="post">
                <fieldset>
                    <div class="form-group">
                        <input class="form-control" placeholder="E-mail" name="email" type="text">
                    </div>
                    <div class="form-group">
                        <input class="form-control" placeholder="Password" name="password" type="password" value="">
                    </div>
                    <input class="btn btn-lg btn-success btn-block" type="submit" value="Login" name="login">
                </fieldset>
                <br>
                <p>Dont have an account? <a href="?page=registration">Register</a></p>
            </form>
        </div>
    </div>
</div>