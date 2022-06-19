<?php
    $error="";
    $incorrect="";
    //check if login button is clicked
    if (isset($_POST['login'])){
        //store inputs in the variables
        $email = $_POST['email'];
        $password = $_POST['password'];
                
        // Database
        $conn = new mysqli ('localhost', 'root', '', 'user_account');
        if ($conn->connect_error){
            die ('Connection Failed : ' .$conn->connect_error);
        }
        else {
            $access = $conn->prepare("select * from voter_tbl where email = ?");
            $access->bind_param('s', $email);
            $access->execute();
            $result = $access->get_result();
            if ($result->num_rows > 0){     //0 zero indicates that email is not a match. Must return 1 as its value
                $data = $result -> fetch_assoc();   //get the data from the entire row

                //compare the password from data base and from login input.
                if ($data ['password'] === $password){  
                    header('Location: voter-home.php');
                }else {
                    $incorrect  = "Incorrect Password!";
                    $error="";
                }
            }else {
                $error = "Invalid Email!";
                $incorrect  ="";}
        }
    }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="voter_log-style.css">
    <title>Online Election System | Voter's Log In</title>
</head>
<body>
       <div class="top">
           <div class="title">
               Online Election System
           </div>     
           <div class="start">                                                                    
                <a href="voter_log.php"class="log-in">Log In</a> 
                <a href="registration.php" class="reg">Register</a>                                         
          </div>
        </div>
        <div class="main-nav">
             <ul class="menu">
                  <li>
                       <a href="home.php">Home</a>
                  </li>
                  <li >
                       <a id="admin-log" href="admin_log.php">Administrator</a>
                  </li>
                  <li>
                       <a id="voter-log" href="voter_log.php">Voter</a>
                  </li>
                  <li>
                       <a id="help" href="help.php">Help</a>
                  </li>
                  <li>
                       <a id="contact" href="contact.php">Contact Us</a>
                  </li>
             </ul>
        </div>
        
         <!-- Log in form -->
         <!-- enclosed all inside class "log-in" -->
        <div class="log-in"> 
            <div class="subtitle">
                Voter's Log In
            </div>   

            <!-- changed div class name -->
            <div class="form">
                <form action="voter_log.php" method ="post">
                    <div>
                    <label class="labels" for="email"><b>Email</b></label><br>
                    <input class="inputs" type="text" name="email" id="email" required>
                    <p class= "error"> <?=$error?> </p>
                    <br><br><br>

                    <label class="labels" for="password"><b>Password</b></label><br>
                    <input class="inputs" type="password" name="password" id="password" required>
                    <p class= "incorrectPW"> <?=$incorrect?> </p>
                    </div>

                    <input class="logButton" type="submit" name="login" value="LOG IN">
                </form>
            </div>

            <div class="signup">
                <p>Not registered yet? <a href="registration.php">Register here</a>.</p>
            </div>
        </div>
       
     
     <!-- Hihglight navigation bar for voters-->
     <style>
          #voter-log {
               color: #1b2459;
               border: 10px solid transparent;
               background-color: #e2e3eb;
               border-color: #e2e3eb;
          }
     </style>
        
</body>
</html>
