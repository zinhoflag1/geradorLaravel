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

    $sql = "SELECT * FROM information_schema.columns where table_name = '{$table}' and table_schema = '{$dbname}'";
    $query = $pdo->prepare($sql);
    $query->execute();

    while( $linha = $query->fetch(PDO::FETCH_OBJ) ){
        $dados[] = $linha;
    }


    //var_dump($dados);   


    ###################  create ########################

    $datapicker_form = "";

    # inicio formulario 
    
        $openForm = "{{ Form::open(array('url' => '/".$table."')) }}
        <br>
        <div class='col-md-6'>
        {{ Form::token() }}
        </div>";
    //

    # fim form
    $fimForm = "{{ Form::close() }}";

    $input = "";
    
    foreach ($dados as $key => $coluna) {

        $total_campos = ceil(count($dados) / 2) ;

                      
        # id 
        if($coluna->COLUMN_KEY == 'PRI'){
            //echo $coluna->COLUMN_NAME."<br>";
        
        # Texto
        }elseif($coluna->DATA_TYPE == 'varchar'){
            if(false) { # mascara
                $input .= $coluna->COLUMN_NAME."<br>";
            }else { # texto
                $input .= "<div class='col-md-6'>";
                $input .=  "{{ Form::label('".$coluna->COLUMN_NAME."', '".$coluna->COLUMN_COMMENT."') }}";
                $input .=  "{{ Form::text('".$coluna->COLUMN_NAME."', '".$coluna->COLUMN_COMMENT."') }}";
                $input .= "</div>";
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

                                $input .= "<div class='col-md-6'>";
                                $input .=  "{{ Form::label('".$coluna->COLUMN_NAME."', '".$coluna->COLUMN_COMMENT."') }}";
                                $input .= "{{ Form::text('".$coluna->COLUMN_NAME."', '".$coluna->COLUMN_COMMENT."') }}";
                                $input .= "</div>";

        # dataTime
        }elseif($coluna->DATA_TYPE == 'datetime'){
            $datapicker_form .= "<!- Datapicker ".$coluna->COLUMN_COMMENT."->
                                <script>
                                \$function(){
                                $(#".$coluna->COLUMN_NAME.").datetimepicker({
                                });
                                </script>
                                
                                ";
                                $input .= "<div class='col-md-6'>";
                                $input .=  "{{ Form::label('".$coluna->COLUMN_NAME."', '".$coluna->COLUMN_COMMENT."') }}";
                                $input .=  "{{ Form::text('".$coluna->COLUMN_NAME."', '".$coluna->COLUMN_COMMENT."') }}";
                                $input .= "</div>";

        # radio 
        }elseif($coluna->DATA_TYPE == 'varchar'){
            $input .= "<div class='col-md-6'>";
            $input .=  "{{ Form::label('".$coluna->COLUMN_NAME."', '".$coluna->COLUMN_COMMENT."') }";
            $input .=  $coluna->COLUMN_NAME."<br>";
            $input .= "</div>";
        
        /* checkbox  */
        }elseif($coluna->DATA_TYPE == 'varchar'){
            $input .= "<div class='col-md-6'>";
            $input .=  "{{ Form::label('".$coluna->COLUMN_NAME."', '".$coluna->COLUMN_COMMENT."') }";
            $input .=  $coluna->COLUMN_NAME."<br>";
            $input .= "</div>";
        

        /* select */
        }elseif($coluna->DATA_TYPE == 'varchar'){
            $input .= "<div class='col-md-6'>";
            $input .= "{{ Form::label('".$coluna->COLUMN_NAME."', '".$coluna->COLUMN_COMMENT."') }";
            $input .=  $coluna->COLUMN_NAME."<br>";
            $input .= "</div>";

        /* autocomplete */
        }elseif($coluna->DATA_TYPE == 'varchar'){
            $input .= "<div class='col-md-6'>";
            $input .=  "{{ Form::label('".$coluna->COLUMN_NAME."', '".$coluna->COLUMN_COMMENT."') }";
            $input .=  $coluna->COLUMN_NAME."<br>";
            $input .= "</div>";
        
        /* textarea */
        }elseif($coluna->DATA_TYPE == 'varchar'){
            $input .= "<div class='col-md-6'>";
            $input .=  "{{ Form::label('".$coluna->COLUMN_NAME."', '".$coluna->COLUMN_COMMENT."') }";
            $input .=  $coluna->COLUMN_NAME."<br>";
            $input .= "</div>";
        

        /* upload */
        }elseif($coluna->DATA_TYPE == 'varchar'){
            $input .= "<div class='col-md-6'>";
            $input .=  "{{ Form::label('".$coluna->COLUMN_NAME."', '".$coluna->COLUMN_COMMENT."') }";
            $input .=  $coluna->COLUMN_NAME."<br>";
            $input .= "</div>";
        }

    }

    
    print $openForm;
    
    print $input;
    //print $fimForm;
   // print $datapicker_form;

//var_dump($total_campos);

    ?>



    




