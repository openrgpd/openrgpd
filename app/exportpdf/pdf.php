<?php
use Fpdf\Fpdf;

/**
 * Custom Pdf
 */
class PDF extends Fpdf
{
// Chargement des données
function LoadData($file)
{
    // Lecture des lignes du fichier
    $lines = file($file);
    $data = array();
    foreach($lines as $line)
        $data[] = explode(';',trim($line));
    return $data;
}

/**
 * Rédefinition pour decoder utf8
 */
function Cell($w, $h=0, $txt='', $border=0, $ln=0, $align='', $fill=false, $link='') {
    Fpdf::Cell($w,$h,utf8_decode($txt), $border, $ln, $align, $fill, $link);
}

// Tableau simple
function BasicTable($header, $data)
{
    // En-tête
    foreach($header as $col)
        $this->Cell(40,7,$col,1);
    $this->Ln();
    // Données
    foreach($data as $row)
    {
        foreach($row as $col)
            $this->Cell(40,6,$col,1);
        $this->Ln();
    }
}

// Tableau amélioré
function ImprovedTable($header, $data)
{
    // Largeurs des colonnes
    $w = array(40, 35, 45, 40);
    // En-tête
    for($i=0;$i<count($header);$i++)
        $this->Cell($w[$i],7,$header[$i],1,0,'C');
    $this->Ln();
    // Données
    foreach($data as $row)
    {
        $this->Cell($w[0],6,$row[0],'LR');
        $this->Cell($w[1],6,$row[1],'LR');
        $this->Cell($w[2],6,number_format($row[2],0,',',' '),'LR',0,'R');
        $this->Cell($w[3],6,number_format($row[3],0,',',' '),'LR',0,'R');
        $this->Ln();
    }
    // Trait de terminaison
    $this->Cell(array_sum($w),0,'','T');
}

// Tableau coloré
function FancyTable($header, $data)
{
    // Couleurs, épaisseur du trait et police grasse
    $this->SetFillColor(255,0,0);
    $this->SetTextColor(255);
    $this->SetDrawColor(128,0,0);
    $this->SetLineWidth(.3);
    $this->SetFont('','B');
    // En-tête
    $w = array(40, 35, 45, 40);
    for($i=0;$i<count($header);$i++)
        $this->Cell($w[$i],7,$header[$i],1,0,'C',true);
    $this->Ln();
    // Restauration des couleurs et de la police
    $this->SetFillColor(224,235,255);
    $this->SetTextColor(0);
    $this->SetFont('');
    // Données
    $fill = false;
    foreach($data as $row)
    {
        $this->Cell($w[0],6,$row[0],'LR',0,'L',$fill);
        $this->Cell($w[1],6,$row[1],'LR',0,'L',$fill);
        $this->Cell($w[2],6,number_format($row[2],0,',',' '),'LR',0,'R',$fill);
        $this->Cell($w[3],6,number_format($row[3],0,',',' '),'LR',0,'R',$fill);
        $this->Ln();
        $fill = !$fill;
    }
    // Trait de terminaison
    $this->Cell(array_sum($w),0,'','T');
}


/********************************************
		partie saut de ligne
********************************************/ 
function Header()
{
    global $titre;

    // Arial gras 14
    $this->SetFont('Arial','B',12);
    // Calcul de la largeur du titre et positionnement
    $w = $this->GetStringWidth($titre)+6;
    $this->SetX((220-$w)/2);
    // Couleurs du cadre, du fond et du texte
    $this->SetDrawColor( 5, 5, 5 );
    $this->SetFillColor( 2255, 255, 255 );
    $this->SetTextColor(220,50,50);
    // Epaisseur du cadre (1 mm)
    $this->SetLineWidth(0.5);
    // Titre
    $this->Cell($w,9,$titre,1,1,'C',true);
    // Saut de ligne
    $this->Ln(10);
}
function Footer()
{
    // Positionnement à 1,5 cm du bas
    $this->SetY(-15);
    // Arial italique 8
    $this->SetFont('Arial','I',8);
    // Couleur du texte en gris
    $this->SetTextColor(128);
    // Numéro de page
    $this->Cell(0,10,'Page '.$this->PageNo(),0,0,'C');
}

function TitreChapitre($num, $libelle)
{
    // Arial 12
    $this->SetFont('Arial','',12);
    // Couleur de fond
    $this->SetFillColor(200,220,255);
    // Titre
    $this->Cell(0,6,"Chapitre $num : $libelle",0,1,'L',true);
    // Saut de ligne
    $this->Ln(4);
}

function CorpsChapitre($fichier)
{
    // Lecture du fichier texte
    $txt = file_get_contents($fichier);
    // Times 12
    $this->SetFont('Times','',12);
    // Sortie du texte justifié
    $this->MultiCell(0,5,$txt);
    // Saut de ligne
    $this->Ln();
    // Mention en italique
    $this->SetFont('','I');
    $this->Cell(0,5,"(fin de l'extrait)");
}

function AjouterChapitre($num, $titre, $fichier)
{
    $this->AddPage();
    $this->TitreChapitre($num,$titre);
    $this->CorpsChapitre($fichier);
}

/*PARTIE BOOKMARK****/
protected $outlines = array();
protected $outlineRoot;

function Bookmark($txt, $isUTF8=true, $level=0, $y=0)
{
    if(!$isUTF8)
        $txt = utf8_encode($txt);
    if($y==-1)
        $y = $this->GetY();
    $this->outlines[] = array('t'=>$txt, 'l'=>$level, 'y'=>($this->h-$y)*$this->k, 'p'=>$this->PageNo());
}

function _putbookmarks()
{
    $nb = count($this->outlines);
    if($nb==0)
        return;
    $lru = array();
    $level = 0;
    foreach($this->outlines as $i=>$o)
    {
        if($o['l']>0)
        {
            $parent = $lru[$o['l']-1];
            // Set parent and last pointers
            $this->outlines[$i]['parent'] = $parent;
            $this->outlines[$parent]['last'] = $i;
            if($o['l']>$level)
            {
                // Level increasing: set first pointer
                $this->outlines[$parent]['first'] = $i;
            }
        }
        else
            $this->outlines[$i]['parent'] = $nb;
        if($o['l']<=$level && $i>0)
        {
            // Set prev and next pointers
            $prev = $lru[$o['l']];
            $this->outlines[$prev]['next'] = $i;
            $this->outlines[$i]['prev'] = $prev;
        }
        $lru[$o['l']] = $i;
        $level = $o['l'];
    }
    // Outline items
    $n = $this->n+1;
    foreach($this->outlines as $i=>$o)
    {
        $this->_newobj();
        $this->_put('<</Title '.$this->_textstring($o['t']));
        $this->_put('/Parent '.($n+$o['parent']).' 0 R');
        if(isset($o['prev']))
            $this->_put('/Prev '.($n+$o['prev']).' 0 R');
        if(isset($o['next']))
            $this->_put('/Next '.($n+$o['next']).' 0 R');
        if(isset($o['first']))
            $this->_put('/First '.($n+$o['first']).' 0 R');
        if(isset($o['last']))
            $this->_put('/Last '.($n+$o['last']).' 0 R');
        $this->_put(sprintf('/Dest [%d 0 R /XYZ 0 %.2F null]',$this->PageInfo[$o['p']]['n'],$o['y']));
        $this->_put('/Count 0>>');
        $this->_put('endobj');
    }
    // Outline root
    $this->_newobj();
    $this->outlineRoot = $this->n;
    $this->_put('<</Type /Outlines /First '.$n.' 0 R');
    $this->_put('/Last '.($n+$lru[0]).' 0 R>>');
    $this->_put('endobj');
}

function _putresources()
{
    parent::_putresources();
    $this->_putbookmarks();
}

function _putcatalog()
{
    parent::_putcatalog();
    if(count($this->outlines)>0)
    {
        $this->_put('/Outlines '.$this->outlineRoot.' 0 R');
        $this->_put('/PageMode /UseOutlines');
    }
}

}
?>