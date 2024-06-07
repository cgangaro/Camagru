<?php

$conn = mysqli_connect($_ENV['HOSTNAME'], $_ENV['DB_USERNAME'], $_ENV['PASSWORD_DB'], $_ENV['DB_NAME']);

if (!$conn) {
	die("Connection failed: " . mysqli_connect_error());
}
else {

}
?>