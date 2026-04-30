<?php
session_start();
session_unset(); // Tatanggalin lahat ng session variables
session_destroy(); // Sisirain ang session record

// Babalik sa login page na nasa parehong folder
header("Location: login.php");
exit();
?>