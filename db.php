<?php
$servername = "localhost";
$username = "covid";
$password = "cenfotec";
$dbname = "covid";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT Continent, Date, SUM(Cases) as Cases FROM confirmados GROUP BY Continent, Date";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    // output data of each row

    $arr = array();
    while($row = $result->fetch_assoc()) {
        // $arr = array (
        //     'name' => $row['Continent'],
        //     'data' => array_map('intval', explode(",",$row['Cases']))
        // );

        // $series_array[] = $arr;
        $key = $row['Continent'];

        $just_date = strtotime($row['Date']) * 1000;
        //strtotime($row['Date']);
        //$strip = $date->format('Y-m-d');
       // $converted_date = date()
        $value = array($just_date, intval($row['Cases']));
        //$value = $row['Cases'];
        $arr = update_keypair($arr, $key, $value);

    }


    foreach($arr as $key => $value){
        $json[] = array (
            'name' => $key,
            'data' => $value
        );
    }

    return json_encode($json);

} else {
    echo "0 results";
}
$conn->close();


// Agrega un elemento al array de valores si la llave existe y si no, crea una nueva key y elemento
function update_keypair($arr, $key, $val)
{
   if(empty($arr[$key])) $arr[$key] = array($val);
   else $arr[$key][] = $val;
   return $arr;
}
?> 