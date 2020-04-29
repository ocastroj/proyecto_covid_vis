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


// Obtenemos la fecha mas reciendo de datos
function getRecentDate() {
    $sql = "SELECT confirmados.Date
    FROM confirmados
    ORDER BY Date DESC
    LIMIT 1";

    $result = getDataset($sql);

    if ($result->num_rows > 0){
        while($row = $result->fetch_assoc()) {
            return($row['Date']);
        }
    }
    else {
        echo "No date";
    }
}

// Agrega un elemento al array de valores si la llave existe y si no, crea una nueva key y elemento
function update_keypair($arr, $key, $val)
{
   if(empty($arr[$key])) $arr[$key] = array($val);
   else $arr[$key][] = $val;
   return $arr;
}

// **************************
// CALCULO DE DATOS PARA GRAFICOS DE LINEAS
// **************************


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


// **************************
// CALCULO DE DATOS PARA GRAFICOS PIE
// **************************


// Retorna un dataset con los casos por pais acumulado
function getDatos_x_Pais_Acumulado($query) {

    $result = getDataset($query);

    if ($result->num_rows > 0) {

        $json = array();
        while($row = $result->fetch_assoc()) {

            $y = round((intval($row['Sub']) * 100) / intval($row['Total']),2);

            $json[] = array(
                'name' => $row['Country'], 
                'y' => $y
            );
        }

        $json2 = array(
            'name' => 'Confirmados',
            'data' => $json
        );

        $json3 = array(
            $json2
        );

        return json_encode($json3);

    } else {
        echo "0 results";
    }
}

function getConfirmados_x_Pais_Acumulado() {
    $date = getRecentDate();
    $sql = "SELECT Country, SUM(Cases) As Sub, 
    (SELECT SUM(Cases) FROM confirmados WHERE confirmados.Date = '$date') As Total
    FROM confirmados
    WHERE confirmados.Date = '$date'
    GROUP BY country
    ORDER BY Sub DESC
    LIMIT 6";
    return getDatos_x_Pais_Acumulado($sql);
}

function getFallecidos_x_Pais_Acumulado() {
    $date = getRecentDate();
    $sql = "SELECT Country, SUM(Cases) As Sub, 
    (SELECT SUM(Cases) FROM fallecidos WHERE fallecidos.Date = '$date') As Total
    FROM fallecidos
    WHERE fallecidos.Date = '$date'
    GROUP BY country
    ORDER BY Sub DESC
    LIMIT 6";
    return getDatos_x_Pais_Acumulado($sql);
}

function getRecuperados_x_Pais_Acumulado() {
    $date = getRecentDate();
    $sql = "SELECT Country, SUM(Cases) As Sub, 
    (SELECT SUM(Cases) FROM recuperados WHERE recuperados.Date = '$date') As Total
    FROM recuperados
    WHERE recuperados.Date = '$date'
    GROUP BY country
    ORDER BY Sub DESC
    LIMIT 6";
    return getDatos_x_Pais_Acumulado($sql);
}


// **************************
// CALCULO DE DATOS PARA GRAFICO TREEMAP
// **************************

function getAcumulados_Region_Pais_Estados() {
    $date = getRecentDate();
    $sql = "SELECT continentes.nombre AS Continent, confirmados.Country AS Country, 
    confirmados.Cases AS Confirmed,
    (SELECT fallecidos.Cases
     FROM fallecidos 
     WHERE confirmados.Country = fallecidos.Country AND
     fallecidos.Date = '$date'
    ) AS Deceased,
    (SELECT recuperados.Cases
     FROM recuperados 
     WHERE confirmados.Country = recuperados.Country AND
     recuperados.Date = '$date'
    ) AS Recovered
        FROM confirmados 
        INNER JOIN continentes ON confirmados.Continent = continentes.codigo
        WHERE confirmados.Date = '$date'
        GROUP BY continentes.nombre, confirmados.Country";

    $result = getDataset($sql);

    if ($result->num_rows > 0) {

        $json = array();
        while($row = $result->fetch_assoc()) {
            $region = $row['Continent'];
            $country = $row['Country'];
            $datos = array(
                $country => array (
                    'Confirmados' => intval($row['Confirmed']),
                    'Fallecidos' => intval($row['Deceased']),
                    'Recuperados' => intval($row['Recovered'])
                )
            );

            $json = update_keypair($json, $region, $datos);
        }

        return json_encode($json);
    } else {
        echo "No results";
    }
}

// **************************
// CALCULO DE TASA DE LETALIDAD
// **************************

function getTasa_Letalidad_Paises() {
    $date = getRecentDate();
    $sql = "SELECT continentes.nombre AS Continent, confirmados.Country AS Country, 
    ((
    (SELECT fallecidos.Cases
     FROM fallecidos 
     WHERE confirmados.Country = fallecidos.Country AND
     fallecidos.Date = '$date'
    ) / confirmados.Cases) * 100) AS LetalityRate
        FROM confirmados 
        INNER JOIN continentes ON confirmados.Continent = continentes.codigo
        WHERE confirmados.Date = '$date'
        GROUP BY continentes.nombre, confirmados.Country
        ORDER BY LetalityRate DESC
        LIMIT 25";

    $result = getDataset($sql);

    if ($result->num_rows > 0) {

       $datos = array();
        while($row = $result->fetch_assoc()) {
            $datos[] = array(
                'name' => $row['Country'],
                'data' => (float) ($row['LetalityRate'])
            );
            // $datos[] = array(
            //     $row['Country'],
            //     (float) $row['LetalityRate']
            // );

        }

        return json_encode($datos);

    } else {
        echo "No results";
    }
}
?> 