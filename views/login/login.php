<?php

session_start();

require_once '../../system/database.php';
new Database();

// include layout
//require_once '../../layout/backend/header.php';

if(isset($_SESSION['loginfailure'])){
    echo '<div id="failure">'.$_SESSION['loginfailure'].'</div>';
    unset($_SESSION['loginfailure']);
}

?>
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


if(isset($_POST['login'])){
    require_once '../../controllers/loginController.php';
    new LoginController($_POST);
}

/* End of file login.php */
/* Location: ./views/login.php */