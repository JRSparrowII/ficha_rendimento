<?php  
    $periodo            = $_GET['p1'];
    $bloco              = $_GET['p2'];
    $id_curso           = $_GET['p3'];
    $id_disciplina      = $_GET['p4'];

    // $periodo             = 201901;
    // $bloco               = 6;
    // $id_curso            = 1;    
    // $id_disciplina       = 10286;

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
    $sql .= "order by  desc_aluno asc ";         
            
    $op_consulta = mysqli_query($conecta,$sql);

    mysqli_close($conecta);
    
    foreach ($op_consulta as $key => $valor) {
        $desc_disciplina = $valor['desc_disciplina'];
        $desc_curso = $valor['desc_curso'];
    }
    // echo "<pre>";
    // print_r($reg);
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

                font-size: 9px !important;



            }

            *:hover {
                background: #fff !important;
                color: #000 !important;
            }
            
            tr th {
                border: 1px solid #A9A9A9 !important;
                color: #000 !important;
                background: transparent !important;

            }

            tr td {
                border: 1px solid #A9A9A9 !important;
                color: #000 !important;
                background: transparent !important;

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
            .container-table100 > h1  {
                font-size: 11px !important;
            }


        }
        .container-table100 > h1 {
            text-transform: uppercase;
            font-family: Montserrat-Medium;
            padding: 20px;
            font-size: 23px;
        }
        .container-table100 > h1 span {
             font-size: 14px;
        }
      /*  .row100  span:hover {
            color: #fff !important;
        }
        .table100 .row100:hover {
            color: #fff !important;

        }*/
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
     /*   .vermelho:hover {
            color: red !important;
            font-weight: bold;
        }*/
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
            <h1>Disciplina - <?php echo utf8_encode($desc_disciplina) ?> <br><span>Bloco: <?php echo $bloco ?> - Periodo: <?php echo $periodo ?> - Curso: <?php echo utf8_encode($desc_curso) ?> </span></h1>
            <div class="wrap-table100">
               

                <div class="table100 ver1 m-b-110">
                    <table data-vertable="ver1">
                        <thead>
                            <tr class="row100 head">
                                <th class="column100 column1" data-column="column1">Nome</th>
                                <th class="column100 column2" data-column="column2">NOTA 1</th>
                                <th class="column100 column3" data-column="column3">NOTA 2</th>
                                <th class="column100 column4" data-column="column4">NOTA 3</th>
                                <th class="column100 column5" data-column="column5">MP</th>
                                <th class="column100 column6" data-column="column6">Matricula</th>
                                <th class="column100 column7" data-column="column7">SITUAÇÃO</th>
                                
                            </tr>
                        </thead>
                        <tbody>
                            <?php  
                            foreach ($op_consulta as $key => $value) {
                                // $reg[] = $value;
                                $idOco = $value['idOcorreAcd']; 
                                $nota1 = floatval($value['nota1']) ;
                               // if ($nota1 >= 7) {
                               //     $nota1 = '<span style="color:blue;">'.$nota1.'</span>';
                               // } else {                                   
                               //     $nota1 = '<span style="color:red;"><strong>'.$nota1.'</strong></span>';
                               //     // $nota1 = '<span style="color:;">$nota1</span>';
                               // }                                 
                                switch ($idOco) {
                                    case 'PC':
                                        $idOcoDesc = 'EM CURSO';
                                        break;
                                    
                                    default:
                                        # code...
                                        break;
                                }

                            ?>
                            <tr class="row100">
                                <td class="column100 column1" data-column="column1"><?php echo utf8_encode($value['desc_aluno']);  ?></td>
                                <?php if ($nota1 >= 7): ?>
                                <td class="column100 column2 azul" data-column="column2"><?php echo $nota1; ?></td>                                    
                                <?php else: ?>
                                <td class="column100 column2 vermelho" data-column="column2" ><?php echo $nota1; ?></td>                                    
                                    
                                <?php endif ?>
                                <td class="column100 column3" data-column="column3">--</td>
                                <td class="column100 column4" data-column="column4">--</td>
                                <td class="column100 column5" data-column="column5">--</td>
                                <td class="column100 column6" data-column="column6"><?php echo $value['matricula']; ?></td>
                                <td class="column100 column7" data-column="column7"><?php echo $idOcoDesc; ?></td>
                                
                            </tr>

                            
                        <?php  }?>
                        </tbody>
                    </table>
                </div>

                <div class="table100 ver3 m-b-110" style="display: none;">
                    <table data-vertable="ver3">
                        <thead>
                            <tr class="row100 head">
                                <th class="column100 column1" data-column="column1">Nome</th>
                                <th class="column100 column2" data-column="column2">NOTA 1</th>
                                <th class="column100 column3" data-column="column3">NOTA 2</th>
                                <th class="column100 column4" data-column="column4">NOTA 3</th>
                                <th class="column100 column5" data-column="column5">MP</th>
                                <th class="column100 column6" data-column="column6">Matricula</th>
                                <th class="column100 column7" data-column="column7">SITUAÇÃO</th>
                                
                            </tr>
                        </thead>
                        <tbody>
                            <?php  
                            foreach ($op_consulta as $key => $value) {
                                // $reg[] = $value;
                                $idOco = $value['idOcorreAcd'];                                
                                switch ($idOco) {
                                    case 'PC':
                                        $idOcoDesc = 'EM CURSO';
                                        break;
                                    
                                    default:
                                        # code...
                                        break;
                                }

                            

                            ?>
                            <tr class="row100">
                                <td class="column100 column1" data-column="column1"><?php echo $value['desc_aluno'];  ?></td>
                                <td class="column100 column2" data-column="column2"><?php echo $value['nota1']; ?></td>
                                <td class="column100 column3" data-column="column3">--</td>
                                <td class="column100 column4" data-column="column4">--</td>
                                <td class="column100 column5" data-column="column5">--</td>
                                <td class="column100 column6" data-column="column6"><?php echo $value['matricula']; ?></td>
                                <td class="column100 column7" data-column="column7"><?php echo $idOcoDesc; ?></td>
                                
                            </tr>

                            
                        <?php  }?>
                        </tbody>
                    </table>
                </div>

                <div class="table100 ver4 m-b-110" style="display: none;">
                    <table data-vertable="ver4">
                        <thead>
                            <tr class="row100 head">
                                <th class="column100 column1" data-column="column1"></th>
                                <th class="column100 column2" data-column="column2">Sunday</th>
                                <th class="column100 column3" data-column="column3">Monday</th>
                                <th class="column100 column4" data-column="column4">Tuesday</th>
                                <th class="column100 column5" data-column="column5">Wednesday</th>
                                <th class="column100 column6" data-column="column6">Thursday</th>
                                <th class="column100 column7" data-column="column7">Friday</th>
                                <th class="column100 column8" data-column="column8">Saturday</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="row100">
                                <td class="column100 column1" data-column="column1">Lawrence Scott</td>
                                <td class="column100 column2" data-column="column2">8:00 AM</td>
                                <td class="column100 column3" data-column="column3">--</td>
                                <td class="column100 column4" data-column="column4">--</td>
                                <td class="column100 column5" data-column="column5">8:00 AM</td>
                                <td class="column100 column6" data-column="column6">--</td>
                                <td class="column100 column7" data-column="column7">5:00 PM</td>
                                <td class="column100 column8" data-column="column8">8:00 AM</td>
                            </tr>

                            <tr class="row100">
                                <td class="column100 column1" data-column="column1">Jane Medina</td>
                                <td class="column100 column2" data-column="column2">--</td>
                                <td class="column100 column3" data-column="column3">5:00 PM</td>
                                <td class="column100 column4" data-column="column4">5:00 PM</td>
                                <td class="column100 column5" data-column="column5">--</td>
                                <td class="column100 column6" data-column="column6">9:00 AM</td>
                                <td class="column100 column7" data-column="column7">--</td>
                                <td class="column100 column8" data-column="column8">--</td>
                            </tr>

                            <tr class="row100">
                                <td class="column100 column1" data-column="column1">Billy Mitchell</td>
                                <td class="column100 column2" data-column="column2">9:00 AM</td>
                                <td class="column100 column3" data-column="column3">--</td>
                                <td class="column100 column4" data-column="column4">--</td>
                                <td class="column100 column5" data-column="column5">--</td>
                                <td class="column100 column6" data-column="column6">--</td>
                                <td class="column100 column7" data-column="column7">2:00 PM</td>
                                <td class="column100 column8" data-column="column8">8:00 AM</td>
                            </tr>

                            <tr class="row100">
                                <td class="column100 column1" data-column="column1">Beverly Reid</td>
                                <td class="column100 column2" data-column="column2">--</td>
                                <td class="column100 column3" data-column="column3">5:00 PM</td>
                                <td class="column100 column4" data-column="column4">5:00 PM</td>
                                <td class="column100 column5" data-column="column5">--</td>
                                <td class="column100 column6" data-column="column6">9:00 AM</td>
                                <td class="column100 column7" data-column="column7">--</td>
                                <td class="column100 column8" data-column="column8">--</td>
                            </tr>

                            <tr class="row100">
                                <td class="column100 column1" data-column="column1">Tiffany Wade</td>
                                <td class="column100 column2" data-column="column2">8:00 AM</td>
                                <td class="column100 column3" data-column="column3">--</td>
                                <td class="column100 column4" data-column="column4">--</td>
                                <td class="column100 column5" data-column="column5">8:00 AM</td>
                                <td class="column100 column6" data-column="column6">--</td>
                                <td class="column100 column7" data-column="column7">5:00 PM</td>
                                <td class="column100 column8" data-column="column8">8:00 AM</td>
                            </tr>

                            <tr class="row100">
                                <td class="column100 column1" data-column="column1">Sean Adams</td>
                                <td class="column100 column2" data-column="column2">--</td>
                                <td class="column100 column3" data-column="column3">5:00 PM</td>
                                <td class="column100 column4" data-column="column4">5:00 PM</td>
                                <td class="column100 column5" data-column="column5">--</td>
                                <td class="column100 column6" data-column="column6">9:00 AM</td>
                                <td class="column100 column7" data-column="column7">--</td>
                                <td class="column100 column8" data-column="column8">--</td>
                            </tr>

                            <tr class="row100">
                                <td class="column100 column1" data-column="column1">Rachel Simpson</td>
                                <td class="column100 column2" data-column="column2">9:00 AM</td>
                                <td class="column100 column3" data-column="column3">--</td>
                                <td class="column100 column4" data-column="column4">--</td>
                                <td class="column100 column5" data-column="column5">--</td>
                                <td class="column100 column6" data-column="column6">--</td>
                                <td class="column100 column7" data-column="column7">2:00 PM</td>
                                <td class="column100 column8" data-column="column8">8:00 AM</td>
                            </tr>

                            <tr class="row100">
                                <td class="column100 column1" data-column="column1">Mark Salazar</td>
                                <td class="column100 column2" data-column="column2">8:00 AM</td>
                                <td class="column100 column3" data-column="column3">--</td>
                                <td class="column100 column4" data-column="column4">--</td>
                                <td class="column100 column5" data-column="column5">8:00 AM</td>
                                <td class="column100 column6" data-column="column6">--</td>
                                <td class="column100 column7" data-column="column7">5:00 PM</td>
                                <td class="column100 column8" data-column="column8">8:00 AM</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="table100 ver5 m-b-110" style="display: none;">
                    <table data-vertable="ver5">
                        <thead>
                            <tr class="row100 head">
                                <th class="column100 column1" data-column="column1"></th>
                                <th class="column100 column2" data-column="column2">Sunday</th>
                                <th class="column100 column3" data-column="column3">Monday</th>
                                <th class="column100 column4" data-column="column4">Tuesday</th>
                                <th class="column100 column5" data-column="column5">Wednesday</th>
                                <th class="column100 column6" data-column="column6">Thursday</th>
                                <th class="column100 column7" data-column="column7">Friday</th>
                                <th class="column100 column8" data-column="column8">Saturday</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="row100">
                                <td class="column100 column1" data-column="column1">Lawrence Scott</td>
                                <td class="column100 column2" data-column="column2">8:00 AM</td>
                                <td class="column100 column3" data-column="column3">--</td>
                                <td class="column100 column4" data-column="column4">--</td>
                                <td class="column100 column5" data-column="column5">8:00 AM</td>
                                <td class="column100 column6" data-column="column6">--</td>
                                <td class="column100 column7" data-column="column7">5:00 PM</td>
                                <td class="column100 column8" data-column="column8">8:00 AM</td>
                            </tr>

                            <tr class="row100">
                                <td class="column100 column1" data-column="column1">Jane Medina</td>
                                <td class="column100 column2" data-column="column2">--</td>
                                <td class="column100 column3" data-column="column3">5:00 PM</td>
                                <td class="column100 column4" data-column="column4">5:00 PM</td>
                                <td class="column100 column5" data-column="column5">--</td>
                                <td class="column100 column6" data-column="column6">9:00 AM</td>
                                <td class="column100 column7" data-column="column7">--</td>
                                <td class="column100 column8" data-column="column8">--</td>
                            </tr>

                            <tr class="row100">
                                <td class="column100 column1" data-column="column1">Billy Mitchell</td>
                                <td class="column100 column2" data-column="column2">9:00 AM</td>
                                <td class="column100 column3" data-column="column3">--</td>
                                <td class="column100 column4" data-column="column4">--</td>
                                <td class="column100 column5" data-column="column5">--</td>
                                <td class="column100 column6" data-column="column6">--</td>
                                <td class="column100 column7" data-column="column7">2:00 PM</td>
                                <td class="column100 column8" data-column="column8">8:00 AM</td>
                            </tr>

                            <tr class="row100">
                                <td class="column100 column1" data-column="column1">Beverly Reid</td>
                                <td class="column100 column2" data-column="column2">--</td>
                                <td class="column100 column3" data-column="column3">5:00 PM</td>
                                <td class="column100 column4" data-column="column4">5:00 PM</td>
                                <td class="column100 column5" data-column="column5">--</td>
                                <td class="column100 column6" data-column="column6">9:00 AM</td>
                                <td class="column100 column7" data-column="column7">--</td>
                                <td class="column100 column8" data-column="column8">--</td>
                            </tr>

                            <tr class="row100">
                                <td class="column100 column1" data-column="column1">Tiffany Wade</td>
                                <td class="column100 column2" data-column="column2">8:00 AM</td>
                                <td class="column100 column3" data-column="column3">--</td>
                                <td class="column100 column4" data-column="column4">--</td>
                                <td class="column100 column5" data-column="column5">8:00 AM</td>
                                <td class="column100 column6" data-column="column6">--</td>
                                <td class="column100 column7" data-column="column7">5:00 PM</td>
                                <td class="column100 column8" data-column="column8">8:00 AM</td>
                            </tr>

                            <tr class="row100">
                                <td class="column100 column1" data-column="column1">Sean Adams</td>
                                <td class="column100 column2" data-column="column2">--</td>
                                <td class="column100 column3" data-column="column3">5:00 PM</td>
                                <td class="column100 column4" data-column="column4">5:00 PM</td>
                                <td class="column100 column5" data-column="column5">--</td>
                                <td class="column100 column6" data-column="column6">9:00 AM</td>
                                <td class="column100 column7" data-column="column7">--</td>
                                <td class="column100 column8" data-column="column8">--</td>
                            </tr>

                            <tr class="row100">
                                <td class="column100 column1" data-column="column1">Rachel Simpson</td>
                                <td class="column100 column2" data-column="column2">9:00 AM</td>
                                <td class="column100 column3" data-column="column3">--</td>
                                <td class="column100 column4" data-column="column4">--</td>
                                <td class="column100 column5" data-column="column5">--</td>
                                <td class="column100 column6" data-column="column6">--</td>
                                <td class="column100 column7" data-column="column7">2:00 PM</td>
                                <td class="column100 column8" data-column="column8">8:00 AM</td>
                            </tr>

                            <tr class="row100">
                                <td class="column100 column1" data-column="column1">Mark Salazar</td>
                                <td class="column100 column2" data-column="column2">8:00 AM</td>
                                <td class="column100 column3" data-column="column3">--</td>
                                <td class="column100 column4" data-column="column4">--</td>
                                <td class="column100 column5" data-column="column5">8:00 AM</td>
                                <td class="column100 column6" data-column="column6">--</td>
                                <td class="column100 column7" data-column="column7">5:00 PM</td>
                                <td class="column100 column8" data-column="column8">8:00 AM</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="table100 ver6 m-b-110" style="display: none;">
                    <table data-vertable="ver6">
                        <thead>
                            <tr class="row100 head">
                                <th class="column100 column1" data-column="column1"></th>
                                <th class="column100 column2" data-column="column2">Sunday</th>
                                <th class="column100 column3" data-column="column3">Monday</th>
                                <th class="column100 column4" data-column="column4">Tuesday</th>
                                <th class="column100 column5" data-column="column5">Wednesday</th>
                                <th class="column100 column6" data-column="column6">Thursday</th>
                                <th class="column100 column7" data-column="column7">Friday</th>
                                <th class="column100 column8" data-column="column8">Saturday</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="row100">
                                <td class="column100 column1" data-column="column1">Lawrence Scott</td>
                                <td class="column100 column2" data-column="column2">8:00 AM</td>
                                <td class="column100 column3" data-column="column3">--</td>
                                <td class="column100 column4" data-column="column4">--</td>
                                <td class="column100 column5" data-column="column5">8:00 AM</td>
                                <td class="column100 column6" data-column="column6">--</td>
                                <td class="column100 column7" data-column="column7">5:00 PM</td>
                                <td class="column100 column8" data-column="column8">8:00 AM</td>
                            </tr>

                            <tr class="row100">
                                <td class="column100 column1" data-column="column1">Jane Medina</td>
                                <td class="column100 column2" data-column="column2">--</td>
                                <td class="column100 column3" data-column="column3">5:00 PM</td>
                                <td class="column100 column4" data-column="column4">5:00 PM</td>
                                <td class="column100 column5" data-column="column5">--</td>
                                <td class="column100 column6" data-column="column6">9:00 AM</td>
                                <td class="column100 column7" data-column="column7">--</td>
                                <td class="column100 column8" data-column="column8">--</td>
                            </tr>

                            <tr class="row100">
                                <td class="column100 column1" data-column="column1">Billy Mitchell</td>
                                <td class="column100 column2" data-column="column2">9:00 AM</td>
                                <td class="column100 column3" data-column="column3">--</td>
                                <td class="column100 column4" data-column="column4">--</td>
                                <td class="column100 column5" data-column="column5">--</td>
                                <td class="column100 column6" data-column="column6">--</td>
                                <td class="column100 column7" data-column="column7">2:00 PM</td>
                                <td class="column100 column8" data-column="column8">8:00 AM</td>
                            </tr>

                            <tr class="row100">
                                <td class="column100 column1" data-column="column1">Beverly Reid</td>
                                <td class="column100 column2" data-column="column2">--</td>
                                <td class="column100 column3" data-column="column3">5:00 PM</td>
                                <td class="column100 column4" data-column="column4">5:00 PM</td>
                                <td class="column100 column5" data-column="column5">--</td>
                                <td class="column100 column6" data-column="column6">9:00 AM</td>
                                <td class="column100 column7" data-column="column7">--</td>
                                <td class="column100 column8" data-column="column8">--</td>
                            </tr>

                            <tr class="row100">
                                <td class="column100 column1" data-column="column1">Tiffany Wade</td>
                                <td class="column100 column2" data-column="column2">8:00 AM</td>
                                <td class="column100 column3" data-column="column3">--</td>
                                <td class="column100 column4" data-column="column4">--</td>
                                <td class="column100 column5" data-column="column5">8:00 AM</td>
                                <td class="column100 column6" data-column="column6">--</td>
                                <td class="column100 column7" data-column="column7">5:00 PM</td>
                                <td class="column100 column8" data-column="column8">8:00 AM</td>
                            </tr>

                            <tr class="row100">
                                <td class="column100 column1" data-column="column1">Sean Adams</td>
                                <td class="column100 column2" data-column="column2">--</td>
                                <td class="column100 column3" data-column="column3">5:00 PM</td>
                                <td class="column100 column4" data-column="column4">5:00 PM</td>
                                <td class="column100 column5" data-column="column5">--</td>
                                <td class="column100 column6" data-column="column6">9:00 AM</td>
                                <td class="column100 column7" data-column="column7">--</td>
                                <td class="column100 column8" data-column="column8">--</td>
                            </tr>

                            <tr class="row100">
                                <td class="column100 column1" data-column="column1">Rachel Simpson</td>
                                <td class="column100 column2" data-column="column2">9:00 AM</td>
                                <td class="column100 column3" data-column="column3">--</td>
                                <td class="column100 column4" data-column="column4">--</td>
                                <td class="column100 column5" data-column="column5">--</td>
                                <td class="column100 column6" data-column="column6">--</td>
                                <td class="column100 column7" data-column="column7">2:00 PM</td>
                                <td class="column100 column8" data-column="column8">8:00 AM</td>
                            </tr>

                            <tr class="row100">
                                <td class="column100 column1" data-column="column1">Mark Salazar</td>
                                <td class="column100 column2" data-column="column2">8:00 AM</td>
                                <td class="column100 column3" data-column="column3">--</td>
                                <td class="column100 column4" data-column="column4">--</td>
                                <td class="column100 column5" data-column="column5">8:00 AM</td>
                                <td class="column100 column6" data-column="column6">--</td>
                                <td class="column100 column7" data-column="column7">5:00 PM</td>
                                <td class="column100 column8" data-column="column8">8:00 AM</td>
                            </tr>
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