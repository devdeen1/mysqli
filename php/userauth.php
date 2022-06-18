<?php
include "../config.php";
// require_once "../config.php";


//register users
function registerUser($fullnames, $email, $password, $gender, $country){
    //create a connection variable using the db function in config.php
    $conn = db();
    // Check if email already exist
    $select = mysqli_query($conn, "SELECT * FROM students WHERE email ='$email'");
        if(mysqli_num_rows($select)) {
            exit ("<script> alert('User email already exist');
            window.location='../forms/register.html'; 
            </script>");
           
}

    $query = "INSERT into `students` (`full_names`, `country`, `email`, `gender`, `password`)
             VALUES ('$fullnames', '$country','$email', '$gender',  '$password')";
    // If successfully save do this
    
    $result = mysqli_query($conn, $query);
    if ($result) {
        echo "<script> alert('User Successfully Registered');
        window.location='../forms/login.html'; 
        </script>";
    }else {
        echo "<script> alert('Required field are missing');
        window.location='../forms/register.html'; 
        </script>";
    }
}


//login users
function loginUser($email, $password){
    //create a connection variable using the db function in config.php
    $conn = db();

    //open connection to the database and check if username exist in the database
    
    $query = "SELECT * FROM `students` WHERE email='$email' AND password='$password'";
    
    //if true then set user session for the user and redirect to the dasbboard
    $result = mysqli_query($conn, $query) or die(mysqli_error());
    // Pick the Full Name from the query details
    $rows = mysqli_num_rows($result);

    // $data = mysqli_fetch_assoc($result, $rows)['fullnames'];
    session_start();
    $data = mysqli_fetch_assoc($result);

    if ($rows == 1) {
        $_SESSION['user'] = $data['full_names'];
        echo '<script>alert("Welcome ' . $_SESSION['user'] . '");
              header: location="../dashboard.php";
              </script>';
    }else{
        echo "<script> alert('Invalid Credentials');
        window.location='../forms/login.html'; 
        </script>";
    }
  
}


function resetPassword($email, $password){
    //create a connection variable using the db function in config.php
    $conn = db();
    $sql = "SELECT * FROM students WHERE  email= '$email'";
    $my_res = mysqli_query($conn, $sql);
    // Getting information
    $data = mysqli_fetch_assoc($my_res);
    $id = $data['id'];
    if($my_res){
        $sql = "UPDATE students SET password='$password' WHERE id='$id'";
        $my_res = mysqli_query($conn, $sql);
    
    if ($my_res){
        echo '<script> alert("User Password Changed"); 
        window.location="../forms/login.html"; 
        </script>';
    }else{
        echo '<script> alert("Process failed"); 
        window.location="../forms/register.html"; 
        </script>';
    }    
    }
    }

function getusers(){
    $conn = db();
    $sql = "SELECT * FROM Students";
    $result = mysqli_query($conn, $sql);
    echo"<html>
    <head></head>
    <body>
    <center><h1><u> ZURI PHP STUDENTS </u> </h1> 
    <table border='1' style='width: 700px; background-color: magenta; border-style: none'; >
    <tr style='height: 40px'><th>ID</th><th>Full Names</th> <th>Email</th> <th>Gender</th> <th>Country</th> <th>Action</th></tr>";
    if(mysqli_num_rows($result) > 0){
        while($data = mysqli_fetch_assoc($result)){
            //show data
            echo "<tr style='height: 30px'>".
                "<td style='width: 50px; background: blue'>" . $data['id'] . "</td>
                <td style='width: 150px'>" . $data['full_names'] .
                "</td> <td style='width: 150px'>" . $data['email'] .
                "</td> <td style='width: 150px'>" . $data['gender'] . 
                "</td> <td style='width: 150px'>" . $data['country'] . 
                "</td>
                <form action='action.php' method='post'>
                <input type='hidden' name='id'" .
                 "value=" . $data['id'] . ">".
                "<td style='width: 150px'> <button type='submit', name='delete'> DELETE </button>".
                "</tr>";
        }
        echo "</table></table></center></body></html>";
    }
    //return users from the database
    //loop through the users and display them on a table
}

 function deleteaccount($id){
    $conn = db();
    //delete user with the given id from the database
    $sql = "DELETE FROM `students` WHERE `id`='$id'";
    $my_res = mysqli_query($conn, $sql);
    if ($my_res){
        echo '<script> alert("User deleted succesfully"); 
        window.location="../forms/login.html"; 
        </script>';
    }else{
        echo '<script> alert("Failed to delete user"); 
        window.location="../dashboard.php"; 
        </script>';
    }    

}
