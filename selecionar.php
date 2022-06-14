<?php  
  require_once 'classes/Professores.php';
  require_once 'classes/Cursos.php';

  $professores = new Professores();
  $cursos = new Cursos();


  $data['Professores'] = $professores->lista();
  $data['Cursos'] = $cursos->lista();
  $selectProfessores = '<option value="" >-----</option>';  
  foreach ($data['Professores'] as $professores) {
      $selectProfessores .= "<option value=".$professores['id']." >".utf8_encode($professores['descricao'])."</option>";        
  }

  $selectCursos = '<option value="" >-----</option>';  
  foreach ($data['Cursos'] as $cursos) {
      $selectCursos .= "<option value=".$cursos['id']." >".utf8_encode($cursos['descricao'])."</option>";        
  }


  $selectPeriodo = '<option value="" >-----</option>';
  $selectPeriodo .= '<option value="201801" >2018/01</option>';
  $selectPeriodo .= '<option value="201802" >2018/02</option>';
  $selectPeriodo .= '<option value="201901" >2019/01</option>';
  $selectPeriodo .= '<option value="202001" >2020/01</option>';


  $selectBloco = '<option value="" >-----</option>';
  $selectBloco .= '<option value="1" >1</option>';
  $selectBloco .= '<option value="2" >2</option>';
  $selectBloco .= '<option value="3" >3</option>';
  $selectBloco .= '<option value="4" >4</option>';
  $selectBloco .= '<option value="5" >5</option>';
  $selectBloco .= '<option value="6" >6</option>';
  $selectBloco .= '<option value="7" >7</option>';
  $selectBloco .= '<option value="8" >8</option>';
  $selectBloco .= '<option value="9" >9</option>';
  $selectBloco .= '<option value="10" >10</option>';
  

?>
<!DOCTYPE html>
<html>
<head>
  <title>Ficha Rendimento</title>
  <link href="https://fonts.googleapis.com/css?family=Roboto+Slab:400,700" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Roboto:400,500,700" rel="stylesheet">
  <!-- <link rel="stylesheet" href="css/style.css"> -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <link rel="stylesheet" type="text/css" href="css/consulta.css">
  <style type="text/css">
              .select2-container {
                margin-top: 5px !important;
                font-family: "Roboto", serif;
                font-size: 14px;
                width: 440px !important;

              }
              h1 {
                  font-family: "Roboto Slab", serif !important; 
                  font-size: 25px;
              }
              label {
                  font-family: "Roboto", serif;
                  font-size: 15px;
              }
              #btnContinuar {
                margin-top: 30px !important;
                font-family: "Roboto", serif !important;
              }
              .link {
                border: 1px solid rgba(147, 184, 189,0.8) !important;
                left: -1px !important;
                height: 22px !important;
              }
              .link a {
                  font-size: 14px !important;
              }
      </style>
</head>
<body style="background: #eee;">
<div class="container" >
    <a class="links" id="aba1"></a>
    <a class="links" id="aba2"></a>
    <a class="links" id="aba3"></a>
    
    <div class="content">  
      <!-- ABA3-->
      <!-- <div id="aluno" style="display: ;">
        <form method="post" action="rel_aluno.php"> 
          <h1>Relatório por Aluno</h1> 
          <p>             
            <label for="aluno_id">Aluno</label>
            <label for="id_label_single6"> 
              <select name="aluno_id" class="selectAluno js-states form-control" id="id_label_single6">
                 <?php echo $selectProfessores; ?>
              </select>
            </label>
          </p>
         
          
          
          <p> 
            <input type="submit" value="Gerar Relatório" /> 
          </p>
          
          <p class="link">            
            <a href="#aba1">Relatório por Curso</a>
            <a href="#aba2"> Rel. por Professor </a>
          </p>
      
        </form>
      </div> -->

      <!--FORMULÁRIO DE LOGIN-->
      <div id="login" style="display: ;">
        <form method="post" action="rel_professor.php"> 
          <h1>Relatório por Professor</h1> 
          <p>             
            <label for="professor_id">Professor</label>
            <label for="id_label_single"> 
              <select name="professor_id" class="selectProfessores js-states form-control" id="id_label_single1">
                 <?php echo $selectProfessores; ?>
              </select>
            </label>
          </p>
          <p> 
            <label for="periodo_id">Período</label>
            <label for="id_label_single21">                  
                  <select name="periodo_id" class="selectPeriodo js-states form-control" id="id_label_single21">
                     <?php echo $selectPeriodo; ?>
                 </select>
             </label>
          </p>
          
          
          <p> 
            <input type="submit" value="Gerar Relatório" id="btnContinuar"/>  
          </p>
          
          <p class="link">            
            <a href="#aba1">Relatório por Curso</a>
            <!-- <a href="#aba3"> Rel. por Aluno </a> -->
          </p>
        
        </form>
      </div>
      
      <!--FORMULÁRIO DE CADASTRO-->
      <div id="cadastro" >
        <form id="formCursoPeriodo" method="post" action="index.php" > 
          <h1>Relatório por Curso/Período</h1> 
          <p> 
            
            <label for="bloco_id">Bloco</label>
            <label for="id_label_single4"> 
              <select name="bloco_id" class="selectBloco js-states form-control" id="id_label_single4">
                 <?php echo $selectBloco; ?>
              </select>
            </label>
          </p>
          <p> 
            <label for="curso_id">Curso</label>
            <label for="id_label_single3">                  
                  <select name="curso_id" class="selectCurso js-states form-control" id="id_label_single3">
                     <?php echo $selectCursos; ?>
                 </select>
             </label>
          </p>
          <p> 
            <label for="periodo_id">Período</label>
            <label for="id_label_single2">                  
                  <select name="periodo_id" class="selectPeriodo js-states form-control" id="id_label_single2">
                     <?php echo $selectPeriodo; ?>
                 </select>
             </label>
          </p>

          <style>
            #impRel {
               background: #90C991;
            }
            #impRel:hover {
               background: #309A30;
            }
          </style>
          <p>             
            <input type="submit" id="visualizarRel" value="Visualizar Relatório" /> 
            <input type="submit" id="impRel" value="Imprimir Relatório" />
          </p>
          
          <p class="link">              
            <a href="#aba2"> Rel. por Professor </a>
            <!-- <a href="#aba3"> Rel. por Aluno </a> -->
          </p>
       
        </form>
      </div>
    </div>
  </div>   
  <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
  <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script> 
  <link rel="stylesheet" href="js/jquery-ui/css/smoothness/jquery-ui-1.9.2.custom.css" />
  <script type="text/javascript" src="js/jquery-ui/js/jquery-ui-1.9.2.custom.js"></script>  
  <script>
    // <input type="submit" id="visualizarRel" value="Visualizar Relatório" /> 
    //         <input type="submit" id="impRel" value="Imprimir Relatório" /> 
    $(document).ready(function(){
        $('.selectProfessores').select2();
        $('.selectPeriodo').select2();
        $('.selectCurso').select2();
        $('.selectBloco').select2();
        $('.selectAluno').select2();
        
        $('.selectProfessores').change(function(event) {
            // $(".selectCurso").prop("disabled", false);
            // $("#btnContinuar").prop("disabled", false);
            $(".selectPeriodo").prop("disabled", false);

        });
        $('.selectPeriodo').change(function(event) {
            $("#btnContinuar").prop("disabled", false);

        });

        $('#visualizarRel').on('click', function(event) {
          event.preventDefault();
            $("#formCursoPeriodo").attr("action","index.php");      
            $("#formCursoPeriodo").submit();

        });

        $('#impRel').on('click', function(event) {
          event.preventDefault();
            $("#formCursoPeriodo").attr("action","relatorio/relGraficoPorCursoPeriodo.php");      
            $("#formCursoPeriodo").submit();
        });

    });
  </script>
</body>
</html>