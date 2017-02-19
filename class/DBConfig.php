<?php
class DBConfig {
    public $user_table="user_table";
    public $thread_table="thread_table";
    public $topic_table="topic_table";
    public $image_table="image_table";
    public $comment_table="comment_table";
    /*public function dbReturn(){
        $servername = "localhost";
        $dbUser = "root";
        $dbPass = "";
        $dbname="assignment";
        try {
            $conn = new PDO("mysql:host=$servername;$dbname", $dbUser, $dbPass);
            // set the PDO error mode to exception
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "CREATE DATABASE IF NOT EXISTS $dbname";
            // use exec() because no results are returned
            $conn->exec($sql);
            //echo "Database created successfully<br>";
        }
        catch(PDOException $e)
        {
            echo "There was a problem<br>";
            echo $sql . "<br>" . $e->getMessage();
        }
        return $conn;
    }*/

    public function dbConnector(){
        $servername = "localhost";
        $dbUser = "root";
        $dbPass = "";
        $dbname="assignment";
        try {
            $conn = new PDO("mysql:host=$servername;dbname=$dbname", $dbUser, $dbPass);
            // set the PDO error mode to exception
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            #echo "Connected successfully";
            $this->conn = $conn;
        }
        catch(PDOException $e)
        {
            echo "Connection failed: " . $e->getMessage();
        }
        return $conn;
    }

} 