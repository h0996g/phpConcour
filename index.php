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
</head>
<body>
    <div class="container">
        <h1>Welcome to Dashboard</h1>
        <a href="logout.php" class="btn btn-warning">Logout</a>
    </div>

    <table style="width:100%">
    <th>nom</th>
    <th>email</th>
    

    <?php
try{
    $conn=new PDO('mysql:host=localhost;dbname=concours;charset=utf8','root','',array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION));

}catch(Exception $e){
die('ERROR :'.$e->getMessage());

}

$all=$conn->query('SELECT * FROM Posts');

while($affich=$all->fetch()){

                  echo
                  '<tr>'.
                    '<td>'.$affich['desc_post'].'</td>'.
                    '<td>'.$affich['grad_post'].'</td>'.
                    '<td>'.$affich['desc_post'].'</td>'.

                    // '<td>'.$affich['grad_post'].'</td>'.

                    // '<td>'.$affich['nombre_post'].'</td>'.
                    // '<td>'.$_SESSION['email'].'</td>'.

                  '</tr>';
                  
}
$all->closeCursor();

?>
</table>
</body>
</html>