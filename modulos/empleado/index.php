<?php 

include("../../conexion.php");

$stm=$conexion->prepare("SELECT em.id, em.nombre, em.email, em.sexo, ar.nombre as area, em.boletin FROM empleado em INNER JOIN areas ar ON em.area_id = ar.id");
$stm->execute();
$empleados=$stm->fetchAll(PDO::FETCH_ASSOC);

//Opción para eliminar 
if(isset($_GET['id'])){

  $txtid=(isset($_GET['id'])?$_GET['id']:"");
  $stm=$conexion->prepare("DELETE FROM empleado WHERE id=:txtid");
  $stm->bindParam(":txtid",$txtid);
  $stm->execute();
  header("location:index.php");

}

?>


<?php include("../../template/header.php") ?>

<!-- Button trigger modal -->
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#create">
  Nuevo
</button>


<div class="table-responsive">
  <table class="table table-striped">
    <thead>
      <tr>
        <th scope="col">
          <div class="d-flex align-items-center">
            <span class="material-icons">person</span>&nbsp
            <span>Nombre</span>
          </div>
        </th>
        <th scope="col">
          <div class="d-flex align-items-center">
            <span>@</span>&nbsp
            <span>Email</span>
          </div>
        </th>
        <th scope="col">
          <div class="d-flex align-items-center">
            <div class="d-flex flex-row">
              <span class="material-icons">female</span>
              <span class="material-icons">male</span>&nbsp
            </div>
            <span>Sexo</span>
          </div>
        </th>
        <th scope="col">
          <div class="d-flex align-items-center">
            <span class="material-icons">business_center</span>&nbsp
            <span>Área</span>
          </div>
        </th>
        <th scope="col">
          <div class="d-flex align-items-center">
            <span class="material-icons">local_post_office</span>&nbsp
            <span>Boletín</span>
          </div>
        </th>
        <th scope="col">Modificar</th>
        <th scope="col">Eliminar</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach($empleados as $empleado) { ?>
      <tr class="">
        <td scope="row"><?php echo $empleado['nombre']; ?></td>
        <td><?php echo $empleado['email'] ?></td>
        <td><?php echo $empleado['sexo'] ?></td>
        <td><?php echo $empleado['area'] ?></td>
        <td><?php echo $empleado['boletin'] == 1 ? "Sí" : "No" ?></td>
        <td>
          <a href="edit.php?id=<?php echo $empleado['id']; ?>">
            <span class="material-icons">edit_square</span>
          </a>
        </td>
        <td>
          <a href="index.php?id=<?php echo $empleado['id']; ?>">
            <span class="material-icons">delete</span>
          </a>
        </td>
      </tr>
      <?php } ?>
    </tbody>
  </table>
</div>
<?php include("create.php"); ?>


<?php include("../../template/footer.php") ?>