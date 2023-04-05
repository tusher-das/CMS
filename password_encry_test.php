<?php

$password = "1122";

$hash_password = password_hash($password, PASSWORD_DEFAULT, array('cost' => 10));

echo "Old password : " . $password . "<br>";
echo "Encrypted password : " . $hash_password . "<br>";

$verify_password = password_verify($password, $hash_password);
echo "IsPasswordVerify : " . $verify_password . "<br>";

?>