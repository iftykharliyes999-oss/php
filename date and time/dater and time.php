

<?php
echo date('t');
echo "<br>";
echo date('d');
echo "<br>";
echo date('f');
echo "<br>";
echo date('m');
echo "<br>";
echo date('F');
echo "<br>";
echo date('M');
echo "<br>";
echo date('y');
echo "<br>";
echo date('D');
echo "<br>";
echo date('r');
echo "<br>";
echo date('d/m/y');
echo "<br>";
echo date('n');
echo "<br>";
echo date('d');
echo "<br>";
echo date('d');
echo "<br>";
echo date_default_timezone_set("Asia/Dhaka");
echo date("Y-m-d h:i:s");
echo "<br>";
$birthDate = new DateTime("2002-05-15");
$today = new DateTime("2026-03-11");

$diff = $birthDate->diff($today);

echo "Years: " . $diff->y . "<br>";
echo "Months: " . $diff->m . "<br>";
echo "Days: " . $diff->d . "<br>";
$birthDate = new DateTime("2002-05-15");
$today = new DateTime("2026-03-11");

$diff = $birthDate->diff($today);

$totalDays = $diff->days;
$weeks = floor($totalDays / 7);
$hours = $totalDays * 24;

echo "Total Days: $totalDays <br>";
echo "Weeks: $weeks <br>";
echo "Hours: $hours";

?>