<?php

    class GetMessage {
        public function getSuccessMessage($message){?>
            <div class="alert alert-success alert-dismissable fade in" id="success-alert">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            <?php echo$message;?>
            </div>
        <?php }

        public function getErrorMessage($message){?>
            <div class="alert alert-danger alert-dismissable fade in" id="success-alert">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            <?php echo$message;?>
            </div>
        <?php }
        public function getWraningMessage($message){?>
            <div class="alert alert-warning alert-dismissable fade in" id="success-alert">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                <?php echo$message;?>
            </div>
        <?php }
    }
?>