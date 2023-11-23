<?php

// import db config
include 'config.php';

// db connection variable
global $host;
global $dbname;
global $username;
global $password;

// recuperation of data
$name = $_POST['name'];
$surname = $_POST['surname'];
$uid = $_POST['uid'];

// config connect db
$dsn = "pgsql:host=$host;port=5432;dbname=$dbname;user=$username;password=$password";

// db connection
$conn = new PDO($dsn);

// main try catch
try{
    if($conn) {
        // insertion request
        $insert_user = "INSERT INTO data.sensor (uuid, surname, name, privileged) VALUES (:uid, :surname, :name, :privileged)";

        // bind value for security
        $resultset = $conn->prepare($insert_user);
        $resultset->bindValue(':uid', md5($uid), PDO::PARAM_STR);
        $resultset->bindValue(':surname', $surname, PDO::PARAM_STR);
        $resultset->bindValue(':name', $name, PDO::PARAM_STR);
        $resultset->bindValue(':privileged', 1, PDO::PARAM_STR);

        // execute query and check status
        $query_executed = $resultset->execute();

        // intercept the response
        if ($query_executed) {
            echo "User created successfully !";
        } else {
            echo "User creation failed...";
        }
    }
    else{
        echo 'DB error';
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
