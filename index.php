<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Formulario agenda con OOP, PDO y BBDD</title>
    </head>
    <body>
        <form name="formulario" method="get" action="">
            <label for="name"><h1>Name: </h1></label>
            <input type="text" id="user" name="name" required><br>
            <label for="telephone"><h1>Contact Number: </h1></label>
            <input type="text" maxlength="9" id="telephone" name="telephone"><br><br>
            <input type="submit" value="Submit">
        </form>
        
        <?php
            /*
                *
                * @author Francisco José Gordo Salguero
                * Fecha Inicio: 11/12/2020
                * Fecha Fin: 15/12/2020
                * Curso: 2do FPS DAW Presencial
                * Modulo: Programación PHP
                * Practica Agenda con OOP, PDO y BBDD
                * @versión: 1.0
            */

                // put your code here

                /*function mi_autocargador($clase) {
                    include 'objects/' . $clase . '.clase.php';
                }
                spl_autoload_register('mi_autocargador');
                spl_autoload_register('messages');
                spl_autoload_register('user');*/
        
                include_once 'objects/messages.php';
                
                include_once 'config/database.php';
                
                $database = new Database();
                $db = $database->getConnection();
                $message = new Messages($db);
        
                function mostratTabla($message) {
                    echo "<table class='table table-hover table-responsive table-bordered'>";
                    echo "<tr>";
                        echo "<th> Name </th>";
                        echo "<th> Telephone </th>";
                    echo "</tr>";
                    $stmt = $message->readAllMessages();
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        extract($row);
                        echo "<tr>";
                            echo "<td> {$name} </td>";
                            echo "<td> {$telephone} </td>";
                        echo "</tr>";
                    };
                    echo "</table>";
                }
                
                if (!empty($_GET)) {
                    try {
                        

                        $message->name = $_GET['name'];
                        $message->telephone = $_GET['telephone'];
                        
                        if (empty($message->telephone)) {
                            if ($message->CountRows()) {
                                $message->DropRow();
                            }
                        } else {
                            if ($message->CountRows() > 0) {
                                if($message->UpdateRow()){
                                    echo "<div class='alert alert-success'>Contact was Updated.</div>";
                                } else {
                                    echo "<div class='alert alert-danger'>Contact wasn't Updated.</div>";
                                }
                            } else {
                                if($message->create()){
                                    echo "<div class='alert alert-success'>Contact was created.</div>";
                                } else {
                                    echo "<div class='alert alert-danger'>Contact wasn't created</div>";
                                }
                            }
                        }
                        if ($message->CountAllRows() > 0) {
                            mostratTabla($message);
                        }
                    // show Error
                    } catch (PDOException $exception) {
                        die('ERROR: ' . $exception->getMessage());
                    }
                } else {
                    if ($message->CountAllRows() > 0) {
                        mostratTabla($message);
                    }
                }
        ?>
    </body>
</html>