<head>
    <link rel="stylesheet" type="text/css" href="css/stylesMenu.css"> 
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/b965409e0d.js" crossorigin="anonymous"></script>
</head>

<?php
    session_start();
    include_once("modelo\consultas.php");
    include_once("menu.php");
    $obProm = new Consultas();
    $sql="";

    try{
        $sql = "SELECT p.* FROM producto p, postres po WHERE p.id_producto=po.id_producto  AND p.id_categoria=5 ORDER BY p.id_producto";
        $prom=$obProm->buscarTodos($sql);
    }catch(Exception $e){
        //Enviar el error específico a la bitácora de php (dentro de php\logs\php_error_log
        error_log($e->getFile()." ".$e->getLine()." ".$e->getMessage(),0);
        $sErr = "Error en base de datos, comunicarse con el administrador";
    }
?>
    <!-- FALTA HACER QUE EL BOTON CAMBIE -->
    <!-- CUANDO SE SELECCIONE DEBE DE CAMBIAR SU FORMATO, INVESTIGAR COMO HACERLO -->
    <!-- CUANDO SE DESELECCIONE DEBE REGRESAR NORMLAL -->
    <!-- DEBE DE HABER UN INPUT K ALMACENE EL ID -->
    <!-- IGUAL CUANDO SE PRESIONE DEBE DE MANDAR A LA PAGINA DE ORDEN EN ID DEL PRODUCTO -->
    <section>
        <br>
        <?php
            if ($prom!=null){
        ?>
                <div class="contenedorM">
                <h1>P O S T R E S</h1>
            <?php
                foreach($prom as $aLinea){
            ?>
                    <div>
                        <input style="display:none;" type="text" name="numIdprod" value="<?php echo  $aLinea[0]?>">
                        <!-- <input style="display:none;" type="text" name="precioProd" value="<?php echo  $aLinea[3]?>"> -->
                        <img class="imgM" src="data:image/jpg;base64, <?php echo base64_encode($aLinea[5])?>" alt="Imagen del producto">
                        <div class="infoM">
                            <form name="tabla" method="post" action="postres.php">
                                <div><p><b><?php echo $aLinea[1]?></b></p></div> <br>
                                <div><p>Descripción:<br><?php echo $aLinea[2]?> <br><b>$ <?php echo number_format($aLinea[3],2);?></b> </p></div>
                                <input type="hidden" name="numIdprod" value="<?php echo  $aLinea[0]?>">
                                <input type="hidden" name="precioProd" value="<?php echo  $aLinea[3]?>">
                                <br>
                                <input type="number" name="cant" value="1" class="cant-control">
                                <br><br>
                                <button type="submit"  class="botonA2" name="añadirCarrito">Agregar <i class="fas fa-shopping-cart"></i></button>
                            </form>
                        </div>
                    </div>
            <?php
                }
            ?>
                </div>
        <?php
           }else{
        ?>
            <h1 class="error">No hay promociones por el momento</h1>
        <?php
            }
        ?>
    </section>
   
    <br><br>

    <?php
        include_once("pie.html");
    ?>