<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:opsz,wght@16..144,100..700&display=swap"
        rel="stylesheet">
    <title>EPI Movie Club</title>
    <style>
        * {
            font-family: "Montserrat", sans-serif;
            outline: none;
            border: none;
        }

        /* Container */
        .container {
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            /* margin: 2rem auto; */
        }

        .container form {
            width: 50%;
            max-width: 500px;
        }

        /* Login */
        #div_login {
            width: 100%;
            border-radius: 3px;
            margin: 0 auto;
        }

        #div_login h1 {
            padding: .5rem 1rem;
            background-color: cornflowerblue;
            color: white;
            width: 100%;
        }

        #div_login div {
            clear: both;
            margin-top: 10px;
            padding: 5px;
        }

        #div_login .textbox {
            width: 97.5%;
            padding: 1rem 1.5rem;
            border: 1px solid gainsboro
        }

        #div_login input[type=submit] {
            padding: .5rem;
            width: 100px;
            background-color: cornflowerblue;
            border: 0px;
            color: white;
            font-size: 1rem;
            cursor: pointer;
            opacity: 60%;
        }

        #div_login input[type=submit]:hover {
            opacity: 100%;
        }
    </style>
</head>

<body>
    <div class="container">
        <form method="post" action="">
            <div id="div_login">
                <h1>Admin</h1>
                <div>
                    <input type="text" class="textbox" id="txt_uname" name="txt_uname" placeholder="Username" />
                </div>
                <div>
                    <input type="password" class="textbox" name="txt_pwd" placeholder="Password" />
                </div>
                <div>
                    <input type="submit" value="Submit" name="but_submit" id="but_submit" />
                </div>
            </div>
        </form>
    </div>
</body>

</html>

<?php
include "config.php";

if (isset($_POST['but_submit'])) {

    $uname = mysqli_real_escape_string($con, $_POST['txt_uname']);
    $password = mysqli_real_escape_string($con, $_POST['txt_pwd']);

    if ($uname != "" && $password != "") {

        $sql_query = "select count(*) as cntUser from users where username='" . $uname . "' and password='" . $password . "'";
        $result = mysqli_query($con, $sql_query);
        $row = mysqli_fetch_array($result);

        $count = $row['cntUser'];

        if ($count > 0) {
            $_SESSION['uname'] = $uname;
            header('Location: admin.php');
        } else {
            echo "Invalid username and password";
        }
    }
}
?>