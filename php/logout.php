<?php
include "userauth.php";

session_start();
if (!isset($_SESSION['user'])) {
    
}

function logout(){
    session_unset();
    session_destroy();
    echo '<script>alert("User succefully logout");
              header: location="../forms/login.html";
              </script>';
    
}

logout();
