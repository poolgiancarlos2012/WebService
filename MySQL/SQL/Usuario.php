<?php

$response = []; 

if($_SERVER['REQUEST_METHOD']=='POST'){

    require_once '../conexion/config.php';
    require_once '../conexion/MYSQLConnectionPDO.php';

    $Instanciarcnx = MYSQLConnectionPDO::getInstance();
    $cnx = $Instanciarcnx->getConnection();

    switch ($_POST['accion']):
        case 'VerificarUsuario':
            $user = $_POST['usuario'];
            $pass = $_POST['password'];

            $stmt = $cnx->prepare("SELECT idusuario, nombre, paterno, materno, dni FROM usuario WHERE usuario= '$user' AND clave= MD5('$pass')");
            $stmt->execute();

            $ar_acceso= $stmt->fetchAll(PDO::FETCH_ASSOC);            

            if(count($ar_acceso) != 0){
                $response['success']    = true;
                $response['message']    = "Successfully";
                $response['idusuario']  = $ar_acceso[0]['idusuario'];
                $response['nombre']     = $ar_acceso[0]['nombre'];
                $response['paterno']    = $ar_acceso[0]['paterno'];
                $response['materno']    = $ar_acceso[0]['materno'];
                $response['dni']    = $ar_acceso[0]['dni'];
            }
            break;
    endswitch;


} else {
    $response['success'] = false;
	$response['message'] = "Error";
}


echo json_encode($response);

?>