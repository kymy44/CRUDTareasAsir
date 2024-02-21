<?php
include('plantillas/header.php');
include('modelo/conectar.php');
include('funciones.php');



   

   //Si $_POST existe es porque ya nos han mandado los datos por formulario
    if (isset($_POST['submit'])){

        $nuevaTarea = array (
            "nombre" => $_POST["nombre"],
            "fechaInicio" => $_POST["fechaInicio"],
            "fechaFin" => $_POST["fechaFin"],
            "descripcion" => $_POST["descripcion"],
            "responsable" => $_POST["responsable"]
        );
       
   //Aquí preparamos el insert
       $sql = "INSERT INTO t_tareas (nombre, fechaInicio, fechaFin, descripcion, responsable)
           values (:nombre, :fechaInicio, :fechaFin, :descripcion, :responsable)";

       try {
           $statement = $pdo->prepare($sql);
           $statement->execute($nuevaTarea);
       }catch(PDOException $e){
           echo $e->getMessage();
       }
    }

    //PAGINACIÓN
    $tareasPorPagina = 7; // Num de tareas a mostrar por cada página
    $pagina = isset($_GET['pagina']) ? $_GET['pagina'] : 1; //página actual
    $indiceInicio = ($pagina - 1) * $tareasPorPagina;

   ?>

<div class="container-fluid" style="height: calc(100vh - 100px);"> <!--______________________________________DIV EN EL QUE SE CONTIENE LA VISTA_______________________________________________________________ -->
    <!-- Formulario que lista las tareas -->
    <form action="detalleTarea.php" method="post">
    <ul class="list-unstyled"><!--_____________________UL___________________-->
        <!-- Barra antes de la primera tarea -->
        <br><br>
        <hr class="my-4 barras">
        <?php
        //obtenemos las tareas ordenadas por fecha
        $tareas = obtenerTareasPaginadas($pdo,$indiceInicio,$tareasPorPagina);

        //y las listamos en un foreach
        foreach ($tareas as $tarea): ?>
            <li class="text-center">
                <button type="submit" name="codigo" value="<?php echo $tarea['codigo']; ?>" class="invisible-button">
                    <?php echo $tarea['nombre']; ?>
                </button>
                <br>
                <span class="tarea-info">
                    <?php echo $tarea['fechaFin']; ?> - Codigo: <?php echo $tarea['codigo']?>
                </span>
                <input type="hidden" name="accion" value="ver">
                <hr class="my-4 barras">
            </li>
        <?php endforeach; ?>
    </ul>
</form>

    <?php /*
        //Avisamos si se inserta algo
        if (isset($_POST['submit'])&& isset($statement)) {
            echo 'Inserción de '.$_POST["nombre"].'correcta, bd actualizada.';
        }else{
            echo 'no se ha insertado nada';
        }
        */
    
        $totalTareas = contarTareas($pdo);
$totalPaginas = ceil($totalTareas / $tareasPorPagina);


    ?>
    <!-- Generamos los enlaces de paginación -->
<div class="container mt-4 fixed-bottom posicionBotonesPag">
    <div class="row justify-content-center">
        <div class="col-md-6 text-center">
            <?php
            for ($i = 1; $i <= $totalPaginas; $i++) {
                echo "<a href='?pagina=$i' class='btn btn-outline-primary'>$i</a> ";
            }
            ?>
        </div>
    </div>
</div>


<!-- Botón fijo para abrir el modal -->
<button type="button" class="btn btn-primary fixed-button" data-bs-toggle="modal" data-bs-target="#exampleModalCenter">
    Nueva tarea
</button>

<!-- Modal -->
<div class="modal fade" id="exampleModalCenter" tabindex="-1" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalCenterTitle">Añadir Tarea</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <!-- Formulario para insertar tarea -->
        <form method="post">
          <label for="nombre" class="form-label">Nombre:</label>
          <input type="text" id="nombre" name="nombre" class="form-control">
          <br>
          <label for="fechaInicio" class="form-label">Fecha de inicio:</label>
          <input type="date" id="fechaInicio" name="fechaInicio" class="form-control">
          <br>
          <label for="fechaFin" class="form-label">Fecha de fin:</label>
          <input type="date" id="fechaFin" name="fechaFin" class="form-control">
          <br>
          <label for="responsable" class="form-label">Responsable:</label>
          <input type="text" id="responsable" name="responsable" class="form-control">
          <br>
          <label for="descripcion" class="form-label">Descripción:</label>
          <textarea id="descripcion" name="descripcion" class="form-control"></textarea>
          <br>
          <button type="submit" name="submit" class="btn btn-primary">Enviar</button>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary botonElim" data-bs-dismiss="modal">Cancelar</button>
      </div>
    </div>
  </div>
</div>
</div>



<?php
include('plantillas/footer.php');
?>
