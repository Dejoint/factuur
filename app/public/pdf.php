<?php
session_start();

require('FPDF/fpdf.php');
require_once 'includes/config.php';
require_once 'includes/functions.php';

$db = getDatabase(); 

$factuur = $_SESSION['cart'];

$cust = isset($_POST['cust']) ? $_POST['cust'] : '';
$BTW = isset($_POST['BTW']) ? $_POST['BTW'] : '';
$adres = isset($_POST['adres']) ? $_POST['adres'] : '';
$gem = isset($_POST['gem']) ? $_POST['gem'] : '';
$post = isset($_POST['post']) ? $_POST['post'] : '';
$mail = isset($_POST['mail']) ? $_POST['mail'] : '';
$factnum = isset($_POST['factnum']) ? $_POST['factnum'] : '';
$betreft  = isset($_POST['betreft']) ? $_POST['betreft'] : '';

function getData($id){
    $db = getDatabase(); 
    $stmt = $db->prepare('SELECT * FROM verkoop WHERE id = ?');
    $stmt->execute(array($id));
    return $stmt->fetchAll(PDO::FETCH_ASSOC);

}
$totaal = 0;
class PDF extends FPDF
{
function Header()
{
 
}
function Titel()
{
    global $cust, $BTW, $adres, $gem, $post, $mail, $factnum, $betreft;
    $this->Image('img/logo.png',10,6,30);
    $this->SetFont('Helvetica','B',30);
    $this->Ln(5);
    $this->Cell(100);
    $this->Cell(30,10,'FACTUUR',0,0,'L');
    $this->Cell(100);
    $this->SetFont('Helvetica','',10); 
    $this->Ln(20);
    $this->SetFont('Helvetica','',10);
    $this->Cell(30,10,'Aan: ' . $cust,0,0,'L');
    $this->Cell(70); 
    $this->Cell(30,10,'Jeugdhuis De Wattage ',0,0,'L');
    $this->Ln(5);
    $this->Cell(30,10,$adres,0,0,'L');
    $this->Cell(70);
    $this->Cell(30,10,'Solleveld 37',0,0,'L');
    $this->Ln(5);
    $this->Cell(30,10,$post . ' ' . $gem ,0,0,'L');
    $this->Cell(70);
    $this->Cell(30,10,'9550 Herzele',0,0,'L');
    $this->Ln(5);
    $this->Cell(30,10,$mail,0,0,'L');
    $this->Cell(70);
    $this->Cell(30,10,'jeugdhuisdewattage@gmail.com',0,0,'L');
    $this->Ln(10);
    $this->SetFont('Helvetica','B',10);
    $this->Cell(30,10,'Factuurnummer',0,0,'L');
    $this->Cell(20);
    $this->Cell(30,10,'Factuurdatum',0,0,'L');
    $this->Cell(20);
    $this->Cell(30,10,'Vervaldatum',0,0,'L');
    $this->Ln(10);
    $this->SetFont('Helvetica','',10);
    $this->Cell(30,10,$factnum,0,0,'L');
    $this->Cell(20);
    $this->Cell(30,10,date("d/m/y"),0,0,'L');
    $this->Cell(20);
    $this->Cell(30,10,date('d/m/y', strtotime(date('y-m-d') . ' + 7 days')),0,0,'L');
    $this->Ln(10);
    $this->SetFont('Helvetica','B',10);
    $this->Cell(30,10,'Betreft: ' . $betreft,0,0,'L');
    $this->Ln(15);
}    

function Footer()
{
    
    $this->SetY(-15);
    $this->SetFont('Helvetica','',8);
    $this->Cell(0,10, 'Copyright ' . date("Y") . chr(169) . ' Jeugdhuis De Wattage' ,0,0,'C');
    $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
}
function Table($header, $data)
{

    $this->SetFillColor(51,51,51);
    $this->SetTextColor(255);
    $this->SetDrawColor(51,51,51);
    $this->SetLineWidth(.3);
    $this->SetFont('Helvetica','B');
    $w = array(40, 35, 40, 45);
    $t = array(115, 45);
    for($i=0;$i<count($header);$i++)
        $this->Cell($w[$i],7,$header[$i],1,0,'C',true);
    $this->Ln();
    $this->SetFillColor(224,235,255);
    $this->SetTextColor(0);
    $this->SetFont('');
    $fill = false;
    global $totaal;
    foreach($data as $row)
    {
        $artInfo = getData($row[1]);
        $regelTot = (double)$row[0] * (double)$artInfo[0]["prijs"];
        $totaal = (double)$totaal + (double)$regelTot;
        $this->Cell($w[0],6,$artInfo[0]["naam"],'LR',0,'C',$fill);
        $this->Cell($w[1],6,$row[0],'LR',0,'C',$fill);
        $this->Cell($w[2],6,chr(128) . $artInfo[0]["prijs"] ,'LR',0,'C',$fill);
        $this->Cell($w[3],6,chr(128) . $regelTot,'LR',0,'C',$fill);
        $this->Ln();
        $fill = !$fill;
    }
    
    $this->Cell(array_sum($w),0,'','T');
    $this->Ln(10);
    $this->SetFillColor(242,242,242);
    $this->SetTextColor(0);
    $this->SetDrawColor(242,242,242);
    $this->SetLineWidth(.3);
    $this->SetFont('Helvetica','B');
    $this->Cell($t[0],6,'Totaal: ','',0,'R', true);
    $this->Cell($t[1],6,chr(128) . number_format($totaal, 2),'',0,'L', true);
    $this->Ln(10);
}
function ending(){
    global $totaal;
    $this->SetFont('Helvetica','B',10); 
    $this->Ln(10);
    $this->Cell(30,10,'Voor uw betaling, gelieve onderstaande gegevens te gebruiken:',0,0,'L');
    $this->Ln(10);
    $this->SetFont('Helvetica','',10); 
    $this->Cell(30,10,'Naam en adres begunstigde:',0,0,'L');
    $this->Cell(70);
    $this->Cell(30,10,'Jeugdhuis Wattage vzw',0,0,'L');
    $this->Ln(5);
    $this->Cell(100);
    $this->Cell(30,10,'Solleveld 35',0,0,'L');
    $this->Ln(5);
    $this->Cell(100);
    $this->Cell(30,10,'9550 Herzele',0,0,'L');
    $this->Ln(8);
    $this->Cell(30,10,'Rekeningnummer:',0,0,'L');
    $this->Cell(70);
    $this->Cell(30,10,'001-6722252-34',0,0,'L');
    $this->Ln(5);
    $this->Cell(100);
    $this->Cell(30,10,'IBAN: BE68 0016 7222 5234      BIC: GEBABEBB',0,0,'L');
    $this->Ln(8);
    $this->Cell(30,10,'Bedrag:',0,0,'L');
    $this->Cell(70);
    $this->Cell(30,10,chr(128) . number_format($totaal, 2) . ' Te betalen ten laatste op: ' . date('d/m/y', strtotime(date('y-m-d') . ' + 7 days')),0,0,'L');
    $this->Ln(10);
    $this->Cell(30,10,'Het jeugdwerk geniet vrijstelling van B.T.W. op goederen en diensten. (Artikel 44, paragraaf 2 van het B.T.W. -wetboek)',0,0,'L');
}
}

$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->Titel();
$pdf->SetFont('Times','',12);
$header = array('Beschrijving', 'Aantal', 'Eenheidsprijs', 'Regeltotaal');
$pdf->Table($header,$factuur);    
$pdf->ending();
$pdf->Output();
?>
