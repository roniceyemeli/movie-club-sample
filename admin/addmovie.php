<?php
include "config.php";

// Check user login or not
if (!isset($_SESSION['uname'])) {
    header('Location: index.php');
}

// logout
if (isset($_POST['but_logout'])) {
    session_destroy();
    header('Location: index.php');
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Admin Dashboard</title>
    <link rel="icon" type="image/png" href="../img/logo.png">
    <link rel="stylesheet" href="../style/styles.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css"
        integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.22/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:opsz,wght@16..144,100..700&display=swap"
        rel="stylesheet">
    <style>
        * {
            font-family: "Montserrat", sans-serif;
            outline: none;
            border: none;
        }
    </style>
</head>

<body>
    <?php
    $sql = "SELECT * FROM bookingTable";
    $bookingsNo = mysqli_num_rows(mysqli_query($con, $sql));
    $messagesNo = mysqli_num_rows(mysqli_query($con, "SELECT * FROM feedbackTable"));
    $moviesNo = mysqli_num_rows(mysqli_query($con, "SELECT * FROM movieTable"));
    ?>

    <?php include ('header.php'); ?>

    <div class="admin-container">

        <?php include ('sidebar.php'); ?>
        <div class="admin-section admin-section2">
            <div class="admin-section-column">


                <div class="admin-section-panel admin-section-panel2">
                    <div class="admin-panel-section-header">
                        <h2>Movies</h2>
                        <i class="fas fa-film" style="background-color: #4547cf"></i>
                    </div>
                    <form action="" method="POST" enctype="multipart/form-data">
                        <input placeholder="Title" type="text" name="movieTitle" required>
                        <input placeholder="Genre" type="text" name="movieGenre" required>
                        <input placeholder="Duration" type="number" name="movieDuration" required>
                        <input placeholder="Release Date" type="date" name="movieRelDate" required>
                        <input placeholder="Director" type="text" name="movieDirector" required>
                        <input placeholder="Actors" type="text" name="movieActors" required>
                        <label>Price</label>
                        <input placeholder="Main Hall" type="text" name="mainhall" required><br />
                        <input placeholder="Vip-Hall" type="text" name="viphall" required><br />
                        <input placeholder="Private Hall" type="text" name="privatehall" required><br />
                        <br>
                        <label>Add Poster</label>
                        <input type="file" name="movieImg" accept="image/*">
                        <button type="submit" value="submit" name="submit" class="form-btn">Add Movie</button>
                        <?php
                        if (isset($_POST['submit'])) {
                            $target_dir = "img"; // Upload to the current directory where your PHP script is located
                            $target_file = $target_dir . basename($_FILES["movieImg"]["name"]);
                            $uploadOk = 1;
                            $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

                            // Check if file already exists
                            if (file_exists($target_file)) {
                                echo "Sorry, file already exists.";
                                $uploadOk = 0;
                            }

                            // Check file size (example: 500KB)
                            if ($_FILES["movieImg"]["size"] > 500000) {
                                echo "Sorry, your file is too large.";
                                $uploadOk = 0;
                            }

                            // Allow certain file formats
                            if (
                                $imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
                                && $imageFileType != "gif"
                            ) {
                                echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
                                $uploadOk = 0;
                            }

                            // Check if $uploadOk is set to 0 by an error
                            if ($uploadOk == 0) {
                                echo "Sorry, your file was not uploaded.";
                            } else {
                                if (move_uploaded_file($_FILES["movieImg"]["tmp_name"], "../" . $target_file)) {
                                    // File uploaded successfully, now insert data into database
                                    $insert_query = "INSERT INTO 
            movieTable (  movieImg,
                            movieTitle,
                            movieGenre,
                            movieDuration,
                            movieRelDate,
                            movieDirector,
                            movieActors,
                            mainhall,
                            viphall,
                            privatehall)
            VALUES (        '" . $target_file . "',
                            '" . $_POST["movieTitle"] . "',
                            '" . $_POST["movieGenre"] . "',
                            '" . $_POST["movieDuration"] . "',
                            '" . $_POST["movieRelDate"] . "',
                            '" . $_POST["movieDirector"] . "',
                            '" . $_POST["movieActors"] . "',
                            '" . $_POST["mainhall"] . "',
                            '" . $_POST["viphall"] . "',
                            '" . $_POST["privatehall"] . "')";
                                    $rs = mysqli_query($con, $insert_query);
                                    if ($rs) {
                                        echo "<script>alert('Successfully Submitted');
                  window.location.href='addmovie.php';</script>";
                                    } else {
                                        echo "Error: " . mysqli_error($con);
                                    }
                                } else {
                                    echo "Sorry, there was an error uploading your file.";
                                }
                            }
                        }
                        ?>

                    </form>
                </div>
                <div class="admin-section-panel admin-section-panel2">
                    <div class="admin-panel-section-header">
                        <h2>Recent Movies</h2>
                        <i class="fas fa-film" style="background-color: #4547cf"></i>
                    </div>

                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <tr>
                            <th>Movie ID</th>
                            <th>Movie Title</th>
                            <th>Movie Gender</th>
                            <th>Release Ddate</th>
                            <th>Director</th>
                            <th>Actions</th>

                        </tr>
                        <tbody>
                            <?php
                            $host = "localhost"; /* Host name */
                            $user = "root"; /* User */
                            $password = ""; /* Password */
                            $dbname = "cinema_db"; /* Database name */

                            $con = mysqli_connect($host, $user, $password, $dbname);
                            $select = "SELECT * FROM `movietable`";
                            $run = mysqli_query($con, $select);
                            while ($row = mysqli_fetch_array($run)) {
                                $ID = $row['movieID'];
                                $title = $row['movieTitle'];
                                $genere = $row['movieGenre'];
                                $releasedate = $row['movieRelDate'];
                                $movieactor = $row['movieDirector'];
                                ?>
                                <tr align="center">
                                    <td><?php echo $ID; ?></td>
                                    <td><?php echo $title; ?></td>
                                    <td><?php echo $genere; ?></td>
                                    <td><?php echo $releasedate; ?></td>
                                    <td><?php echo $movieactor; ?></td>
                                    <!--<td><?php echo "<a href='deletemovie.php?id=" . $row['movieID'] . "'  style='color: white;text-decoration:none'>delete</a>"; ?></td>-->
                                    <td><button value="Book Now!" type="submit" onclick="" type="button"
                                            class="btn btn-danger"><?php echo "<a href='deletemovie.php?id=" . $row['movieID'] . "'  style='color: white;text-decoration:none'>delete</a>"; ?></button>
                                    </td>
                                </tr>
                            <?php }
                            ?>
                        </tbody>

                    </table>
                </div>
            </div>

        </div>
    </div>

    <script src="../scripts/jquery-3.3.1.min.js "></script>
    <script src="../scripts/owl.carousel.min.js "></script>
    <script src="../scripts/script.js "></script>
</body>

</html>