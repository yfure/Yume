<?

include_once "class.securelogin.php";

$auth = new securelogin;

//set form index
$auth->post_index = array(
    'user' => 'username' ,
    'pass' => 'password' ,
);

//using session instead of cookie
$auth->use_cookie = false;
$auth->use_session = true;

session_start(); //require

if (@$_GET['a']) $auth->clearlogin();

if ($auth->haslogin()) {
    $auth->savelogin();
    echo "You have login with username : " . $auth->username . "<BR>";
    echo "Your passhash  : " . $auth->passhash . "<BR>";
    echo "<a href='test_form.php?a=1'>Logout</a><br>";
} else {


?>
<form action=test_form.php method=post>
    Username <input type=text name=username><br>
    Password <input type=password name=password><br>
    <input type=submit>
</form>


<?

}

?>