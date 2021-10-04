<?php


$_post = $_POST['txtRaiz'];

$dir = $_SERVER['DOCUMENT_ROOT']."/".$_post;


if(file_exists($dir)){


print "<form action='gerar.php' method='POST' name='frmGerador' id='frmGerador'>";
	

$view = dir($dir."/resources/views");

print "<select name='selViews' id='selViews'>";
print "<option>Escolha a Tabela</option>";

while($arquivo = $view -> read()){
	print $arquivo;
	if($arquivo != "." and $arquivo != ".."){
		print "<option>".$arquivo."</option>";
	}
}
print "</select>";

print "<br><input type='submit' name='btnGerar' id='btnGerar'> ";

print "</form>";









}else {
	print "nao existe";

}?>