<?

include_once "class.securelogin.php";

function test_checklogin($user,$hash) {
    //this is just a demo function :)
    return ($user == 'user' && $hash == md5('pass'));
}

$auth = new securelogin;

//set checklogin handler
$auth->handler['checklogin'] = 'test_checklogin';

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

if ($auth->haslogin(true)) {
    $auth->savelogin();
    echo "You have login with username : " . $auth->username . "<BR>";
    echo "Your passhash  : " . $auth->passhash . "<BR>";
    echo "<a href='test_checklogin.php?a=1'>Logout</a><br>";
} else {

    if ($auth->haslogin()) echo "Incorrect Username or password.";

?>
<form action=test_checklogin.php method=post>
    Username <input type=text name=username><br>
    Password <input type=password name=password><br>
    <input type=submit>
</form>


<?

}

?>