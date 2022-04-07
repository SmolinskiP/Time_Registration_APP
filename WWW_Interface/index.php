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
  width: 75%;
  border-collapse: collapse;
  float: left;
}
tr{
    background-color: rgba(0, 0, 0, 0.0) !important;
}
th, td{
  border: 1px solid white;
  border-collapse: collapse;
  width: 10%;
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
<form action="index.php" method="post">

<input type="date" id="data2" name="data2" value="<?php echo date('Y-m-d'); ?>">
<br><br>
<button type="submit" class="myButton">Przeladuj strone</button></form>
<br>
<a href="download.php">
   <button class="myButton">Wygeneruj Excela</button>
</a>
<br><br>
<?php
$db = new mysqli('');
mysqli_set_charset($db,"utf8");
$logout_text = "Aktualnie obecny/a";
$logout_array = array("Drapie się po... nodze", "Zbija bąki na stanowisku", "Bombluje z MC90", "Byczy się obok lutownicy", "Udaje, że siedzi w kiblu", "Włóczy się bez celu po firmie", "Legalnie się opieprza", "Zgubił się we frezarkowni", "Podziwia matę antyprzepięciową", "Szuka Marcina i nie może znaleźć", "Chowa się przed Anią", "Udaje, że go nie ma", "Podłącza plus do minusa", "Zastanawia się, gdzie jest Nemo", "Zaplątał się w kabel od internetów", "Czyta instrukcję obsługi śrubokręta", "Szkaluje współpracowników na GoWorku");
$html_data2 = $_POST['data2'];
if ($html_data2 == "")
        $html_data2 = date('Y-m-d');

if ($_SERVER['PHP_AUTH_USER'] == '')
    $dzial = 5;
elseif ($_SERVER['PHP_AUTH_USER'] == '')
    $dzial = 4;
elseif ($_SERVER['PHP_AUTH_USER'] == '')
    $dzial = 3;
elseif ($_SERVER['PHP_AUTH_USER'] == '')
    $dzial = 2;
elseif ($_SERVER['PHP_AUTH_USER'] == '')
    $dzial = 2;
elseif ($_SERVER['PHP_AUTH_USER'] == '')
    $dzial = 1;
else
    $dzial = 5;
$get_table = "SELECT pracownicy.id, pracownicy.imie, pracownicy.nazwisko, obecnosc.time, obecnosc.action FROM obecnosc LEFT JOIN pracownicy ON obecnosc.pracownik = pracownicy.id LEFT JOIN _dzial ON pracownicy.dzial = _dzial.id WHERE pracownicy.dzial = ".$dzial." AND action != 2  AND obecnosc.time LIKE '".$html_data2."%' ORDER BY obecnosc.action, pracownicy.nazwisko";

if ($_SERVER['PHP_AUTH_USER'] == ''){
    $get_table = "SELECT pracownicy.id, pracownicy.imie, pracownicy.nazwisko, obecnosc.time, obecnosc.action FROM obecnosc LEFT JOIN pracownicy ON obecnosc.pracownik = pracownicy.id LEFT JOIN _dzial ON pracownicy.dzial = _dzial.id WHERE pracownicy.teamleader = 1 AND obecnosc.time LIKE '".$html_data2."%' AND obecnosc.action !=2 ORDER BY obecnosc.action, obecnosc.time";
    $logout_text = "Jeszcze się obija";}
elseif ($_SERVER['PHP_AUTH_USER'] == ''){
    $get_table = "SELECT pracownicy.id, pracownicy.imie, pracownicy.nazwisko, obecnosc.time, obecnosc.action FROM obecnosc LEFT JOIN pracownicy ON obecnosc.pracownik = pracownicy.id WHERE pracownicy.teamleader = 2 AND action != 2  AND obecnosc.time LIKE '".$html_data2."%' ORDER BY obecnosc.action, obecnosc.time";
    $logout_text = "Jeszcze się obija";}
elseif ($_SERVER['PHP_AUTH_USER'] == '')
    $get_table = "SELECT pracownicy.id, pracownicy.imie, pracownicy.nazwisko, obecnosc.time, obecnosc.action FROM obecnosc LEFT JOIN pracownicy ON obecnosc.pracownik = pracownicy.id LEFT JOIN _dzial ON pracownicy.dzial = _dzial.id WHERE pracownicy.teamleader = 3 AND action != 2  AND obecnosc.time LIKE '".$html_data2."%' ORDER BY obecnosc.action, obecnosc.time";
elseif ($_SERVER['PHP_AUTH_USER'] == '')
    $get_table = "SELECT pracownicy.id, pracownicy.imie, pracownicy.nazwisko, obecnosc.time, obecnosc.action FROM obecnosc LEFT JOIN pracownicy ON obecnosc.pracownik = pracownicy.id LEFT JOIN _dzial ON pracownicy.dzial = _dzial.id WHERE pracownicy.teamleader = 4 AND action != 2  AND obecnosc.time LIKE '".$html_data2."%' ORDER BY obecnosc.action, obecnosc.time";
$result = $db->query($get_table);


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
        if ($action > 4){
            $czas = "";}
	if ($action == 1){
		$action = "Wejscie:";}
	elseif ($action == 2){
		$action = "Wylogowanie";}
	elseif ($action == 3){
		$action = "Przerwa";}
	elseif ($action == 4){
		$action = "Koniec przerwy";}
        elseif ($action > 4){
                $action = "URLOP/ZWOLNIENIE";}
		echo "<table><tr>
		<td style='width:1%';colspan=10>$counting</td>
		<td>$nazwisko</td>
		<td>$imie</td>
		<td style='width:5%'>$action</td>
		<td style='width:5%'>$czas</td>";
		$get_table_logout = "SELECT time FROM obecnosc WHERE obecnosc.pracownik = ".$id." AND action = 2 AND TIME LIKE '".$data."%'";
                $result_logout = $db->query($get_table_logout);
                $r_logout = $result_logout->fetch_assoc();

                $czas_wyjscie = $r_logout['time'];
                $data_wyjscie = substr($czas_wyjscie, 0, 10);
                $godz_wyjscie = substr($czas_wyjscie, 10, 10);
                $pracownik_wyjscie = $r_logout['imie'];
		if ($godz_wyjscie != ""){
	                echo "<td style='width:7%'>Wylogowanie:</td><td>$godz_wyjscie</td></tr></table>";}
		elseif ($_SERVER['PHP_AUTH_USER'] == ''){
			$logout_text = $logout_array[array_rand($logout_array)];
			echo "<td style='width:7%'>Wylogowanie:</td><td>$logout_text</td></tr></table>";}
		elseif ($_SERVER['PHP_AUTH_USER'] == ''){
                        $logout_text = $logout_array[array_rand($logout_array)];
                        echo "<td style='width:7%'>Wylogowanie:</td><td>$logout_text</td></tr></table>";}
		elseif ($_SERVER['PHP_AUTH_USER'] == ''){
                        $logout_text = $logout_array[array_rand($logout_array)];
                        echo "<td style='width:7%'>Wylogowanie:</td><td>$logout_text</td></tr></table>";}
		elseif ($_SERVER['PHP_AUTH_USER'] == ''){
                        $logout_text = $logout_array[array_rand($logout_array)];
                        echo "<td style='width:7%'>Wylogowanie:</td><td>$logout_text</td></tr></table>";}
		else{
			echo "<td style='width:7%'>Wylogowanie:</td><td>$logout_text</td></tr></table>";}
                unset($czas_wyjscie);
		$counting = $counting + 1;
}

echo "</body>";
echo "</html>";
?>
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
