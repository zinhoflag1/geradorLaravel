<?php

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