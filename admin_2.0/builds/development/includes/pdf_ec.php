<?php
require_once("fpdf/fpdf.php");
require_once("php_init.php");
$sql="SELECT f.id,f.folio,sum(pa.pago) as 'pagos',sum(f.cantidad) as 'monto',f.id_prov,p.nombre,f.id_rs,rs.razon FROM proveedores p JOIN facturas f ON f.id_prov=p.id";
$sql.=" JOIN razones_sociales rs ON f.id_rs=rs.id LEFT JOIN pagos pa on pa.id_fac=f.id GROUP BY f.id_prov,f.id_rs";
$sql.=" HAVING sum(pa.pago)<=sum(f.cantidad) ORDER BY rs.razon,p.nombre";
$res=exec_query($sql);
$dia=std_date("today");
$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 14);
$pdf->Image("../public/images/logo.jpg", 10,8,40,20, 'JPG');
$pdf->Ln(18);
$pdf->Cell(70,10,"");
$pdf->Cell(70,10,"Estado de cuenta general");
$pdf->Ln(10);
$pdf->SetFont('Arial','',12);
$pdf->Cell(80,10,"");
$pdf->Cell(40,10,$dia);
$pdf->Ln(10);
$pdf->SetFont('Arial','',10);
$pdf->Cell(18,5,"Direccion: ");
$pdf->SetFont('Arial','',10);
$pdf->Cell(105,5,"AV ALVARO OBREGON SUR 1880 LOC 39 D CENTRO");
$pdf->Cell(50,5,"Correo: contabilidad@grupomara.mx");
$pdf->Ln(5);
$pdf->Cell(80,5,"Codigo Postal: 80243");
$pdf->Cell(43,5,"Pais: Mexico");
$pdf->Cell(30,5,"Telefono: +52 (667)1 52-14-83");

$pdf->Ln(15);
$pdf->SetFont('Arial','B',13);
$pdf->Cell(10,10,"");
$pdf->Cell(60,10,"Proveedor");
$pdf->Cell(85,10,"Razon social");
$pdf->Cell(40,10,"Cantidad");
$pdf->Ln(10);
$pdf->Cell(10,10,"");
$pdf->SetFont('Arial','',10);
while ($row=fetch($res)) {
    $prov=html_prep($row["nombre"]);
    $rs=html_prep($row["razon"]);
    $monto=(float)$row["monto"];
    $pagos=(float)$row["pagos"];
    $adeudo=money($monto-$pagos);
    $pdf->Cell(60,10,$prov);
    $pdf->Cell(85,10,$rs);
    $pdf->Cell(40,10,$adeudo);
    $pdf->Ln(10);
    $pdf->Cell(10,10,"");
}
$pdf->Ln(10);
$pdf->SetFont('Arial','',9);
$pdf->SetTextColor(80,80,80);
$pdf->Cell(120,10,"");
$pdf->Cell(70,10,"*Cantidad expresada en pesos MXN");
$pdf->Output();
?>
