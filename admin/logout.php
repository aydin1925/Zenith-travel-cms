<?php

session_start();

// oturumdaki bütün verileri hafızadan siliyorum
session_unset();

// oturumu kapat
session_destroy();

// login'e yönlendiriyorum
header("Location: login.php");
exit;