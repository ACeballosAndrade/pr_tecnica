<?php 

include("../../conexion.php");

//Opción para eliminar 
if(isset($_GET['id'])){

  $txtid=(isset($_GET['id'])?$_GET['id']:"");
  $stm=$conexion->prepare("SELECT * FROM empleado WHERE id=:txtid");
  $stm->bindParam(":txtid",$txtid);
  $stm->execute();
  $registro=$stm->fetch(PDO::FETCH_LAZY);
  $nombre=$registro['nombre'];
  $email=$registro['email'];
  $descripcion=$registro['descripcion'];

  $response = $conexion->prepare("SELECT * FROM areas");
  $response->execute();
}


if($_POST){
  $txtid=(isset($_POST['txtid'])?$_POST['txtid']:"");
  $nombre=(isset($_POST['nombre'])?$_POST['nombre']:"");
  $email=(isset($_POST['email'])?$_POST['email']:"");
  $sexo=(isset($_POST['sexo'])?$_POST['sexo']:"");
  $area=(isset($_POST['area'])?$_POST['area']:"");
  $descripcion=(isset($_POST['descripcion'])?$_POST['descripcion']:"");
  $boletin=(isset($_POST['boletin'])?$_POST['boletin']:"");
  
  $stm=$conexion->prepare("UPDATE empleado SET nombre=:nombre, email=:email, sexo=:sexo, area_id=:area, descripcion=:descripcion, boletin=:boletin WHERE id=:txtid");
  $stm->bindParam(":nombre",$nombre);
  $stm->bindParam(":email",$email);
  $stm->bindParam(":sexo",$sexo);
  $stm->bindParam(":area",$area);
  $stm->bindParam(":boletin",$boletin);
  $stm->bindParam(":descripcion",$descripcion);
  $stm->bindParam(":txtid",$txtid);
  $stm->execute();
  


  //Se insertan los roles en la tabla relacionada
  $rol=(isset($_POST['rol'])?$_POST['rol']:"");
  foreach($rol as $roles) {
    $sql="UPDATE empleado_rol SET rol_id=$roles WHERE empleado_id=$txtid";
    $conexion->query($sql);
  }

  header("location:index.php");

}

?>

<?php include("../../template/header.php") ?>


<form action="" method="post">

          <input type="hidden" class="form-control" name="txtid" value="<?php echo $txtid; ?>" placeholder="na">

          <div class="form-group row">
            <label for="nombre" class="col-sm-2 col-form-label">Nombre completo *</label>
            <div class="col-sm-10">
              <input name="nombre" type="text" class="form-control" id="nombre" placeholder="Nombre completo del empleado" value="<?php echo $nombre ?>" require >
            </div>
          </div>

          <div class="form-group row">
            <label for="email" class="col-sm-2 col-form-label">Correo electrónico *</label>
            <div class="col-sm-10">
              <input name="email" type="email" class="form-control" id="email" placeholder="Correo electrónico" value="<?php echo $email ?>" require>
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
            <label for="descripcion" class="col-sm-2 col-form-label">Descripción *</label>
            <div class="col-sm-10">
              <textarea name="descripcion" class="form-control" id="descripcion" rows="3" placeholder="Descripción de la experiencia del empleado" value="<?php echo $descripcion ?>" require></textarea>
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
              <button type="submit" class="btn btn-primary">Actualizar</button>
              <a href="index.php" >Cancelar</a>
            </div>
          </div>
        </form>

<?php include("../../template/footer.php") ?>