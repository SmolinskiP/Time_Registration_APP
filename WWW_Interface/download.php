<?php
$department = $_GET['departments'];
$date = $_GET['excel_date'];

if (isset($date)){
	$year = substr($date, 0, 4);
	$month = intval(substr($date, 5, 2));}

$logged_user = strval($_SERVER['PHP_AUTH_USER']);

echo "ROK - status     :".isset($year)."<br>";
echo "Miesiąc - status :".isset($month)."<br>";
echo "Dział - status   :".isset($department)."<br>";

if (isset($year) == 0){
	echo "Nie ustawiony rok<br>";
        $year = date("Y");}
if (isset($month) == 0){
	echo "Nie ustawiony miesiac<br>";
        $month = intval(date("m"));}
if (isset($department) == 0){
	if (in_array($logged_user, array(""))){
		$department = 5;}
	elseif (in_array($logged_user, array(""))){
		$department = 4;}
	elseif (in_array($logged_user, array(""))){
		$department = 3;}
	elseif (in_array($logged_user, array(""))){
		$department = 2;}
	elseif (in_array($logged_user, array(""))){
		$department = 1;}
	elseif (in_array($logged_user, array(""))){
		$department = 57;}
	else{
		$department = 57;}
}
if ($department == "69"){
	$department = 0;
	$localization = 1;}
elseif ($department == "666"){
	$department = 0;
	$localization = 2;}
else{
	$localization = 1;}


echo "Dzial: ".$department;
echo "<br>";
echo "Lokalizacja: ".$localization;
echo "<br>";
echo "Rok: ".$year;
echo "<br>";
echo "Miesiac: ".$month;
echo "<br>";


exec("python3 /var/www/html/rcp/RCPexcel.py ".$localization." ".$department." ".$month." ".$year);

header('Location: Obecnosc.xlsx');
?>

