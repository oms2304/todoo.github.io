

<!DOCTYPE html>
<html>
 
<head>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.min.css">
    <script>
    function checkacc(){
    var Password = document.getElementById("password").value;
    var Confirm = document.getElementById("passconfirm").value;
    var email = document.getElementById("email").value;


    if (Confirm == ""){
        alert("Confirm password")
        return false;
    }
    if (Password !== Confirm ){
        alert("Passwords dont match");
        return false;
    }
    if (Password == "" && email == ""){
        alert("Enter email and password")
        return false;
    }
    if (Password == ""){
        alert("Enter password")
        return false;
    }  
    if (email == ""){
        alert("Enter email")
        return false;
    } 
    
    window.location.href = '/insert_type.php';


    }
    </script>
</head>
<body>
<?php
require(__DIR__ . "/nav.php");
?>
    <h2 class = "title">Login</h2>

    <form action="findacc.php" method="post" onsubmit="return checkacc()">
        <div class = "box">
            <label class ="etitle" for="email">Email:</label>
        <input type="email" id="email" name="email">

        <br>

        <label class = "ptitle" for="password">Password:</label>
        <input type="password" id="password" name="password">
        <br>

        <button type="submit">Submit</button>

        </div>

    </form>
    <style>
        /* Apply Flexbox properties to the form container */
        .box {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            margin-top: 20px;
        }
        .title{
            text-align: center;
            margin-top: 150px;
            

        }
        .etitle{
            margin-right: 155px;

        }
        .ptitle{
            margin-right: 125px;

        }
        .ctitle{
            margin-right: 65px;

        }

        /* Style the form inputs */
        input {
            margin-bottom: 10px; /* Add some space between inputs */
        }
    </style>

</body>
</html>
