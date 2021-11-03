<?php
include("template/cabecera.php");
?>

<?php
include("administrador/config/bd.php");

$sentenciaSQL=$conexion->prepare("SELECT * from accesorios");
$sentenciaSQL->execute();
$listaraccesorios=$sentenciaSQL->fetchall(PDO::FETCH_ASSOC);

?>

<?php foreach($listaraccesorios as $accesorios){ ?>
       <div class="col-md-3">
              <div class="card-columns">
                     <img class="card-img-top" src="./img/<?php echo $accesorios["imagen"]; ?>" alt="">
                            <div class="card-body">
                                   <input visibility: hidden class="card-title"><?php echo $accesorios["nombre"]; ?>
                                   <br>
                                   <input visibility: hidden class="card-title"><?php echo $accesorios["precio"]; ?>
                                   <br>
                                   <a name="" id="" class="btn btn-primary" href="#" role="button">Agregar al carrito</a>
                            </div>
              </div>
       </div>
<?php } ?>

<?php
include("template/pie.php");
?>

<?php
include("template/pie.php");
?>