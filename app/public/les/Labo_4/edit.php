<?php

/**
 * Includes
 * ----------------------------------------------------------------
 */
session_start();

if (!isset($_SESSION['user'])) {
    header('Location: login.php');
}
// config & functions
require_once 'includes/config.php';
require_once 'includes/functions.php';


/**
 * Database Connection
 * ----------------------------------------------------------------
 */

// @TODO
$db = getDatabase();

/**
 * Initial Values
 * ----------------------------------------------------------------
 */

$priorities = array('low','normal','high'); // The possible priorities of a task
$formErrors = array(); // The encountered form errors

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0; // The passed id of the task
if ($id == 0) {
    $id = isset($_POST['id']) ? (int) $_POST['id'] : 0;
};

$what = isset($_POST['what']) ? $_POST['what'] : ''; // The task that was sent in via the form
$priority = isset($_POST['priority']) ? $_POST['priority'] : 'low'; // The priority that was sent via the form
$stmt = $db->query('SELECT name FROM  tasks WHERE id = "' . $id .'"' );
$name = $stmt->fetch(PDO::FETCH_ASSOC);
/**
 * Handle action 'edit' (user pressed edit button)
 * ----------------------------------------------------------------
 */

if (isset($_POST['moduleAction']) && ($_POST['moduleAction'] == 'edit')) {
 $check = true;
    // check if item exists (use the id from the $_POST array!)
    if (!isset($_POST['id'])) {
        $stmt = $db->query('SELECT name FROM tasks WHERE id = "' . $id . '"');
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if (mysql_num_rows($result) == 0) {
            $check = false;
        }
        
    };



    // @TODO (if error, redirect to index.php)

    // check parameters

    // @TODO (if an error was encountered, add it to the $formErrors array)

    // if no errors: updates values in the database
    if ($check) {
        $stmt = $db->query('UPDATE tasks SET `name` = "' . $what . '", priority = "' . $priority . '" WHERE id = "' . $id . '"');
        
        
       header('Location: index.php');
    }
    // @TODO

    // if query succeeded: redirect to index.php
    if ($check) {
        //header('Location: index.php');
    };
    // @TODO

}


/**
 * No action to handle: show edit page
 * ----------------------------------------------------------------
 */

// @TODO Check if the passed id (in $_GET) exists as a task item (if it fails, redirect to index.php)

// @TODO Get the item from the database

// @TODO If the form has not been sent, overwrite the $what and $priority parameters


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
                Taak wijzigen
            </div>
            <div class="panel-body">
<?php
// @TODO if any errors are set, show them inside, list them in a <div> like in index.php
?>
                <!-- Task Edit Form -->
                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" class="form-horizontal">

                    <!-- Task Name -->
                    <div class="form-group">
                        <label for="what" class="col-sm-3 control-label">Taak</label>

                        <div class="col-sm-9">
<?php
// @TODO persist the text control

?>
                            <input type="text" name="what" id="what" class="form-control" value="<?php echo htmlentities($name['name'])?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="priority" class="col-sm-3 control-label">Prioriteit</label>
                        <div class="col-sm-9">
                            <select name="priority" id="priority" class="form-control">
<?php
                                foreach ($priorities as $priority) {?>
                                    <option value="<?php echo $priority?>" > <?php echo $priority ?></option>
                                    
                              <?php  }
?>
                            </select>
                        </div>
                    </div>
                    <input type="hidden" name="moduleAction" value="edit" />
<?php
// @TODO include the id from the GET query string into the hidden field below
?>
                    <input type="hidden" name="id" value="<?php echo $id?>" />

                    <!-- Add Task Button -->
                    <div class="form-group">
                        <div class="col-sm-offset-3 col-sm-6">
                            <button type="submit" class="btn btn-default">
                                <i class="fa fa-btn fa-pencil"></i>Taak wijzigen
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
<script src="js/edit.js"></script>
</body>