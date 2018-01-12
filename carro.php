<?php
  session_start();
  include("./include/funciones.php");
  $connect = connect_db();

  $title = "Plantas el Caminàs -> ";
  $redireccion = urlencode($_GET["redirect"]);
  include("./include/header.php");
  require './include/ElCaminas/Carrito.php';
  require './include/ElCaminas/Producto.php';
  require './include/ElCaminas/Productos.php';
  use ElCaminas\Carrito;




  $carrito = new Carrito();
  //Falta comprobar qué acción: add, delete, empty
  if($_GET["action"]=='add'){
  $carrito->addItem($_GET["id"], 1);
  }
  else if($_GET["action"]=='delete'){
  $carrito->deleteItem($_GET["id"], 1);
  }
  else if($_GET["action"]=='empty'){
  $carrito->empty($_GET["id"], 1);
  }
?>
  <div class="row carro">
    <h2 class='subtitle' style='margin:0'>Carrito de la compra</h2>
    <?php  echo $carrito->toHtml();
    echo $carrito->getTotalPrecio();?>
    <script src="https://www.paypalobjects.com/api/checkout.js"></script>
    <script src="js/paypal.js"></script>
    <div id="paypal-button-container"></div>
  </div>

  <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Detalle del producto</h4>
      </div>
      <div class="modal-body">
        <iframe src='#' width="100%" height="600px" frameborder=0 style='padding:8px'></iframe>
      </div>
    </div>
  </div>
</div>

<?php

include("./include/footer.php");
?>
