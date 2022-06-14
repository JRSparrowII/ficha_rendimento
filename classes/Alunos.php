<?php  
	/**
	 * 
	 */
	class Alunos {
	
		
		function __construct()
		{
			require_once 'config.php';
		}

		public function alunosPorDisciplina($bloco, $periodo, $id_curso) {
			$conecta = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
			if (mysqli_connect_errno()) {				
				// die("Conexão falhou: ".mysqli_connect_errno() );
			} else {
				// echo "Conectado com sucesso";		
			}
						
			$sql = 'SELECT ';
			$sql .= 'DISTINCT n.matricula, ';			
			$sql .= 'tp.id_turma, t.qtdeAlunos, t.id_disciplina, ';			
			$sql .= 't.id_curso, t.id_periodo , t.bloco_dis, tp.id_professor, c.descricao AS desc_curso, ';			
			$sql .= 'd.descricao AS desc_disciplina, p.descricao AS desc_professor,	 ';			
			$sql .= 'n.nota1, ';			
			$sql .= 'n.idOcorreAcd, ';			
			$sql .= 'a.descricao AS desc_aluno 	  ';			
			// $sql .= 'fdsfsdfds ';			
			

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
			$sql .= "AND n.idOcorreAcd <> 'RF' AND n.idOcorreAcd <> 'CM' ";			
			
			$sql .= "ORDER BY ";			
			$sql .= "a.descricao asc	 ";			
			
					
			$op_consulta = mysqli_query($conecta,$sql);
			
			$i = 0;
			$contador=1;
			foreach ($op_consulta as $key => $value) {
				// $dados[] = $value;
				// echo "registro '$key'<br>";
				$descricao_disciplina = utf8_encode($value['desc_disciplina']);
				
				// se o ultimo registro existir, se nao existir entao a primeira linha nem foi criada ainda
				if (isset($ultimo_registro)) {
					// se o aluno for igual a o aluno do ultimo registro, entao só irei acrescentar mais uma disciplina com sua nota
					if (utf8_encode($value['desc_aluno']) == $ultimo_registro) {
						$registro[$key-$contador][$descricao_disciplina] = $value['nota1'];
						// print_r( $registro[$key])."<br>";
						// echo "igual<br>";
						$contador++;
					} else {
						//se nao será criado um novo registro
						$registro[$key]['desc_aluno'] = utf8_encode($value['desc_aluno']);				
						$registro[$key][$descricao_disciplina] = $value['nota1'];	
						// echo "novo registro sendo que existe um ultimo registro".$value['desc_aluno']."<br>";
						$contador = 1;	
					}
				} else {
					//se nao existi ultimo registro, entao agora é que será criado o primeiro (primeira linha)
					$registro[$key]['desc_aluno'] = utf8_encode($value['desc_aluno']);				
					$registro[$key][$descricao_disciplina] = $value['nota1'];		
					// echo "novo registro".$value['desc_aluno']."<br>";	
				}
				// $i++;
				$ultimo_registro = utf8_encode($value['desc_aluno']);
				
				// echo $ultimo_registro ." ".$i. "<br>";
				// if ($i == 20) {
				// 	echo "<pre>";
				// 	print_r($registro);
				// 	echo "</pre>";	
				// 	exit();
					
				// }
			}
			

			mysqli_close($conecta);

			return $registro;		
		}
		
	}
	
?>