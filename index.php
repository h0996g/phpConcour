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
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <title>User Dashboard</title>
    <style>
        .hidden {
            display: none;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Welcome to Dashboard</h1>
        <a href="logout.php" class="btn btn-warning">Logout</a>
    </div>

    <button id="toggleButton" class="btn btn-primary">Toggle Posts</button>

    <table style="width:100%" id="allPostsTable">
        <th>Desc</th>
        <th>Grad</th>

        <?php
        try {
            $conn = new PDO('mysql:host=localhost;dbname=concours;charset=utf8', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
        } catch (Exception $e) {
            die('ERROR :' . $e->getMessage());
        }

        $all = $conn->query('SELECT * FROM Posts');

        while ($affich = $all->fetch()) {
            $desc_post = $affich['desc_post'];
            $grad_post = $affich['grad_post'];
            $id_post = $affich['id'];
            echo
                '<tr>' .
                '<td>' . $affich['desc_post'] . '</td>' .
                '<td>' . $affich['grad_post'] . '</td>' .
                '<td><a href="concour.php?id=' . $affich['id'] . '">Show</a></td>' .
                '</tr>';
        }
        $all->closeCursor();
        ?>
    </table>

    <table style="width:100%" id="clientPostsTable" class="hidden">
        <th>Desc</th>
        <th>Grad</th>

        <?php
         echo
         '<tr>' .
         '<td>fhhhh</td>' .
         '<td>ffffff</td>' .
        //  '<td><a href="concour.php?id=' . $affich['id'] . '">Show</a></td>' .
         '</tr>';
        // Retrieve and display client's posts here
        // Replace this section with your logic to fetch posts registered by the client
        ?>

    </table>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var allPostsTable = document.getElementById('allPostsTable');
            var clientPostsTable = document.getElementById('clientPostsTable');
            var toggleButton = document.getElementById('toggleButton');

            toggleButton.addEventListener('click', function () {
                allPostsTable.classList.toggle('hidden');
                clientPostsTable.classList.toggle('hidden');
            });
        });
    </script>
</body>
</html>
