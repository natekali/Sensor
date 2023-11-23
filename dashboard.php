<!DOCTYPE html>
<html>
<head>
    <title>Dashboard Sensor</title>
</head>
<body>

<h2>Privileged User Creation</h2>

<form method="post" action="creation.php">
    <label for="name">Name :</label>
    <input type="text" id="name" name="name"><br><br>

    <label for="surname">Surname :</label>
    <input type="text" id="surname" name="surname"><br><br>

    <label for="uid">Uid :</label>
    <input type="text" id="uid" name="uid"><br><br>

    <input type="submit" value="Submit">
</form>

<h2>Simple User Deletion</h2>

<form method="post" action="deletion.php">
    <label for="name">Name :</label>
    <input type="text" id="name" name="name"><br><br>

    <label for="surname">Surname :</label>
    <input type="text" id="surname" name="surname"><br><br>

    <input type="submit" value="Submit">
</form>

</body>
</html>


