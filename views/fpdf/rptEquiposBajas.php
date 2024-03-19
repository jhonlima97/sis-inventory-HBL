<?php
header('Content-Type: text/html; charset=utf-8');
setlocale(LC_TIME, 'es_ES.UTF-8');

require('./fpdf.php');
//require_once 'conexionbd.php';
require_once __DIR__ . '/../../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../..');
$dotenv->load();

$servername = $_ENV['DB_HOST'];
$username   = $_ENV['DB_USER'];
$password   = $_ENV['DB_PASS'];
$dbname     = $_ENV['DB_NAME'];

$conn = new mysqli($servername, $username, $password, $dbname);

$conn->query("SET NAMES 'utf8'");
if ($conn->connect_error) {
   die("Error de conexión a la base de datos: " . $conn->connect_error);
}

class PDF extends FPDF
{
   private $headerPrinted = false;

   // Cabecera de página
   function Header()
   {
      if (!$this->headerPrinted) {
         $this->Image('hospital.jpeg', 185, 5, 20);
         $this->SetFont('Arial', 'B', 19);
         $this->SetTextColor(0, 0, 0);

         $this->Cell(0, 10, utf8_decode("Hospital Provincial Docente"), 0, 1, 'C', 0);
         $this->Cell(0, 10, utf8_decode('"Belén" Lambayeque'), 0, 1, 'C', 0);
         $this->Ln(10);

         $this->SetFont('Arial', 'I', 10);
         $this->Cell(0, 5, 'Lambayeque, ' . strftime('%d de %B de %Y'), 0, 1, 'R');

         $this->SetFont('Arial', '', 10);
         $this->Cell(100, 10, utf8_decode("Oscar Anibal Silva Guerra"), 0, 0, 'L', 0);
         $this->Ln(5);
         $this->Cell(100, 10, utf8_decode("Jefe de la División de Administración"), 0, 0, 'L', 0);
         $this->Ln(5);

         $this->SetFont('Arial', '', 10);
         $this->Cell(0, 10, utf8_decode("Asunto : Bienes Infomáticos para ser entregados a Patrimonio"), 0, 0, 'R', 0);
         $this->Ln(5);
         $this->Cell(0, 10, utf8_decode("por inoperatividad dentro de la RED - HBL"), 0, 0, 'R', 0);
         $this->Ln(10);

         $this->SetFont('Arial', '', 10);
         $this->Cell(0, 10, utf8_decode("Se detallan a continuación los bienes entregados: "), 0, 1, 'L', 0);
         $this->Ln(5);
         $this->headerPrinted = true; // Marcamos que se ha impreso el encabezado
      }
   }

   // Pie de página
   function Footer()
   {
      $this->SetY(-15); // Posición: a 1,5 cm del final
      $this->SetFont('Arial', 'I', 10); //tipo fuente, negrita(B-I-U-BIU), tamañoTexto
      $this->Cell(0, 10, utf8_decode('Página ') . $this->PageNo(), 0, 0, 'C'); //pie de pagina(numero de pagina)


   }
}

//Crear el PDF
$pdf = new PDF();
$pdf->AddPage(); /* aqui entran dos para parametros (horientazion,tamaño)V->portrait H->landscape tamaño (A3.A4.A5.letter.legal) */
$pdf->AliasNbPages(); //muestra la pagina / y total de paginas


$pdf->SetFont('Arial', '', 12); //
$pdf->SetTextColor(0, 0, 0); //Color de letra
$pdf->SetDrawColor(128, 128, 128); //colorBorde tabla 
//$pdf->SetFillColor(125, 173, 221); //colorFondo cabecera


// Consulta para obtener los tipos de bien distintos
$sqlTiposBien = "SELECT DISTINCT nombre FROM tipo_bien"; // Aquí debes reemplazar 'tipo_de_bien' por el nombre de tu tabla

$resultTiposBien = $conn->query($sqlTiposBien);

if ($resultTiposBien->num_rows > 0) {
   while ($rowTipoBien = $resultTiposBien->fetch_assoc()) {
      $tipoBien = $rowTipoBien['nombre'];

      // Consulta para obtener los registros asociados a este tipo de bien
      $sqlRegistros = "SELECT a.nombre AS area, c.cod_patrimonial, c.marca, c.modelo, c.serie, c.estado 
                         FROM $tipoBien c
                         LEFT JOIN areas a ON c.area_id = a.id
                         WHERE c.estado = 'MALO'";

      $resultRegistros = $conn->query($sqlRegistros);

      if ($resultRegistros->num_rows > 0) {
         // Impresión de la tabla para este tipo de bien

         $i = 0;
         $pdf->SetFont('Arial', 'B', 10);
         $pdf->Cell(0, 10, utf8_decode('Productos inactivos - ' . strtoupper($tipoBien)), 0, 1, 'L');   //L es left pues xdxd   R --> Right    C ---> Center 

         //colorFondo cabecera
         $pdf->SetFillColor(135, 206, 235);
         $pdf->Cell(15, 10, utf8_decode('N°'),  1, 0, 'C', 0);
         $pdf->Cell(30, 10, utf8_decode('A/U'),  1, 0, 'C', 0);
         $pdf->Cell(40, 10, utf8_decode('Cód. Patrimonial'),  1, 0, 'C', 0);
         $pdf->Cell(25, 10, utf8_decode('Marca'),  1, 0, 'C', 0);
         $pdf->Cell(30, 10, utf8_decode('Modelo'),  1, 0, 'C', 0);
         $pdf->Cell(30, 10, utf8_decode('Serie'),  1, 0, 'C', 0);
         $pdf->Cell(20, 10, utf8_decode('Estado'),  1, 1, 'C', 0); // AnchoCelda,AltoCelda,titulo,borde(1-0),saltoLinea(1-0),posicion(L-C-R),ColorFondo(1-0)

         while ($row = $resultRegistros->fetch_assoc()) {
            $i++;

            $pdf->SetFont('Arial', '', 10);
            $pdf->Cell(15, 10, utf8_decode($i), 1, 0, 'C', 0);
            $pdf->Cell(30, 10, utf8_decode($row['area']), 1, 0, 'C', 0);
            $pdf->Cell(40, 10, utf8_decode($row['cod_patrimonial']), 1, 0, 'C', 0);
            $pdf->Cell(25, 10, utf8_decode($row['marca']), 1, 0, 'C', 0);
            $pdf->Cell(30, 10, utf8_decode($row['modelo']), 1, 0, 'C', 0);
            //$pdf->Cell(30, 10, utf8_decode($row['serie']),1, 0, 'C', 0);
            if (!empty($row['serie'])) {
               $pdf->Cell(30, 10, utf8_decode($row['serie']), 1, 0, 'C', 0);
            } else {
               $pdf->Cell(30, 10, 'Sin Serie', 1, 0, 'C', 0);
            }
            $pdf->Cell(20, 10, utf8_decode($row['estado']), 1, 1, 'C', 0);
         }

         $pdf->Ln(5);
        
      } else {
         //echo "<p>No hay registros para $tipoBien.</p>";
      }
   }
} else {
   // No se encontraron datos para el ID proporcionado
   $this->Cell(0, 10, utf8_decode("No se encontraron datos de equipos dado de baja "), 0, 1, 'L', 0);
}

$pdf->Ln(5); //salto de línea

$conn->close();

$pdf->Output('EquiposInactivos.pdf', 'I');//nombreDescarga, Visor(I->visualizar - D->descargar)