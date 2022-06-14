<?php  
    $periodo            = $_GET['p1'];
    $bloco              = $_GET['p2'];
    $id_curso           = $_GET['p3'];
    // $id_disciplina      = $_GET['p4'];

    // $periodo             = 201901;
    // $bloco               = 6;
    // $id_curso            = 1;    
    // $id_disciplina       = 10286;

    require_once '../classes/Alunos.php';
    require_once '../classes/Disciplinas.php';
    require_once '../classes/Cursos.php';

    $alunos = new Alunos();
    $disciplina = new Disciplinas();
    $cursos = new Cursos();

    $dados['alunos'] = $alunos->alunosPorDisciplina($bloco, $periodo, $id_curso);
    $dados['disciplina'] = $disciplina->disciplinasPorBlocoEPeriodo($bloco, $periodo, $id_curso);
    $desc_curso = $cursos->descCurso($id_curso);

    foreach ($dados['disciplina'] as $key => $value) {
            $desc_disciplina[] = utf8_encode($value['descricao']);
    }
    
    // echo "<pre>";
    // print_r($dados['alunos'] );
    // echo "</pre>";
    // exit();

?>
<!DOCTYPE html>
<html lang="pt-bt">
<head>
    <title>Ficha Rendimento</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->  
    <link rel="icon" type="image/png" href="../images/icons/favicon.ico"/>
<!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="../vendor/bootstrap/css/bootstrap.min.css">
<!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="../fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="../vendor/animate/animate.css">
<!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="../vendor/select2/select2.min.css">
<!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="../vendor/perfect-scrollbar/perfect-scrollbar.css">
<!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="../css/util.css">
    <link rel="stylesheet" type="text/css" href="../css/main.css">
<!--===============================================================================================-->
    <style>
        @media print {
            * {
                background: transparent;
                color: #000;
                text-shadow: none;
                filter: none;
                -ms-filter: none;

                font-size: 8px !important;



            }
            
            *:hover {
                background: #fff !important;
                color: #000 !important;
            }
            .container-table100 > h1  {
                font-size: 11px !important;
            }
            
            tr th {
                border: 1px solid #A9A9A9 !important;
                color: #000 !important;
                background: transparent !important;
                padding: 0 !important;
                text-align: center;
            }

            tr td {
                border: 1px solid #A9A9A9 !important;
                color: #000 !important;
                background: transparent !important;

                padding: 0 !important;
                text-align: center;

            }

            body {
                background: transparent !important;
            }

            .container-table100 {
                background: transparent !important;

            }
            .no-print {
                display: none
            }


        }

        /*layout normal*/
        .container-table100 > h1 {
            text-transform: uppercase;
            font-family: Montserrat-Medium;
            padding: 20px;
            font-size: 23px;
        }
        .container-table100 > h1 span {
             font-size: 14px;
        }
        .table100.ver1 .row100 td:hover {
            color: #fff !important;

        }
        
        .table100.ver1 .row100 td span {
            width: 100% !important;

        } 
        .table100.ver1 .row100 td span:hover {
            color: #fff !important;

        } 

        .azul {
            color: blue !important;
        }
        .vermelho {
            color: red !important;
            font-weight: bold;
        }
        #imprimir {
            text-align: center;
            font-family: Montserrat-Medium;
            background: #90C991;
            width: 100%;
            /*width: 200px;*/
            height: 50px
            color: #fff;
            float: right;
            margin-left/*: 30px
            margin-top:10px*/ 
            color: #fff !important;
        }

        #imprimir:hover {
            color: #fff;
            background: #309A30;
        }

       .limiter {
           background: #d1d1d1;
       }

    </style>
</head>
<body>
    
    <div class="limiter">
        <button type="button" id="imprimir" class="no-print">IMPRIMIR</button>
        <div class="container-table100">
            <h1>Relatório Alunos por Disciplinas  <br><span>Bloco: <?php echo $bloco ?> - Periodo: <?php echo $periodo ?> - Curso: <?php  echo $desc_curso ?></span></h1>
            <div class="wrap-table100">
                <div class="table100 ver1 m-b-110">
                    <table data-vertable="ver1">
                        <thead>
                            <tr class="row100 head">
                                <th class="column100 column1" data-column="column1">NOME</th>
                                <?php  
                                $cont = 2;
                                foreach ($desc_disciplina as $key => $valor_disciplina) {                                
                                 
                                ?>
                                
                                <th class="column100 column<?php echo $cont?>" data-column="column<?php echo $cont ?>"><?php echo utf8_decode($valor_disciplina) ?></th>
                              
                                <?php
                                $cont++;
                                } 
                                ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($dados['alunos'] as $key => $dadosAlunos): ?>
                                 
                            <tr class="row100">
                                <td class="column100 column1" data-column="column1"><?php echo $dadosAlunos['desc_aluno'] ?></td>
                                <?php  
                                $contador = 2;    
                                ?>
                                <?php foreach ($desc_disciplina as $c => $v): ?>
                                    <?php if (isset($dadosAlunos[utf8_decode($v)])): ?>
                                        <?php if (floatval($dadosAlunos[utf8_decode($v)]) >= 7): ?>
                                        <td class="azul column100 column<?php echo $contador?>" data-column="column<?php echo $contador?>"><?php echo $dadosAlunos[utf8_decode($v)] ?></td>                                        
                                            
                                        <?php else: ?>
                                        <td class="vermelho column100 column<?php echo $contador?>" data-column="column<?php echo $contador?>"><?php echo $dadosAlunos[utf8_decode($v)] ?></td>                                        
                                            
                                        <?php endif ?>

                                    <?php else: ?>
                                        <td class="column100 column<?php echo $contador?>" data-column="column<?php echo $contador?>"><?php echo "NC" ?></td>                                        
                                        
                                    <?php endif ?>
                                <?php 
                                $contador++;
                                ?>
                                <?php endforeach ?> 
                                
                                                                
                            </tr>
                            <?php endforeach ?>                                    
                        </tbody>
                    </table>
                </div>

                
            </div>
        </div>
    </div>


    

<!--===============================================================================================-->  
    <script src="../vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
    <script src="../vendor/bootstrap/js/popper.js"></script>
    <script src="../vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
    <script src="../vendor/select2/select2.min.js"></script>
<!--===============================================================================================-->
    <script src="../js/main.js"></script>
    <script>
        $('#imprimir').on('click', function(event) {
            event.preventDefault();
            $(this).css('display', 'none');
            window.print();
            $(this).css('display', 'block');
        });
    </script>
</body>
</html>