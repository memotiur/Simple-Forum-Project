<?php
    require_once('class/DBConfig.php');

    class GetValue {
        public function loginCheck($email,$password,$status){
            $dbObj=new DBConfig();
            $connection=$dbObj->dbConnector();
            try {

                $sql = "SELECT * FROM ".$dbObj->user_table." WHERE email='$email' AND password='$password'";
                $result = $connection->query($sql);
                $result->execute();
                $row_count =$result->rowCount ();
                $value =$result->fetch();
                //print_r($value);
                if( $row_count == 1) {
                    $_SESSION['full_name'] =$value['full_name'];
                    $_SESSION['email'] = $email; //echo$_SESSION['user'];
                    $_SESSION['pass'] = $password; //echo$_SESSION['pass'];
                    $_SESSION['login_status'] = 1; //echo$_SESSION['pass'];
                    if($status==1){
                        header("Location: index.php?page=create_thread");
                    }else
                        header("Location: index.php");
                        $login_status=1;
                }else {
                    $login_status=2;
                }

            }catch(Exception $e){
                $login_status=0;
            }
            return $login_status;
        }

        public function getAllTopics(){
            $dbObj=new DBConfig();
            $connection=$dbObj->dbConnector();
            try {

                $sql = "SELECT topic_name FROM ".$dbObj->topic_table;
                $result = $connection->query($sql);
                $result->execute();
                $topics = $result->fetchall();
                return $topics;

            }catch(Exception $e){
                echo$e->getMessage();
            }

        }
        public function getAllThreads(){
            $dbObj=new DBConfig();
            $connection=$dbObj->dbConnector();
            try {

                $sql = "SELECT * FROM ".$dbObj->thread_table;
                $result = $connection->query($sql);
                $result->execute();
                $threads = $result->fetchall();
                return $threads;

            }catch(Exception $e){
                echo$e->getMessage();
            }

        }

    }
?>