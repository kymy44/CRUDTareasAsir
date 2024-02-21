<?php
include('plantillas/header.php');
include('modelo/conectar.php');
include('funciones.php');

//HACER SWITCH EN FUNCION DEL POST
//obtenemos el codigo por post
$codigo= $_POST['codigo'];

echo 'El código de la tarea es '.$codigo;

//ELIMINAR TAREA
if($_POST['accion']=='eliminar'){
    eliminarTarea($codigo,$pdo);
    ?>
    <br><br><br><br><br>
    <form method="post" action="index.php">
        <button type="submit">Volver</button>
    </form>
<?php
}


//editar
if ($_POST['accion'] == 'editar') {
    editarTarea($codigo,$pdo);
    //header('Location: index.php'); // Redirigir a la página principal después de editar
    //exit; // Detener la ejecución del script para evitar que el resto del código se ejecute
    $_POST['accion'] = 'ver';
}



//mostrar detalles
if($_POST['accion']=='ver'){
         
        //recuperamos la tarea asociada al codigo en un array
        $tarea = selectPorCodigo($codigo,$pdo);
        ?>
        
    <!-- Formulario-->
    <div class="container mt-4">
        <br><br>
        <div class="row justify-content-center">
            <div class="col-md-6">
                <form method="post">
                    <label for="nombre">Nombre:</label>
                    <input type="text" id="nombre" name="nombre" value="<?php echo $tarea['nombre'] ?>" class="form-control">
                    <br>
                    <label for="fechaInicio">Fecha de inicio:</label>
                    <input type="date" id="fechaInicio" name="fechaInicio" value="<?php echo $tarea['fechaInicio'] ?>" class="form-control">
                    <br>
                    <label for="fechaFin">Fecha de fin:</label>
                    <input type="date" id="fechaFin" name="fechaFin" value="<?php echo $tarea['fechaFin'] ?>" class="form-control">
                    <br>
                    <label for="responsable">Responsable:</label>
                    <input type="text" id="responsable" name="responsable" value="<?php echo $tarea['responsable'] ?>" class="form-control">
                    <br>
                    <label for="descripcion">Descripción:</label>
                    <textarea id="descripcion" name="descripcion" class="form-control"><?php echo $tarea['descripcion'] ?></textarea>
                    <br>
                    <input type="submit" name="accion" value="editar" class="btn btn-primary">
                    <input type="hidden" name="codigo" value="<?php echo $codigo?>">
                </form>
            </div>
    </div>
    <div class="row justify-content-center mt-3">
        <div class="col-md-6">
            <form method="post" action="detalleTarea.php">
                <button type="submit" name="accion" value="eliminar" class="btn btn-danger">Eliminar</button>
                <input type="hidden" name="codigo" value="<?php echo $codigo?>">
            </form>
        </div>
    </div>
    <div class="row justify-content-center mt-3">
        <div class="col-md-6">
            <form method="post" action="index.php">
                <button type="submit" class="btn btn-secondary">Volver</button>
            </form>
        </div>
    </div>
</div>


    <?php
}











include('plantillas/footer.php');
?>


