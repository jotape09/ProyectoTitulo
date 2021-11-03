<?php
include("../template/cabecera.php");
?>


<?php
$txtID=(isset($_POST['txtID']))?$_POST['txtID']:"";
$txtNombre=(isset($_POST['txtNombre']))?$_POST['txtNombre']:"";
$txtPrecio=(isset($_POST['txtPrecio']))?$_POST['txtPrecio']:"";
$txtImagen=(isset($_FILES['txtImagen']['name']))?$_FILES['txtImagen']['name']:"";
$accion=(isset($_POST['accion']))?$_POST['accion']:"";

include("../config/bd.php");

switch($accion){

    case "Agregar":
        $sentenciaSQL=$conexion->prepare("INSERT INTO notebook (nombre, precio, imagen) VALUES (:nombre,:precio,:imagen);");
        $sentenciaSQL->bindParam(':nombre', $txtNombre);
        $sentenciaSQL->bindParam(':precio', $txtPrecio);
        //$sentenciaSQL->bindParam(':imagen', $txtImagen);
        //$sentenciaSQL->execute();

        $fecha=new DateTime();
        $nombreArchivo=($txtImagen!="")?$fecha->getTimestamp()."".$_FILES["txtImagen"]["name"]:"imagen.jpg";

        $tmpImagen=$_FILES["txtImagen"]["tmp_name"];

        if($tmpImagen!=""){
            move_uploaded_file($tmpImagen,"../../img/".$nombreArchivo);
        }
        $sentenciaSQL->bindParam(':imagen', $nombreArchivo);
        $sentenciaSQL->execute();

        header("Location:notebook.php");
        //echo "presionando boton Agregar";
        break;

    case "Modificar":
        $sentenciaSQL=$conexion->prepare("UPDATE notebook set nombre=:nombre WHERE id=:id");
        $sentenciaSQL->bindParam(':nombre', $txtNombre);
        $sentenciaSQL->bindParam(':nombre', $txtPrecio);
        $sentenciaSQL->bindParam(':id', $txtID);
        $sentenciaSQL->execute();

        if($txtImagen!=""){

            $fecha=new DateTime();
            $nombreArchivo=($txtImagen!="")?$fecha->getTimestamp()."".$_FILES["txtImagen"]["name"]:"imagen.jpg";

            $tmpImagen=$_FILES["txtImagen"]["tmp_name"];
            move_uploaded_file($tmpImagen,"../../img/".$nombreArchivo);

            $sentenciaSQL=$conexion->prepare("SELECT imagen from notebook WHERE id=:id");
            $sentenciaSQL->bindParam(':id', $txtID);
            $sentenciaSQL->execute();
            $notebook=$sentenciaSQL->fetch(PDO::FETCH_LAZY);
    
            if(isset($notebook["imagen"]) && ($notebook["imagen"]!="imagen.jpg")){
    
                if(file_exists("../../img".$notebook["imagen"])){
                    unlink("../../img".$notebook["imagen"]);
                }
    
            }

            $sentenciaSQL=$conexion->prepare("UPDATE notebook set imagen=:imagen WHERE id=:id");
            $sentenciaSQL->bindParam(':imagen', $nombreArchivo);
            $sentenciaSQL->bindParam(':id', $txtID);
            $sentenciaSQL->execute();
        }

        header("Location:notebook.php");
        //echo "presionando boton Modificar";
        break;

    case "Cancelar":

        header("Location:notebook.php");

        //echo "presionando boton Cancelar";
    break;

    case "Seleccionar":
        $sentenciaSQL=$conexion->prepare("SELECT * from notebook WHERE id=:id");
        $sentenciaSQL->bindParam(':id', $txtID);
        $sentenciaSQL->execute();
        $mostrarnotebook=$sentenciaSQL->fetch(PDO::FETCH_LAZY);

        $txtNombre=$mostrarnotebook['nombre'];
        $txtPrecio=$mostrarnotebook['precio'];
        $txtImagen=$mostrarnotebook['imagen'];

        //echo "presionando boton Seleccionar";
    break;

    case "Borrar":

        $sentenciaSQL=$conexion->prepare("SELECT imagen from notebook WHERE id=:id");
        $sentenciaSQL->bindParam(':id', $txtID);
        $sentenciaSQL->execute();
        $notebook=$sentenciaSQL->fetch(PDO::FETCH_LAZY);

        if(isset($notebook["imagen"]) && ($notebook["imagen"]!="imagen.jpg")){

            if(file_exists("../../img".$notebook["imagen"])){
                unlink("../../img".$notebook["imagen"]);
            }

        }

        $sentenciaSQL=$conexion->prepare("DELETE from notebook WHERE id=:id");
        $sentenciaSQL->bindParam(':id', $txtID);
        $sentenciaSQL->execute();
        header("Location:notebook.php");
        //echo "presionando boton Borrar";
    break;

}

$sentenciaSQL=$conexion->prepare("SELECT * from notebook");
$sentenciaSQL->execute();
$listarnotebook=$sentenciaSQL->fetchall(PDO::FETCH_ASSOC);

?>

<div class="col-md-5">

    <div class="card">
        <div class="card-header">
            Datos de notebook
        </div>
        <div class="card-body">
            <form method="POST" enctype="multipart/form-data">
            
                <div class = "form-group">
                <label for="txtID">ID:</label>
                <input type="text" required readonly class="form-control" value="<?php echo $txtID; ?>" name="txtID" id="txtID" placeholder="ID">
                </div>

                <div class = "form-group">
                <label for="txtNOmbre">Nombre:</label>
                <input type="text" required class="form-control" value="<?php echo $txtNombre; ?>" name="txtNombre" id="txtNombre" placeholder="Nombre">
                </div>

                <div class = "form-group">
                <label for="txtNOmbre">Precio:</label>
                <input type="text" required class="form-control" value="<?php echo $txtPrecio; ?>" name="txtPrecio" id="txtPrecio" placeholder="Precio">
                </div>

                <div class = "form-group">
                <label for="txtImagen">Imagen:</label>

                <?php echo $txtImagen; ?>

                <?php if($txtImagen!=""){ ?>

                    <img class="img-thumbnail rounded" src="../../img/<?php echo $txtImagen;?>" width="50" alt=""> 

                <?php } ?>

                <input type="file" class="form-control"  name="txtImagen" id="txtImagen" placeholder="Imagen">
                </div>


                <div class="btn-group" role="group" aria-label="">
                    <button type="submit" name="accion" <?php echo ($accion=="Seleccionar")?"disabled":"" ?> value="Agregar" class="btn btn-success">Agregar</button>
                    <button type="submit" name="accion" <?php echo ($accion!="Seleccionar")?"disabled":"" ?>value="Modificar" class="btn btn-warning">Modificar</button>
                    <button type="submit" name="accion" <?php echo ($accion!="Seleccionar")?"disabled":"" ?>value="Cancelar" class="btn btn-info">Cancelar</button>
                </div>

            </form>
        </div>

    </div>


</div>

<div class="col-md-7">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Precio</th>
                <th>Imagen</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
                <?php
                    foreach($listarnotebook as $notebook){
                ?>
            
                    <tr>
                        <td><?php echo $notebook['id']; ?></td>
                        <td><?php echo $notebook['nombre']; ?></td>
                        <td><?php echo $notebook['precio']; ?></td>
                        <td>
                           
                            <img class="img-thumbnail rounded" src="../../img/<?php echo $notebook['imagen'];?>" width="50" alt="">

                        </td>
                        <td>
                            <form method="post">

                                <input type="hidden" name="txtID" id="txtID" value="<?php echo $notebook['id']; ?>">
                                <input type="submit" name="accion" value="Seleccionar" class="btn btn-primary">
                                <input type="submit" name="accion" value="Borrar" class="btn btn-danger">

                            </form>
                        </td>
                    </tr>

                <?php
                    }
                ?>

        </tbody>
    </table>
</div>


<?php
include("../template/pie.php");
?>