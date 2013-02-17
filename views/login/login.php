<?php session_start();ob_start();?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../../sources/css/style_backend.css" rel="stylesheet" type="text/css" media="screen" />
<title>FHD App - CMS</title>
</head>

<body>

    <div id ="header">
        <div id ="headline">
            <h1>CMS Web-App</h1>
        </div>
    </div>
    
    <div id ="wrapper">
        
        <div id ="content">

<?php

require_once '../../system/database.php';
new Database();
<<<<<<< HEAD

require_once '../../system/database.php';
new Database();

// include layout
//require_once '../../layout/backend/header.php';
<<<<<<< HEAD
=======
>>>>>>> origin/daniel16.02
=======
>>>>>>> f9553293b59511910e04ea3b3db00b1d87a108c7

if(isset($_SESSION['loginfailure'])){
    echo '<div id="failure">'.$_SESSION['loginfailure'].'</div>';
    unset($_SESSION['loginfailure']);
}

?>
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> f9553293b59511910e04ea3b3db00b1d87a108c7
    <body>
        
        <form name="loginform" method="post" action="">
            <table>
                <tr><td>Benutzername:</td><td><input type="text" name="username" /></td></tr>
                <tr><td>Passwort:</td><td><input type="password" name="password"/></td></tr>
                <tr><td><input type="submit" name="login" value="Login"/></td></tr
            </table>
        </form>

<?php

//require_once '../../layout/backend/footer.php';
<<<<<<< HEAD


=======
    <form name="loginform" method="post" action="">
        <table>
            <tr><td>Benutzername:</td><td><input type="text" name="username" /></td></tr>
            <tr><td>Passwort:</td><td><input type="password" name="password"/></td></tr>
            <tr><td><input type="submit" name="login" id="login" value="Login"/></td></tr>
        </table>
    </form>
=======
>>>>>>> f9553293b59511910e04ea3b3db00b1d87a108c7

    <style type="text/css">
        #login{ 
            padding: 2% 4%; 
        }
    </style>

<?php

>>>>>>> origin/daniel16.02
if(isset($_POST['login'])){
    require_once '../../controllers/loginController.php';
    new LoginController($_POST);
}

require_once '../../layout/backend/footer.php';

ob_flush();


/* End of file login.php */
/* Location: ./views/login.php */

?>
