<?php session_start();

unset($_SESSION['user_id']);

$_SESSION['logout'] = 'Logout Erfolgreich';

header('Location: ../../index.php');

/* End of file login.php */
/* Location: ./views/login.php */

?>