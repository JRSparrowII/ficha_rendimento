<?php  
	/**
	 * 
	 */
	class Cursos 
	{
		
		function __construct()
		{
			require_once 'config.php';
		}

		public function lista($value='')
		{
			$conecta = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
			if (mysqli_connect_errno()) {
				// echo "Conexão falhou";
				// die("Conexão falhou: ".mysqli_connect_errno() );
			} else {
				// echo "Conectado com sucesso";		
			}
			$sql = 'SELECT * from  ';
			$sql .= 'tb_cursos ';		
			$op_consulta = mysqli_query($conecta,$sql);			
			// $obj = mysqli_fetch_object($op_consulta);			
			mysqli_close($conecta);
			return $op_consulta;
		}

		public function descCurso($id_curso='')
		{
			$conecta = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
			if (mysqli_connect_errno()) {
				// echo "Conexão falhou";
				// die("Conexão falhou: ".mysqli_connect_errno() );
			} else {
				// echo "Conectado com sucesso";		
			}
			$sql = 'SELECT * from  ';
			$sql .= 'tb_cursos ';		
			$sql .= 'WHERE ';		
			$sql .= "id = $id_curso" ;		

			$op_consulta = mysqli_query($conecta,$sql);			
						
			
			foreach ($op_consulta as $key => $value) {
				$desc_curso = utf8_encode($value['descricao']);
			}

			
			mysqli_close($conecta);
			return $desc_curso;
			// return $op_consulta;
		}


	}

?>