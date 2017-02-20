<?php
    require_once('class/DBConfig.php');
    class Createtable {
        public function createUserTable(){
            $dbObj=new DBConfig();
            $conn=$dbObj->dbConnector();
            try {
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $table_create="CREATE TABLE IF NOT EXISTS ".$dbObj->user_table."(
				user_id INT AUTO_INCREMENT ,
				full_name VARCHAR(255),
				email VARCHAR(255) UNIQUE,
				password VARCHAR(255),
				edit_time datetime,
				registration_time datetime NOT NULL DEFAULT NOW(),
				PRIMARY KEY(userId)
			)";
                $conn->exec($table_create);
                echo 'user_table Created Successfully';
            }catch(PDOException $e){
                echo 'Table Not Creted'. $e->getMessage();
            }

        }
        public function createThreadTable(){
            $dbObj=new DBConfig();
            $foregin_table=$dbObj->user_table;
            $conn=$dbObj->dbConnector();
            try {
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $table_create="CREATE TABLE IF NOT EXISTS ".$dbObj->thread_table."(
                    thread_id INT AUTO_INCREMENT ,
                    title VARCHAR(255),
                    description VARCHAR(255),
                    topic_name VARCHAR(255),
                    email VARCHAR(255),
                    update_time datetime,
                    create_time datetime NOT NULL DEFAULT NOW(),
                    PRIMARY KEY(thread_id),
                    FOREIGN KEY (email) REFERENCES $foregin_table(email)
                )";
                $conn->exec($table_create);
                echo $dbObj->thread_table."Created Successfully";
            }catch(PDOException $e){
                echo 'Table Not Creted'. $e->getMessage();
            }

        }
        public function createTopicTable(){
            $dbObj=new DBConfig();
            $foregin_table=$dbObj->user_table;
            $conn=$dbObj->dbConnector();
            try {
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $table_create="CREATE TABLE IF NOT EXISTS ".$dbObj->topic_table."(
                    topic_id INT AUTO_INCREMENT ,
                    topic_name VARCHAR(255),
                    create_time datetime NOT NULL DEFAULT NOW(),
                    PRIMARY KEY(topic_id)
                )";
                $conn->exec($table_create);
                echo $dbObj->topic_table."Created Successfully";
            }catch(PDOException $e){
                echo 'Table Not Creted'. $e->getMessage();
            }

        }

    }
?>