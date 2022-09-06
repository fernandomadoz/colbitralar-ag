<!doctype html>
<html>
<head>
<meta charset="utf-8">
    <!-- Required meta tags-->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Title Page-->
    <title>Certificado de Matricula: <?php echo $Afiliado->nombre ?> <?php echo $Afiliado->Apellido ?></title>

    <style type="text/css">
      .recuadro {
        border-style: solid; 
        border-width: 3px;
        border-color: black;
        width: 100%;
        max-width: 900px;
      }
      .contenido {
        padding: 20px;
        text-align: center;

      }

      .qrstyle {
        width: 120px;

      }

      .texto {
        text-align: justify;
        margin-left: 50px;
        margin-right: 50px;
      }

      .imgFirma {
        width: 200px;
        padding-bottom: -40px;
        margin-bottom: -40px;
      }

      .textoFirma {
        text-align: center;
        font-size: 12px;
        font-style: italic;
      }

      table td {
        font-family: sans-serif;
      }
    </style>

</head>

<body>

  <center>


    <table class="recuadro">
      <tbody>
        <tr>
          <td class="contenido">
            <img src="<?php echo env('PATH_PUBLIC')?>img/logo.jpg" alt=""/><br>
            <h2>CERTIFICADO DE ETICA</h2>
            <h3><i><u>EL CONSEJO DE LICENCIADOS EN PRODUCCION EN BIO-IMÁGENES Y TECNICOS RADIOLOGOS DE LA PROVINCIA DE LA RIOJA CREADO POR LEY 8.077</u></i></h3>
          </td>
        </tr>
        <tr>
          <td class="contenido">
            <p class="texto">CERTIFICA que <?php echo $pronombre ?> <strong><?php echo $abreviacion ?> <?php echo $Afiliado->apellido ?>, <?php echo $Afiliado->nombre ?>. <?php echo $nemotecnico ?>: <?php echo $Afiliado->nro_de_documento ?></strong> se encuentra habilitado para ejercer la Profesión de <strong><?php echo $titulo ?></strong> por registrar inscripción en
la matricula<strong> <?php echo $categoria ?> Nº <?php echo $Afiliado->nro_de_matricula ?></strong>, de Fecha <strong><?php echo $fecha_de_matriculacion ?> encontrándose al día en el pago de su cuota anual y no registrando sanción disciplinaria alguna.</strong><br>Se extiende el presente a los <?php echo $diaHoy ?> días del mes de <?php echo $mesHoy ?> de <?php echo $anioHoy ?>.-</p>
          </td>
        </tr>

        <tr>
          <td class="contenido">
            <p class="firma">
              <img src="<?php echo env('PATH_PUBLIC')?>img/firma-presidente.png" class="imgFirma" /><br>
              <p class="textoFirma">
                ........................................................................<br><br>
                <?php echo $nombre_presidente ?><br>
                <?php echo $matricula_presidente ?>
              </p>

            </p>
          </td>
        </tr>
        

        <tr>
          <td>
            <table align="center">
              <tr>
                <td><img src="<?php echo $dir_imagen_url ?>"  alt="" class="qrstyle" /></td>                
                <td>Escanee este código para verificar<br> la veracidad de este documento</td>                
              </tr>
            </table>
          </td>
        </tr>
      </tbody>
    </table>
  </center>



</body>
</html>



