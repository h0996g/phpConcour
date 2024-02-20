<?php
session_start();
if (!isset($_SESSION["user"])) {
   header("Location: login.php");
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Dashboard</title>
    <style>
  body {
    font-family: Arial, sans-serif;
    /* background-color: #f5f5f5; Light Gray */
    background-image: url("aa.jpg");
    background-size: cover;


    margin: 0;
    padding: 0;
}

.navbar {
        background-color: #333;
        overflow: hidden;
        display: flex;
        justify-content: space-between; /* Align items to the start and end of the flex container */
        padding: 0 20px; /* Add padding to give some space */
    }

    .logout-button {
        margin-left: auto; /* Push the logout button to the right by using margin-left: auto */
        
    }

    .navbar a {
        color: #f2f2f2;
        text-decoration: none;
        padding: 14px 16px;
    }

    .navbar a:hover {
        background-color: #ddd;
        color: black;
    }
.container {
    padding: 20px;
    text-align: center;
    background-color: #fff;
    border: 1px solid #ddd; /* Light Gray */
    border-radius: 10px;
    margin-top: 20px;
}

h1 {
    color: #4caf50; /* Green */
}

.btn {
    padding: 10px 20px;
    font-size: 16px;
    margin: 10px;
    background-color: #ffc107; /* Yellow */
    color: #212529; /* Black */
    border: 1px solid #ffc107; /* Yellow */
    border-radius: 5px;
    text-decoration: none;
    cursor: pointer;
}



input[type="text"], input[type="password"] {
    width: 100%;
    padding: 10px;
    margin: 5px 0 15px 0;
    display: inline-block;
    border: 1px solid #ccc; /* Light Gray */
    box-sizing: border-box;
    border-radius: 5px;
}

table {
    width: 100%;
    margin-top: 20px;
    border-collapse: collapse;
    background-color: #fff;
    border: 1px solid #ddd; /* Light Gray */
    border-radius: 10px;
}

th, td {
    padding: 12px;
    text-align: left;
    border-bottom: 1px solid #ddd; /* Light Gray */
}

th {
    background-color: #0000FF; /* Green */
    color: #fff;
}

.hidden {
    display: none;
}


    </style>
</head>
<body>
<div class="navbar">
    <a href="index.php" id="showAllPostsButton">Home</a>
    <a href="In_process.php" id="showClientPostsButton">In process</a>
    <div class="logout-button">
        <a href="logout.php" class="btn btn-warning">Logout</a>
    </div>
</div>


    <div class="container">
        <!-- <h1>Welcome </h1> -->
        <img src="logo.jpg" alt="Logo" width="150" height="120">
        

        <table id="allPostsTable">
            <thead>
                <tr>
                    <th>Desc</th>
                    <th>Grad</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                try {
                  
                    // $conn = new PDO('mysql:host=localhost;dbname=memoir;charset=utf8', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
                  require_once "database.php";
                  
                    $all_post = $conn->query('SELECT * FROM poste');

                    while ($affich = $all_post->fetch()) {
                        $desc_post = $affich['des_poste'];
                        $grad_post = $affich['grade_poste'];
                        $id_post = $affich['Id_Poste'];
                        echo
                            '<tr>' .
                            '<td>' . $desc_post . '</td>' .
                            '<td>' . $grad_post . '</td>' .
                            '<td><a href="concour.php?id=' . $id_post . '">Show</a></td>' .
                            '</tr>';
                    }
                    $all_post->closeCursor();
                } catch (Exception $e) {
                    die('ERROR :' . $e->getMessage());
                }
                ?>
            </tbody>
        </table>

    </div>
</body>
</html>
