<?php
include("template/cabecera.php");
?>

<?php
include("administrador/config/bd.php");

$sentenciaSQL=$conexion->prepare("SELECT * from mundogammer");
$sentenciaSQL->execute();
$listarmundogammer=$sentenciaSQL->fetchall(PDO::FETCH_ASSOC);

?>

<?php foreach($listarmundogammer as $mundogammer){ ?>
       <div class="col-md-3">
              <div class="card-columns">
                     <img class="card-img-top" src="./img/<?php echo $mundogammer["imagen"]; ?>" alt="">
                            <div class="card-body">
                                   <h4 class="card-title"><?php echo $mundogammer["nombre"]; ?></h4>
                                   <h4 class="card-title"><?php echo $mundogammer["precio"]; ?></h4>
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