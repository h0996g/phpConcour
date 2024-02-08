<?php
session_start();
if (!isset($_SESSION["admin"])) {
   header("Location: loginA.php");
}
// function button1($conn){
//     try {      
//         $add = $conn->prepare("UPDATE participe
//         SET resultat = :resultat
//         WHERE id_user= :id_user and id_concour= :id_concour");
    
//         $add->execute(array(
//             'id_user' => 4,
//             'id_concour' =>1,
//             'resultat' =>$resultat 
//         ));

//         $add->closeCursor();
//     } catch(Exception $e){
//         // Handle the exception if needed
//     } 
// } 
try {
    $conn = new PDO('mysql:host=localhost;dbname=memoir;charset=utf8','root','',array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION));
    // $all = $conn->query('SELECT * FROM Concours where id_post =1 ');
} catch(Exception $e){
    die('ERROR :'.$e->getMessage());
}

if(isset($_POST['update'])) { 
    // button1($conn); 
    try {      
        $add = $conn->prepare("UPDATE participe
        SET Resultat = :Resultat
        WHERE Id_Part= :Id_Part and ID_Concours= :ID_Concours");
    
        $add->execute(array(
            'Id_Part' => $_POST['id_user'],
            'ID_Concours' =>$_POST['id_concour'],
            'Resultat' =>$_POST['resultat'] 
        ));

        $add->closeCursor();
    } catch(Exception $e){
        // Handle the exception if needed
    } 
    // header("Refresh:0");
    header("Location: ".$_SERVER['PHP_SELF']."?id=".$_GET['id']);
  exit();

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
  
    <a href="indexA.php" id="showAllPostsButton">Home</a>
    <a href="addPost.php" id="">Add post</a>
    <div class="logout-button">
        <a href="logoutA.php" class="btn btn-warning">Logout</a>
    </div>
</div>

    <div class="container">
        <h1>Welcome </h1>
        

        <!-- <button id="toggleButton" class="btn btn-primary">Mon Concours</button> -->

        <table id="allPostsTable">
            <thead>
                <tr>
                    <th>nom</th>
                    <th>prenom</th>
                    <th>email</th>
                    <th>Profile</th>
                    <th>resultat</th>
                    <th>update</th>

                </tr>
            </thead>
            <tbody>
                <?php
                try {
                    $conn = new PDO('mysql:host=localhost;dbname=memoir;charset=utf8', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
                    $all_post = $conn->prepare('select * from participe p ,concours c,participants u WHERE p.ID_Concours =c.ID_Concours  and c.Id_Poste = :Id_Poste and u.Id_Part =p.Id_Part ');
                    $all_post->execute(array(
                        'Id_Poste' => $_GET['id'],
                    ));
                    while ($affich = $all_post->fetch()) {
                        $nom = $affich['Nom_Part'];
                        $prenom = $affich['Prenom_Part'];
                        $email = $affich['email_Part'];
                        $id_user=$affich['Id_Part'];
                        $id_concour=$affich['ID_Concours'];
                        $resultat=$affich['Resultat'];
                        echo
                            '<tr>' .
                            '<td>' . $nom. '</td>' .
                            '<td>' . $prenom. '</td>' .
                            '<td>' . $email. '</td>' .
                            '<td><a href="detailsUser.php?id=' . $id_user . '">Show</a></td>' .
                            // '<td><a href="concour.php?id=' . $affich['id'] . '">Delete</a></td>' .
                            
                          
                            '<form method="post">'.

                            '<td>'.
                             ' <select name="resultat" id="resultat">'.
                            ' <option value="none" selected disabled hidden>'.$resultat.'</option>'.
                             '<option value="en attente">en attente</option>'.
                              '<option value="acceptable">acceptable</option>'.
                              '<option value="inacceptable">inacceptable</option>'.
                            '</select>'.
                            '</td>' .
                            '<td>'.
                            '<input type="hidden" name="id_concour" value='.$id_concour.'>'.
                            '<input type="hidden" name="id_user" value='.$id_user.'>'.
                            '<input type="submit"  name="update" class="update" value="update" />'.
                        '</form>'.
                            
                            '</td>'.
                            
                            '</tr>';
                         
                    }
                    $all_post->closeCursor();
                } catch (Exception $e) {
                    die('ERROR :' . $e->getMessage());
                }
                ?>
            </tbody>
            
        </table>

     

        <!-- <script>
           document.addEventListener('DOMContentLoaded', function () {
        var allPostsTable = document.getElementById('allPostsTable');
        var clientPostsTable = document.getElementById('clientPostsTable');
        var AllPostButton = document.getElementById('showAllPostsButton');
        var ClientPostButton = document.getElementById('showClientPostsButton');

        AllPostButton.addEventListener('click', function () {
            clientPostsTable.style.display = 'none';
            allPostsTable.style.display = 'table'; // Set display property to 'table' to show the table
        });
        ClientPostButton.addEventListener('click', function () {
            allPostsTable.style.display = 'none';
            clientPostsTable.style.display = 'table'; // Set display property to 'table' to show the table
        });
    });
        </script> -->
    </div>
</body>
</html>
