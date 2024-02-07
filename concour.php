<?php
session_start();
if (!isset($_SESSION["user"])) {
    header("Location: login.php");
}

function button1($conn){
    try {      
        $add = $conn->prepare("INSERT INTO participe (id_user, id_concour,resultat) values(:id_user,:id_concour,:resultat)");
    
        $add->execute(array(
            'id_user' => $_SESSION['id_user'],
            'id_concour' => $_GET['id'],
            'resultat' => 'attend'
        ));

        $add->closeCursor();
    } catch(Exception $e){
        // Handle the exception if needed
    } 
} 

try {
    $conn = new PDO('mysql:host=localhost;dbname=concours;charset=utf8','root','',array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION));
    // $all = $conn->query('SELECT * FROM Concours where id_post =1 ');
} catch(Exception $e){
    die('ERROR :'.$e->getMessage());
}

if(isset($_POST['button1'])) { 
    button1($conn); 
    // header("Refresh:0");
    header("Location: ".$_SERVER['PHP_SELF']."?id=".$_GET['id']);
  exit();

}

$concours = $conn->prepare('SELECT * FROM concours WHERE id_post = :id_post');
$concours->execute(array(
    'id_post' => $_GET['id'],
));
while($affich = $concours->fetch()){
    $id_concour = $affich['id'];
    $date_concour = $affich['date_concour'];
    $lieu_concour = $affich['lieu_concour'];
    $nombre_post = $affich['nombre_post'];
}
$concours->closeCursor();

$participe = $conn->prepare('SELECT * FROM participe WHERE id_user = :id_user and id_concour = :id_concour');
$participe->execute(array(
    'id_concour' => $id_concour,
    'id_user' => $_SESSION['id_user']
));

$resultat = 'register';

while($participe_affich = $participe->fetch()){
    $resultat = $participe_affich['resultat'];
}

$participe->closeCursor();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5; /* Light Gray */
            margin: 0;
            padding: 0;
            background-image: url("medical.jpg");

        }
       

        .container {
            padding: 20px;
            text-align: center;
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 10px;
            margin-top: 20px;
        }

        h1 {
            color: #4caf50;
        }

        .details {
            margin-bottom: 20px;
        }

        .button {
            padding: 10px 20px;
            font-size: 16px;
            margin: 10px;
            cursor: pointer;
            /* background-color: #4caf50; */
            color: #212529;
            border: 1px solid #ffc107;
            border-radius: 5px;
            text-decoration: none;
        }

        .button:hover {
            /* background-color: #ffca2b; */
            /* color: #212529; */
            /* border: 1px solid #ffca2b; */
        }
    </style>
 
</head>
<body>
    <div class="container">
        <h1>Concours Details</h1>
        <div class="details"> 
            <p><strong>Date:</strong> <?php echo $date_concour ?> </p>
            <p><strong>Place:</strong> <?php echo $lieu_concour ?></p>
            <p><strong>Number of Participants:</strong><?php echo $nombre_post ?></p>
        </div>
        <form method="post">
            <input type="hidden" name="form_submitted" value="1">
            <input type="submit"  name="button1" class="button"  value="<?php echo $resultat ?>" <?php if($resultat != 'register'){ echo 'disabled="disabled"'; } ?> />
        </form>
    </div>
</body>
</html>
