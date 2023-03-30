<?php 
//require("../../conexion.php");

$response = $conexion->prepare("SELECT * FROM areas");
$response->execute();

if($_POST){

  $nombre=(isset($_POST['nombre'])?$_POST['nombre']:"");
  $email=(isset($_POST['email'])?$_POST['email']:"");
  $sexo=(isset($_POST['sexo'])?$_POST['sexo']:"");
  $area=(isset($_POST['area'])?$_POST['area']:"");
  $descripcion=(isset($_POST['descripcion'])?$_POST['descripcion']:"");
  $boletin=(isset($_POST['boletin'])?$_POST['boletin']:"");
  
  $stm=$conexion->prepare("INSERT INTO empleado(id, nombre, email, sexo, area_id, boletin, descripcion)
  VALUES(NULL, :nombre, :email, :sexo, :area, :boletin, :descripcion )");
  $stm->bindParam(":nombre",$nombre);
  $stm->bindParam(":email",$email);
  $stm->bindParam(":sexo",$sexo);
  $stm->bindParam(":area",$area);
  $stm->bindParam(":boletin",$boletin);
  $stm->bindParam(":descripcion",$descripcion);
  $stm->execute();
  
  //Obtenemos el id del empleado
  $id_empleado=$conexion->lastInsertId();

  //Se insertan los roles en la tabla relacionada
  $rol=(isset($_POST['rol'])?$_POST['rol']:"");
  foreach($rol as $roles) {
    $sql="INSERT INTO empleado_rol(empleado_id, rol_id)
    VALUES($id_empleado, $roles)";
    $conexion->query($sql);
  }

  //header("location:index.php");
  echo '<script>window.location="index.php"</script>';

}

?>

<!-- Modal para crear empleado-->
<div class="modal fade bd-example-modal-lg" id="create" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Crear empleado</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">


        <form action="" method="post">
          <div class="form-group row">
            <label for="nombre" class="col-sm-2 col-form-label">Nombre completo *</label>
            <div class="col-sm-10">
              <input name="nombre" type="text" class="form-control" id="nombre" placeholder="Nombre completo del empleado">
            </div>
          </div>

          <div class="form-group row">
            <label for="email" class="col-sm-2 col-form-label">Correo electrónico *</label>
            <div class="col-sm-10">
              <input name="email" type="email" class="form-control" id="email" placeholder="Correo electrónico">
            </div>
          </div>

          <div class="form-group row">
            <div class="row">
            <label for="inputSexo" class="col-sm-2 col-form-label">Sexo *</label>
              <div class="col-sm-10">
                <div class="form-check">
                  <input class="form-check-input" type="radio" name="sexo" id="masculino" value="Masculino" checked>
                  <label class="form-check-label" for="masculino">
                    Masculino
                  </label>
                </div>
                <div class="form-check">
                  <input class="form-check-input" type="radio" name="sexo" id="femenino" value="Femenino">
                  <label class="form-check-label" for="femenino">
                    Femenino
                  </label>
                </div>
              </div>
            </div>
          </div>

          <br>

          <div class="form-group row">
            <label for="area" class="col-sm-2 col-form-label">Área *</label>
            <div class="col-sm-10">
              <select class="form-control" id="area" name="area">
                <?php  foreach($response as $r) {
                  echo "<option value=".$r[0].">".$r[1]."</option>";
                } ?>
              </select>
            </div>
          </div>

          <br>

          <div class="form-group row">
            <label for="descripcio" class="col-sm-2 col-form-label">Descripción *</label>
            <div class="col-sm-10">
              <textarea name="descripcion" class="form-control" id="descripcio" rows="3" placeholder="Descripción de la experiencia del empleado"></textarea>
            </div>
          </div>
            
          <br>

          <div class="form-group row">
            <div class="col-sm-2"></div>
            <div class="col-sm-10">
              <div class="form-check">
                <input class="form-check-input" type="checkbox" id="boletin" name="boletin" value="1">
                <label class="form-check-label" for="boletin">
                  Deseo recibir boletín informativo
                </label>
              </div>
            </div>
          </div>

          <br>

          <div class="form-group row">
            <div class="col-sm-2">Roles *</div>
            <div class="col-sm-10">
              <div class="form-check">
                <input class="form-check-input" type="checkbox" id="desarrollador" name="rol[]" value="1" >
                <label class="form-check-label" for="desarrollador">
                  Desarrollador
                </label>
              </div>

              <div class="form-check">
                <input class="form-check-input" type="checkbox" id="analista" name="rol[]" value="2" >
                <label class="form-check-label" for="analista">
                  Analista
                </label>
              </div>

              <div class="form-check">
                <input class="form-check-input" type="checkbox" id="tester" name="rol[]" value="3" >
                <label class="form-check-label" for="tester">
                  Tester
                </label>
              </div>

              <div class="form-check">
                <input class="form-check-input" type="checkbox" id="diseñador" name="rol[]" value="4" >
                <label class="form-check-label" for="diseñador">
                  Diseñador
                </label>
              </div>

              <div class="form-check">
                <input class="form-check-input" type="checkbox" id="pmo" name="rol[]" value="5" >
                <label class="form-check-label" for="pmo">
                  Profesional PMO
                </label>
              </div>

              <div class="form-check">
                <input class="form-check-input" type="checkbox" id="servicios" name="rol[]" value="6" >
                <label class="form-check-label" for="servicios">
                  Profesional de servicios
                </label>
              </div>

              <div class="form-check">
                <input class="form-check-input" type="checkbox" id="auxiliar" name="rol[]" value="7" >
                <label class="form-check-label" for="auxiliar">
                  Auxiliar administrativo
                </label>
              </div>

              <div class="form-check">
                <input class="form-check-input" type="checkbox" id="codirector" name="rol[]" value="8" >
                <label class="form-check-label" for="codirector">
                  Codirector
                </label>
              </div>

            </div>

          
          </div>
          
          <br>
          
          <div class="form-group row">
            <div class="col-sm-2"></div>
            <div class="col-sm-10">
              <button type="submit" class="btn btn-primary">Guardar</button>
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
          </div>
        </form>



      </div>
    </div>
  </div>
</div>