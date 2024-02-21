<?php
//RECUPERAR TAREAS POR FECHA
function tareasPorFecha(PDO $pdo) {
    $sql = "SELECT * FROM t_tareas ORDER BY fechafin";
    $stmt = $pdo->query($sql);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

//RECUPERAR TAREA ASOCIADA A CODIGO
function selectPorCodigo($codigo, $pdo) {
    try {
        $sql = "SELECT * FROM t_tareas WHERE codigo = :codigo";

        // Preparar y ejecutar la consulta
        $statement = $pdo->prepare($sql);
        $statement->execute(array(':codigo' => $codigo));

        // Obtener la fila como un array asociativo
        $fila = $statement->fetch(PDO::FETCH_ASSOC);
        
        // Devolver la fila obtenida
        return $fila;
    } catch (PDOException $e) {
        // Capturar cualquier excepción y mostrar un mensaje de error
        echo 'Error al ejecutar la consulta: ' . $e->getMessage();
        return false; // Devolver false en caso de error
    }
}

function eliminarTarea($codigo, $pdo){
    try{
        $sql = "DELETE FROM t_tareas where codigo= :codigo";

        $statement = $pdo->prepare($sql);
        $statement->execute(array(':codigo' => $codigo));
    }catch (PDOException $e) {
        // Capturar cualquier excepción y mostrar un mensaje de error
        echo 'Error al ejecutar la consulta: ' . $e->getMessage();
        return false; // Devolver false en caso de error
    }
};

function editarTarea($codigo,$pdo) {
    $datos = [
        "codigo"        => $_POST['codigo'],
        "nombre"        => $_POST['nombre'],
        "fechaInicio"   => $_POST['fechaInicio'],
        "fechaFin"      => $_POST['fechaFin'],
        "responsable"   => $_POST['responsable'],
        "descripcion"   => $_POST['descripcion']
    ];
    $sql = "UPDATE t_tareas 
            set nombre = :nombre,
                fechaInicio = :fechaInicio,
                fechaFin = :fechaFin,
                responsable = :responsable,
                descripcion = :descripcion
            where codigo = :codigo";
    try{
        $statement = $pdo->prepare($sql);
        $statement->execute($datos);
    }catch(PDOexception $e){
        echo $e->getMessage();
    }
}

function obtenerTareasPaginadas(PDO $pdo,$indiceInicio,$tareasPorPagina) {
    try{
        $sql = "SELECT * FROM t_tareas ORDER BY fechaFin LIMIT :inicio, :tareasPorPagina";
        $statement = $pdo->prepare($sql);
        $statement->bindParam(':inicio', $indiceInicio, PDO::PARAM_INT);
        $statement->bindParam(':tareasPorPagina', $tareasPorPagina, PDO::PARAM_INT);
        $statement->execute();
        $tareas = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $tareas;
    }catch(PDOexception $e){
        echo $e->getMessage();
}
}

function contarTareas($pdo) {
    try{
        $sql = "SELECT COUNT(*) AS total FROM t_tareas";
        $statement = $pdo->prepare($sql);
        $statement->execute();
        $resultado = $statement->fetch(PDO::FETCH_ASSOC);
        return $resultado['total'];
    }catch(PDOexception $e){
        echo $e->getMessage();
    }
}


////////////////////////////////////////////////////////////////////////////////// AL COGER LOS DATOS POR $TAREA[]NO FUNCIONA A PESAR DE QUE LOS ARRAYS SON IGUALES
/*function editarTareaXDDDDDDDDDD($codigo,$pdo) {
    $tarea = selectPorCodigo($codigo,$pdo);
    $datos = [
        "codigo"        => $tarea['codigo'],
        "nombre"        => $tarea['nombre'],
        "fechaInicio"   => $tarea['fechaInicio'],
        "fechaFin"      => $tarea['fechaFin'],
        "responsable"   => $tarea['responsable'],
        "descripcion"   => $tarea['descripcion']];
    $sql = "UPDATE t_tareas 
            set nombre = :nombre,
                fechaInicio = :fechaInicio,
                fechaFin = :fechaFin,
                responsable = :responsable,
                descripcion = :descripcion
            where codigo = :codigo";
    try{
        $statement = $pdo->prepare($sql);
        $statement->execute($datos);
    }catch(PDOexception $e){
        echo $e->getMessage();
    }
}*/
?>