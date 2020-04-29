<?php
  include('data.php');

  // Obtenemos los datasets para los graficos de pie
  $data = getTasa_Letalidad_Paises();
  
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

        let data = <?=$data?>;
        let cat = data.map(d => d.name);
        let datos = data.map(d => d.data);
        let datos3 = {
          name : 'Datos',
          data : datos
        };
        let datos4 = [{
          name : 'Datos',
          data : datos
        }];

          datos2 = [{
      name: 'Year 180',
      data: [107,57, 100, 89 ,32]
    }];
  console.log(datos2);
  console.log(datos4);

Highcharts.chart('container', {
  chart: {
    type: 'bar'
  },
  title: {
    text: 'Historic World Population by Region'
  },
  subtitle: {
    text: 'Source: <a href="https://en.wikipedia.org/wiki/World_population">Wikipedia.org</a>'
  },
  xAxis: {
    categories: cat,
    title: {
      text: null
    }
  },
  yAxis: {
    min: 0,
    title: {
      text: 'Population (millions)',
      align: 'high'
    },
    labels: {
      overflow: 'justify'
    }
  },
  tooltip: {
    valueSuffix: ' millions'
  },
  plotOptions: {
    bar: {
      dataLabels: {
        enabled: true
      }
    }
  },
  // legend: {
  //   layout: 'vertical',
  //   align: 'right',
  //   verticalAlign: 'top',
  //   x: -40,
  //   y: 80,
  //   floating: true,
  //   borderWidth: 1,
  //   backgroundColor:
  //     Highcharts.defaultOptions.legend.backgroundColor || '#FFFFFF',
  //   shadow: true
  // },
  credits: {
    enabled: false
  },
  series: datos4
});


        </script>
        
	</body>
</html>
