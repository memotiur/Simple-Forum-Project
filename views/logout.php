<?PHP
//require_once('inc/session_manage.php');
session_unset();

session_destroy();
//echo'<script>window.location.href = "login.php";</script>';
header('Location: index.php?page=login');

?>