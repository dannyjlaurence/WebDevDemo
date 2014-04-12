
<?php
	require_once 'database.php';
	global $user;
	global $facebook;
	if ($user) {
		echo "<a href=\"".$facebook->getLogoutUrl()."\">Logout</a>";
	} else {
		echo "<a href=\"".$facebook->getLoginUrl()."\">Login</a>";
	}
?>