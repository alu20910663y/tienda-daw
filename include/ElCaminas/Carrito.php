<?php

namespace ElCaminas;
use \PDO;
use \ElCaminas\Producto;
class Carrito
{
    protected $connect;
    protected $totalPrecio;
    /** Sin parámetros. Sólo crea la variable de sesión
    */
    public function __construct()
    {
        global $connect;
        $this->connect = $connect;
        if (!isset($_SESSION['carrito'])){
            $_SESSION['carrito'] = array();
        }

    }
    public function addItem($id, $cantidad){
        $_SESSION['carrito'][$id] = $cantidad;
    }
    public function deleteItem($id){
      unset($_SESSION['carrito'][$id]);
    }
    public function empty(){
      unset($_SESSION['carrito']);
      self::__construct();
    }
    public function howMany(){
      return count($_SESSION['carrito']);
    }
    public function setTotalPrecio($total){
      $totalPrecio = $total;
    }
    public function getTotalPrecio(){
      return $totalPrecio;
    }

    public function toHtml(){
      if(isset($_GET["redirect"])){
        $urlReturn = urldecode($_GET["redirect"]);
      }
      else{
        $urlReturn = 'index.php';
      }
      //NO USAR, de momento
      $str = <<<heredoc
      <table class="table">
        <thead> <tr> <th>#</th> <th>Producto</th> <th>Cantidad</th> <th>Precio</th> <th>Total</th></tr> </thead>
        <tbody>
heredoc;
      if ($this->howMany() > 0){
        $i = 0;
        $total = 0;
        foreach($_SESSION['carrito'] as $key => $cantidad){
          $producto = new Producto($key);
          $i++;
          $subtotal = $producto->getPrecioReal() * $cantidad;
          $total += $subtotal;
          $subtotalTexto = number_format($subtotal , 2, ',', ' ') ;
          $str .=  "<tr><th scope='row'>$i</th><td><a href='" .  $producto->getUrl() . "'>" . $producto->getNombre() . "</a>
          <a class='open-modal' title='Haga clic para ver el detalle del producto' href='" .  $producto->getUrl() . "'><span style='color:#000' class='fa fa-external-link'></span></a>
          </td><td>$cantidad</td><td>" .  $producto->getPrecioReal() ." €</td><td>$subtotalTexto €</td><td>";
          $str .=  "<a class='btn btn-danger' href='carro.php?action=delete&id=". $producto->getId() ."&redirect=". $_GET["redirect"] ."' onclick=' return borrarItem()'>Borrar</a></td></tr>";
        }
        $this->setTotalPrecio($total);
      }

      $str .= <<<heredoc
        </tbody>
      </table>
heredoc;
      $str .= "<hr>";
      if($i>0){
      $str .= "<p>Precio total : ". $total ." €</p><br/>";
      }
      $str .= " <a class='btn btn-danger pull-right' id='borrarTodo' href='carro.php?action=empty&redirect=". $_GET["redirect"]."'>Vaciar todos</a>";
      $str .= "<a class='btn btn-success pull-right' href='" . $urlReturn . "'>Seguir comprando</a> ";
      return $str;
    }
}
