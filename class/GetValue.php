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
                    }else if($status==2){
                        header("Location: index.php");
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
            $thread_table=$dbObj->thread_table.".email";
            $user_table=$dbObj->user_table.".email";
            try {

                $sql = "SELECT * FROM ".$dbObj->thread_table." INNER JOIN
                 ".$dbObj->user_table." ON
                    $thread_table =$user_table ORDER BY thread_id DESC";
                $result = $connection->query($sql);
                $result->execute();
                $threads = $result->fetchall();
                return $threads;

            }catch(Exception $e){
                echo$e->getMessage();
            }

        }
        public function getImages($upload_type,$reference_id){
            $dbObj=new DBConfig();
            $connection=$dbObj->dbConnector();
            try {

                $sql = "SELECT img_ref FROM ".$dbObj->image_table." WHERE upload_type='$upload_type' AND reference_id= $reference_id";
                $result = $connection->query($sql);
                $result->execute();
                $images = $result->fetchall();
                return $images;

            }catch(Exception $e){
                echo$e->getMessage();
            }

        }
        public function getSinglePostComments($thread_id){
            $dbObj=new DBConfig();
            $connection=$dbObj->dbConnector();
            $comment_table_column=$dbObj->comment_table.".user_email";
            $user_table_column=$dbObj->user_table.".email";
            $get_thread_column=$dbObj->comment_table.".thread_id";
            try {

                $sql = "SELECT * FROM ".$dbObj->comment_table." INNER JOIN
                 ".$dbObj->user_table." ON
                    $comment_table_column =$user_table_column WHERE $get_thread_column=$thread_id ORDER BY comment_id DESC";
                $result = $connection->query($sql);
                $result->execute();
                $comments = $result->fetchall();
                return $comments;

            }catch(Exception $e){
                echo$e->getMessage();
            }

        }

        public function getSearchResults($keywords){
            $dbObj=new DBConfig();
            $connection=$dbObj->dbConnector();
            $thread_table_title=$dbObj->thread_table.".title";
            $thread_table_description=$dbObj->thread_table.".description";
            $user_table_full_name=$dbObj->user_table.".full_name";
            try {

                $sql = "SELECT * FROM ".$dbObj->thread_table.",".$dbObj->user_table." WHERE $user_table_full_name LIKE '%$keywords%' OR
                $thread_table_title LIKE '%$keywords%' OR $thread_table_description LIKE '%$keywords%'";
                $result = $connection->query($sql);
                $result->execute();
                $threads = $result->fetchall();print_r($threads);
                return $threads;

            }catch(Exception $e){
                echo$e->getMessage();
            }

        }

        public function test($keywords){
            $dbObj=new DBConfig();
            $connection=$dbObj->dbConnector();
            $thread_table=$dbObj->thread_table.".email";
            $user_table=$dbObj->user_table.".email";
            $thread_table_title=$dbObj->thread_table.".title";
            $thread_table_description=$dbObj->thread_table.".description";
            $user_table_full_name=$dbObj->user_table.".full_name";
            try {

                $sql = "SELECT * FROM ".$dbObj->thread_table." INNER JOIN
                 ".$dbObj->user_table." ON
                    $thread_table =$user_table WHERE $user_table_full_name LIKE '%$keywords%' OR
                $thread_table_title LIKE '%$keywords%' OR $thread_table_description LIKE '%$keywords%'";
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