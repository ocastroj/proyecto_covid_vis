<?php
  include('data.php');

  // Obtenemos los datasets para los graficos de linea
  $line_confirmados_data = getConfirmados_x_Continente_Diarios();
  $line_fallecidos_data = getFallecidos_x_Continente_Diarios();
  $line_recuperados_data = getRecuperados_x_Continente_Diarios();

  // Obtenemos los datasets para los graficos de pie
  $pie_confirmados_data = getConfirmados_x_Pais_Acumulado();
  $pie_fallecidos_data = getFallecidos_x_Pais_Acumulado();
  $pie_recuperados_data = getRecuperados_x_Pais_Acumulado();

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
                        <figure class="highcharts-figure">
                            <div id="line-fallecidos-region"></div>
                        </figure>
                    </div>

                    <div class="column">
                        <figure class="highcharts-figure">
                            <div id="line-recuperados-region"></div>
                        </figure>
                    </div>

                </div>

                <div class="columns">
                    <div class="column">
                        <figure class="highcharts-figure-pie">
                            <div id="pie-confirmados-region"></div>
                        </figure>
                    </div> 

                    <div class="column">
                        <figure class="highcharts-figure-pie">
                            <div id="pie-fallecidos-region"></div>
                        </figure>
                    </div> 

                    <div class="column">
                        <figure class="highcharts-figure-pie">
                            <div id="pie-recuperados-region"></div>
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

            // Make monochrome colors
            var pieColors = (function () {
            var colors = [],
                base = Highcharts.getOptions().colors[0],
                i;

            for (i = 0; i < 10; i += 1) {
                // Start out with a darkened base color (negative brighten), and end
                // up with a much brighter color
                colors.push(Highcharts.color(base).brighten((i - 3) / 7).get());
            }
            return colors;
            }());

            // Build the chart
            Highcharts.chart('pie-confirmados-region', {
            chart: {
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false,
                type: 'pie'
            },
            title: {
                text: 'Paises con mayor cantidad de casos confirmados'
            },
            tooltip: {
                pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
            },
            accessibility: {
                point: {
                valueSuffix: '%'
                }
            },
            plotOptions: {
                pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                colors: pieColors,
                dataLabels: {
                    enabled: true,
                    format: '<b>{point.name}</b><br>{point.percentage:.1f} %',
                    distance: -50,
                    filter: {
                    property: 'percentage',
                    operator: '>',
                    value: 4
                    }
                }
                }
            },
            series: <?=$pie_confirmados_data?>
            });

        
            Highcharts.chart('pie-fallecidos-region', {
                chart: {
                    plotBackgroundColor: null,
                    plotBorderWidth: null,
                    plotShadow: false,
                    type: 'pie'
                },
                title: {
                    text: 'Paises con mayor cantidad de casos fallecidos'
                },
                tooltip: {
                    pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
                },
                accessibility: {
                    point: {
                    valueSuffix: '%'
                    }
                },
                plotOptions: {
                    pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    colors: pieColors,
                    dataLabels: {
                        enabled: true,
                        format: '<b>{point.name}</b><br>{point.percentage:.1f} %',
                        distance: -50,
                        filter: {
                        property: 'percentage',
                        operator: '>',
                        value: 4
                        }
                    }
                    }
                },
                series: <?=$pie_fallecidos_data?>
            });

            Highcharts.chart('pie-recuperados-region', {
                chart: {
                    plotBackgroundColor: null,
                    plotBorderWidth: null,
                    plotShadow: false,
                    type: 'pie'
                },
                title: {
                    text: 'Paises con mayor cantidad de casos recuperados'
                },
                tooltip: {
                    pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
                },
                accessibility: {
                    point: {
                    valueSuffix: '%'
                    }
                },
                plotOptions: {
                    pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    colors: pieColors,
                    dataLabels: {
                        enabled: true,
                        format: '<b>{point.name}</b><br>{point.percentage:.1f} %',
                        distance: -50,
                        filter: {
                        property: 'percentage',
                        operator: '>',
                        value: 4
                        }
                    }
                    }
                },
                series: <?=$pie_recuperados_data?>
            });


		</script>
	</body>
</html>