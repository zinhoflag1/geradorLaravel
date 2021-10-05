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
        <div class="col-md-12 text-center">
          <legend>Gerador Laravel - Tabelas </legend>
        </div>

		<?php


		try {
			$hostname = $_POST["host"];
			$dbname = $_POST["db"];
			$username = $_POST["usuario"];
			$password = $_POST["password"];
			$pathProjeto = $_POST['selProjeto'];

			$pdo = new PDO ("mysql:host=$hostname;dbname=$dbname","$username","$password");
		} catch (PDOException $e) {
			echo "Erro de Conexão " . $e->getMessage() . "\n";
			exit;
		}

			$dados = array();

			$sql = "SELECT TABLE_NAME FROM information_schema.tables where table_schema = '{$dbname}'";
			$query = $pdo->prepare($sql);
			$query->execute();
		
			while( $linha = $query->fetch(PDO::FETCH_OBJ) ){
				$dados[] = $linha;
			}

	
			unset($pdo); 
			unset($query);

		print "<form action='gerar.php' method='POST' name='frmGerador' id='frmGerador'>";

		print "<input type='hidden' name='pathProjeto' value='".$pathProjeto."' >";

		print "<input type='hidden' value='".$_POST["host"]."' name='host' id='host'>";
		print "<input type='hidden' value='".$_POST["db"]."' name='db' id='db'>";
		print "<input type='hidden' value='".$_POST["usuario"]."' name='usuario' id='usuario'>";
		print "<input type='hidden' value='".$_POST["password"]."' name='password' id='password'>";

			
		print "<select class='form form-control' name='selTable' id='selTable'>";
		print "<option>Escolha a Tabela</option>";

			foreach ($dados as $key => $value) {
				print "<option>".$value->TABLE_NAME."</option>";
			}

		print "</select>";

		print "<br><input class='btn btn-primary' type='submit' name='btnGerar' id='btnGerar'> ";

		print "</form>";

		?>

</div>

<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>
