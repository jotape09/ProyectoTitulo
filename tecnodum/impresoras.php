<?php
include("template/cabecera.php");
?>

<?php
include("administrador/config/bd.php");

$sentenciaSQL=$conexion->prepare("SELECT * from impresoras");
$sentenciaSQL->execute();
$listarimpresoras=$sentenciaSQL->fetchall(PDO::FETCH_ASSOC);

?>

<?php foreach($listarimpresoras as $impresora){ ?>

       <div class="col-md-3">
              <div class="card-columns">
                     <img class="card-img-top" src="./img/<?php echo $impresora["imagen"]; ?>" alt="">
                            <div class="card-body">
                                   <input visibility: hidden class="card-title"><?php echo $impresora["nombre"]; ?>
                                   <br>
                                   <input visibility: hidden class="card-title"><?php echo $impresora["precio"]; ?>
                                   <br>
                                   <a name="" id="" class="btn btn-primary" href="#" role="button">Agregar al carrito</a>
                            </div>
              </div>
       </div>

<?php } ?>

<?php
include("template/pie.php");
?>