<?php 
ini_set('display_error','on');
error_reporting(E_ALL);
$email = input_filter($_POST["email"]); 
$password = input_filter($_POST["password"]); 
$admin_email = "admin@localhost.com";


function input_filter($data){
    $data = trim($data);
    $data = stripcslashes($data);
    $data = htmlspecialchars($data);
    return $data ;
}


$con = new mysqli("localhost","root","","CaraShopBase"); 
if($con->connect_error){
    die("Failed To Connect :".$con->connect_error);
}else{
    $statment = $con->prepare("select * from registration where email=? "); 
    $statment->bind_param("s", $email); 
    $statment->execute(); 
    $state_result = $statment ->get_result();
    $stat2 = $con->prepare("select * FROM registration where email=? ");
    $stat2->bind_param('s', $admin_email);
    $stat2->execute();
    $aDresult= $stat2->get_result();
    echo "<h1>first debug</h1>";
    if($state_result->num_rows > 0 && $aDresult -> num_rows>0 ){
        echo"Second Debug";
        $data = $state_result->fetch_assoc();
        $adData = $aDresult->fetch_assoc();
        if($data['password'] === $password){
            if($email === $adData['email']){
                header("Location: dashboard.html"); 
                exit();
                
            }else{
                header("Location: index.html");
            }
            
        }else{
            echo "<h2>Wrong Password</h2>";
        }
    }else{
        echo "<h2>Invalid Email or Password";
    }
}

?>