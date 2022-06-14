<?php  
/**
 * 
 */
class Notas {
	
	function __construct()
	{
		require_once 'config.php';
	}

	public function qtdAlunosAprovadosPorProfessorTurma($periodo,$id_professor,$id_turma ) {		
		$conecta = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
		if (mysqli_connect_errno()) {
			// echo "Conexão falhou";
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
		// $sql .= "t.bloco_dis = 3  ";
		// $sql .= "AND ";
		$sql .= "t.id_periodo = '$periodo'  ";		
		$sql .= "AND n.idOcorreAcd <> 'RF' AND n.idOcorreAcd <> 'CM' ";
		// $sql .= "AND p.id = 146";
		$sql .= "AND p.id = '$id_professor' ";
		// $sql .= "AND t.id = 6309 ";
		$sql .= "AND t.id = '$id_turma' ";

		$op_consulta = mysqli_query($conecta,$sql);

		$numAprov = 0;
		foreach ($op_consulta as $key => $row) {
			if ($row['nota1'] >= 7) {
				$numAprov++;
			};
		}
		
		return $numAprov;
		
		mysqli_close($conecta);
	

	}

	public function qtdAlunosQueNãoFizeramProva($periodo,$id_professor,$id_turma ) {		
	// public function qtdAlunosPorProfessorTurma($id_turma ) {		
		$conecta = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
		if (mysqli_connect_errno()) {
			// echo "Conexão falhou";
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
		// $sql .= "t.bloco_dis = 3  ";
		// $sql .= "AND ";
		$sql .= "t.id_periodo = '$periodo'  ";		
		$sql .= "AND n.idOcorreAcd <> 'RF' AND n.idOcorreAcd <> 'CM' ";
		// $sql .= "AND p.id = 146";
		$sql .= "AND p.id = '$id_professor' ";
		// $sql .= "AND t.id = 6309 ";
		$sql .= "AND t.id = '$id_turma' ";
		$sql .= "AND n.nota1 = '' ";

		$op_consulta = mysqli_query($conecta,$sql);
		
		
		return mysqli_num_rows($op_consulta);
		
		mysqli_close($conecta);
	}


	public function qtdAlunosPorProfessorTurma($periodo,$id_professor,$id_turma ) {		
	// public function qtdAlunosPorProfessorTurma($id_turma ) {		
		$conecta = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
		if (mysqli_connect_errno()) {
			// echo "Conexão falhou";
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
		// $sql .= "t.bloco_dis = 3  ";
		// $sql .= "AND ";
		$sql .= "t.id_periodo = '$periodo'  ";		
		$sql .= "AND n.idOcorreAcd <> 'RF' AND n.idOcorreAcd <> 'CM' ";
		// $sql .= "AND p.id = 146";
		$sql .= "AND p.id = '$id_professor' ";
		// $sql .= "AND t.id = 6309 ";
		$sql .= "AND t.id = '$id_turma' ";

		$op_consulta = mysqli_query($conecta,$sql);
		
		
		return mysqli_num_rows($op_consulta);
		
		mysqli_close($conecta);
	}
	public function NotasPorProfessorTurma($periodo,$id_professor)
	{
		$conecta = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
		if (mysqli_connect_errno()) {
			// echo "Conexão falhou";
			// die("Conexão falhou: ".mysqli_connect_errno() );
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
		$sql .= "t.id_periodo = '$periodo'  ";		
		$sql .= "AND n.idOcorreAcd <> 'RF' AND n.idOcorreAcd <> 'CM' ";
		// $sql .= "AND p.id = 146";
		$sql .= "AND p.id = '$id_professor'";
		
		

		$op_consulta = mysqli_query($conecta,$sql);

		foreach ($op_consulta as $key => $valor) {
			$registro[$valor['id_turma']]= $valor['id_turma'];

			
		}
		
		foreach ($op_consulta as $chave => $value) {
			foreach ($registro as $key => $dados) {
				// $notas1 = $dados;
				if ($value['id_turma'] == $dados) {					
					if (isset($notas1[$dados])) {
						$notas1[$dados] = $value['nota1'] + $notas1[$dados];
						$disciplina[$dados] = $value['desc_disciplina'];
						$data[$value['id_turma']] = array(
							'notas' => $notas1[$dados],
							'disciplina' => $disciplina[$dados]
						);
					} else {						
						$notas1[$dados] = $value['nota1'];
						$disciplina[$dados] = $value['desc_disciplina'];
						$data[$value['id_turma']] = array(
							'notas' => $notas1[$dados],
							'disciplina' => $disciplina[$dados]
						);
					}
					
				} 
			}
		}

		

		
		$n = array(
			'notas' => $notas1, 
			'disciplina' => $disciplina
		);


		$arrayName1 = array(
			$arrayName2 = array('name' => "Introducao a Computacao",
								'y' =>  80.0,
								'drilldown' => "Introducao a Computacao"),
			$arrayName3 = array('name' => "Nada com nada",
								'y' =>  20.0,
								'drilldown' => "Nada com nada")
		);

		mysqli_close($conecta);
		return $data;
	}


}


?>