<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <style type="text/css">
        li {
  list-style-type: none;
}
    </style>
    <title>Hello, world!</title>

</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <legend>Nomeclatuda Banco de Dados</legend>

                <b>Obs: Gerar primeiro as tabelas FILHAS</b>
                <li>Chave primária : <b>id</b></li>
                <li>Campo Data : <b>data_</b> ( Datapicker )</li>
                <li>Campo Valores Monerarios : <b>val_</b> ( Mascara )</li>
                <li>Nome para checkbox <b>ck_</b> Tipo BD TINYINT(1)</li>
                <li>Nome para Radio Button <b>rb_</b> Tipo BD TINYINT(2)</li>
                <li>Campo Numerico <b>num_</b> varchar</li>
                <br>
                <li>Ordenação Formulario ( segue ordem colunas tabela BD )</li>
                <li>Comentário de colunas usado como Label</li>
                <li>Bootstrap v5.1.3</li>


            </div>
            <div class="col-md-12">
                <?php


                try {
                    $hostname = $_POST["host"];
                    $dbname   = $_POST["db"];
                    $username = $_POST["usuario"];
                    $password = $_POST["password"];
                    $table    = $_POST['selTable'];

                    $pdo = new PDO("mysql:host=$hostname;dbname=$dbname;port=3307", "$username", "$password");
                } catch (PDOException $e) {
                    echo "Erro de Conexão " . $e->getMessage() . "\n";
                    exit;
                }

                $dados = array();
                $dadosSemPrimary = array();

                $sql = "SELECT * FROM information_schema.columns where table_name = '{$table}' and table_schema = '{$dbname}'";
                $query = $pdo->prepare($sql);
                $query->execute();

                while ($linha = $query->fetch(PDO::FETCH_OBJ)) {
                    if ($linha->COLUMN_KEY != "PRI") {
                        $dadosSemPrimary[] = $linha;
                    }
                    $dados[] = $linha;
                }


                //var_dump($dados);   

                ###################  create ########################

                include('create_form.php');


                ################### controllers ####################
                include('controllers.php');




####################################################################################################################################################


                ?>
                <legend>LEMBRE-SE DE VERIFICAR A PROPRIEDADE FILLABLE OU GUARD NO MODEL</legend>
                <br>


                <?php



####################################################################################################################


        print "<table class='table table-sm table-bordered' id='tblCampos'>
            <tr>
                <th>Campo</th>
                <th>Tipo</th>
                <th>Regras</th>
            </tr>";

?>

<form action="result.php" method="POST" name="frm">

<?php
        foreach ($dados as $key => $campo1) {

            print "<input type='hidden' name='".$campo1->COLUMN_NAME."' value='".$campo1->COLUMN_NAME."'>";
           

            print "<tr>
                    <td>".$campo1->COLUMN_NAME."</td>
                    <td>
                        <table class=\"table table-sm table-bordered table-striped\" name='tblOpcoes'>
                            <tr>
                                <td><input type=\"text\" name='".$campo1->COLUMN_NAME."_max' value='".$campo1->CHARACTER_MAXIMUM_LENGTH."' data-max='max'> Máximo Caracteres</td>        

                            </tr>
                            <tr>
                                <!--  CAMPO OBRIGATORIO -->
                                <td><input type=\"checkbox\" name='".$campo1->COLUMN_NAME."_required'[] value='required' data-campo='".$campo1->COLUMN_NAME."' data-max='required'> Campo Obrigatório</td>
                            </tr>
                            
                            <tr>
                                <!-- CAMPO INTEIRO NUMEROS -->
                                <td><input type=\"checkbox\" name='".$campo1->COLUMN_NAME."_integer' value='integer' data-campo='".$campo1->COLUMN_NAME."' data-max='integer'> Número</td>
                            </tr>
                            
                            <tr>

                                <!-- CAMPO EMAIL -->
                                <td><input type=\"checkbox\" name='".$campo1->COLUMN_NAME."_email' value='email' data-campo='".$campo1->COLUMN_NAME."' data-max='email'> Email</td>
                            </tr>
                            
                            <tr>

                                <!-- CAMPO UPLOAD -->
                                <td><input type=\"checkbox\" name=\"file_".$campo1->COLUMN_NAME."\" value='file' data-campo='".$campo1->COLUMN_NAME."' data-max='file'> File
                                </td>
                                </tr>
                            <tr>
                                <td><input type=\"checkbox\" name=\"file_tipo[]\" value='png' data-campo='file'> PNG <br>
                                    <input type=\"checkbox\" name=\"file_tipo[]\" value='jpg'> JPG <br>
                                    <input type=\"checkbox\" name=\"file_tipo[]\" value='jpeg'> JPEG <br>
                                    <input type=\"checkbox\" name=\"file_tipo[]\" value='pdf'> PDF <br>
                                    <input type=\"checkbox\" name=\"file_tipo[]\" value='doc'> DOC <br>
                                </td>
                            </tr>
                        </table>
                    </td>

                    <td>
                        <span name='spRegra_".$campo1->COLUMN_NAME."'></span>
                        <br>
                        <hr>
                        <ul id='valida1'></ul>
                    </td>

                  </tr>";
            
        }

        print "<table>";

        

        ?>

        <button type="submit">Gerar</button>

</form>

        <?php






        print "<button id='gerar'>Gerar Validação</button><br><br>";

        print "<table>
            <tr>
                <td>[
                    <ul id='regra'></ul>
                    ]
                </td>
            </tr>
            <tr>
                <td>[
                    <ul id='valida'></ul>
                    ]
                </td>
            </tr>
        </table>";






        ###################################   FORMULARIO GENERICO   #######################################################

            print nl2br(htmlspecialchars(" ############  formulario generico #########################
                {{ Form::open(array('url' => '/" . $table . "/create')) }}
                {{ Form::token() }}"));


            foreach ($dados as $key => $value) {
                

                print nl2br(htmlspecialchars("<div class='col'>
                {{ Form::label('" . $value->COLUMN_NAME . "', '" . $value->COLUMN_COMMENT . "')}}:
                {{ Form::text('" . $value->COLUMN_NAME . "', '', ['class'=>'form form-control'])}}
                <br></div>"));
                print "<br>";
               
            }

            print nl2br(htmlspecialchars("<div class='row'>
            {{ Form::submit('Gravar', ['class'=>'btn btn-primary']) }}
        </div>"));

        print nl2br(htmlspecialchars("{{ Form::close() }}
        </div>"));
            

                ?>
                <br>
                <!--<p style="text-align: center;"><b> ################################ CONTROLLER ################################</b></p>

                ##################### INDEX ########################<br>
                <?php
                //print $controllerIndex;
                ?>
                <br>
                ##################### CREATE ########################<br>
                <?php
                //print $controllerCreate;
                ?>
                <br>
                ##################### STORE ########################<br>
                <?php
                //print $controllerStore;
                ?>
                <br>
                ##################### EDIT ########################<br>
                <?php
                //print $controllerEdit;
                ?>
                <br>
                ##################### UPDATE ########################<br>
                <?php
                //print $controllerUpdate;
                ?>
                <br>
                ##################### DESTROY ########################<br>
                <?php
                //print $controllerDestroy;
                ?>
                <br>
                #####################################################################################
                <br>
                <b> ################## CHECKBOX - NO CONTROLLER ################# </b>
                <?php
                //print $checkbox_controller
                ?>
                <br>
                ############################################ VIEW #####################################################

                <b> ################## View INDEX #############</b><br>
                <?php
                //print $viewIndex;
                ?>
                <br>
                <b> ################## View CREATE #############</b><br>
                <?php
                //print $viewCreate;
                ?>
                <br>
                <b> ################## View STORE #############</b><br>
                <?php
                //print $viewStore;
                ?>
                <br>
                <b> ################## View EDIT #############</b><br>
                <?php
                //print $viewEdit;
                ?>
                <br>
                <b> ################## View UPDATE #############</b><br>
                <?php
                //print $viewUpdate;
                ?>
                <br>
                <b> ################## View DESTROY #############</b><br>
                <?php
                //print $viewDestroy;
                ?>
                <br>
                ############################################ FORM #####################################################<br>

                <b> ################## FORMULARIO CREATE #############</b><br>
                <?php
                //print $formCreate;
                ?>
                <br>
                <b> ################## FORMULARIO EDIT #############</b><br>
                <?php
                //print $formEdit;
                ?>-->






   <script src="https://code.jquery.com/jquery-3.6.3.js" integrity="sha256-nQLuAZGRRcILA+6dMBOvcRh5Pe310sBpanc6+QBmyVM=" crossorigin="anonymous"></script>
   <script type="text/javascript">
       var campo;
       var regra = [];
       var valida = [];

       var regraGeral = []
       var validaGeral = [];


       $("input[type='checkbox']").click(function() {
            
            if( $(this).is(":checked", true ) ){

                /*nome do campo banco de dados */
                campo   = $(this).data('campo');
                console.log(campo);


                if(regra.length ===0){
                    regra = '\''+campo+'\' => \''+$(this).val();          
                }else {
                    regra +="|"+($(this).val());             
                }



                /* MAX LENGHT */
                    if($(this).val() == 'max'){

                        valida.push(campo +'.max=> \'O Campo '+ $(this).data('campo') + ' deve ter no máximo '+ $("input[name='"+campo+"']").val() +' Caracteres !') ;
                    }


                /* REQUERIDO */
                    if($(this).val() == 'required'){

                        valida.push($(this).data('campo') +'.'+ $(this).val() + '=> \'O Campo '+ $(this).data('campo') + ' é Obrigatório !') ;
                    }


                /* INTEIRO */
                    if($(this).val() == 'integer'){

                        valida.push($(this).data('campo') +'.'+ $(this).val() + '=> \'O Campo '+ $(this).data('campo') + ' deve conter somente números !') ;
                    }

                /* EMAIL */
                    if($(this).val() == 'email'){

                        valida.push($(this).data('campo') +'.email => O Campo '+ $(this).data('campo') + ' deve deve ser um email valido !') ;
                    }

                /* FILE  
                    if($(this).val() == 'file'){

                        valida.push($(this).data('campo') +'.file => O Campo '+ $(this).data('campo') + ' deve deve ser um email valido !') ;
                    }*/

                /* TIPOS UPLOAD */
                    if($(this).val() == 'png'){

                        valida.push($(this).data('campo') +'.mimes => O Campo '+ $(this).data('campo') + ' só é permitido arquivos do Tipo png, jpg, jpeg, pdf, doc !') ;
                    }

                    


            $('span[name=spRegra_'+campo+']').text('\''+regra+'\'');

            valida.forEach((element) => {
                $('#valida1').append('<li>'+element+'</li>');
            });

              
valida = [];


            regraGeral.push(regra);

            }else {

                
            }


       });


       $("#gerar").click(function(){

       
           regraGeral.forEach((element) => {
                $('#regra').append('<li>'+element+'</li>');
            });



           valida.forEach((element) => {
                $('#valida').append('<li>'+element+'</li>');
            });



       });


       
   </script>
