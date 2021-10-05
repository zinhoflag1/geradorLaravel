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


    var_dump($dados[1]);   

    ###################  create ########################
    
    foreach ($dados as $key => $coluna) {
        
        # id 
        if($coluna->COLUMN_KEY == 'PRI'){
            //echo $coluna->COLUMN_NAME."<br>";
        
        # Texto / Data
        }elseif($coluna->DATA_TYPE == 'varchar'){
            if(true) { # mascara
                echo $coluna->COLUMN_NAME."<br>";
            }else { # texto
                echo "Form::label('".$coluna->COLUMN_NAME."', '".$coluna->COLUMN_COMMENT."')"."<br>";
                echo "Form::text('".$coluna->COLUMN_NAME."', '".$coluna->COLUMN_COMMENT."')"."<br>";
            }
        
        # radio 
        }elseif($coluna->DATA_TYPE == 'varchar'){
            echo $coluna->COLUMN_NAME."<br>";
        
        /* checkbox  */
        }elseif($coluna->DATA_TYPE == 'varchar'){
            echo $coluna->COLUMN_NAME."<br>";
        

        /* select */
        }elseif($coluna->DATA_TYPE == 'varchar'){
            echo $coluna->COLUMN_NAME."<br>";

        /* autocomplete */
        }elseif($coluna->DATA_TYPE == 'varchar'){
            echo $coluna->COLUMN_NAME."<br>";
        
        /* textarea */
        }elseif($coluna->DATA_TYPE == 'varchar'){
            echo $coluna->COLUMN_NAME."<br>";
        

        /* upload */
        }elseif($coluna->DATA_TYPE == 'varchar'){
            echo $coluna->COLUMN_NAME."<br>";
        }

    }

    




