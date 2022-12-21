<?php 

$hostname = $_POST["host"];
    $dbname   = $_POST["db"];
    $username = $_POST["usuario"];
    $password = $_POST["password"];

class Conexao {

public static $instance;

public static function getInstance() {

    if (!isset(self::$instance)) {
        
        if($_SERVER['DOCUMENT_ROOT'] == '/web') {

            if(TESTE){
                self::$instance = new PDO('mysql:host=200.198.29.229;dbname=teste', 'usuario', 'usuario', array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
            }else {
                self::$instance = new PDO('mysql:host=200.198.29.229;dbname=gestaocedec', 'usuario', 'usuario', array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
            }
        }else {
            //self::$instance = new PDO('mysql:host=10.180.216.68;port=3306;dbname=gestaocedec', 'usuario', 'usuario', array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
            self::$instance = new PDO('mysql:host=localhost;port=3307;dbname=gestaocedeclaravel', 'root', '', array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
        }

        /* self::$instance = new PDO('mysql:host=localhost;dbname=gestaocedec', 'usuario', 'usuario', array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));*/
        self::$instance -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        self::$instance -> setAttribute(PDO::ATTR_ORACLE_NULLS, PDO::NULL_EMPTY_STRING);
    }
    
    return self::$instance;
}

        
            
       try {

        $pdo = new PDO ("mysql:host=$hostname;dbname=$dbname;","$username","$password");
        } catch (PDOException $e) {
            echo "Erro de Conexão " . $e->getMessage() . "\n";
            exit;
        }
    

?>