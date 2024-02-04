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
    <head>
    <script>

    </script>
</head>
</head>
<body>
 
    

    <?php
try{
    $conn=new PDO('mysql:host=localhost;dbname=concours;charset=utf8','root','',array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION));
    $all=$conn->query('SELECT * FROM Concours where id_post =1 ');

}catch(Exception $e){
die('ERROR :'.$e->getMessage());

}
if(isset($_POST['button1'])) { 
    button1($conn); 
    header("Location: ".$_SERVER['PHP_SELF']."?id=".$_GET['id']);
    exit();
}


function button1($conn){
    try{      
        $add = $conn->prepare("INSERT INTO participe (id_user, id_concour,resultat) values(:id_user,:id_concour,:resultat)");
    
        $add->execute(array(
            'id_user' => $_SESSION['id_user'],
            'id_concour' => $_GET['id'],
            'resultat'=>'attend'
            
          ));


          $add->closeCursor();
        // echo '<script>alert("This player already exists")</script>';
       
        }catch(Exception $e){
                    // die("Something went wrong");
    } 
} 

// $all=$conn->query('SELECT * FROM concours where id_post = 1');
$concours = $conn->prepare('SELECT * FROM concours WHERE id_post = :id_post');

$concours->execute(array(
    'id_post' => $_GET['id'],
 
));

while($affich=$concours->fetch()){
    $id_concour=$affich['id'];
    $date_concour=$affich['date_concour'];
    $lieu_concour=$affich['lieu_concour'];
    $nombre_post=$affich['nombre_post'];
}
$concours->closeCursor();
$participe = $conn->prepare('SELECT * FROM participe WHERE id_user = :id_user and id_concour = :id_concour' );

$participe->execute(array(
    'id_concour' => $id_concour,
    'id_user'=>$_SESSION['id_user']
 
));
$resultat='register';

while($participe_affich=$participe->fetch()){
  
    $resultat=$participe_affich['resultat'];
}
$participe->closeCursor();


?>

         
           <div class="container">
<h1>Concours Details</h1>
<div class="details"> 
 <p><strong>Date:</strong> <?php echo $date_concour ?> </p>
 <p><strong>Place:</strong> <?php echo $lieu_concour ?></p>
 <p><strong>Number of Participants:</strong><?php echo $nombre_post ?></p>
 
</div>
<form method="post" > 
<input type="hidden" name="form_submitted" value="1">
<input type="submit" name="button1" class="button" value= <?php echo $resultat ?> <?php if($resultat!='register'){
    echo ' disabled=disabled ';
} ?> />

</div>
</div>     
</body>
</html>