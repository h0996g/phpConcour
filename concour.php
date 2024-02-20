<?php
session_start();
if (!isset($_SESSION["user"])) {
    header("Location: login.php");
}

function button1($conn){
    try {      
        $add = $conn->prepare("INSERT INTO participe (Id_Part, ID_Concours,Resultat) values(:Id_Part,:ID_Concours,:Resultat)");
    
        $add->execute(array(
            'Id_Part' => $_SESSION['id_user'],
            'ID_Concours' => $_POST['id_concour'],
            'Resultat' => 'en attente'
        ));

        $add->closeCursor();
    } catch(Exception $e){
        // Handle the exception if needed
        die($e);
    } 
} 

try {
    // $conn = new PDO('mysql:host=localhost;dbname=memoir;charset=utf8','root','',array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION));
    require_once "database.php";

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

$concours = $conn->prepare('SELECT * FROM concours WHERE Id_Poste = :Id_Poste');
$concours->execute(array(
    'Id_Poste' => $_GET['id'],
));
while($affich = $concours->fetch()){
    $id_concour = $affich['ID_Concours'];
    $date_concour = $affich['Date_Concours'];
    $lieu_concour = $affich['Lieu_Concours'];
    $nombre_post = $affich['Nombre_poste'];
}
$concours->closeCursor();

$participe = $conn->prepare('SELECT * FROM participe WHERE Id_Part = :Id_Part and ID_Concours = :ID_Concours');
$participe->execute(array(
    'ID_Concours' => $id_concour,
    'Id_Part' => $_SESSION['id_user']
));

$resultat = 'register';

while($participe_affich = $participe->fetch()){
    $resultat = $participe_affich['Resultat'];
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

        .button:hover {
            /* background-color: #ffca2b; */
            /* color: #212529; */
            /* border: 1px solid #ffca2b; */
        }
        .details {
    margin-bottom: 20px;
    background-color: #f9f9f9;
    padding: 15px;
    border-radius: 5px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.details p {
    margin: 8px 0;
    font-size: 16px;
    line-height: 1.6;
}

.details strong {
    font-weight: bold;
}
.label {
    border: 1px solid #ff0000; /* Red border */
    padding: 5px 10px; /* Adjust padding as needed */
    border-radius: 5px; /* Rounded corners */
    display: inline-block; /* Make the strong tag inline-block to allow padding and border */
    font-weight: bold; /* Make the text bold */
    color: #ff0000; /* Red text color */
}


    </style>
 <script>
function printDetails() {
    var details = document.querySelector('.container');
    var printWindow = window.open('', '_blank');
    printWindow.document.open();
    printWindow.document.write('<html><head><title>Print</title></head><body>');
    printWindow.document.write(details.innerHTML);
    printWindow.document.write('</body></html>');
    printWindow.document.close();
    printWindow.print();
}
</script>

</head>
<body>
    
<div class="navbar">
  
  <a href="index.php" id="showAllPostsButton">Home</a>
  <a href="In_process.php" id="showClientPostsButton">In process</a>
  <div class="logout-button">
      <a href="logout.php" class="btn btn-warning">Logout</a>
  </div>
</div>
<?php if($resultat !== 'acceptable'): ?>
    <div class="container">
        <img src="logo.jpg" alt="Logo" width="150" height="120">
        <!-- Concours Details -->
        <div class="details"> 
            <!-- <p><strong>Date:</strong> <?php echo $date_concour ?> </p> -->
            <!-- <p><strong>Place:</strong> <?php echo $lieu_concour ?></p> -->
            <p><strong>Number of Participants:</strong><?php echo $nombre_post ?></p>
        </div>
        <form method="post">
            <input type="hidden" name="form_submitted" value="1">
            <input type="hidden" name="id_concour" value="<?php echo $id_concour ?>">
            <input type="submit"  name="button1" class="button"  value="<?php echo $resultat ?>" <?php if($resultat != 'register'){ echo 'disabled="disabled"'; } ?> />
        </form>
    </div>
<?php else: 
    require_once "./database.php";

    $concours = $conn->prepare('SELECT * FROM participants WHERE Id_Part = :Id_Part');
    $concours->execute(array(
        'Id_Part' =>  $_SESSION['id_user']
    ));
    while($affich = $concours->fetch()){
        $email=$affich["email_Part"];
        $nom = $affich["Nom_Part"];
        $prenom = $affich["Prenom_Part"];
        $date_naissance = $affich["Date_nais"];
        $lieu_naissance = $affich["Lieu_de_naissance"];
        $adresse = $affich["Adresse_Part"];
        $telephone = $affich["Telph_Part"];
        $sexe = $affich["Sexe_part"];
        $etat_civil = $affich["etat_civil"];
        $nombre_enfants = $affich["nmb_enf"];
        $diplom = $affich["diplome_part"];
        $service_national = $affich["service_national"];
        $malade_chronique = $affich["malade_chronique"];
       
        // $nombre_post = $affich['nombre_post'];
    }
    $concours->closeCursor();
    
    
    ?>
    <!-- Congratulatory message -->
    <div class="container">
    <!-- <img src="../logo.jpg" alt="Logo" width="150" height="120"> -->
    <div class="details"> 
    <p><strong class="label">Date du Concours </strong> <?php echo $date_concour ?> </p>
    <p><strong class="label">Lieu du Concours </strong> <?php echo $lieu_concour ?></p>
    <p><strong class="label">Number of Participants </strong> <?php echo $nombre_post ?></p>
</div>
       
            <p><strong>nom:</strong> <?php echo $nom ?> </p>
            <p><strong>email:</strong> <?php echo $email ?></p>
            <p><strong>prenom:</strong><?php echo $prenom ?></p>
            <p><strong>date_naissance:</strong><?php echo $date_naissance ?></p>
            <p><strong>lieu_naissance:</strong><?php echo $lieu_naissance ?></p>
            <p><strong>telephone:</strong><?php echo $telephone ?></p>
            <p><strong>sexe:</strong><?php echo $sexe ?></p>
            <p><strong>etat_civil:</strong><?php echo $etat_civil ?></p>
            <p><strong>nombre_enfants:</strong><?php echo $nombre_enfants ?></p>
            <p><strong>diplom:</strong><?php echo $diplom ?></p>
            <p><strong>service_national:</strong><?php echo $service_national ?></p>
            <p><strong>adresse:</strong><?php echo $adresse ?></p>
            <button onclick="printDetails()" class="button">Imprimer</button>
      

    </div>
<?php endif; ?>

</body>
</html>
