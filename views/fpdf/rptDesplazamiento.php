<?php
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

$id_reporte = isset($_GET['cod_rpt']) ? intval($_GET['cod_rpt']) : 0;


class PDF extends FPDF
{
    private $isFirstPage = true; // Bandera para controlar si es la primera página

    // Cabecera de página
    function Header()
    {
       
        if ($this->isFirstPage) { // Mostrar el encabezado solo en la primera página
            $this->Image('hospital.jpeg', 185, 5, 20); //logo de la empresa,moverDerecha,moverAbajo,tamañoIMG
            $this->SetFont('Arial', 'B', 19); //tipo fuente, negrita(B-I-U-BIU), tamañoTexto
            $this->SetTextColor(0, 0, 0); //color
    
            $this->Cell(0, 10, utf8_decode("Hospital Provincial Docente"), 0, 1, 'C', 0);
            $this->Cell(0, 10, utf8_decode("Belén Lambayeque"), 0, 1, 'C', 0);
    
            $this->Ln(3); // Salto de línea
    
            $this->SetFont('Arial', '', 14); //tipo fuente, negrita(B-I-U-BIU-BU), tamañoTexto
            $this->Cell(0, 10, utf8_decode("Unidad de Estadística e Informática"), 0, 1, 'C', 0);
            $this->SetFont('Arial', 'B', 14);
            $this->Cell(0, 6, utf8_decode("CSI - Centro de Sistemas de Información"), 0, 1, 'C', 0);
            $this->Ln(1); // Salto de línea
            // Dibuja una línea divisoria
            $this->SetLineWidth(0.2); // Establece el ancho de la línea
            $this->Line($this->GetX(), $this->GetY(), $this->GetX() + 190, $this->GetY()); // Dibuja la línea horizontal
    
            // Salto de línea
            $this->Ln(2); // Ajusta la distancia según sea necesario
            $this->SetFont('Arial', 'I', 12);
    
            // - 4 para disminuir el espaciado entre lineas
            $this->MultiCell(0, 6, utf8_decode('"Año del Bicentenario, de la consolidación de nuestra Independencia, y de la conmemoración de las heroicas batallas de Junín y Ayacucho"'), 0, 'C'); //,false, 0.5);
            $this->Ln(5); // Ajusta la distancia según sea necesario
            
            $this->isFirstPage = false; // Marcar que ya no estamos en la primera página
        }
    }

   // Restablecer la bandera de primera página para cada nueva página
   function AddPage($orientation = '', $size = '', $rotation = 0)
   {
       parent::AddPage($orientation, $size, $rotation);
       $this->isFirstPage = true;
   }

    function generarInforme($id_reporte)
    {
        global $conn;  // Usamos la palabra clave global para acceder a la variable global $conn

        // Consulta SQL para obtener los datos del desplazamiento
        //$sql_desplazamiento = "SELECT * FROM desplazamiento WHERE id = $id_reporte";
        $sql_desplazamiento = "SELECT d.*, ap.nombre AS nombre_area_proveniente, aa.nombre AS nombre_area_asignada FROM desplazamiento d INNER JOIN areas ap ON d.area_prov = ap.id INNER JOIN areas aa ON d.area_asig = aa.id WHERE d.id = $id_reporte";
        $result_desplazamiento = $conn->query($sql_desplazamiento);


        if ($result_desplazamiento->num_rows > 0) {

            // Datos del informe encontrados
            $row_desplazamiento = $result_desplazamiento->fetch_assoc();

            //// Añadir celdas  --- // AnchoCelda,AltoCelda,titulo,borde(1-0),saltoLinea(1-0),posicion(L-C-R),ColorFondo(1-0)
            $this->SetFont('Arial', 'BU', 15);
            $this->Cell(0, 10, utf8_decode("Ficha de desplazamiento de Bien Informático  N° " . $row_desplazamiento['id']), 0, 1, 'C', 0);
            $this->Ln(6);

            $this->SetFont('Arial', 'BU', 13);
            $this->Cell(30, 10, utf8_decode("MOTIVO"), 0, 0, 'L', 0);
            $this->SetFont('Arial', '', 13);
            $this->Cell(0, 10, utf8_decode($row_desplazamiento['motivo']), 0, 1, 'C', 0);
            $this->Ln(5);


            // Consulta SQL para obtener los equipos asignados a este desplazamiento
            $sql_equipos = "SELECT * FROM detalle_desplazamiento WHERE id_desplazamiento = $id_reporte";
            $result_equipos = $conn->query($sql_equipos);

            if ($result_equipos->num_rows > 0) {

                // Arreglo para mantener el último tipo de bien procesado
                $last_tipo_bien = null;

                // Recorrer los equipos y añadirlos al PDF
                while ($row_equipo = $result_equipos->fetch_assoc()) {

                    // Verificar si el tipo de bien ha cambiado
                    if ($row_equipo['tipo_bien'] != $last_tipo_bien) {
                        // Mostrar un nuevo título para el nuevo tipo de bien
                        $this->SetFont('Arial', 'BU', 13);
                        $this->Cell(0, 10, utf8_decode(strtoupper($row_equipo['tipo_bien'])), 0, 1, 'L', 0);
                        $this->Ln(6);

                        // Actualizar el último tipo de bien procesado
                        $last_tipo_bien = $row_equipo['tipo_bien'];
                    }

                    $this->SetFont('Arial', '', 13);
                    $this->Cell(100, 10, utf8_decode('MARCA: '), 0, 0, 'R', 0);
                    $this->SetFont('Arial', '', 13);
                    $this->Cell(0, 10, utf8_decode($row_equipo['marca']), 0, 1, 'L', 0);


                    $this->SetFont('Arial', '', 13);
                    $this->Cell(100, 10, utf8_decode('MODELO: '), 0, 0, 'R', 0);
                    $this->SetFont('Arial', '', 13);
                    $this->Cell(0, 10, utf8_decode($row_equipo['modelo']), 0, 1, 'L', 0);

                    $this->SetFont('Arial', '', 13);
                    $this->Cell(100, 10, utf8_decode('SERIE: '), 0, 0, 'R', 0);
                    $this->SetFont('Arial', '', 13);
                    $this->Cell(0, 10, utf8_decode($row_equipo['serie']), 0, 1, 'L', 0);

                    $this->SetFont('Arial', '', 13);
                    $this->Cell(100, 10, utf8_decode('COD. PATRIMONIAL: '), 0, 0, 'R', 0);
                    $this->SetFont('Arial', '', 13);
                    $this->Cell(0, 10, utf8_decode($row_equipo['cod_patrimonial']), 0, 1, 'L', 0);
                    $this->Ln(8);

                }
                $this->Ln(4); // Espacio entre cada equipo
            } else {
                // No se encontraron equipos asignados para este desplazamiento
                $this->SetFont('Arial', '', 13);
                $this->Cell(0, 10, utf8_decode("No se encontraron equipos asignados para este desplazamiento"), 0, 1, 'L', 0);
                $this->Ln(4);
            }

            $this->SetFont('Arial', 'BU', 13);
            $this->Cell(30, 10, utf8_decode("PROVENIENTE DE "), 0, 1, 'L', 0);

            $this->SetFont('Arial', '', 13);
            $this->Cell(100, 10, utf8_decode('Responsable funcional: '), 0, 0, 'R', 0);
            $this->SetFont('Arial', '', 13);
            $this->Cell(0, 10, utf8_decode($row_desplazamiento['responsable_prov']), 0, 1, 'L', 0);

            $this->SetFont('Arial', '', 13);
            $this->Cell(100, 10, utf8_decode('Unidad Orgánica: '), 0, 0, 'R', 0);
            $this->SetFont('Arial', '', 13);
            $this->Cell(0, 10, utf8_decode($row_desplazamiento['nombre_area_proveniente']), 0, 1, 'L', 0);
            $this->Ln(8);

            $this->SetFont('Arial', 'BU', 13);
            $this->Cell(30, 10, utf8_decode("ASIGNADO A "), 0, 1, 'L', 0);
            $this->SetFont('Arial', '', 13);
            $this->Cell(100, 10, utf8_decode('Responsable funcional: '), 0, 0, 'R', 0);
            $this->SetFont('Arial', '', 13);
            $this->Cell(0, 10, utf8_decode($row_desplazamiento['responsable_asig']), 0, 1, 'L', 0);

            $this->SetFont('Arial', '', 13);
            $this->Cell(100, 10, utf8_decode('Unidad Orgánica: '), 0, 0, 'R', 0);
            $this->SetFont('Arial', '', 13);
            $this->Cell(0, 10, utf8_decode($row_desplazamiento['nombre_area_asignada']), 0, 1, 'L', 0);
            $this->Ln(20);

            $this->SetFont('Arial', 'I', 12);
            //$fechaDesdeBD = $row['fecha'];

            $this->Cell(0, 5, utf8_decode('Lambayeque, ' . strftime('%d de %B de %Y', strtotime($row_desplazamiento['fecha']))), 0, 1, 'R');
        } else {
            // No se encontraron datos para el ID proporcionado
            $this->Cell(0, 10, utf8_decode("No se encontraron datos para el Reporte #" . $id_reporte), 0, 1, 'L', 0);
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


// Crear el PDF
$pdf = new PDF();

$pdf->AddPage();

// Generar el informe utilizando el ID obtenido desde la URL
$pdf->generarInforme($id_reporte);

$pdf->AliasNbPages();
$pdf->SetFont('Arial', '', 12);
$pdf->SetTextColor(0, 0, 0);
$pdf->SetDrawColor(128, 128, 128);

$pdf->Ln(5);



$conn->close();

$pdf->Output('EquiposInactivos.pdf', 'I');//nombreDescarga, Visor(I->visualizar - D->descargar)