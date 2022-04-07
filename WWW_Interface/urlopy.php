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

<form action="urlopy.php" method="post">

<?php

if (strval($_SERVER['PHP_AUTH_USER']) != '')
    header('Location: ');

$db = new mysqli('');
mysqli_set_charset($db,"utf8");

$get_table = "SELECT * FROM pracownicy ORDER BY pracownicy.nazwisko";
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
<!---<label for='urlop_type'>Wybierz rodzaj urlopu:</label>
    <select name="urlop_type" id="urlop_type">
        <option value="1">Wejście</option>
        <option value="2">Wyjście</option>
        <option value="5">Urlop wypoczynkowy</option>
        <option value="6">Urlop bezpłatny</option>
        <option value="7">Urlop na żądanie</option>
        <option value="8">Zwolnienie lekarskie</option>
        <option value="9">Nieobecność nieusprawiedliwiona</option>
        <option value="10">Urlop wychowawczy / macierzyński</option>
        <option value="11">Nieobecność usprawiedliwiona</option>
        <option value="12">Home Office</option>
        <option value="13">Nieobecność usprawiedliwiona / Oddaje krew</option>
	<option value="14">Urlop okolicznościowy</option>
	<option value="15">Opieka nad dzieckiem art. 188 kp.</option>
	<option value="16">Nieobecność usprawiedliwiona - zlecenie</option>
    </select>
<br>
--->
<?php
echo "<label for='urlop_type'>Wybierz rodzaj urlopu:</label><select name='urlop_type' id='urlop_type'>";
$sql_query = "SELECT id, action FROM _action";
$result = $db->query($sql_query);
while ($r = $result->fetch_assoc())
{
        $action_id = $r['id'];
        $action = $r['action'];
        echo '<option value="'.$action_id.'">'.$action.'</option>';
}
echo "</select><br>";
?>


Wybierz datę:
OD <input type="date" id="urlop_data" name="urlop_data" value="<?php echo date('Y-m-d'); ?>">
DO <input type="date" id="urlop_data2" name="urlop_data2" value="<?php echo date('Y-m-d'); ?>">

<br>

Wybierz czas:
<input type="time" id="employee_time" name="employee_time" step="2" value="07:00:00">
<br>
Dodaj komentarz:
<input type="text" id="komentarz" name="komentarz">
<br><br>

<button type="submit" class="myButton">Wyślij pracownika na urlop ;)</button>
</form>
</body>
</html>

<?php
$employee_id=$_POST['employee'];
$urlop_type=$_POST['urlop_type'];
$urlop_data=$_POST['urlop_data'];
$urlop_data2=$_POST['urlop_data2'];
$employee_time=$_POST['employee_time'];
$urlop_data=$urlop_data." ".$employee_time;
$OD_data = substr($urlop_data, 8, 2);
$DO_data = substr($urlop_data2, 8, 2);
$comment=$_POST['komentarz'];
echo "<br>";

$forbidden_chars = array("'", "\"", "\\", "=", "+", "-", "*", ";", ":");

if (isset($employee_id)) {
    foreach ($forbidden_chars as &$value){
                if (strpos($comment, $value) !== false){
                        exit("Zakazane znaki, nieładnie");
                        }}
    while ($OD_data <= $DO_data)
    {
        $urlop_data = substr($urlop_data, 0, 8).$OD_data." ".substr($urlop_data, 10);
        $update_table = ("INSERT INTO obecnosc (pracownik, time, action, komentarz) VALUES ('".$employee_id."', '".$urlop_data."', '".$urlop_type."', '".$comment."')");
        $db->query($update_table);
        $OD_data++;
        echo "<br>";
        echo "$update_table";
    }
}

?>

