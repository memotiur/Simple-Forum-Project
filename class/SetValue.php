<?php
    require_once('class/DBConfig.php');

    class SetValue {
        public function setUserDetails($full_name,$email,$password){
            $dbObj=new DBConfig();
            $conn=$dbObj->dbConnector();
            try{
                $stmt=$conn->prepare("INSERT INTO ".$dbObj->user_table."(full_name,email,password)
                VALUES(:full_name,:email,:password)");
                $stmt->bindParam('full_name',$full_name);
                $stmt->bindParam('email',$email);
                $stmt->bindParam('password',$password);
                $stmt->execute();
                return 1;
            }catch (Exception $e){
                return 0;
            }
        }
        public function setTopic($topic_name){
            $dbObj=new DBConfig();
            $conn=$dbObj->dbConnector();
            try{
                $stmt=$conn->prepare("INSERT INTO ".$dbObj->topic_table."(topic_name)
                VALUES(:topic_name)");
                $stmt->bindParam('topic_name',$topic_name);
                $stmt->execute();
                return 1;
            }catch (Exception $e){
                return 0;
            }
        }
        public function setThread($thread_title,$thread_details,$topic,$email){
            $dbObj=new DBConfig();
            $conn=$dbObj->dbConnector();
            try{
                $stmt=$conn->prepare("INSERT INTO ".$dbObj->thread_table."(title,description,topic_name,email)
                VALUES(:title,:description,:topic_name,:email)");
                $stmt->bindParam('title',$thread_title);
                $stmt->bindParam('description',$thread_details);
                $stmt->bindParam('topic_name',$$topic);
                $stmt->bindParam('email',$email);
                $stmt->execute();
                return 1;
            }catch (Exception $e){
                return 0;
            }
        }

    }
?>