<?php
session_start();
if (!isset($_SESSION["admin"])) {
    header("Location: indexA.php");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Form</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css"
        integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi"
        crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
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
        padding: 10px 12px;
    }

    .navbar a:hover {
        background-color: #ddd;
        color: black;
    }
.container {
    text-align: center;
    max-width: 400px;
    margin: 0 auto; /* Center the container */
    overflow-y: auto; /* Enable vertical scrolling */
}

form {
    width: 100%;
}

.form-group {
    margin-bottom: 20px;
}

.form-btn {
    text-align: center;
    
}

/* Improved styling for the "Already Registered, Login Here" link */
p {
    margin-top: 20px;
    font-size: 14px;
    color: #555;
}

a {
    color: #007bff;
    text-decoration: none;
    font-weight: bold;
}

a:hover {
    text-decoration: underline;
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
        <?php
              if (isset($_POST["submit"])) {
                $des_poste=$_POST["des_poste"];
                $grade_poste = $_POST["grade_poste"];
                $Date_Concours = $_POST["Date_Concours"];
                $Lieu_Concours = $_POST["Lieu_Concours"];
                $Nombre_poste = $_POST["Nombre_poste"];          
     try{

        // $conn=new PDO('mysql:host=localhost;dbname=memoir;charset=utf8','root','',array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION));
        require_once "database.php";


         $add = $conn->prepare("INSERT INTO poste (des_poste,grade_poste) values(:des_poste,:grade_poste)");
       $add->execute(array(
             'des_poste' => $des_poste,
             'grade_poste' => $grade_poste,
           
           ));
         
           $lastId=$conn->lastInsertId();

           $add->closeCursor();

           $add2 = $conn->prepare("INSERT INTO concours (Id_Poste,Date_Concours,Lieu_Concours,Nombre_poste) values(:Id_Poste,:Date_Concours,:Lieu_Concours,:Nombre_poste)");
           $add2->execute(array(
                 'Id_Poste' => $lastId,
                 'Date_Concours' => $Date_Concours,
                 'Lieu_Concours' => $Lieu_Concours,
                 'Nombre_poste' => $Nombre_poste,
            //    
               ));
           $add2->closeCursor();

                    //  echo "<div class='alert alert-success'>You are registered successfully '$lastId'.</div>";
    header("Location:indexA.php");
    exit();
     
     }catch(Exception $e){
                     die($e);
     }    
             
       }
        ?>
        <form action="addPost.php" method="post">
            
        <div class="form-group">

                <input type="text" class="form-control" name="des_poste" placeholder="des_poste" required>
            </div>
            <div class="form-group">
                <input type="text" class="form-control" name="grade_poste" placeholder="grade_poste" required>
            </div>

            <div class="form-group">
                <input type="date" class="form-control" name="Date_Concours" placeholder="Date_Concours" required>
            </div>
            <div class="form-group">
                <input type="text" class="form-control" name="Lieu_Concours" placeholder="Lieu_Concours" required>
            </div>
            <div class="form-group">
                <input type="number" class="form-control" name="Nombre_poste" placeholder="Nombre_poste" required>
            </div>
            <div class="form-btn">
                <input type="submit" class="btn btn-primary" value="Add" name="submit" required>
            </div>
        </form>
        
    </div>
</body>

</html>
