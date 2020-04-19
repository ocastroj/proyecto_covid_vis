<?php
  include('data.php');

  // Obtenemos los datasets para los graficos de linea
  $line_confirmados_data = getConfirmados_x_Continente_Diarios();
  $line_fallecidos_data = getFallecidos_x_Continente_Diarios();
  $line_recuperados_data = getRecuperados_x_Continente_Diarios();
?>

<!DOCTYPE HTML>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Proyecto Cenfotec - Vis COVID-19</title>
        <link rel="stylesheet" href="style.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.8.2/css/bulma.min.css">
        
	</head>
	<body>

        <script src="code/highcharts.js"></script>
        <script src="code/modules/series-label.js"></script>
        <script src="code/modules/exporting.js"></script>
        <script src="code/modules/export-data.js"></script>
        <script src="code/modules/accessibility.js"></script>
        <script defer src="https://use.fontawesome.com/releases/v5.3.1/js/all.js"></script>

        <section class="section">
            <div class="container">

                <div class="columns">

                    <div class="column">
                        <figure class="highcharts-figure">
                            <div id="line-confirmados-region"></div>
                        </figure>
                    </div>

                    <div class="column">
                        <figure class="highcharts-figure1">
                            <div id="line-fallecidos-region"></div>
                        </figure>
                    </div>

                    <div class="column">
                        <figure class="highcharts-figure2">
                            <div id="line-recuperados-region"></div>
                        </figure>
                    </div>

                </div>
            </div>   
        </section>



        <script type="text/javascript">
            Highcharts.chart('line-confirmados-region', {

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

                series: <?=$line_confirmados_data?>
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

            Highcharts.chart('line-fallecidos-region', {

                title: {
                    text: 'Números de casos fallecidos por región'
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

                series: <?=$line_fallecidos_data?>
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


                Highcharts.chart('line-recuperados-region', {

                    title: {
                        text: 'Números de casos recuperados por región'
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

                    series: <?=$line_recuperados_data?>
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
