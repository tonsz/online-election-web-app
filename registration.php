<?php
    $error ="";
    $success="";

    if (isset($_POST['register'])){
        // Store input values into a variable
        $firstName = $_POST['firstName'];
        $lastName = $_POST['lastName'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $account = $_POST['account'];

        // Database
        $link = new mysqli ('localhost', 'root', '', 'user_account');
        if ($link->connect_error){
            die ('Connection Failed : ' .$link->connect_error);
        }
        else {
            //Check account type for validation
            if ($account === "voter"){
                $access = $link->prepare("select * from voter_tbl where email = ?");
            }
            else if ($account === "creator"){
                $access = $link->prepare("select * from admin_tbl where email = ?");
            }
            // Check existing emails stored in the database,
            $access->bind_param('s', $email);
            $access->execute();
            $check = $access->get_result();
            
            if ($check->num_rows > 0){          //Check if email was already used.  
                $error= "Email has already been taken.";
                $success ="";
            }
            else{
                //Check account type for storing
                if ($account === "voter"){
                    $store = $link->prepare("insert into voter_tbl (firstName, lastName, email, password) values(?,?,?,?)");
                }
                else if ($account === "creator"){
                    $store = $link->prepare("insert into admin_tbl (firstName, lastName, email, password) values(?,?,?,?)");
                }
                $store->bind_param("ssss", $firstName, $lastName, $email, $password);
                $store->execute();
                $success = "You have successfully created an account!";
                $error ="";
                $store->close();
                $link->close();
            }//storing
        } //validation
    } //register button
?>



<!DOCTYPE.html>

<html lang="en">
    <head>
        <title>Online Election System | Registration</title>
        <link rel="stylesheet" href="registration-style.css">
    </head>

    <body>
        <div class="title">
               Online Election System
        </div>     
        <br><br>
        <div class="container">
               <h2 class="vote">
                    Getting started.
               </h2>
               <p> The Online Election System is a platform for institutions to conduct their own elections or voting event polls. Register, know your election ID and let your choice count. </p>
        </div>
        
        <div class = "infos">
            <form action="registration.php" method ="post">
                    
                <label class = "labels" for="firstName"><b>First Name</b></label>
                <label class = "lastlabel" for="lastName"><b>Last Name</b></label>
                <br>

                <input class = "firstname" type="text" id= "firstName" name="firstName" required>
                <input class = "lastname" type="text" id= "lastName" name="lastName" required>
                <br> <br>
                
                <label class="labels" for="email"><b>Email</b></label> <br>
                <input class="email" type="text" name="email" id="email" required>
                <p class= "error"> <?=$error?> </p>
                <br> <br>
                

                <label class="pwlabel" for="password"><b>Password</b></label> <br>
                <input class="password" type="password" name="password" id="password" required>
                <br> <br>

                <input class="voter-radio" type="radio" id="user" name="account" value="voter" checked>
                <label class="account" for="user">I want to vote for election</label>

                <input class ="admin-radio" type="radio" id="admin" name="account" value="creator">
                <label class="account" for="admin">I want to create my own election</label>
                <br>
                <p class= "success"> <?=$success?> </p>
                <br>
                <input class="button" type="submit" name="register" value="REGISTER">

            </form>
            <div class="signin">
                     <p>Already have an account? <a href="voter_log.php">Sign in</a>.</p>
            </div>
        </div>
  
        

    </body>
</html>
