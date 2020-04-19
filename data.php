<?php

// **************************
// UTILIDADES
// **************************

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



// **************************
// CALCULO DE DATOS PARA GRAFICOS DE LINEAS
// **************************

// Agrega un elemento al array de valores si la llave existe y si no, crea una nueva key y elemento
function update_keypair($arr, $key, $val)
{
   if(empty($arr[$key])) $arr[$key] = array($val);
   else $arr[$key][] = $val;
   return $arr;
}


// Retorna un dataset con los casos  por continente por dia
function getDatos_x_Continente_Diarios($query) {

    $result = getDataset($query);

    if ($result->num_rows > 0) {
        // output data of each row

        $arr = array();
        while($row = $result->fetch_assoc()) {
            $key = $row['Continent'];
            $just_date = strtotime($row['Date']) * 1000;
            $value = array($just_date, intval($row['Cases']));
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

function getConfirmados_x_Continente_Diarios() {
    $sql = "SELECT continentes.nombre as Continent, confirmados.Date as Date, SUM(confirmados.Cases) as Cases
    FROM confirmados 
    INNER JOIN continentes ON confirmados.Continent = continentes.codigo
    GROUP BY continentes.nombre, confirmados.Date";
    return getDatos_x_Continente_Diarios($sql);
}

function getFallecidos_x_Continente_Diarios() {
    $sql = "SELECT continentes.nombre as Continent, fallecidos.Date as Date, SUM(fallecidos.Cases) as Cases
    FROM fallecidos 
    INNER JOIN continentes ON fallecidos.Continent = continentes.codigo
    GROUP BY continentes.nombre, fallecidos.Date";
    return getDatos_x_Continente_Diarios($sql);
}

function getRecuperados_x_Continente_Diarios() {
    $sql = "SELECT continentes.nombre as Continent, recuperados.Date as Date, SUM(recuperados.Cases) as Cases
    FROM recuperados 
    INNER JOIN continentes ON recuperados.Continent = continentes.codigo
    GROUP BY continentes.nombre, recuperados.Date";
    return getDatos_x_Continente_Diarios($sql);
}


?> 