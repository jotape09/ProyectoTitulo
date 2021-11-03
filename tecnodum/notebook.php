<?php
include("template/cabecera.php");
?>

<?php


$txtNombre=(isset($_POST['txtNombre']))?$_POST['txtNombre']:"";
$txtPrecio=(isset($_POST['txtPrecio']))?$_POST['txtPrecio']:"";
$accion=(isset($_POST['accion']))?$_POST['accion']:"";

include("administrador/config/bd.php");

$sentenciaSQL=$conexion->prepare("SELECT * from notebook");
$sentenciaSQL->execute();
$listarnotebook=$sentenciaSQL->fetchall(PDO::FETCH_ASSOC);

switch($accion){

       case "Agregar":
           $sentenciaSQL=$conexion->prepare("INSERT INTO carritodecompras (nombre, precio) VALUES (:nombre,:precio);");
           $sentenciaSQL->bindParam(':nombre', $txtNombre);
           $sentenciaSQL->bindParam(':precio', $txtPrecio);
           //$sentenciaSQL->bindParam(':imagen', $txtImagen);
           //$sentenciaSQL->execute();
   
           $sentenciaSQL->execute();
   
           //header("Location:impresoras.php");
           echo "presionando boton Agregar";
           echo $txtNombre;
           echo $txtPrecio;
           echo "presionando boton Agregar";
       break;

   }

?>

<?php foreach($listarnotebook as $notebook){ ?>

       <form method="POST" enctype="multipart/form-data">

              <div class="col-md-3">
                     <div class="card-columns">
     
                                   <img class="card-img-top" src="./img/<?php echo $notebook["imagen"]; ?>" alt="">
                                          <div class="card-body">
                                          <h4 type="text" required readonly class="card-title" value="<?php echo $txtNombre ?>" name="txtNombre" id="txtNombre"><?php echo $notebook["nombre"]; ?></h4>
                                          <br>
                                          <h4 type="text" required readonly class="card-title" value="<?php echo $txtPrecio ?>" name="txtPrecio" id="txtPrecio"><?php echo $notebook["precio"]; ?></h4>
                                          <br>
                                          <button type="submit" name="accion" <?php echo ($accion=="Seleccionar")?"disabled":"" ?> value="Agregar" class="btn btn-success">Agregar al carrito</button>
              
                                          </div>

                     </div>
              </div>
       </form>

<?php } ?>

<?php
include("template/pie.php");
?>

<?php
include("template/pie.php");
?>