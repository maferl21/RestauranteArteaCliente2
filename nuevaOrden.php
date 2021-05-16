<?php
    session_start();
    include_once("modelo\consultas.php");
    $oConex = new Consultas();

    // OBTENER FECHA ACTUAL
    date_default_timezone_set("America/Mexico_City");
    $fechaActual=date("Y")."-".date("m")."-".date("d"); //fecha actual del sistema
    $mesa=$_POST['mesa']; //numero de mesa recibida del qr

    $_SESSION["NumMesa"]=$mesa;
    
    // CUANDO ENTRA AL IF ES POR QUE ES UNA NUEVA ORDEN
    if(isset($_POST['ordenarB'])){
        // include_once("index.php");
        // include_once("promociones.php");
        $oConex = new Consultas();

        // BUSCAR EL ID DE LA MESA
        $sqlMesa="SELECT id_mesa FROM mesas WHERE num_mesa=".$mesa; 
        $IDmesa=$oConex->regresaUnValor($sqlMesa);
       
        //BUSCA EL ID MAXIMO POR LO QUE ES LA ULTIMA ORDEN
        $sqlUO = $oConex->regresaUnValor("SELECT id_orden FROM orden WHERE id_orden=(SELECT MAX(id_orden)FROM orden)");
        $numUltOrden=$sqlUO[0][0]; //Id de la ultima orden
        $numNOrden=$numUltOrden+1; //numero de nueva orden
        
        // GENERAR NUEVA ORDEN
        // $sqlNuevaOrden="INSERT INTO orden (id_orden, fecha, num_mesa) VALUES ('".$numNOrden."','".$fechaActual."','".$IDmesa."')";
        // $nuevaOrden=$oConex->ejecutar($sqlNuevaOrden);
        
        $_SESSION["nuevaOrden"]=$numNOrden;
        
        header("Location:promociones.php");
?>

<br> <br>

<?php
        // include_once("pie.html");
    }else{
?>
        <p class="mensaje">Debe escanear el codigo Qr y dar click en <b>Ordenar</b></p>
<?php
    }
?>
