<?php
            
$hostname = "localhost";
$banco = "db_fonoteka";
$usuario = "root";
$senha = "";

$conn = new mysqli($hostname,$usuario,$senha,$banco);

if($conn->connect_errno){
    echo "Falha ao conectar: (" . $conn->connect_errno . ") " . $conn -> connect_error;
}
            
?>
