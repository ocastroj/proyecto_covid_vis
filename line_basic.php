<?php
  include('data.php');

  $json_data = getConfirmados_x_Continente_Diarios();
?>

<!DOCTYPE HTML>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Proyecto Cenfotec - Vis COVID-19</title>
        <link rel="stylesheet" href="style.css">
	</head>
	<body>

        <script src="code/highcharts.js"></script>
        <script src="code/modules/series-label.js"></script>
        <script src="code/modules/exporting.js"></script>
        <script src="code/modules/export-data.js"></script>
        <script src="code/modules/accessibility.js"></script>

        <figure class="highcharts-figure">
            <div id="container"></div>
        </figure>


        <script type="text/javascript">
            Highcharts.chart('container', {

                title: {
                    text: 'Números de casos confirmados por región'
                },

                subtitle: {
                    text: 'Fuente: Jonh Hopkins Univesity'
                },

                yAxis: {
                    title: {
                        text: 'Casos'
                    }
                },

                xAxis: {
                    accessibility: {
                        rangeDescription: 'Range: 2010 to 2017'
                    },
                    type: 'datetime'
                },

                legend: {
                    layout: 'vertical',
                    align: 'right',
                    verticalAlign: 'middle'
                },

                plotOptions: {
                    series: {
                        label: {
                            connectorAllowed: false
                        }
                    }
                },

                series: <?=$json_data?>
                ,

                responsive: {
                    rules: [{
                        condition: {
                            maxWidth: 500
                        },
                        chartOptions: {
                            legend: {
                                layout: 'horizontal',
                                align: 'center',
                                verticalAlign: 'bottom'
                            }
                        }
                    }]
                }

            });
		</script>
	</body>
</html>
