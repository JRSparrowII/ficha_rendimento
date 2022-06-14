<?php  
	require_once 'classes/Professores.php';

	$professores = new Professores();
	$data['Professores'] = $professores->lista();
	$selectProfessores = '<option value="" >-----</option>';	
    foreach ($data['Professores'] as $professores) {
        $selectProfessores .= "<option value=".$professores['id']." >".utf8_encode($professores['descricao'])."</option>";        
    }

    $selectPeriodo = '<option value="" >-----</option>';
    $selectPeriodo .= '<option value="201801" >2018/01</option>';
    $selectPeriodo .= '<option value="201802" >2018/02</option>';
    $selectPeriodo .= '<option value="201901" >2019/01</option>';



	// $data['selectProfessores'] = $selectProfessores;

// print_r($selectProfessores);
// print_r($data['Professores'] );
// exit();

?>
<!DOCTYPE html>
<html>
<head>
	<title>Ficha Rendimento</title>
	<link href="https://fonts.googleapis.com/css?family=Roboto+Slab:400,700" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Roboto:400,500,700" rel="stylesheet">
	<link rel="stylesheet" href="css/style.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<style>
		.select2-container {
			font-family: 'Roboto', serif;		    
		    font-size: 14px;
		    font-weight: 400;
		    text-transform: normal;
		    min-width: 100px;
		    max-width: 400px;
		}


		label {
			font-family: 'Roboto', serif;
		    text-transform: uppercase;
		    font-size: 14px;
		    font-weight: 700;
		    margin-right: 20px;
		}
	</style>
</head>
<body>
	<form action="index.php" method="post" id="formSelecao">
        <div class="selecionar-professor" style="">
            <div class="form-group col-cl-3">
                <label for="professor_id">Professor</label>
                <label for="id_label_single">                	
                  <select name="professor_id" class="selectProfessores js-states form-control" id="id_label_single1">
                     <?php echo $selectProfessores; ?>
                 </select>
             </label>
        	</div>
        </div>
        <div class="selecionar-periodo" style="">
            <div class="form-group col-cl-3">
                <label for="periodo_id">Periodo</label>
                <label for="id_label_single2">                	
                  <select name="periodo_id" class="selectPeriodo js-states form-control" id="id_label_single2">
                     <?php echo $selectPeriodo; ?>
                 </select>
             </label>
        	</div>
        </div>
     	<div class="span12" style="padding: 1%; margin-left: 0">
	        <div class="span6 offset3" style="text-align: center">
	            <button class="btn btn-success" disabled="" id="btnContinuar"><i class="icon-share-alt icon-white"></i> Continuar</button>
	            <a href="#" class="btn"><i class="icon-arrow-left"></i> Voltar</a>
	        </div>
	    </div>   
     </form>
    
  <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
	<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>	
	<link rel="stylesheet" href="js/jquery-ui/css/smoothness/jquery-ui-1.9.2.custom.css" />
	<script type="text/javascript" src="js/jquery-ui/js/jquery-ui-1.9.2.custom.js"></script>
	<script type="text/javascript">
        $(document).ready(function(){
            $('.selectProfessores').select2();
            $('.selectPeriodo').select2();
            
            $('.selectProfessores').change(function(event) {
                // $(".selectCurso").prop("disabled", false);
                // $("#btnContinuar").prop("disabled", false);
                $(".selectPeriodo").prop("disabled", false);

            });
            $('.selectPeriodo').change(function(event) {
                $("#btnContinuar").prop("disabled", false);

            });

        });
    </script>
</body>
</html>