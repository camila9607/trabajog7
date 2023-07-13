<?php

include 'conexion.php';
$pdo = new Conexion();

// Consultar un registro
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $sql = $pdo->prepare("SELECT * FROM usuarios WHERE usuario = :usu AND contrasena = :clave");
	$sql->bindValue(':usu', $_GET['usu']);
	$sql->bindValue(':clave', $_GET['clave']);
    $sql->execute();
    $sql->setFetchMode(PDO::FETCH_ASSOC);
    $cuenta = $sql->rowCount();
    echo $cuenta;
if ($cuenta) {
        header('HTTP 200 OK');
        echo json_encode($sql->fetchAll());
    }
else {
        echo "Usuario o contraseña invalida";
    }
exit;
} 

// Crear un registro
if ($_SERVER['REQUEST_METHOD'] == 'POST'){
        $sql = "INSERT INTO usuarios (usuario, contrasena) VALUES (:usuario, :contrasena)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':usuario', $_POST['usuario']); 
        $stmt->bindValue(':contrasena', $_POST['contrasena']); 
        $stmt->execute();
        $idPost = $pdo->lastInsertId();
        if ($idPost) { 
            header("HTTP/1.1 200 OK");
            echo json_encode($idPost);
            
        }
        else echo "usuario no registrado";
        exit;
    } 

?>