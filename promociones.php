<head>
    <link rel="stylesheet" type="text/css" href="css/stylesProm.css"> 
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
        $sql = "SELECT p.* FROM producto p, promociones pro WHERE p.id_producto=pro.id_producto  AND p.id_categoria=1 ORDER BY p.id_producto";
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
    <section>
        <br>
        <?php
            if ($prom!=null){
        ?>
                <div class="contenedorP">
                <h1>P R O M O C I O N E S</h1>
            <?php
                foreach($prom as $aLinea){
            ?>
                    <div class="in-flex">
                        <img class="imgP" src="data:image/jpg;base64, <?php echo base64_encode($aLinea[5])?>" alt="Imagen del producto">
                        <form name="tabla" method="post" action="promociones.php">
                        <div class="infoP">
                            <!-- <form name="tabla" method="post" action="desayunos.php"> -->
                                <div class="des desT"><p><b><?php echo $aLinea[1]?></b></p></div>
                                <div class="des desD"><p>Descripción:<br><?php echo $aLinea[2]?> <br><b>$ <?php echo $aLinea[3]?></b> </p></div>
                                <input type="hidden" name="numIdprod" value="<?php echo  $aLinea[0]?>">
                                <input type="hidden" name="precioProd" value="<?php echo  $aLinea[3]?>">
                                <div class="des desC"><input type="number" name="cant" value="1" class="cant-control"></div>
                                <div class="des boxBoton"><button type="submit"  class="botonA" name="añadirCarrito">Agregar <i class="fas fa-shopping-cart"></i></button></div>
                            <!-- </form> -->
                        </div>
                        </form>
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