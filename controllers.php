<?php 

################################################  CONTROLLER INDEX  #################################################


                $controllerIndex = nl2br(htmlspecialchars('/* controller index */
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

################################################  CONTROLLER CREATE  #################################################


                $controllerCreate = nl2br(htmlspecialchars('/* controller create */
                    return view(\'drrd/paebm/empdor/create\')'));


################################################  CONTROLLER STORE  #################################################

                $controllerStore = nl2br(htmlspecialchars('/* controller store */
                    $request->validate(
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



################################################  CONTROLLER SHOW  #################################################

                $controllerShow = nl2br(htmlspecialchars('/* controller show */
                    return view(
            \'drrd/paebm/empdor/show\',
            [
                \'empdor\' => $paeEmpdor,
            ]
        );'));

################################################  CONTROLLER EDIT  #################################################


                $controllerEdit = nl2br(htmlspecialchars('/* controller edit */
                    return view(
            \'drrd/paebm/empdor/edit\',
            [
                \'empdor\' => $paeEmpdor,
            ]
        );'));


################################################  CONTROLLER UPDATE  #################################################

                $controllerUpdate = nl2br(htmlspecialchars('/* controller update */
                    $request->validate(
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

################################################  CONTROLLER DESTROY  #################################################

                $controllerDestroy = nl2br(htmlspecialchars('/* controller destroy */
                    $compdecLeis = CompdecAnexo::find($id);

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


################################################  FIM CONTROLLERS  #################################################