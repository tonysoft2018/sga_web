HTML
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link rel="stylesheet"   href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>

        <title>Generar códigos QR con PHP</title>
        <link rel="stylesheet" href="css/style.css">
        <script src="../vistas/ajax_generate_code.js"></script>
    </head>

    <body class="">
        <div class="container" style="min-height:500px;">
            <div class="container">     
                <div class="row">
                    <h2>Generar códigos QR con PHP</h2>
                </div>
                 

                <label class="control-label">Información : </label>
                <input class="form-control col-xs-1" id="datos" type="text" required="required">
                <input class="form-control col-xs-1" id="calidad" type="hidden" required="required" value='H'>
                <input class="form-control col-xs-1" id="tamaxo" type="hidden" required="required" value='5'>
                <br>
                <br>
                <input type="button" name="submit" id="submit" class="btn btn-success" value="Generar código QR" onclick="Enviar()">
                
                <div class="col-md-6">
                    <div class="showQRCode"></div>

                    <img id='qr' class="img-thumbnail" src="" />
                    
                </div>
            </div>
        </div>
        </div>  
        <div class="insert-post-ads1" style="margin-top:20px;">

        </div>
        </div>
    </body>
</html>
