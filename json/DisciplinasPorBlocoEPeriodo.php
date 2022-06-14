<?php  
	// $arrayName1 = array(
	// 	$arrayName2 = array('id_disciplina' => 6321,
	// 						'percAprov' =>   60,
	// 						'Disciplina' => "TGS"),

	// 	$arrayName3 = array('id_disciplina' => 6323,							
	// 						'percAprov' =>  80.0,
	// 						'Disciplina' => "Indro Comp")
	// );
	
	$periodo 		= $_GET['param1'];
	$bloco 			= $_GET['param2'];
	$id_curso 		= $_GET['param3'];

	require_once '../classes/config.php';
	$conecta = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
	if (mysqli_connect_errno()) {				
		// die("Conexão falhou: ".mysqli_connect_errno() );
	} else {
		// echo "Conectado com sucesso";		
	}
				
	$sql = 'SELECT ';
	$sql .= '* ';			

	$sql .= 'FROM tb_turmas t ';
	
	$sql .= 'INNER JOIN tb_cursos c ON c.id = t.id_curso ';
	$sql .= 'INNER JOIN tb_disciplina d ON d.id = t.id_disciplina ';
	
	$sql .= 'WHERE  ';

	$sql .= "t.bloco_dis = '$bloco'  ";						
	$sql .= "AND t.id_periodo = '$periodo'  ";		
	$sql .= "AND c.id = '$id_curso' ";			
	
			
	$op_consulta = mysqli_query($conecta,$sql);
	
	$qtdDisciplina = mysqli_num_rows($op_consulta);

	foreach ($op_consulta as $key => $value) {
		$value['descricao'] = utf8_encode($value['descricao']);
		$reg[] = $value;
		 
		
	}
	mysqli_close($conecta);
	
	
	
	echo json_encode($reg);
?>