<?PHP
session_start();
setlocale (LC_ALL, 'en_US.utf8','eng'); 

$cred_login = 'admin';
$cred_pass = '$2y$10$JnEYR9QPPJYVqK4np2rW6eLzVe9933KFoS5aVCadHjqg3K3xHS2ui';

if ((isset($_GET["action"])) && ($_GET["action"]=='login')) {
	if (((isset($_POST['chklogin'])) && (isset($_POST['chkpass']))) && ((!empty($_POST['chklogin'])) && (!empty($_POST['chkpass'])))) {
		if (strcmp($_POST['chklogin'], $cred_login) == 0) {
			if (password_verify($_POST['chkpass'], $cred_pass)) {
				$_SESSION['user'] = $cred_login;
				header ("location: index.php");
				exit();
			}
		} else {
			$_SESSION = array(); 
			@session_write_close();
			@session_destroy ();
		}
	}
	else {
		$_SESSION = array(); 
		@session_write_close();
		@session_destroy();
	}
}

if ((isset($_GET["action"])) && ($_GET["action"]=='logout')) {
	$_SESSION = array(); 
	@session_write_close();
	@session_destroy();
}

header ("location: login.php");
exit();
?>