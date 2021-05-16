<head>
    <link rel="stylesheet" type="text/css" href="css/stylesCarrito.css"> 
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/b965409e0d.js" crossorigin="anonymous"></script>
</head>

<?php
    session_start();
    include_once("modelo\consultas.php");
    include_once("menu.php");

    $obProm = new Consultas();
    
    $sql="";

    $idR=$_POST['numIdprod'];
    $precioR=$_POST['precioProd'];
    $cantR=$_POST['cant'];
    // echo "id-$idR";
    // echo "precio-$precioR";
    // echo "cant-$cantR";

    $sqlUO = $obProm->buscarTodos("SELECT * FROM orden WHERE id_orden=(SELECT MAX(id_orden)FROM orden)");
    $numUltOrden=$sqlUO[0][0]; //Id de la ultima orden
    $fechaUO=$sqlUO[0][1]; //fecha de la ultima orden
    $cantUO=$sqlUO[0][2];//Cantidad de la ultima orden --
    $mesaUO=$sqlUO[0][3];//Mesa de la ultima orden --
    $totalUO=$sqlUO[0][4];//Total de la ultima orden --
    $formaUO=$sqlUO[0][5];//Forma de pago de la ultima orden --
    $recepUO=$sqlUO[0][6];//Id recepcionista de la ultima orden --
    $numNOrden=$numUltOrden+1; //numero de nueva orden
    

    // SI ESTAN ESTOS CAMPOS VACIOS, ES QUE AUN NO TERMINAN DE ORDENAR
    if($cantUO="" && $totalUO="" && $formaUO="" && $recepUO=""){
        // COMPARA EL NUMERO DE MESA QUE RECIBE
        switch ($mesaUo) {
            case $mesaRecMenu:
                # code...
                break;
            case 'Mesa 2':
                    # code...
                    break;
            case 'Mesa 3':
                # code...
                break;
            default:
                # code...
                break;
        }

    }

    if(isset($idR)){
        // PARA OBTENER EL ULTIMO REGISTRO DE LA ORDEN
        try{
            // $sqlUO = $obProm->buscarTodos("SELECT * FROM orden WHERE id_orden=(SELECT MAX(id_orden)FROM orden)");
            // $numUltOrden=$sqlUO[0][0]; //Id de la ultima orden
            // $fechaUO=$sqlUO[0][1]; //fecha de la ultima orden
            // $cantUO=$sqlUO[0][2];//Cantidad de la ultima orden --
            // $mesaUO=$sqlUO[0][3];//Mesa de la ultima orden --
            // $totalUO=$sqlUO[0][4];//Total de la ultima orden --
            // $formaUO=$sqlUO[0][5];//Forma de pago de la ultima orden --
            // $recepUO=$sqlUO[0][6];//Id recepcionista de la ultima orden --
           
            $numNOrden=$numUltOrden+1; //numero de nueva orden

            echo "Valor de orden ultima: $numUltOrden";
            echo "<br>Valor de orden nueva: $numNOrden";
            echo "<br>Ultima cantidad de la ultima orden: $cantUO";
            echo "<br>Ultima total de la ultima orden: $totalUO <br>";
            // echo "<br>Ultima forma de la ultima orden: $formaUO";
            // echo "<br>Ultima recep de la ultima orden: $recepUO <br>";
        }catch(Exception $e){
            error_log($e->getFile()." ".$e->getLine()." ".$e->getMessage(),0);
            $sErr = "Error en base de datos, comunicarse con el administrador";
        }

        //CUANDO YA HAY UN PRODUCTO RELACIONADO CON LA ULTIMA ORDEN
        try {
            $sqlBusODE = "SELECT id_detalle FROM detalle_orden WHERE id_orden =".$numUltOrden; 
            // $sqlBusODN = "SELECT id_detalle FROM detalle_orden WHERE id_orden =".$numNOrden; 
            // $busRegDON = $obProm->buscarDetalle($sqlBusODN);//REGRESA FALSO SI NO ENCUENTRA VALOR
            $busRegDOU = $obProm->buscarDetalle($sqlBusODE);//REGRESA FALSO SI NO ENCUENTRA VALOR

            $totalP=$cantR*$precioR; //precio total de un producto nuevo
            echo "<br>PRODUCTO RECIBIDO";
            echo "<br>Orden: $numUltOrden";
            echo "<br>id-$idR";
            echo "<br>precio-$precioR";
            echo "<br>cant-$cantR";
            echo "<br>totalP-$totalP <br>";

            $cantAO=$cantUO+$cantR; //cant nueva de un producto nuevo
            $totalAO=$totalUO+$totalP; //total nuevo de un producto nuevo

            echo "<br>cant sumada-$$cantAO";
            echo "<br>totalP sumada-$totalAO <br>";

            if ($busRegDOU){
                // HAY PRODUCTOS EN EL CARRITO
                // BUSCA UN PRODUCTO EXISTENTE EN LA TABLA DE DETALLES
                $sqlBusProdD="SELECT id_orden, cantidad, total FROM detalle_orden WHERE id_orden =".$numUltOrden." AND id_prod=".$idR; 
                $BusProdD = $obProm->buscarTodos($sqlBusProdD);
                // SI EXISTE UN PRODUCTO LO MODIFICA
                if($BusProdD!=null){
                    echo "<br>ENTRA IF REFERENCIANDO K SI EXISTE ESE PRODUCTO";
                    $BusProdD0=$BusProdD[0][0];
                    $BusProdD1=$BusProdD[0][1];
                    $BusProdD2=$BusProdD[0][2];
                    echo "<br>Datos recuperados del registro existente en detalle<br>cantidad-$BusProdD1";
                    echo "<br>precio-$BusProdD2";

                    $cantProdDN=$BusProdD1+$cantR;
                    $precioProdDN=$BusProdD2+$totalP;
                    // MODIFICA TABLA DETALLES
                    echo "<br>SI EXISTE PRODUCTO EN DETALLE -VALORES NUEVOS EN DETALLE";
                    echo "<br>id: $idR";
                    echo "<br>cantidad-$cantProdDN";
                    echo "<br>precio-$precioProdDN";
                    // $sqlModProdD="UPDATE detalle_orden SET cantidad='".$cantProdDN."',total = '".$precioProdDN."' WHERE id_orden = ".$BusProdD0." AND id_prod = ".$idR;
                    // $obProm->ejecutar($sqlModProdD);
                    
                    // MODIFICA TABLA ORDEN
                    $cantProdON=$cantUO+$cantProdDN;
                    $precioProdON=$totalUO+$precioProdDN;
                    echo "<br>SI EXISTE PRODUCTO EN DETALLE - VALORES NUEVOS EN ORDEN";
                    echo "<br>id: $numUltOrden";
                    echo "<br>cantidad-$cantAO";
                    echo "<br>precio-$$totalAO";
                    // $sqlModProdO="UPDATE orden SET cant_producto='".$cantAO."',total_orden = '".$totalAO."' WHERE id_orden = ".$numUltOrden;
                    // $obProm->ejecutar($sqlModProdO);
                }else {
                    // ENTRA ELSE REFERENCIANDO K NO EXISTE ESE PRODUCTO
                    // $obProm->insertarPedido($numUltOrden, $idR, $cantR, $totalP); //INSERTAR EN TABLA DETALLE
                    // $obProm->modificarOrden($numUltOrden, $cantAO, $totalAO);
                }
            }else{
                echo "<p>No existe pedido en carrito</p>";
            }
            // VISUALIZAR VISTA DE LA TABLA DETALLES
            $sqlVista="SELECT * FROM condetalle WHERE id_orden=".$numUltOrden;
            $resVista=$obProm->buscarTodos($sqlVista);
        }catch(Exception $e){
            error_log($e->getFile()." ".$e->getLine()." ".$e->getMessage(),0);
            $sErr = "Error en base de datos, comunicarse con el administrador";
        }
    }else{
        // header("Location: index.php");//?sError=".$sErr);
        echo "<h1 class='error'>No hay nada en el carrito</h1>";
    }
?>

<section>
    <br>
        <!-- SI HAY PEDIDOS QUE COINCIDAN CON LA ULTIMA ORDEN -->
            <?php if ($resVista){ ?>
                    <div class="contenedorC">
                        <h1>MI COMPRAS</h1>
                        <br><br>
                        <table class="tabla">
                            <tr class="trB">
                                <th>Imagen</th>
                                <th>Platillo/Bebida</th>
                                <th>Precio </th>
                                <th>Cantidad</th>
                                <th>Total</th>
                                <th>Eliminar</th>
                            </tr>
                        <?php 
                            foreach($resVista as $aLinea){
                        ?>
                            <tr class="trB">
                                <td class="tdB"><img class="imgR" src="data:image/jpg;base64, <?php echo base64_encode($aLinea[2])?>" alt="Imagen del producto"></td>
                                <td class="tdB"><?php echo $aLinea[3]?></td>
                                <td class="tdB"><?php echo $aLinea[4]?></td>
                                <td class="tdB"><?php echo $aLinea[5]?></td>
                                <td class="tdB"><?php echo $aLinea[6]?></td>
                                <td class="tdB"><button class="delete"><i class="far fa-trash-alt"></i>Eliminar</button></td>
                            </tr>
                            <?php } ?>
                        </table>
                    </div>
                <?php
                    }else{
                ?>
                        <h1 class="error">No hay nada en el carrito</h1>
                <?php
                    }
                ?>
</section>
