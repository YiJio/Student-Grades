<?php
$username = "root";
$password = "";
$database = "databasename";
$server = "127.0.0.1";

$connect = @mysqli_connect($server, $username, $password);
$select = mysqli_select_db($connect, $database);

if(!$connect) { die("Connection failed: ".mysqli_error()); }
if(!$select) { die("Selection failed: ".mysqli_error()); }

$SQL = "SELECT * FROM data";
$result = mysqli_query($connect, $SQL);
$subjects = array();
$students = array();
$count = 0;
while($field = mysqli_fetch_assoc($result)) {
    $students[$count] = $field['name'];
	$subjects[$count] = $field['subject'];
	$count++;
}
$students = array_values(array_flip(array_flip($students)));
$subjects = array_values(array_flip(array_flip($subjects)));
$numstudents = count($students);
$numsubjects = count($subjects);

echo '<table>';
echo '<tr><th>Name</th>';
// print subject headings
for($i = 0; $i < $numsubjects; $i++) {
    echo '<th>'.$subjects[$i].'</th>';
}
echo '</tr>';
// print data
for($j = 0; $j < $numstudents; $j++) {
    $studentdata = array();
    $studentdata[0] = $students[$j];
    for($i = 0; $i < $numsubjects; $i++) {
        $SQL = "SELECT * FROM data WHERE name = '$students[$j]' AND subject = '$subjects[$i]'";
        $result = mysqli_query($connect, $SQL);
		$field = mysqli_fetch_assoc($result);
		$studentdata[$i + 1] = $field['grade'];
    }
    $total = count($studentdata);
    echo '<tr>';
    for($i = 0; $i < $total; $i++) {
        echo '<td>'.$studentdata[$i].'</td>';
    }
    echo '</tr>';
}
echo '</table>';
?>
