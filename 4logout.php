<?php
session_start();
session_destroy();                                                                       /* LOG-OUT SESSION */
    header("Location: 1login.php");
?>