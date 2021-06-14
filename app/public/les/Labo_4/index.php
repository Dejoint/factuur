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
$db = getDatabase(); //in $db zit nu een PDO opject

/**
 * Initial Values
 * ----------------------------------------------------------------
 */

$priorities = array('low','normal','high'); // The possible priorities of a task
$formErrors = array(); // The encountered form errors

$what = isset($_POST['what']) ? $_POST['what'] : ''; // The task name that was sent via the form
$priority = isset($_POST['priority']) ? $_POST['priority'] : 'low'; // The priority that was sent via the form


/**
 * Handle action 'add' (user pressed add button)
 * ----------------------------------------------------------------
 */

if (isset($_POST['moduleAction']) && ($_POST['moduleAction'] == 'add')) {

    // check parameters
    if (trim($what) === '') {
        $formErrors[] = 'Gelieve een taak in te vullen.';
    };
    if (! in_array($priority, $priorities)) {
        $formErrors[] = 'Je hebt geprutst met de prioriteit.';
    };
    if (count($formErrors) == 0) {
        $stmt = $db-> prepare('INSERT INTO tasks (`name`, priority, added_on ) VALUES (?,?,?)');
        $stmt->execute(array($what, $priority, (new DateTime())->format('Y-m-d')));
        header('Location: index.php');
    };
    // @TODO (if an error was encountered, add it to the $formErrors array)

    // if no errors: insert values into database

    // @TODO

    // if insert query succeeded: redirect to this very same page

    // @TODO

};


/**
 * No action to handle: show our page itself
 * ----------------------------------------------------------------
 */

// @TODO get all task items from the databases
$stmt = $db->query('SELECT * FROM  tasks ORDER BY priority');
$tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
            
                <a href="logout.php" class="btn btn-default">Uitloggen</a>
            
        </div>
    </div>
</nav>

<div class="container">
    <div class="col-sm-offset-2 col-sm-8">
        <div class="panel panel-default">
            <div class="panel-heading">
                Nieuwe taak
            </div>
            <div class="panel-body">

<?php  
    if (count($formErrors) != 0) {?>

                <!-- Display Validation Errors -->
                <!-- Form Error List -->
                <div class="alert alert-danger">
                    <strong>Hier is iets misgegaan.</strong>
                    <br><br>
                    <ul>
                        <?php
                        foreach ($formErrors as $error) {?>
                            <li> <?php echo $error;  ?> </li>
                        <?php } ?>
                        
                    </ul>
                </div>
<?php }?>
                <!-- New Task Form -->
                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" class="form-horizontal">

                    <!-- Task Name -->
                    <div class="form-group">
                        <label for="what" class="col-sm-3 control-label">Taak</label>

                        <div class="col-sm-9">
<?php
// @TODO persist the text control
?>
                            <input type="text" name="what" id="what" class="form-control" value="<?php echo htmlentities($what);?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="priority" class="col-sm-3 control-label">Prioriteit</label>
                        <div class="col-sm-9">
                            <select name="priority" id="priority" class="form-control">
<?php
                                foreach ($priorities as $priority) {?>
                                    <option value="<?php echo $priority?>"> <?php echo $priority ?></option>
                                    
                              <?php  }
?>
                            </select>
                        </div>
                    </div>
                    <input type="hidden" name="moduleAction" value="add" />

                    <!-- Add Task Button -->
                    <div class="form-group">
                        <div class="col-sm-offset-3 col-sm-6">
                            <button type="submit" class="btn btn-default">
                                <i class="fa fa-btn fa-plus"></i>Voeg taak toe
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Current Tasks -->
        <div class="panel panel-default">
            <div class="panel-heading">
                Huidige taken
            </div>
            <div class="panel-body">


                <table class="table table-striped task-table" >
                    <thead>
                    <tr>
                        <th class="col-sm-8">Taak</th>
                        <th class="col-sm-2">&nbsp;</th>
                        <th class="col-sm-2">&nbsp;</th>
                    </tr>

                    </thead>
                    <tbody>

<?php
// @TODO if any task items are found, show them inside <tr></tr> using the struct below
    foreach($tasks as $task){
?>
                        <tr>
                            <td class="table-text">
                                <div class="item <?php echo $task['priority']?>"><?php echo $task['name']?></div>
                            </td>
                            <td>
                                <a class="btn btn-primary" href="edit.php?id=<?php echo $task['id']?>" role="button">
                                    <i class="fa fa-btn fa-pencil"></i>Wijzigen
                                </a>
                            </td>
                            <td>
                                <a class="btn btn-danger" href="delete.php?id=<?php echo $task['id']?>" role="button">
                                    <i class="fa fa-btn fa-trash"></i>Verwijderen
                                </a>
                            </td>
                        </tr>
<?php }
// @TODO if no task items are found, show a user-friendly message
?>

                    </tbody>
                </table>
<?php
// @TODO if no task items are found, don't show the <table> but show a user-friendly message in a <p> in stead
?>
            </div>
        </div>

    </div>
</div>
<footer class="footer mt-auto py-3">
    <div class="container">
        <span class="text-muted">&copy; 2020 Odisee &mdash; Opleiding Elektronica-ICT &mdash; Server-side Web Scripting</span>
    </div>
</footer>

<!-- JavaScripts -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
<script src="js/index.js"></script>
</body>