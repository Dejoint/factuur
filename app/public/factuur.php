<?php
session_start();

if (!isset($_SESSION['user'])) {
  header('Location: login.php');
}

require_once 'includes/config.php';
require_once 'includes/functions.php';

$db = getDatabase(); 

$total = 0;

function getData($id){
  $db = getDatabase(); 
  $stmt = $db->prepare('SELECT * FROM verkoop WHERE id = ?');
  $stmt->execute(array($id));
  return $stmt->fetchAll(PDO::FETCH_ASSOC);

}

?>
<!DOCTYPE html>
<html lang="nl">
<head>
  <meta charset="UTF-8">
  <title>Home</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
  

  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:400,700">
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
  <script src="https://kit.fontawesome.com/aa9a352006.js" crossorigin="anonymous"></script>
  <style>
    td {
      color: #FFFFFF
    }
    th{
      color: #FFFFFF
    }
  </style>

</head>
  <body style="background-color: #454545">
    <div class="container">
    <div class="row">
      <div class="col">
        <img src="img/logo.png" class="rounded float-left" width="100px" height="100px">

      </div>
      <div class="col">
        
          <p>Naam</p>

        
      </div>
    </div>
    <div class="row">
      <table class="table table-striped table-sm">
          <thead>
            <tr>
              <th>#</th>
              <th>Naam</th>
              <th>Categorie</th>
              <th>Eenheidsprijs</th>
              <th>Aantal</th>
              <th>Regeltotaal</th>
              
            </tr>
          </thead>
          <tbody>
            <?php
            if (isset($_SESSION['cart'])) {
              $array = $_SESSION['cart'];
              $total = 0;
              $totAantal = 0;
              $count = 1;
              foreach ($array as $subArray) {
                $artikelInfo = getData($subArray[1]);

                $regelTotaal = (double)$subArray[0] * (double)$artikelInfo[0]['prijs'];
                $totAantal = $totAantal + $subArray[0];
                $total = (double)$total + (double)$regelTotaal;
                $idArt = $subArray[1]
                ?>

                <tr>
                  <td><?php echo $count ?></td>
                  <td><?php echo $artikelInfo[0]['naam']?></td>
                  <td><?php echo $artikelInfo[0]['categorie']?></td>
                  <td>€<?php echo $artikelInfo[0]['prijs']?></td>
                  <td><?php echo $subArray[0] ?></td>
                  <td>€<?php echo $regelTotaal ?></td>
                 
                </tr>


              <?php $count++; }
            } 
            ?>
          </tbody>
        </table>
    </div>
  </div>
  </body>
</html>
