<!DOCTYPE html>
<html>
<style>
body, head, html {
  height: 100%;
}

.bg {
  /* The image used */
  background-image: url("strona2.png");
  background:"black"
  /* Full height */
  height: 100%;

  /* Center and scale the image nicely */
  background-position: center;
  background-repeat: no-repeat;
  background-size: cover;
}
</style>
<head>
<link rel="stylesheet" href="bg.css">
<title>Lista obecności</title>
</head>
<style>
table{
  border: 1px solid white;
  width: 60%;
  border-collapse: collapse;
  float: left;
}
tr{
    background-color: rgba(0, 0, 0, 0.0) !important;
}
th, td{
  border: 1px solid white;
  border-collapse: collapse;
  width: 15%;
}
caption{
  border: 3px solid black;
  border-collapse: collapse;
}
tr:nth-of-type(odd){
  background-color:#ccc;
}
</style>
<body>

Wybierz datę:
<div style="background-image: url('strona2.png');"> 
<! --- <img src="pp.png" alt="Logo" align="right"> --->
<form action="admin.php" method="post">

<input type="date" id="data2" name="data2" value="<?php echo date('Y-m-d'); ?>">
<label for="dzialy">Wybierz dzial:</label>
	<select name="dzialy" id="dzialy">
		<option value="1"<?php if($_POST['dzialy'] == '1'){ php?>selected<?php } php?>>Kadry i Ksiegowosc</option>
		<option value="2"<?php if($_POST['dzialy'] == '2'){ php?>selected<?php } php?>>Biuro</option>
		<option value="3"<?php if($_POST['dzialy'] == '3'){ php?>selected<?php } php?>>Magazyn</option>
		<option value="4"<?php if($_POST['dzialy'] == '4'){ php?>selected<?php } php?>>Logistyka</option>
		<option value="5"<?php if($_POST['dzialy'] == '5'){ php?>selected<?php } php?>>Serwis</option>
		<option value="13"<?php if($_POST['dzialy'] == '13'){ php?>selected<?php } php?>>Margines</option>
                <option value="9"<?php if($_POST['dzialy'] == '9'){ php?>selected<?php } php?>>Handlowcy</option>
                <option value="11"<?php if($_POST['dzialy'] == '11'){ php?>selected<?php } php?>>Marketing</option>
	</select>


<br><br>
<button type="submit" class="myButton">Przeladuj strone</button></form>
<?php
$logged_user = strval($_SERVER['PHP_AUTH_USER']);
?>
<a href="spoznienia.php">
   <button class="myButton">Stronka ze spoznieniami</button>
</a>

<br><br>
<?php

$logged_user = strval($_SERVER['PHP_AUTH_USER']);

if (in_array($logged_user, array('')) == false)
    header('Location: ');

$db = new mysqli('', '', '', '');
mysqli_set_charset($db,"utf8");
$dzial=$_POST['dzialy'];
if (!isset($dzial)){$dzial=5;}

$get_table = "SELECT pracownicy.id, pracownicy.imie, pracownicy.nazwisko, obecnosc.time, obecnosc.action FROM obecnosc LEFT JOIN pracownicy ON obecnosc.pracownik = pracownicy.id LEFT JOIN _dzial ON pracownicy.dzial = _dzial.id WHERE pracownicy.dzial = ".$dzial." AND action != 2 ORDER BY obecnosc.action, obecnosc.time, pracownicy.nazwisko";

$result = $db->query($get_table);

$html_data2 = $_POST['data2'];
if ($html_data2 == "")
	$html_data2 = date('Y-m-d');
echo "<font size=5>".$html_data2."</font><br><br>";
$user_input = $html_year."-".$html_month."-".$html_day;
$counting = 1;
while ($r = $result->fetch_assoc())
{
	$id=$r['id'];
	$imie=$r['imie'];
	$nazwisko=$r['nazwisko'];
	$time=$r['time'];
	$action=$r['action'];
	$data = substr($time, 0, 10);
	$czas = substr($time, 10, 10);
        if ($action > 4)
            $czas = "";
	if ($action == 1)
		$action = "Wejscie:";
	elseif ($action == 2)
		$action = "Wylogowanie";
	elseif ($action == 3)
		$action = "Przerwa";
	elseif ($action == 4)
		$action = "Koniec przerwy";
        elseif ($action == 5)
                $action = "Urlop wypoczynkowy";
        elseif ($action == 6)
                $action = "Urlop bezpłatny";
        elseif ($action == 7)
                $action = "Urlop na żądanie";
        elseif ($action == 8)
                $action = "Zwolnienie lekarskie"; 
        elseif ($action == 9)
                $action = "Nieobecność nieusprawiedliwiona";
        elseif ($action == 10)
                $action = "Urlop wychowawczy / macierzyński";
        elseif ($action == 11)
                $action = "Oddaje krew";
        elseif ($action == 12)
                $action = "Home Office";
        elseif ($action == 13)
                $action = "Nieobecność nieusprawiedliwiona / Oddaje krew";
        elseif ($action == 14)
                $action = "Urlop okolicznościowy";
        elseif ($action == 15)
                $action = "Opieka nad dzieckiem";
        elseif ($action == 16)
                $action = "Nieobecność usprawiedliwiona - zlecenie";
	if ($data == $html_data2){
		echo "<table><tr>
		<td style='width:1%';colspan=10>$counting</td>
		<td>$nazwisko</td>
		<td>$imie</td>
		<td style='width:15%'>$action</td>
		<td><b>$czas</b></td>";

		$get_table_logout = "SELECT time FROM obecnosc WHERE obecnosc.pracownik = ".$id." AND action = 2 AND TIME LIKE '".$data."%'";
		$result_logout = $db->query($get_table_logout);
		$r_logout = $result_logout->fetch_assoc();

		$czas_wyjscie = $r_logout['time'];
		$data_wyjscie = substr($czas_wyjscie, 0, 10);
	        $godz_wyjscie = substr($czas_wyjscie, 10, 10);
		$pracownik_wyjscie = $r_logout['imie'];
		if ($godz_wyjscie != ""){
			echo "<td style='width:7%'>Wylogowanie:</td><td><b>$godz_wyjscie</b></td></tr></table>";}
		else{echo "<td style='width:7%'>Wylogowanie:</td><td>Aktualnie obecny/a</td></tr></table>";}
		unset($czas_wyjscie);
		$counting++;
		}
}
echo "<br>";
echo '<div style = "clear:both;"></div>';
echo "<p style='font-size:30px'>Generowanie Excela:</p>";

if (in_array($logged_user, array(""))){
	$sql_query = "SELECT id, dzial FROM _dzial WHERE lokalizacja = 2";}
elseif (in_array($logged_user, array(""))){
	$sql_query = "SELECT id, dzial FROM _dzial";}
elseif (in_array($logged_user, array(""))){
	$sql_query = "SELECT id, dzial FROM _dzial WHERE id = 5";}
elseif (in_array($logged_user, array(""))){
        $sql_query = "SELECT id, dzial FROM _dzial WHERE id = 3";}
elseif (in_array($logged_user, array(""))){
        $sql_query = "SELECT id, dzial FROM _dzial WHERE id = 4";}


$default_time = date("Y-m-d");
echo '<form action="download.php" method="get">
Data (dzień nie jest istotny):<input type="date" id="excel_date" name="excel_date" value='.$default_time.'><br>';

$result = $db->query($sql_query);
echo '<label for="departments">Wybierz dzial (EXCEL):</label><select name="departments" id="departments">';

if (in_array($logged_user, array(""))){
	echo '<option value="69">Cały Płońsk</option>';
	echo '<option value="666">Cała Warszawa</option>';}

while ($r = $result->fetch_assoc())
{
	$department_id = $r['id'];
	$department = $r['dzial'];
	echo '<option value="'.$department_id.'">'.$department.'</option>';
}

echo '</select><br><br>
<button type="submit" class="myButton">Wygeneruj Excela</button></form>
<br>';


?>
</body>
<br><br><br><br><br><br>
<br><br><br>
<br><br><br>
<br><br><br>
<br><br><br>
<br><br><br>
<br><br><br>
<br><br><br>
<br><br><br>
<br><br><br>
<br><br><br>
<br><br><br>
<br><br><br>
<br><br><br>
<br><br><br>
<br><br><br>
<br><br><br>
<br><br><br>
<br><br><br>
<br><br><br>
<br><br><br>
<br><br><br>
<br><br><br>

</body>
</html>
