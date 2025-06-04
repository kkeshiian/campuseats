<?php
session_start();
session_unset();
session_destroy();

header("Location: /campuseats/pages/auth/login.php");
exit();
