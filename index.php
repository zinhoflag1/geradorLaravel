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
          <legend>Gerador Laravel</legend>
        </div>
    <?php
        $dir = $_SERVER['DOCUMENT_ROOT'];
    ?>
    <form action="process.php" method="POST" name="frmGerar" id="frmGerar">

    <?php

        $projetoPath = dir($dir);

        print "<label>Host</label>";
        print "<input class='form form-control col-md-4' type='text' name='host' id='host'><br>";
        
        print "<label>Usuario</label>";
        print "<input class='form form-control col-md-4' type='text' name='usuario' id='usuario'><br>";
        
        print "<label>Senha</label>";
        print "<input class='form form-control col-md-4' type='text' name='password' id='password'><br>";

        print "<label>Base de Dados</label>";
        print "<input class='form form-control col-md-4' type='text' name='db' id='db'>";

        print "<label>Projeto</label>";
        print "<select class='form form-control col-md-4' name='selProjeto' id='selProjeto'>";
        print "<option>Escolha o Projeto</option>";

        while($arquivo = $projetoPath -> read()){
            print $arquivo;
            if($arquivo != "." and $arquivo != ".."){
                if( is_dir($dir."/".$arquivo) ) {
                    print "<option>".$arquivo."</option>";
                }
            }
        }
        print "</select>";

    ?>

    <br>
    <input class='btn btn-primary' type="submit" name="btnEnviar" id="btnEnviar">

    </form>
  </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  </body>
</html>

