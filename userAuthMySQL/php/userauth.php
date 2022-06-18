<?php

require_once "../config.php";

//register users
function registerUser($fullnames, $email, $password, $gender, $country){
    //create a connection variable using the db function in config.php
    $conn = db();
   //check if user with this email already exist in the database
$sql = "SELECT * FROM `students` WHERE email ='$email'";
$result = mysqli_query($conn, $sql);
if(mysqli_num_rows ($result)){
    exit("<script>alert('User already registered');
    window.location='../forms/login.html';
    </script>");
}
    else {
        $sql = "INSERT INTO `students`(`full_names`, `country`, `email`, `gender`, `password`)
        VALUES ('$fullnames','$country','$email','$gender','$password')";
        $result = mysqli_query($conn, $sql);
if($result) {
            echo'<script>alert("User Successfully registered");
            window.location="../forms/login.html";
            </script>';  
        } else{
            echo'<script>alert("Unable to registered");
            window.location="../forms/register.html";
            </script>';
        }
            
    }
}


//login users
session_start();
function loginUser($email, $password){
    //create a connection variable using the db function in config.php
    $conn = db();
$sql = "SELECT * FROM `students` WHERE `email`='$email'";
$result = mysqli_query($conn, $sql);
if($result ->num_rows > 0 ){
    $data = mysqli_fetch_assoc($result);

if($data['email']==$email AND $data['password']==$password){
    $_SESSION['user']=$data['full_names'];
    echo'<script>alert("You are Welcome '.$_SESSION['user'].'");
            window.location="../dashboard.php";
            </script>';  
}else{
    echo'<script>alert("Invalid username or password");
    window.location="../forms/login.html";
    </script>';
}
}else {
    echo'<script>alert("User not found");
            window.location="../forms/register.html";
            </script>';
}
    //echo "<h1 style='color: red'> LOG ME IN (IMPLEMENT ME) </h1>";
    //open connection to the database and check if username exist in the database
    //if it does, check if the password is the same with what is given
    //if true then set user session for the user and redirect to the dasbboard
}


function resetPassword($email, $password){
    //create a connection variable using the db function in config.php
    $conn = db();
    $sql = "SELECT * FROM `students` WHERE `email`='$email'";
$result = mysqli_query($conn, $sql);
$data = mysqli_fetch_assoc($result);
$id = $data['id'];
if($result){
    $sql="UPDATE `students` SET `password`='$password' WHERE `id`= '$id'";
    $result = mysqli_query($conn, $sql);

if($result){
    echo'<script>alert("new password assigned");
    window.location="../forms/login.html";
    </script>';  
} else{
    echo'<script>alert("error changing password");
    window.location="../forms/login.html";
    </script>';
}
}else{
    echo'<script>alert("user not recognised");
    window.location="../forms/login.html";
    </script>';
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
     $sql = "DELETE FROM `students` WHERE `id` = $id";
     $result = mysqli_query($conn, $sql);
    if ($result){
        echo'<script>alert("user deleted sucessfully");
        window.location="../forms/login.html";
        </script>';  
    } else{
        echo'<script>alert("error deleting user");
        window.location="../dashboard";
        </script>';
    }

     //delete user with the given id from the database
 }
