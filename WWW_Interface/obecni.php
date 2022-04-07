<!DOCTYPE html>
<html>
<head>
<title>Lista obecności</title>
</head>
<style>
table{
  border: 1px solid black;
  width: 100%;
  border-collapse: collapse;
  float: left;
}
th, td{
  border: 1px solid black;
  border-collapse: collapse;
  width: 25%;
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

<form action="index.php" method="post">

<input type="date" id="data2" name="data2" value="<?php echo date('Y-m-d'); ?>">
<br><br>
<button type="submit">Przeladuj strone</button></form>
<br><br>

<?php
$db = new mysqli('localhost', 'rcp', 'PDArcpSERWIS', 'RFID');
mysqli_set_charset($db,"utf8");

$get_table = "SELECT pracownicy.nazwisko, pracownicy.imie, obecnosc.time, obecnosc.action FROM pracownicy LEFT JOIN obecnosc ON obecnosc.pracownik = pracownicy.id ORDER BY obecnosc.time, pracownicy.nazwisko, obecnosc.action";
$result = $db->query($get_table);

//$html_day = $_POST['dzien'];
//$html_month = $_POST['miesiac'];
//$html_year = $_POST['rok'];
$html_data2 = $_POST['data2'];
if ($html_data2 == "")
	$html_data2 = date('Y-m-d');
echo "<font size=20>".$html_data2."</font><br><br>";
//echo $html_data2;
//echo gettype($html_data2);
$user_input = $html_year."-".$html_month."-".$html_day;
//echo $user_input;

while ($r = $result->fetch_assoc())
{
	$imie=$r['imie'];
	$nazwisko=$r['nazwisko'];
	$time=$r['time'];
	$action=$r['action'];
//	echo gettype($time);
//	echo $time;
	$data = substr($time, 0, 10);
	$czas = substr($time, 10, 10);
//	echo "<br>";
//	echo $data;
	if ($action == 1)
		$action = "Wejscie";
	elseif ($action == 2)
		$action = "Wylogowanie";
	elseif ($action == 3)
		$action = "Przerwa";
	elseif ($action == 4)
		$action = "Koniec przerwy";
	if ($data == $html_data2)
		echo "<table><tr>
		<td colspan=10>$nazwisko</td>
		<td>$imie</td>
		<td>$czas</td>
		<td>$action</td>
		</tr></table>";
}

echo "</body>";
echo "</html>";
?>
