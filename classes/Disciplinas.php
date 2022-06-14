<?php  
	/**
	 * 
	 */
	class Disciplinas
	{
		
		function __construct()
		{
			require_once 'config.php';
		}

		public function qtdDisciplina($bloco, $periodo, $id_curso) {
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

			mysqli_close($conecta);

			return $qtdDisciplina;		
		}
		public function disciplinasPorBlocoEPeriodo($bloco, $periodo, $id_curso) {
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
			
			return $reg;		
		}
		
		public function percAprovPorDisciplina($bloco, $periodo, $id_curso, $id_disciplina)
		{
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
			$qtdAlunos = mysqli_num_rows($op_consulta);

			foreach ($op_consulta as $key => $value) {
				$reg[] = $value;
				if ($value['nota1'] >= 7) {
					$aprovadoD++;
				} 
				
			}

			if ($aprovadoD == 0) {
					$percAprovados = 0;
					$percReprovados = 100;

			} else {
				$percAprovados = round(($aprovadoD / $qtdAlunos) * 100); 
				$percReprovados = 100 - $percAprovados;
			}
				
			
			$arrayName1 = array(
				$arrayName2 = array(
								'percAprov' => $percAprovados,
								'percReprov' =>  $percReprovados
							)
								
							
			);

			mysqli_close($conecta);
			return $arrayName1;			
		}
	}
	
?>