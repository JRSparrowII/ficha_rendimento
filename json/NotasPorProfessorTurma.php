<?php 
		require_once '../classes/config.php';
		require_once '../classes/Notas.php';

		$periodo_id = $_GET['param1'] ;
		$professor_id = $_GET['param2'] ;

		// $periodo_id = 201901;
		// $professor_id = 922 ;
		// print_r($periodo_id);
		// echo "<br>";
		// print_r($professor_id);
		// exit();

		$conecta = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
		if (mysqli_connect_errno()) {
			// echo "Conexão falhou";
			die("Conexão falhou: ".mysqli_connect_errno() );
		} else {
			// echo "Conectado com sucesso";		
		}
		
		// DEFINE O FUSO HORARIO COMO O HORARIO DE BRASILIA
	    date_default_timezone_set('America/Sao_Paulo');
		
		// $data_ini = '';
		// $data_fin = '';
		// $id_professor = 146;
		// $id_bloco = 4;
		// $id_periodo = 201801;

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
		// $sql .= "t.bloco_dis = 3  ";
		// $sql .= "AND ";
		$sql .= "t.id_periodo = '$periodo_id'  ";		
		$sql .= "AND n.idOcorreAcd <> 'RF' AND n.idOcorreAcd <> 'CM' ";
		// $sql .= "AND p.id = 146";
		$sql .= "AND p.id = '$professor_id' ";
		$op_consulta = mysqli_query($conecta,$sql);
		
		//criar um array apenas com os ids das turmas
		foreach ($op_consulta as $key => $valor) {
			$registro[$valor['id_turma']]= $valor['id_turma'];			
		}

		foreach ($op_consulta as $chave => $value) {
			
			foreach ($registro as $key => $dados) {				
				if ($value['id_turma'] == $dados) {					
					if (isset($notas1[$dados])) {																					
						$notas1[$dados] = floatval($value['nota1']) + floatval($notas1[$dados]);
						$desc_curso[$dados] = $value['desc_curso'];
						$id_turma[$dados] = $value['id_turma'];
						$disciplina[$dados] = utf8_encode($value['desc_disciplina']);
						$data[$value['id_turma']] = array(
							'notas' => $notas1[$dados],
							'disciplina' => $disciplina[$dados],
							'desc_professor' =>  utf8_encode($value['desc_professor']),
							'id_turma' =>  $id_turma[$dados]	,						
							'desc_curso' =>  utf8_encode($desc_curso[$dados])
						);
					} else {		
						
						$notas1[$dados] = floatval($value['nota1']);
						$desc_curso[$dados] = $value['desc_curso'];
						$id_turma[$dados] = $value['id_turma'];
						$disciplina[$dados] = utf8_encode($value['desc_disciplina']);
						$data[$value['id_turma']] = array(
							'notas' => $notas1[$dados],
							'disciplina' => $disciplina[$dados],
							'desc_professor' =>  utf8_encode($value['desc_professor']),							
							'id_turma' =>  $id_turma[$dados],
							'desc_curso' =>  utf8_encode($desc_curso[$dados])
							
						);
					}
					
				} 
			}						
		}
		

		$notas = new Notas;		
		foreach ($data as $key => $turmas_notas) {			
			$data[$key]['qtdAlunos'] = $notas->qtdAlunosPorProfessorTurma($periodo_id,$professor_id, $data[$key]['id_turma']);
			$data[$key]['qtdAlunosAprov'] = $notas->qtdAlunosAprovadosPorProfessorTurma($periodo_id,$professor_id,$data[$key]['id_turma']);

			$data[$key]['qtdAlunosNFizeramProvas'] = $notas->qtdAlunosQueNãoFizeramProva($periodo_id,$professor_id,$data[$key]['id_turma']);
			
			if ($data[$key]['qtdAlunos']  == $data[$key]['qtdAlunosNFizeramProvas']) {
				$data[$key]['percAprov'] = 0;
			} else {
				$data[$key]['percAprov'] = round(($data[$key]['qtdAlunosAprov'] /  ($data[$key]['qtdAlunos'] - $data[$key]['qtdAlunosNFizeramProvas'] ) ) * 100 );

			}


		}
	
		// echo "<pre>";		
		// print_r($data);
		// echo "</pre>";
		
		echo json_encode($data);

