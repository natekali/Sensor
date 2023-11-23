<?php

////////////////////////////////////////////////////////////////////////////////////////
//                                                                                    //
// USAGE :                                                                            //
// curl "https://localhost:8888/api_sensor/index.php?uid=XXXXXXXXXXXXXXX"             //
//                                                                                    //
////////////////////////////////////////////////////////////////////////////////////////

// import db config
include 'config.php';

// db connection variable
global $host;
global $dbname;
global $username;
global $password;

// value declaration
$allowed_uid = [];
$message = null;
$surname = null;
$name = null;
$error = null;
$authorized_uid = null;
$user_surname = null;
$user_name = null;
$allowed = false;

// authorized time rules
date_default_timezone_set('Europe/Paris');
$current_timestamp = time();
$allowed_access_start = strtotime('22:00'); // CHANGE TIMES RULES START HERE
$allowed_access_end = strtotime('23:00');   // CHANGE TIMES RULES END HERE

// if times rules not respected, exit
if ($current_timestamp >= $allowed_access_start && $current_timestamp <= $allowed_access_end) {
    echo "Access restricted at this time";
    exit;
}

// verification methode used
if ($_SERVER['HTTPS'] !== 'on') {
    echo 'HTTPS is required for request';
    exit;
}

// config connect db
$dsn = "pgsql:host=$host;port=5432;dbname=$dbname;user=$username;password=$password";

// connexion a la base de donnees
$conn = new PDO($dsn);

// main try-catch
try{
    if($conn) {
        // recuperation de la whitelist
        $sql_wl = "SELECT
                      uuid
                   FROM 
                      data.sensor
                   WHERE
                       privileged = TRUE;";

        // send request to get the whitelist
        $resultset_wl = $conn->prepare($sql_wl);
        $resultset_wl->execute();

        // store wl in an array
        while ($row_uid = $resultset_wl->fetchColumn()) {
            $allowed_uid[] = $row_uid;
        }

        // recuperation methode used
        $request_method = $_SERVER["REQUEST_METHOD"];

        // verification methode used
        if ($request_method === "GET") {

            // recup of card uid
            $sensor_uid = trim(@$_GET['uid']);

            // check the whitelist
            foreach ($allowed_uid as $uid) {
                if (md5($sensor_uid) == $uid) {
                    // if user is allowed, $allowed is true
                    $allowed = true;

                    // for personal response
                    $authorized_uid = $uid;

                    // quit loop
                    break;
                }
            }

            // personalize the response
            if ($allowed) {
                // final response setup
                $message = "ACCESS GRANTED";

                // personalized welcome message
                $sql_perso = "SELECT
                                surname,
                                name
                              FROM 
                                data.sensor
                              WHERE
                                uuid = :uuid;";
                // execute the request
                $resultset_perso = $conn->prepare($sql_perso);
                $resultset_perso->bindValue(':uuid', $authorized_uid, PDO::PARAM_STR);
                $resultset_perso->execute();

                // recuperation of user data
                $user_info = $resultset_perso->fetch(PDO::FETCH_ASSOC);
                $user_surname = $user_info['surname'];
                $user_name = $user_info['name'];

            } else {
                // user blacklist process
                //$sql_bl = "INSERT INTO data.sensor (uuid, surname, name, privileged) VALUES (:uuid, :surname, :name, :privileged)";
                //$resultset_bl = $conn->prepare($sql_bl);
                //$resultset_bl->bindValue(':uuid', $sensor_uid, PDO::PARAM_STR);
                //$resultset_bl->bindValue(':surname', $surname, PDO::PARAM_STR);
                //$resultset_bl->bindValue(':name', $name, PDO::PARAM_STR);
                //$resultset_bl->bindValue(':privileged', 0, PDO::PARAM_STR);
                //$resultset_bl->execute();

                // final response setup
                $message = "ACCESS DENIED";
            }

            // debug response
            echo $message;
            // if allowed, echo user data
            if ($allowed && $user_surname != null && $user_name != null){
                echo "\nWelcome $user_surname $user_name !";
            }

            // logs creation
            $sql_logs = "INSERT INTO data.logs (uuid, message) VALUES (:uuid, :logs)";
            $resultset_logs = $conn->prepare($sql_logs);
            $resultset_logs->bindValue(':uuid', md5($sensor_uid), PDO::PARAM_STR);
            $resultset_logs->bindValue(':logs', $message, PDO::PARAM_STR);
            $resultset_logs->execute();

        } else {
            echo "Wrong method used";
            exit;
        }
    }
// catch error and sql error
} catch (PDOException $e) {
    $error = $e->getMessage();
} catch (Exception $e) {
    $error = $e->getMessage();
} finally {
    if ($error != null){
        echo $error;
    }
    $conn = null;
}
?>
