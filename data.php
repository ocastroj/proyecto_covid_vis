<?php


// Crea una conexion a la base de datos y ejecuta el query
function getDataset($query){

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

    $results = $conn->query($query);
    $conn->close();
    return $results;
}


// Retorna un dataset con los casos confirmados por continente por dia
function getConfirmados_x_Continente_Diarios() {

    $sql = "SELECT continentes.nombre as Continent, confirmados.Date as Date, sum(confirmados.Cases) as Cases
    FROM confirmados 
    INNER JOIN continentes ON confirmados.Continent = continentes.codigo
    GROUP BY continentes.nombre, confirmados.Date";
    
    $result = getDataset($sql);

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
}


// Agrega un elemento al array de valores si la llave existe y si no, crea una nueva key y elemento
function update_keypair($arr, $key, $val)
{
   if(empty($arr[$key])) $arr[$key] = array($val);
   else $arr[$key][] = $val;
   return $arr;
}

?> 