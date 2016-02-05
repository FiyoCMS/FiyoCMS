<?php
if(checkMobile())
    require_once('mobile.php');
else 
    require_once('desktop.php');

?>