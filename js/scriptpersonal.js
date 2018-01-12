function borrarItem(){
  if (confirm("¿Seguro que quieres borrar este producto?") == true) {
    return true;
  }
  else{
    return false;
  }
}


document.getElementById('borrarTodo').onclick = function(){
  var borrar = confirm("¡Cuidado chaval!, ¿Estas seguro de querer borrar todos los productos?");
  if (borrar != true) {
    return false;
  }
}
