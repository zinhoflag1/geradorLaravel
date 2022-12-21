<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

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

                $datapicker_form = "";

                $input = "";

                $cont = 0;

                # FORM CREATE
                $formCreate = "";

                # FORM EDIT
                $formEdit = "";

                # CONTROLLER CHECKBOX
                $checkbox_controller = '';

                $colection = '$nomeColecao';


                $formCreate .= nl2br(htmlspecialchars("<div class='col-md-12'>
                {{ Form::open(array('url' => '/" . $table . "/create')) }}
                {{ Form::token() }}"));

                $formEdit .= nl2br(htmlspecialchars("<div class='col-md-12'>
                {{ Form::open(array('url' => '/" . $table . "/edit')) }}
                {{ Form::token() }}"));


                $formCreate .= nl2br(htmlspecialchars("
            <div class='row'>"));
                foreach ($dadosSemPrimary as $key => $coluna) {

                    if (($key == 0) && ($cont == 2)) {
                        $formCreate .= nl2br(htmlspecialchars("
            <div class='row'>"));

                        $formEdit .= nl2br(htmlspecialchars("
            <div class='row'>"));
                    }


                    # id 
                    if ($coluna->COLUMN_KEY == 'PRI') {
                        //echo $coluna->COLUMN_NAME."<br>";

                        # int
                    } elseif ($coluna->DATA_TYPE == 'int') {

                        $formCreate .= nl2br(htmlspecialchars("
                        <div class='col'>
                        {{ Form::label('" . $coluna->COLUMN_NAME . "', '" . $coluna->COLUMN_COMMENT . "')}}:
                        {{ Form::text('" . $coluna->COLUMN_NAME . "', '', ['class'=>'form form-control', old('" . $coluna->COLUMN_NAME . "')]) }}
                        <br></div>"));

                        $formEdit .= nl2br(htmlspecialchars("
                        <div class='col'>
                        {{ Form::label('" . $coluna->COLUMN_NAME . "', '" . $coluna->COLUMN_COMMENT . "')}}:
                        {{ Form::text('" . $coluna->COLUMN_NAME . "', '', ['class'=>'form form-control', old('" . $coluna->COLUMN_NAME . "')]) }}
                        <br></div>"));


                        # Texto
                    } elseif ($coluna->DATA_TYPE == 'varchar') {
                        if (false) { # mascara
                            $formCreate .= nl2br(htmlspecialchars($coluna->COLUMN_NAME . "<br>"));
                            $formEdit .= nl2br(htmlspecialchars($coluna->COLUMN_NAME . "<br>"));
                        } else { # texto
                            $formCreate .= nl2br(htmlspecialchars("
                            <div class='col'>
                            {{ Form::label('" . $coluna->COLUMN_NAME . "', '" . $coluna->COLUMN_COMMENT . "')}}:
                            {{ Form::text('" . $coluna->COLUMN_NAME . "', '', ['class'=>'form form-control', 'value'=>old('" . $coluna->COLUMN_NAME . "')]) }}
                <br></div>"));

                            $formEdit .= nl2br(htmlspecialchars("
                            <div class='col'>
                            {{ Form::label('" . $coluna->COLUMN_NAME . "', '" . $coluna->COLUMN_COMMENT . "')}}:
                            {{ Form::text('" . $coluna->COLUMN_NAME . "', '', ['class'=>'form form-control', 'value'=>old('" . $coluna->COLUMN_NAME . "')]) }}
                <br></div>"));
                        }

                        # data 
                    } elseif ($coluna->DATA_TYPE == 'date') {

                        $datapicker_form .= "<!- Datapicker " . $coluna->COLUMN_COMMENT . "->
                                <script>
                                \$function(){
                                $(#" . $coluna->COLUMN_NAME . ").datetimepicker({
                                });
                                </script>
                                
                                ";

                        $formCreate .= nl2br(htmlspecialchars("
                                        <div class='col'>
                                            {{ Form::label('" . $coluna->COLUMN_NAME . "', '" . $coluna->COLUMN_COMMENT . "')}}:
                                            {{ Form::text('" . $coluna->COLUMN_NAME . "', '', ['class'=>'form form-control'])}}
                                        <br></div>"));

                        $formEdit .= nl2br(htmlspecialchars("
                                        <div class='col'>
                                            {{ Form::label('" . $coluna->COLUMN_NAME . "', '" . $coluna->COLUMN_COMMENT . "')}}:
                                            {{ Form::text('" . $coluna->COLUMN_NAME . "', '', ['class'=>'form form-control'])}}
                                        <br></div>"));

                        # dataTime
                    } elseif ($coluna->DATA_TYPE == 'datetime') {
                        $datapicker_form .= "<!- Datapicker " . $coluna->COLUMN_COMMENT . "->
                                <script>
                                \$function(){
                                $(#" . $coluna->COLUMN_NAME . ").datetimepicker({
                                });
                                </script>
                                
                                ";

                        $formCreate .= nl2br(htmlspecialchars("<div class='col'>
                                        {{ Form::label('" . $coluna->COLUMN_NAME . "', '" . $coluna->COLUMN_COMMENT . "')}}:
                                        {{ Form::text('" . $coluna->COLUMN_NAME . "', '', ['class'=>'form form-control'])}}
                                        <br></div>"));

                        $formEdit .= nl2br(htmlspecialchars("<div class='col'>
                                        {{ Form::label('" . $coluna->COLUMN_NAME . "', '" . $coluna->COLUMN_COMMENT . "')}}:
                                        {{ Form::text('" . $coluna->COLUMN_NAME . "', '', ['class'=>'form form-control'])}}
                                        <br></div>"));


                        /* select */
                        /* autocomplete */
                        /* textarea */
                        /* upload */

                        # radio sim ou nao / ckeckbox
                    } elseif ($coluna->DATA_TYPE == 'tinyint') {

                        # radio sim ou nao
                        if (stripos($coluna->COLUMN_COMMENT, "Sim/Nao")) {

                            $formCreate .= nl2br(htmlspecialchars("<div class='col'>
                    {{ Form::label('" . $coluna->COLUMN_NAME . "', '" . $coluna->COLUMN_COMMENT . "')}}:
                    <div class='form-check'>
                      <input class='form-check-input' type='radio' name='" . $coluna->COLUMN_NAME . "' id='" . $coluna->COLUMN_NAME . "1'>
                      <label class='form-check-label' for='" . $coluna->COLUMN_NAME . "'>
                        Sim
                      </label>
                    </div>
                    <div class='form-check'>
                      <input class='form-check-input' type='radio' name='" . $coluna->COLUMN_NAME . "' id='" . $coluna->COLUMN_NAME . "2' checked>
                      <label class='form-check-label' for='" . $coluna->COLUMN_NAME . "'>
                        Não
                      </label>
                    </div>

                    <br></div>"));

                            $formEdit .= nl2br(htmlspecialchars("<div class='col'>
                        {{ Form::label('" . $coluna->COLUMN_NAME . "', '" . $coluna->COLUMN_COMMENT . "')}}:
                        <div class='form-check'>
                          <input class='form-check-input' type='radio' name='" . $coluna->COLUMN_NAME . "' id='" . $coluna->COLUMN_NAME . "1'>
                          <label class='form-check-label' for='" . $coluna->COLUMN_NAME . "'>
                            Sim
                          </label>
                        </div>
                        <div class='form-check'>
                          <input class='form-check-input' type='radio' name='" . $coluna->COLUMN_NAME . "' id='" . $coluna->COLUMN_NAME . "2' checked>
                          <label class='form-check-label' for='" . $coluna->COLUMN_NAME . "'>
                            Não
                          </label>
                        </div>

                        <br></div>"));
                            # checkbox
                        } else {

                            $checkbox_controller .= "{\$request->has('" . $coluna->COLUMN_NAME . "') ? \$request['" . $coluna->COLUMN_NAME . "'] = 1 : \$request['" . $coluna->COLUMN_NAME . "'] =0;}";

                            $formCreate .= nl2br(htmlspecialchars("<div class='col'>
                        {{ Form::label('" . $coluna->COLUMN_NAME . "', '" . $coluna->COLUMN_COMMENT . "')}}:
                            <div class='form-check'>
                              {{Form::checkbox('" . $coluna->COLUMN_NAME . "', 
                                        $colection->" . $coluna->COLUMN_NAME . ",
                                        ( ($colection->" . $coluna->COLUMN_NAME . " == 0) ? false : true),
                                         )}}
                              <label class='form-check-label' for='" . $coluna->COLUMN_NAME . "'>
                                " . $coluna->COLUMN_COMMENT . "
                              </label>
                            </div>
                          <br></div>"));

                            $formEdit .= nl2br(htmlspecialchars("<div class='col'>
                        {{ Form::label('" . $coluna->COLUMN_NAME . "', '" . $coluna->COLUMN_COMMENT . "')}}:
                            <div class='form-check'>
                              <input class='form-check-input' type='checkbox' value='' id='" . $coluna->COLUMN_NAME . "'>
                              <label class='form-check-label' for='" . $coluna->COLUMN_NAME . "'>
                                " . $coluna->COLUMN_COMMENT . "
                              </label>
                            </div>
                          <br></div>"));
                        }
                    }

                    $cont++;

                    if ($cont == 2) {
                        $formCreate .= nl2br(htmlspecialchars("
            </div>
            <div class='row'>"));

                        $formEdit .= nl2br(htmlspecialchars("
            </div>
            <div class='row'>"));

                        $cont = 0;
                    }
                }

                $formCreate .= nl2br(htmlspecialchars("<div class='row'>
                                {{ Form::submit('Gravar', ['class'=>'btn btn-primary']) }}
                            </div>"));

                $formEdit .= nl2br(htmlspecialchars("<div class='row'>
                                {{ Form::submit('Gravar', ['class'=>'btn btn-primary']) }}
                            </div>"));



                # fim form
                $formCreate .= nl2br(htmlspecialchars("{{ Form::close() }}
    </div>"));


                $formEdit .= nl2br(htmlspecialchars("{{ Form::close() }}
    </div>"));





                ?>
                <legend>LEMBRE-SE DE VERIFICAR A PROPRIEDADE FILLABLE OU GUARD NO MODEL</legend>
                <br>


                <?php

                /* controller indec */
                $controllerIndex = nl2br(htmlspecialchars('
if ($request->method() == "GET") { 
            $empdors = PaeEmpdor::paginate(7);<

            return view(<br>
                \'drrd/paebm/empdor/index\',
                [<br>
                    \'empdors\' => $empdors,
                ]
            );
        } elseif($request->method() == "POST") {

            $empdors = PaeEmpdor::where(\'pae_empdors.nome\', \'LIKE\', \'%\' . $request->get(\'search\') . \'%\')
                ->paginate();

                return view(
                    \'drrd/paebm/empdor/index\',
                    [
                        \'empdors\' => $empdors,
                    ]
                );
        }'));

                ############################# /* create */ ######################################

                $controllerCreate = nl2br(htmlspecialchars('return view(\'drrd/paebm/empdor/create\')'));


                #############################  /* store */  ##################################### 

                $controllerStore = nl2br(htmlspecialchars('$request->validate(
                [
                    \'nome\'               => "required|max:110",
                ],
                [        
                    \'nome.required\' => \'O campo  Nome é Obrigatório !\',
                    \'nome.max\' => \'O campo Nome suporta no máximo 110 caracteres !\',
                ]
            );


            $empnto = new PaeEmpdor;
            $empnto->nome               = $request->nome;

            $empnto->save();
        
            return redirect(\'pae/empdor\')->with(\'message\',\'Registro Gravado com Sucesso \');'));

                #############################  /* show */  ###################################### 

                $controllerShow = nl2br(htmlspecialchars('return view(
            \'drrd/paebm/empdor/show\',
            [
                \'empdor\' => $paeEmpdor,
            ]
        );'));

                #############################  /* edit  */  #################################### 

                $controllerEdit = nl2br(htmlspecialchars('return view(
            \'drrd/paebm/empdor/edit\',
            [
                \'empdor\' => $paeEmpdor,
            ]
        );'));


                #############################  /* update */  #################################### 

                $controllerUpdate = nl2br(htmlspecialchars('$request->validate(
            [
                \'id\'                 => "required|integer",
                \'nome\'               => "required|max:110",
            ],
            [
                \'id.required\' => \'O campo Id não está presente\',
                \'nome.required\' => \'O campo Nome é Obrigatório !\',
                \'nome.max\' => \'O campo Nome suporta no máximo 110 caracteres !\',
            ]
        );

        $empnto = PaeEmpdor::find($request->id);
        $empnto->nome               = $request->nome;

        $empnto->update();
                
        return redirect(\'pae/empdor\')->with(\'message\',\'Registro Atualizado com Sucesso \');'));

                #############################  /* destroy */  ################################### 

                $controllerDestroy = nl2br(htmlspecialchars('$compdecLeis = CompdecAnexo::find($id);

            $compdecLeis->delete();
            
            /* se for arquivoi remover */
            if(Storage::exists(\'public/compdecleis/\'.$compdecLeis->arquivo)){
                Storage::delete(\'public/compdecleis/\'.$compdecLeis->arquivo);
            }

            if($compdecLeis){
                return back()
                    ->with([
                            \'message\' => \'Registro deletado com Sucesso !\',
                            \'active_tab\' => \'#-arquivo-tab\',
                            ]);
            }'));



        ###################################   FORMULARIO GENERICO   #######################################################

            print nl2br(htmlspecialchars("
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
                <b> ################## CHECKBOX - NO CONTROLLER #############</b>
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