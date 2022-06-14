<?php  
	
if ($_GET['param5'] == 1) {
	$periodo 			= $_GET['param1'];
	$bloco 				= $_GET['param2'];
	$id_curso 			= $_GET['param3'];
	$id_disciplina		= $_GET['param4'];
	
	// $periodo 			= 201901;
	// $bloco 				= 6;
	// $id_curso 			= 1;	
	// $id_disciplina		= 10286;

	require_once '../classes/config.php';
	$conecta = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
	if (mysqli_connect_errno()) {				
		// die("Conexão falhou: ".mysqli_connect_errno() );
	} else {
		// echo "Conectado com sucesso";		
	}
				
	$sql = 'SELECT ';
	$sql .= 'DISTINCT n.matricula,  ';
	$sql .= 'tp.id_turma, t.qtdeAlunos, t.id_disciplina, t.id_curso, ';
	$sql .= 't.id_periodo , t.bloco_dis, tp.id_professor, c.descricao AS desc_curso, ';
	$sql .= 'd.descricao AS desc_disciplina, p.descricao AS desc_professor,  ';
	$sql .= 'n.nota1, ';
	$sql .= 'n.idOcorreAcd, ';
	$sql .= 'a.descricao AS desc_aluno  ';

	$sql .= 'FROM tb_turmas t ';
	$sql .= 'INNER JOIN tb_turma_professor tp ON tp.id_turma = t.id ';
	$sql .= 'INNER JOIN tb_cursos c ON c.id = t.id_curso ';
	$sql .= 'INNER JOIN tb_disciplina d ON d.id = t.id_disciplina ';
	$sql .= 'right JOIN tb_notas n ON n.idTurma = t.id ';
	$sql .= 'left JOIN tb_professores p ON p.id = tp.id_professor ';
	$sql .= 'left JOIN tb_alunos a ON a.matricula = n.matricula ';
	$sql .= 'WHERE  ';

	$sql .= "t.bloco_dis = '$bloco'  ";						
	$sql .= "AND t.id_periodo = '$periodo'  ";		
	$sql .= "AND c.id = '$id_curso' ";
	$sql .= "AND d.id = '$id_disciplina' ";
	$sql .= "AND n.idOcorreAcd <> 'RF' AND n.idOcorreAcd <> 'CM' ";			
			
	$op_consulta = mysqli_query($conecta,$sql);
	$aprovadoD = 0;
	$alunosSemNota = 0;
	$qtdAlunos = mysqli_num_rows($op_consulta);

	foreach ($op_consulta as $key => $value) {
		$reg[] = $value;
		if ($value['nota1'] >= 7) {
			$aprovadoD++;
		} else if ($value['nota1'] == '') {			
			$alunosSemNota++;
		}
		
	}

	if ($alunosSemNota == $qtdAlunos) {
			$percAprovados = 0;
			$percReprovados = 0;
			$percAlunosSemNotas = 100;

	} else {
		$percAprovados = round(($aprovadoD / $qtdAlunos) * 100); 
		$percAlunosSemNotas = round(($alunosSemNota / $qtdAlunos) * 100); 
		$percReprovados = 100 - ($percAprovados + $percAlunosSemNotas);
	}
			
	
	
	$arrayName1 = array(
		$arrayName2 = array(
						'percAprov' => $percAprovados,
						'percReprov' =>  $percReprovados,
						'percAlunosSemN' => $percAlunosSemNotas
					)
						
					
	);

	mysqli_close($conecta);


	
	echo json_encode($arrayName1);
} 
else if ($_GET['param5'] == 2) 
{
	$periodo 			= $_GET['param1'];
	$bloco 				= $_GET['param2'];
	$id_curso 			= $_GET['param3'];
	$id_disciplina		= $_GET['param4'];
	
	// $periodo 			= 201901;
	// $bloco 				= 6;
	// $id_curso 			= 1;	
	// $id_disciplina		= 10286;

	require_once '../classes/config.php';
	$conecta = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
	if (mysqli_connect_errno()) {				
		// die("Conexão falhou: ".mysqli_connect_errno() );
	} else {
		// echo "Conectado com sucesso";		
	}
				
	$sql = 'SELECT ';
	$sql .= 'DISTINCT n.matricula,  ';
	$sql .= 'tp.id_turma, t.qtdeAlunos, t.id_disciplina, t.id_curso, ';
	$sql .= 't.id_periodo , t.bloco_dis, tp.id_professor, c.descricao AS desc_curso, ';
	$sql .= 'd.descricao AS desc_disciplina, p.descricao AS desc_professor,  ';
	$sql .= 'n.nota2, ';
	$sql .= 'n.idOcorreAcd, ';
	$sql .= 'a.descricao AS desc_aluno  ';

	$sql .= 'FROM tb_turmas t ';
	$sql .= 'INNER JOIN tb_turma_professor tp ON tp.id_turma = t.id ';
	$sql .= 'INNER JOIN tb_cursos c ON c.id = t.id_curso ';
	$sql .= 'INNER JOIN tb_disciplina d ON d.id = t.id_disciplina ';
	$sql .= 'right JOIN tb_notas n ON n.idTurma = t.id ';
	$sql .= 'left JOIN tb_professores p ON p.id = tp.id_professor ';
	$sql .= 'left JOIN tb_alunos a ON a.matricula = n.matricula ';
	$sql .= 'WHERE  ';

	$sql .= "t.bloco_dis = '$bloco'  ";						
	$sql .= "AND t.id_periodo = '$periodo'  ";		
	$sql .= "AND c.id = '$id_curso' ";
	$sql .= "AND d.id = '$id_disciplina' ";
	$sql .= "AND n.idOcorreAcd <> 'RF' AND n.idOcorreAcd <> 'CM' ";			
			
	$op_consulta = mysqli_query($conecta,$sql);
	$aprovadoD = 0;
	$alunosSemNota = 0;
	$qtdAlunos = mysqli_num_rows($op_consulta);

	foreach ($op_consulta as $key => $value) {
		$reg[] = $value;
		if ($value['nota2'] >= 7) {
			$aprovadoD++;
		} else if ($value['nota2'] == '') {			
			$alunosSemNota++;
		}
		
	}

	if ($alunosSemNota == $qtdAlunos) {
			$percAprovados = 0;
			$percReprovados = 0;
			$percAlunosSemNotas = 100;

	} else {
		$percAprovados = round(($aprovadoD / $qtdAlunos) * 100); 
		$percAlunosSemNotas = round(($alunosSemNota / $qtdAlunos) * 100); 
		$percReprovados = 100 - ($percAprovados + $percAlunosSemNotas);
	}
			
	
	
	$arrayName1 = array(
		$arrayName2 = array(
						'percAprov' => $percAprovados,
						'percReprov' =>  $percReprovados,
						'percAlunosSemN' => $percAlunosSemNotas
					)
						
					
	);

	mysqli_close($conecta);


	
	echo json_encode($arrayName1);	
}


?>