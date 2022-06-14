<?php  
	require_once 'classes/config.php';
	require_once 'classes/Notas.php';
	require_once 'classes/Disciplinas.php';

	// $bloco = 1;
	// $periodo_id = 201801;	
	// $id_curso = 1;	
	// $professor_id = 682 ;
	if ( !isset($_POST['professor_id']) || !isset($_POST['periodo_id']) ) {
		header('Location: selecionar.php');
	}
	
	
	$professor_id 	= $_POST['professor_id'] ;
	$periodo_id 	= $_POST['periodo_id'] ;
	
	// $disciplinas = new Disciplinas();
	// $qtdDisciplina = $disciplinas->qtdDisciplina($bloco, $periodo_id, $id_curso);
	// echo "<pre>";
	// print_r($qtdDisciplina);
	// echo "</pre>";
	// exit();

?>

<!DOCTYPE html>
<html>
<head>
	<title>Ficha Rendimento</title>
	<meta charset="utf-8">
	<link href="https://fonts.googleapis.com/css?family=Roboto+Slab:400,700" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Roboto:400,500,700" rel="stylesheet">
	<link rel="stylesheet" href="css/style-1.css">
	<script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
	<script src="https://code.highcharts.com/highcharts.js"></script>
	<script src="https://code.highcharts.com/modules/exporting.js"></script>
	<script src="https://code.highcharts.com/modules/export-data.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

</head>
<body>
	<!-- cold -->
	<div class="conteudo" >
		<div class="titulo">
			<h2>Relatório de Rendimento</h2>			
			<h4>Período: <?php echo $periodo_id; ?></h4>			
		</div>	
		<div class="row"  >
			<div class="linha" style="width: 100%;">
				<div id="grafico-50"></div>
			</div>			
			<div class="clear"></div>
		</div>
	</div>
	<!-- <button id="executar">executar</button> -->

	<!-- <script src="https://code.highcharts.com/modules/data.js"></script>
	<script src="https://code.highcharts.com/modules/drilldown.js"></script> -->
<script type="text/javascript">

$(document).ready(function() {
			
		$.getJSON('json/NotasPorProfessorTurma.php',{param1: "<?php echo $periodo_id ?>" , param2: "<?php  echo $professor_id ?>"},  function(data) {
			
			$.each(data, function(i, val) {
				 $desc_prof = val.desc_professor;
				 $desc_curso = val.desc_curso;
			});
			
			options = {
				colors: ['#2b908f', '#90ee7e', '#f45b5b', '#7798BF', '#aaeeee', '#ff0066',
        '#eeaaee', '#55BF3B', '#DF5353', '#7798BF', '#aaeeee'],
			    chart: {
			        renderTo: 'grafico-50',
			        type: 'column'
			    },
			    title: {
			        text: $desc_prof
			    },
			    subtitle: {
			        text: $desc_curso
			    },
			    xAxis: {
			        type: 'category'
			    },
			    yAxis: {
			        title: {
			            text: 'Percentual Aprovados (%)'
			        }

			    },
			    legend: {
			        enabled: true
			    },
			    plotOptions: {
			        series: {
			            borderWidth: 0,
			            dataLabels: {
			                enabled: true,
			                format: '{point.y:.0f}%'
			            }
			        }
			    },

			    tooltip: {
			        headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
			        pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.0f}%</b> of total<br/>'
			    },
			    series: []
			};

			$.each(data, function(index, valor) {
				options.series.push({
				    name: valor.disciplina,
				    data: [valor.percAprov]
				})

			});
			var chart = new Highcharts.Chart(options);
		});
		
});//fim do carregar depois que a DOM carrega

	
		
	jQuery.noConflict();
			var example = 'column-drilldown', 
				theme = 'default';
			(function($){ // encapsulate jQuery
	// Situação do Bloco do Curso
	options  = Highcharts.chart({
        chart: {
            renderTo: 'grafico-50',
            type: 'column'
        },
        title: {
	        text: 'Professor: '
	    },
	    subtitle: {
	        text: ''
	    },
	    xAxis: {
	        type: 'category'
	    },
	    yAxis: {
	        title: {
	            text: 'Percentual Aprovados (%)'
	        }

	    },
	    legend: {
	        enabled: false
	    },
	    plotOptions: {
	        series: {
	            borderWidth: 0,
	            dataLabels: {
	                enabled: true,
	                format: '{point.y:.0f}%'
	            }
	        }
	    },

	    tooltip: {
	        headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
	        pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.0f}%</b> of total<br/>'
	    },
        series: [{
            // name: 'Jane',
            // data: [1, 0, 4]
        }]
    });

	})(jQuery);    
		
	
	</script>	
	
	<!-- <script src="//code.highcharts.com/themes/grid-light.js"></script> -->
	<!-- <script src="//code.highcharts.com/themes/dark-unica.js"></script> -->
	
	

</body>
</html>