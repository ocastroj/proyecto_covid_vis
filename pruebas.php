<?php
  include('data.php');

  // Obtenemos los datasets para los graficos de pie
  $data = getAcumulados_Region_Pais_Estados();
  
  //echo($data);

?>

<!DOCTYPE HTML>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Proyecto Cenfotec - Vis COVID-19</title>
        <link rel="stylesheet" href="css/style.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.8.2/css/bulma.min.css">
        <script src="js/charts.js"></script>
        
	</head>
	<body>

    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/modules/export-data.js"></script>
    <script src="https://code.highcharts.com/modules/accessibility.js"></script>

<script src="https://code.highcharts.com/modules/data.js"></script>
<script src="https://code.highcharts.com/modules/heatmap.js"></script>
<script src="https://code.highcharts.com/modules/treemap.js"></script>


        <section class="section">
            <div class="container">

                <div class="columns">
                    <div class="column">
                        <figure class="highcharts-figure">
                            <div id="prueba"></div>
                        </figure>
  
                    </div> 
                </div>  

                <div class="columns">
                    <div class="column">
                        <figure class="highcharts-figure">
                            <div id="container"></div>
                        </figure>
  
                    </div> 
                </div>   
                
            </div>
        </section>



        <script type="text/javascript">
            var points = [],
            regionP,
            regionVal,
            regionI = 0,
            countryP,
            countryI,
            causeP,
            causeI,
            region,
            country,
            cause,
            causeName = {
                'Confirmados': '# Confirmados',
                'Fallecidos': '# Fallecidos',
                'Recuperados': '# Recuperados'
            };

            var countryCounter;

            data = <?=$data?>

            for (region in data) {
                //console.log(region);
                if (data.hasOwnProperty(region)) {
                    regionVal = 0;
                    regionP = {
                        id: 'id_' + regionI,
                        name: region,
                        color: Highcharts.getOptions().colors[regionI]
                    };

                    countryI = 0;

                    for (let countries in data[region]) {

                        
                        for (country in data[region][countries]) {

                            countryP = {
                                id: regionP.id + '_' + countryI,
                                name: country,
                                parent: regionP.id
                            };

                            points.push(countryP);
                            causeI = 0;

                            for (cause in data[region][countries][country]) {  
                                causeP = {
                                    id: countryP.id + '_' + causeI,
                                    name: causeName[cause],
                                    parent: countryP.id,
                                    value: Math.round(+data[region][countries][country][cause])
                                };
                                regionVal += causeP.value;
                                points.push(causeP);
                                causeI = causeI + 1;
                                console.log(causeP);
                            }
                            countryI = countryI + 1;
                        }
                    
                    }
                    regionP.value = Math.round(regionVal / countryI);
                    points.push(regionP);
                    regionI = regionI + 1;
                }
            }

            Highcharts.chart('prueba', {
            series: [{
                type: 'treemap',
                layoutAlgorithm: 'squarified',
                allowDrillToNode: true,
                animationLimit: 1000,
                dataLabels: {
                enabled: false
                },
                levelIsConstant: false,
                levels: [{
                level: 1,
                dataLabels: {
                    enabled: true
                },
                borderWidth: 3
                }],
                data: points
            }],
            subtitle: {
                text: 'Haga click sobre los graficos para hacer drilldown.'
            },
            title: {
                text: 'Cifras de COVID-19 en el Mundo'
            }
            });


        </script>
        
	</body>
</html>
