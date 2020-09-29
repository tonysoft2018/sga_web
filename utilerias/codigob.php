<html>
<body style="background-color:#fff">

<input type="text" id="data" placeholder="Ingresa un valor">
  <button type="button" id="generar_barcode">Generar código de barras</button>
  <br>
  <div id="imagen"></div>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script> 
  <script>
    $("#generar_barcode").click(function() {
    var data = $("#data").val();
    $("#imagen").html('<img src="barcode.php?text='+data+'&size=45&codetype=Code128&print=true"/>');
    $("#data").val('');
    });
  </script>
</body>
</html>