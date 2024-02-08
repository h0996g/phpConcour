<?php
session_start();
if (!isset($_SESSION["admin"])) {
   header("Location: loginA.php");
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
            background-color: #f5f5f5; /* Light Gray */
            background-image: url("medical.jpg");
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

        input[type="text"],
        input[type="password"] {
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

        th,
        td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd; /* Light Gray */
        }

        th {
            background-color: #4caf50; /* Green */
            color: #fff;
        }

        .hidden {
            display: none;
        }
    </style>
</head>
<body>
<div class="navbar">
    <a href="indexA.php" id="showAllPostsButton">Home</a>
    <a href="addPost.php" id="">Add post</a>
    <div class="logout-button">
        <a href="logoutA.php" class="btn btn-warning">Logout</a>
    </div>
</div>
<div class="container">
    <h1>Welcome </h1>
    <table id="allPostsTable">
        <thead>
        <tr>
            <th>Desc</th>
            <th>Grad</th>
            <th>participe</th>
            <th>delete</th>
        </tr>
        </thead>
        <tbody>
        <?php
        try {
            $conn = new PDO('mysql:host=localhost;dbname=memoir;charset=utf8', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
            $all_post = $conn->query('SELECT * FROM poste');

            while ($affich = $all_post->fetch()) {
                $desc_post = $affich['des_poste'];
                $grad_post = $affich['grade_poste'];
                $id_post = $affich['Id_Poste'];
                echo
                    '<tr>' .
                    '<td>' . $desc_post . '</td>' .
                    '<td>' . $grad_post . '</td>' .
                    '<td><a href="concourA.php?id=' . $id_post . '">Show</a></td>' .
                    '<td><form method="post" onsubmit="return confirm(\'Are you sure you want to delete this record?\');">' .
                    '<input type="hidden" name="id_post" value=' . $id_post . '>' .
                    '<input type="submit"  name="delete" class="delete" value="delete" />' .
                    '</form></td>' .
                    '</tr>';
            }
            $all_post->closeCursor();
        } catch (Exception $e) {
            die('ERROR :' . $e->getMessage());
        }

        if (isset($_POST['delete'])) {
            try {
                $concours = $conn->prepare('SELECT * FROM concours WHERE Id_Poste = :Id_Poste');
                $concours->execute(array(
                    'Id_Poste' => $_POST['id_post'],
                ));
                while ($affich = $concours->fetch()) {
                    $id_concour = $affich['ID_Concours'];
                }
                $concours->closeCursor();

                $participeDelete = $conn->prepare("DELETE FROM participe WHERE ID_Concours=:ID_Concours ;");
                $participeDelete->execute(array(
                    'ID_Concours' => $id_concour,
                ));
                $participeDelete->closeCursor();

                $concourDelete = $conn->prepare("DELETE FROM concours WHERE ID_Concours=:ID_Concours ;");
                $concourDelete->execute(array(
                    'ID_Concours' => $id_concour,
                ));
                $concourDelete->closeCursor();

                $posteDelete = $conn->prepare("DELETE FROM poste WHERE Id_Poste=:Id_Poste ;");
                $posteDelete->execute(array(
                    'Id_Poste' => $_POST['id_post'],
                ));
                $posteDelete->closeCursor();
            } catch (Exception $e) {
                // Handle the exception if needed
            }
            // header("Refresh:0");
            header("Location: " . $_SERVER['PHP_SELF']);
            exit();
        }
        ?>
        </tbody>
    </table>
</div>
</body>
</html>
