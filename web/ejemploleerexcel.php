<table class="table table-bordered">
      <thead>
        <tr>
          <th>ID</th>
          <th>Empresa</th>
          <th>Descripcion</th>           
        </tr>
      </thead>
      <tbody>

<?php
    require_once '../Classes/PHPExcel.php';
    $archivo = "../adjuntos/cat_perfiles.csv";
    $inputFileType = PHPExcel_IOFactory::identify($archivo);
    $objReader = PHPExcel_IOFactory::createReader($inputFileType);
    $objPHPExcel = $objReader->load($archivo);
    $sheet = $objPHPExcel->getSheet(0); 
    $highestRow = $sheet->getHighestRow(); 
    $highestColumn = $sheet->getHighestColumn();

    
    $num=0;
    for ($row = 2; $row <= $highestRow; $row++){ $num++;?>
       <tr>           
          <td><?php echo $sheet->getCell("A".$row)->getValue();?></td>
          <td><?php echo $sheet->getCell("B".$row)->getValue();?></td>
          <td><?php echo $sheet->getCell("C".$row)->getValue();?></td>
           
        </tr>     
<?php        
    }
?>
</tbody>
</table>
