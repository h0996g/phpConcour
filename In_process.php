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
  
    <a href="index.php" id="showAllPostsButton">Home</a>
    <a href="In_process.php" id="showClientPostsButton">In process</a>
    <div class="logout-button">
        <a href="logout.php" class="btn btn-warning">Logout</a>
    </div>
</div>


    <div class="container">
        <h1>Welcome </h1>
        
        <table id="clientPostsTable" >
            <thead>
                <tr>
                    <th>Desc</th>
                    <th>Grad</th>
                    <th>Nombre Post</th>
                    <th>Date Concours</th>
                    <th>Lieu Concours</th>
                    <th>Résultat</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $conn = new PDO('mysql:host=localhost;dbname=memoir;charset=utf8', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));

                $concour_own = $conn->prepare('SELECT * FROM concours c , participe p, poste po where c.ID_Concours=p.ID_Concours and p.Id_Part= :Id_Part and po.Id_Poste=c.Id_Poste;');

                $concour_own->execute(array('Id_Part' => $_SESSION['id_user']));

                while ($row = $concour_own->fetch()) {
                    $id_concour = $row['ID_Concours'];
                    $desc_post = $row['des_poste'];
                    $grad_post = $row['grade_poste'];
                    $date_concour = $row['Date_Concours'];
                    $lieu_concour = $row['Lieu_Concours'];
                    $nombre_post = $row['Nombre_poste'];
                    $resultat = $row['Resultat'];

                    echo
                        '<tr>' .
                        '<td>' . $desc_post . '</td>' .
                        '<td>' . $grad_post . '</td>' .
                        '<td>' . $nombre_post . '</td>' .
                        '<td>' . $date_concour . '</td>' .
                        '<td>' . $lieu_concour . '</td>' .
                        '<td>' . $resultat . '</td>' .
                        '</tr>';
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>
