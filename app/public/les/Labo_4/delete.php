<?php
    session_start();

if (!isset($_SESSION['user'])) {
    header('Location: login.php');
};

    require_once 'includes/config.php';
    require_once 'includes/functions.php';
// @TODO
    $db = getDatabase();
    $id = isset($_GET['id']) ? $_GET['id'] : '';
    $moduleAction = isset($_POST['moduleAction']) ? $_POST['moduleAction'] : '';
    
    $stmt = $db->query('SELECT name FROM  tasks WHERE id = "' . $id .'"' );
    $name = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($moduleAction == "delete") {
        $stmt = $db->query('DELETE FROM tasks WHERE id = "' . $_POST['id'] .'"');
        header('Location: index.php');
        exit();
    };

?><!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Mijn takenlijst</title>
    <!-- Fonts -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css" rel='stylesheet' type='text/css'>
    <link href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700" rel='stylesheet' type='text/css'>
    <!-- Styles -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/tasks.css" rel="stylesheet">
</head>
<body id="app-layout">
<nav class="navbar navbar-default">
    <div class="container">
        <div class="navbar-header"><!-- Just an image -->
            <a class="navbar-brand" href="index.php"><img src="img/ikdoeict.png" height="20" alt="ikdoeict alt logo"></a>
            <a class="navbar-brand" href="index.php">Mijn takenlijst</a>
        </div>
    </div>
</nav>

<div class="container">
    <div class="col-sm-offset-2 col-sm-8">
        <div class="panel panel-default">
            <div class="panel-heading">
                Taak verwijderen
            </div>
            <div class="panel-body">
<?php
                // @TODO if any errors are set, show them inside, list them in a <div> like in index.php
?>
                <!-- Task Delete Form -->
                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" class="form-horizontal">

                    <!-- Task Name -->
                    <div class="form-group">
                        <div class="col-sm-12">
                            <p>Weet je zeker dat je taak <strong><?php echo $name['name'] ?></strong> wil verwijderen?</p>
                        </div>
                    </div>

                    <input type="hidden" name="moduleAction" value="delete" />
<?php
                        
?>
                    <input type="hidden" name="id" value="<?php echo $_GET['id']?>" />

                    <!-- Add Task Button -->
                    <div class="form-group">
                        <div class="col-sm-12">
                            <button type="submit" class="btn btn-default" id="btn-delete">
                                <i class="fa fa-btn fa-trash"></i>Taak verwijderen
                            </button>
                        </div>
                    </div>
                </form>
                <p class="text-left"><a href="index.php">Annuleren en terug naar overzicht</a></p>
            </div>
        </div>

    </div>
</div>
<footer class="footer mt-auto py-3">
    <div class="container">
        <span class="text-muted">&copy; 2019 Odisee &mdash; Opleiding Elektronica-ICT &mdash; Server-side Web Scripting</span>
    </div>
</footer>

<!-- JavaScripts -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
<script src="js/delete.js"></script>
</body>
