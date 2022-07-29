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
            <li>Nome para checkbox <b>ck_</b>  Tipo BD TINYINT(1)</li>
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

    $pdo = new PDO ("mysql:host=$hostname;dbname=$dbname","$username","$password");
} catch (PDOException $e) {
    echo "Erro de Conexão " . $e->getMessage() . "\n";
    exit;
}

    $dados = array();
    $dadosSemPrimary = array();

    $sql = "SELECT * FROM information_schema.columns where table_name = '{$table}' and table_schema = '{$dbname}'";
    $query = $pdo->prepare($sql);
    $query->execute();

    while( $linha = $query->fetch(PDO::FETCH_OBJ) ){
        if($linha->COLUMN_KEY != "PRI"){
            $dadosSemPrimary[] = $linha;
        }
        $dados[] = $linha;
    }


    //var_dump($dados);   


    ###################  create ########################

    $datapicker_form = "";

    

    $input = "";

    $cont = 0;


# inicio formulario 
print nl2br(htmlspecialchars("<div class='col-md-12'>
{{ Form::open(array('url' => '/".$table."')) }}
{{ Form::token() }}"));
    
print nl2br(htmlspecialchars("
            <div class='row'>"));
    foreach ($dadosSemPrimary as $key => $coluna) {

        if( ($key == 0) && ($cont == 2) ) {
            print nl2br(htmlspecialchars("
            <div class='row'>"));
           
        } 

                      
        # id 
        if($coluna->COLUMN_KEY == 'PRI'){
            //echo $coluna->COLUMN_NAME."<br>";

        # int
    }elseif($coluna->DATA_TYPE == 'int'){
        
            print nl2br(htmlspecialchars("
                        <div class='col'>
                        {{ Form::label('".$coluna->COLUMN_NAME."', '".$coluna->COLUMN_COMMENT."')}}:
                        {{ Form::text('".$coluna->COLUMN_NAME."', '', ['class'=>'form form-control', 'value'=>'{{old('".$coluna->COLUMN_NAME."')}}']) }}
            <br></div>"));
        
        
        # Texto
        }elseif($coluna->DATA_TYPE == 'varchar'){
            if(false) { # mascara
                print nl2br(htmlspecialchars($coluna->COLUMN_NAME."<br>"));
            }else { # texto
                print nl2br(htmlspecialchars("
                            <div class='col'>
                            {{ Form::label('".$coluna->COLUMN_NAME."', '".$coluna->COLUMN_COMMENT."')}}:
                            {{ Form::text('".$coluna->COLUMN_NAME."', '', ['class'=>'form form-control', 'value'=>old('".$coluna->COLUMN_NAME."')]) }}
                <br></div>"));
            }
        
        # data 
        }elseif($coluna->DATA_TYPE == 'date'){

            $datapicker_form .= "<!- Datapicker ".$coluna->COLUMN_COMMENT."->
                                <script>
                                \$function(){
                                $(#".$coluna->COLUMN_NAME.").datetimepicker({
                                });
                                </script>
                                
                                ";

                                print nl2br(htmlspecialchars("
                                        <div class='col'>
                                            {{ Form::label('".$coluna->COLUMN_NAME."', '".$coluna->COLUMN_COMMENT."')}}:
                                            {{ Form::text('".$coluna->COLUMN_NAME."', '', ['class'=>'form form-control'])}}
                                        <br></div>"));

        # dataTime
        }elseif($coluna->DATA_TYPE == 'datetime'){
            $datapicker_form .= "<!- Datapicker ".$coluna->COLUMN_COMMENT."->
                                <script>
                                \$function(){
                                $(#".$coluna->COLUMN_NAME.").datetimepicker({
                                });
                                </script>
                                
                                ";
                                print nl2br(htmlspecialchars("<div class='col'>
                                        {{ Form::label('".$coluna->COLUMN_NAME."', '".$coluna->COLUMN_COMMENT."')}}:
                                        {{ Form::text('".$coluna->COLUMN_NAME."', '', ['class'=>'form form-control'])}}
                                        <br></div>"));


        /* select */
        /* autocomplete */
        /* textarea */
        /* upload */
        
        # radio sim ou nao / ckeckbox
        }elseif($coluna->DATA_TYPE == 'tinyint'){
         
                # radio sim ou nao
                if(stripos($coluna->COLUMN_COMMENT, "Sim/Nao")){



                print nl2br(htmlspecialchars("<div class='col'>
                    {{ Form::label('".$coluna->COLUMN_NAME."', '".$coluna->COLUMN_COMMENT."')}}:
                    <div class='form-check'>
                      <input class='form-check-input' type='radio' name='".$coluna->COLUMN_NAME."' id='".$coluna->COLUMN_NAME."1'>
                      <label class='form-check-label' for='".$coluna->COLUMN_NAME."'>
                        Sim
                      </label>
                    </div>
                    <div class='form-check'>
                      <input class='form-check-input' type='radio' name='".$coluna->COLUMN_NAME."' id='".$coluna->COLUMN_NAME."2' checked>
                      <label class='form-check-label' for='".$coluna->COLUMN_NAME."'>
                        Não
                      </label>
                    </div>

                    <br></div>"));
                # checkbox
                }else {
                    print nl2br(htmlspecialchars("<div class='col'>
                        {{ Form::label('".$coluna->COLUMN_NAME."', '".$coluna->COLUMN_COMMENT."')}}:
                            <div class='form-check'>
                              <input class='form-check-input' type='checkbox' value='' id='".$coluna->COLUMN_NAME."'>
                              <label class='form-check-label' for='".$coluna->COLUMN_NAME."'>
                                ".$coluna->COLUMN_COMMENT."
                              </label>
                            </div>
                          <br></div>"));

                }
        }
        
        $cont ++;
        
        if( $cont == 2 ){
            print nl2br(htmlspecialchars("
            </div>
            <div class='row'>"));
            $cont = 0;
        }

       

    }

print nl2br(htmlspecialchars("<div class='row'>
                                {{ Form::submit('Gravar', ['class'=>'btn btn-primary']) }}
                            </div>"));



# fim form
print nl2br(htmlspecialchars("{{ Form::close() }}

</div>"));


//var_dump($dados);
?>
