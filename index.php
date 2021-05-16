
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="css/stylesPrincipal.css">
    <script src="https://kit.fontawesome.com/b965409e0d.js" crossorigin="anonymous"></script>
</head>

<?php
    include_once("modelo\consultas.php");
    $obConex = new Consultas();
    // LA COMPARACION SE ARA CON LA IMAGEN QUE SE ESCANEE
    $sql=$obConex->buscarTodos("SELECT num_mesa FROM mesas WHERE id_mesa='1'");
    $numMesa=$sql[0][0];
?>

    

<?php
    // if(isset($_POST['ordenarB'])){
?>

<!-- <body>
    <div>
        <nav>
            <div id="buscador">
                <table class="contenedorB">
                    <tr>
                        <td>
                            <input type="text" placeholder="Buscar" class="buscar">
                        </td>
                        <td>
                            <a href="#" id="lupa"><i class="fas fa-search"></i></a>
                        </td>
                    </tr>
                </table>
            </div>
            <img id="logo" src="img/logoChico.jpeg" alt="Logo">
            <ul id="menu">
                <li class="mesa" id="mesa">Mesa <?php echo $numMesa ?></li>
                <input type="hidden" name="mesa" value="Mesa 2">
                <li><a href="#" name="menuT">Men&uacute;</a>
                    <ul id="submenu">
                        <li> <a href="promociones.php">Promociones</a></li>
                        <li> <a href="desayunos.php">Desayuno</a></li>
                        <li> <a href="almuerzo.php">Almuerzo</a></li>
                        <li> <a href="cena.php">Cena</a></li>
                        <li> <a href="bebidas.php">Bebidas</a></li>
                        <li> <a href="postres.php">Postres</a></li>
                    </ul>
                </li>
                <li><a href="#">¿Quienes somos?</a>
                    <ul id="submenu">
                        <li><a href="#">Contactos del restaurante</a></li>
                    </ul>
                </li>
                <li><a href="#" id="carrito"><i class="fas fa-shopping-cart"></i>  Mi pedido</a>
                    <ul id="submenu">
                        <li><a href="carrito.php">Mis compras</a></li>
                    </ul>
                </li>
            </ul>
        </nav>
    </div>
    <header>
        <img class="imgG" src="img/imgEncabezado2.png" alt="Banner">
    </header>

</body> -->
<?php
    // }else{
        ?>
        <!-- AQUI SE VA A PONER EL SCANNER -->
        <div class="contenedorEscaner">
            <h1>RESTAURANTE ARTEA</h1>
            <p>ESCANEE EL CODIGO QR DE LA MESA</p>
            <div>
                <p>AQUI VA EL SCANEER O LA CAMARA</p>
            </div>

            <?php
                include_once("modelo\consultas.php");
                $obConex = new Consultas();
                // LA COMPARACION SE ARA CON LA IMAGEN QUE SE ESCANEE
                // $sql=$obConex->buscarTodos("SELECT num_mesa FROM mesas WHERE id_mesa='1'");
                // $numMesa=$sql[0][0];
                echo "mesa = $numMesa";
            ?>

            <form name="tabla" method="post" action="nuevaOrden.php">
                <p><br> N&uacute;mero de mesa: <br></p>
                <p><?php echo $numMesa ?></p>
                <input type="hidden" name="bandera" value="false">
                <input type="hidden" name="mesa" value="<?php echo $numMesa?>">
                <br><br>
                <button type="submit" name="ordenarB"class="botonA2">Ordenar<i class="fas fa-shopping-cart"></i></button>
            </form>
        </div>
<?php
    // }
?>

<style>
.contenedorEscaner{
    text-align: center;
}

</style>