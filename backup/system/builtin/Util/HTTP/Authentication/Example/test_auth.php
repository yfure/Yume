<?

include_once "class.securelogin.php";

$auth = new securelogin;
$auth->use_auth = true;

if (@$_GET['a']) {
    $auth->clearlogin();
    echo "Close the window to logout";
    echo "<script language=javascript>window.close();</script>";
    exit;
}

if ($auth->haslogin()) {
    $auth->savelogin();
    echo "You have login with username : " . $auth->username . "<BR>";
    echo "Your passhash  : " . $auth->passhash . "<BR>";
    echo "<a href='test_auth.php?a=1'>Logout</a><br>";
    echo "There is a problem with HTTP Auth header , this will require you to close the window to logout<br>";
} else {
    $auth->auth();
}


?>