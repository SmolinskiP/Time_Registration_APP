<!DOCTYPE html>
<html>
<style>
body, head, html {
  height: 100%;
}

.bg {
  background-image: url("strona2.png");
  background:"black"
  height: 100%;

  background-position: center;
  background-repeat: no-repeat;
  background-size: cover;
}
</style>
<head>
<link rel="stylesheet" href="bg.css">
<title>Lista obecności</title>
</head>
<body>

<form action="poprawki.php" method="post">

<?php

$logged_user = strval($_SERVER['PHP_AUTH_USER']);

if (in_array($logged_user, array("")) == false)
    header('Location: https://p.pdaserwis.pl/rcp/');

$db = new mysqli('');
mysqli_set_charset($db,"utf8");

if ($logged_user == ""){
    $dzial = 5;}
elseif ($logged_user == ""){
    $dzial = 4;}
elseif ($logged_user == ""){
    $dzial = 3;}
elseif (in_array($logged_user, array(""))){
    $get_table = "SELECT * FROM pracownicy WHERE lokalizacja = 2 ORDER BY pracownicy.nazwisko";}
else{
    $get_table = "SELECT * FROM pracownicy ORDER BY pracownicy.nazwisko";}

if (isset($get_table) == false){
    $get_table = "SELECT * FROM pracownicy WHERE dzial = ".$dzial." ORDER BY pracownicy.nazwisko";}

$result = $db->query($get_table);

echo "<label for='employee'>Wybierz pracownika:</label>";
echo "<select name='employee' id='employee'>";

while ($r = $result->fetch_assoc())
{
    $id=$r['id'];
    $imie=$r['imie'];
    $nazwisko=$r['nazwisko'];
    echo "<option value=$id>$nazwisko $imie</option>";
}
echo "</select>";
?>

<br>
<label for='urlop_type'>Wybierz rodzaj wpisu:</label>
    <select name="urlop_type" id="urlop_type">
        <option value="1">Wejście</option>
        <option value="2">Wyjście</option>
    </select>
<br>

Wybierz datę:
<input type="date" id="urlop_data" name="urlop_data" value="<?php echo date('Y-m-d'); ?>">
<br>

Wybierz czas:
<input type="time" id="employee_time" name="employee_time" step="2" value="07:00:00">
<br>
Dodaj komentarz:
<input type="text" id="komentarz" name="komentarz">
<br><br>

<button type="submit" class="myButton">Wrzuć wpis do bazy</button>
</form>
</body>
</html>

<?php
$employee_id=$_POST['employee'];
$urlop_type=$_POST['urlop_type'];
$urlop_data=$_POST['urlop_data'];
$employee_time=$_POST['employee_time'];
$urlop_data=$urlop_data." ".$employee_time;
$OD_data = substr($urlop_data, 8, 2);
$DO_data = substr($urlop_data2, 8, 2);
$comment=$_POST['komentarz'];
echo "<br>";

$forbidden_chars = array("'", "\"", "\\", "=", "+", "-", "*", ";", ":");

$validance = 0;
if (isset($employee_id)) {
	foreach ($forbidden_chars as &$value){
		if (strpos($comment, $value) !== false){
			exit("Zakazane znaki, nieładnie");
			}}
        $urlop_data = substr($urlop_data, 0, 8).$OD_data." ".substr($urlop_data, 10);
        $update_table = ("INSERT INTO obecnosc (pracownik, time, action, komentarz) VALUES ('".$employee_id."', '".$urlop_data."', '".$urlop_type."', '".$comment."')");
        $db->query($update_table);
        echo "<br>";
        echo "$update_table";
}

?>

