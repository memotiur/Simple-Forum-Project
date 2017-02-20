<?php
	ob_start();
    require_once('DBConfig.php');
    if(isset($_GET['thread_id'])){
        $thread_id=$_GET['thread_id'];
        $delObj=new DeleteValues();
        $delObj->deleteThread($thread_id);

    }else if($_GET['comment_id']){
        $comment_id=$_GET['comment_id'];
        $delObj=new DeleteValues();
        $delObj-> deleteComment($comment_id);
    }
    class DeleteValues {
        public function deleteThread($thread_id){
            $dbObj=new DBConfig();
            $sql="SELECT img_ref FROM  ".$dbObj->image_table." WHERE  reference_id='$thread_id' AND upload_type='thread'";
            $result=$dbObj->dbConnector()->query($sql);
            $result->execute();
            $images = $result->fetchall();
            //print_r($images);
            foreach($images as $image){
                $photo_name="../images/".$image['img_ref'];//Delete photo url maybe changed
                //echo'<img src="'.$photo_name.'">';
                if(file_exists($photo_name))
                    unlink($photo_name);
                //echo$photo_name;
            }
            try {
                $delete="DELETE FROM  ".$dbObj->thread_table." WHERE  thread_id='$thread_id'";
                $dbObj->dbConnector()->exec($delete);
                //Delete image
                $delete_image="DELETE FROM  ".$dbObj->image_table." WHERE  reference_id='$thread_id' AND upload_type='thread'";
                $dbObj->dbConnector()->exec($delete_image);
                header('Location: ' . $_SERVER['HTTP_REFERER']);
            }catch(Exception $e){
                echo$e;
                header('Location: ' . $_SERVER['HTTP_REFERER']);
            }
        }
        public function deleteComment($comment_id){
            $dbObj=new DBConfig();
            $sql="SELECT img_ref FROM  ".$dbObj->image_table." WHERE  reference_id='$comment_id' AND upload_type='comment'";
            $result=$dbObj->dbConnector()->query($sql);
            $result->execute();
            $images = $result->fetchall();
            //print_r($images);
            foreach($images as $image){
                $photo_name="../img/".$image['img_ref'];//Delete photo url maybe changed
                //echo'<img src="'.$photo_name.'">';
                if(file_exists($photo_name))
                    unlink($photo_name);
                //echo$photo_name;
            }
            try {
                $delete="DELETE FROM  ".$dbObj->comment_table." WHERE  comment_id='$comment_id'";
                $dbObj->dbConnector()->exec($delete);
                //Delete image
                $delete_image="DELETE FROM  ".$dbObj->image_table." WHERE  reference_id='$comment_id' AND upload_type='comment'";
                $dbObj->dbConnector()->exec($delete_image);
                header('Location: ' . $_SERVER['HTTP_REFERER']);
            }catch(Exception $e){
                echo$e;
                header('Location: ' . $_SERVER['HTTP_REFERER']);
            }
        }

    }
?>