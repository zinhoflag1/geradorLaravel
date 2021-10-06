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
        <div class="col-md-6">
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


    var_dump($dados);   


    ###################  create ########################

    $datapicker_form = "
    ";

    # inicio formulario 
    
        print "{{ Form::open(array('url' => '/".$table."')) }}";
        print "<br>";
        print "{{ Form::token() }}";
        print "<br>";
    //

    
    foreach ($dados as $key => $coluna) {

               
        # id 
        if($coluna->COLUMN_KEY == 'PRI'){
            //echo $coluna->COLUMN_NAME."<br>";
        
        # Texto
        }elseif($coluna->DATA_TYPE == 'varchar'){
            if(false) { # mascara
                echo $coluna->COLUMN_NAME."<br>";
            }else { # texto
                echo "{{ Form::label('".$coluna->COLUMN_NAME."', '".$coluna->COLUMN_COMMENT."') }}"."<br>";
                echo "{{ Form::text('".$coluna->COLUMN_NAME."', '".$coluna->COLUMN_COMMENT."') }}"."<br>";
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

            echo "{{ Form::label('".$coluna->COLUMN_NAME."', '".$coluna->COLUMN_COMMENT."') }}"."<br>";
            echo "{{ Form::text('".$coluna->COLUMN_NAME."', '".$coluna->COLUMN_COMMENT."') }}"."<br>";

        # dataTime
        }elseif($coluna->DATA_TYPE == 'datetime'){
            $datapicker_form .= "<!- Datapicker ".$coluna->COLUMN_COMMENT."->
                                <script>
                                \$function(){
                                $(#".$coluna->COLUMN_NAME.").datetimepicker({
                                });
                                </script>
                                
                                ";
            echo "{{ Form::label('".$coluna->COLUMN_NAME."', '".$coluna->COLUMN_COMMENT."') }}"."<br>";
            echo "{{ Form::text('".$coluna->COLUMN_NAME."', '".$coluna->COLUMN_COMMENT."') }}"."<br>";

        # radio 
        }elseif($coluna->DATA_TYPE == 'varchar'){
            echo "{{ Form::label('".$coluna->COLUMN_NAME."', '".$coluna->COLUMN_COMMENT."') }"."<br>";
            echo $coluna->COLUMN_NAME."<br>";
        
        /* checkbox  */
        }elseif($coluna->DATA_TYPE == 'varchar'){
            echo "{{ Form::label('".$coluna->COLUMN_NAME."', '".$coluna->COLUMN_COMMENT."') }"."<br>";
            echo $coluna->COLUMN_NAME."<br>";
        

        /* select */
        }elseif($coluna->DATA_TYPE == 'varchar'){
            echo "{{ Form::label('".$coluna->COLUMN_NAME."', '".$coluna->COLUMN_COMMENT."') }"."<br>";
            echo $coluna->COLUMN_NAME."<br>";

        /* autocomplete */
        }elseif($coluna->DATA_TYPE == 'varchar'){
            echo "{{ Form::label('".$coluna->COLUMN_NAME."', '".$coluna->COLUMN_COMMENT."') }"."<br>";
            echo $coluna->COLUMN_NAME."<br>";
        
        /* textarea */
        }elseif($coluna->DATA_TYPE == 'varchar'){
            echo "{{ Form::label('".$coluna->COLUMN_NAME."', '".$coluna->COLUMN_COMMENT."') }"."<br>";
            echo $coluna->COLUMN_NAME."<br>";
        

        /* upload */
        }elseif($coluna->DATA_TYPE == 'varchar'){
            echo "{{ Form::label('".$coluna->COLUMN_NAME."', '".$coluna->COLUMN_COMMENT."') }"."<br>";
            echo $coluna->COLUMN_NAME."<br>";
        }

    }

    # fim form
    print "{{ Form::close() }}";

    print $datapicker_form;
    ?>

        </div>
        <div class="col-md-6">
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
      </div>




    




