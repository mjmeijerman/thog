<?php

namespace AppBundle\Controller;

class DiplomaPdfController extends AlphaPDFController
{
    function HeaderDiploma()
    {
        //BACKGROUND
        $this->Image('images/Diploma_background.png', 0, 0, 210);
    }

    function FooterDiploma($tournamentDate)
    {
        $this->SetX(3);
        $this->SetAlpha(0.4);
        $this->SetFont('Barlow', '', 10);
        $this->SetTextColor(0);

        //DONAR SITE
        $this->Text(3, 145, strtoupper(BaseController::TOURNAMENT_WEBSITE_URL));

        //DATUM
        $this->Text(183, 145, strtoupper(utf8_decode($tournamentDate)));
        $this->SetAlpha(1);
    }

    function ContentDiploma($turnster)
    {
        //MARGINS
        $this->SetMargins(0,0,0);

        //NAAM TURNSTER
        $this->SetFontSize(28);
        $this->SetTextColor(245,36,142);
        $this->Text(10,17,utf8_decode($turnster['naam']));

        $this->SetFontSize(20);

        //NIVEAU TURNSTER
        $this->SetFontSize(20);
        $this->SetTextColor(95,99,253);
        $this->Text(10,30,strtoupper(utf8_decode($turnster['categorie']) . ' ' . utf8_decode($turnster['niveau'])));

        //VERENIGING TURNSTER
        $this->Text(10,40,strtoupper(utf8_decode($turnster['vereniging'])));

        //FILL & TEXT COLOR
        $this->SetFillColor(95,99,253);
        $this->SetTextColor(255,255,255);
        $this->SetFontSize(18);
        $this->Ln(50);

        //SPRONG
        $this->Cell(78,10,'SPRONG  ',0,0,'R','F');   //SPATIE OPZETTELIJK
        $this->Cell(7,10,'','',0,'');
        $this->Cell(40,10,'','B',1);
        $this->Cell(10,6,'',0,1);

        //BRUG
        $this->Cell(78,10,'BRUG  ',0,0,'R','F');   //SPATIE OPZETTELIJK
        $this->Cell(7,10,'','',0,'');
        $this->Cell(40,10,'','B',1);
        $this->Cell(10,6,'',0,1);

        //BALK
        $this->Cell(78,10,'BALK  ',0,0,'R','F');   //SPATIE OPZETTELIJK
        $this->Cell(7,10,'','',0,'');
        $this->Cell(40,10,'','B',1);
        $this->Cell(10,6,'',0,1);

        //VLOER
        $this->Cell(78,10,'VLOER  ',0,0,'R','F');   //SPATIE OPZETTELIJK
        $this->Cell(7,10,'','',0,'');
        $this->Cell(40,10,'','B',1);
        $this->Cell(10,6,'',0,1);

        //TOTAAL
        $this->SetFillColor(245,36,142);
        $this->Cell(78,10,'TOTAAL  ',0,0,'R','F');   //SPATIE OPZETTELIJK
        $this->Cell(7,10,'','',0,'');
        $this->Cell(40,10,'','B',1);

        //SPONSORS
        //FILL
        $this->Ln(36);
    }

    function Wedstrijdnummer($turnster)
    {
        $this->AddFont('OpenSans', '', 'OpenSans-Light.php');
        $this->AddFont('Barlow', '', 'Barlow-Regular.php');
        $this->Image('images/Wedstrijdnummer_background.png',0,0);

        $this->SetFont('Barlow', '', 20);
        $this->SetTextColor(255,255,255);
        $this->Ln(15);
        $this->Cell(210, 15, utf8_decode($turnster['vereniging']), 0, 1, "C");
        $this->Ln(16);
        $this->SetFontSize(200);
        $this->Cell(210, 62, utf8_decode($turnster['wedstrijdnummer']), 0, 1, "C");
        $this->Ln(10);
        $this->SetFontSize(20);
        $this->Cell(210, 10, utf8_decode($turnster['naam']), 0, 0, "C");
    }

    //ROUNDED RECTANGLE
    function RoundedRect($x, $y, $w, $h, $r, $style = '', $angle = '1234')
    {
        $k = $this->k;
        $hp = $this->h;
        if ($style == 'F')
            $op = 'f';
        elseif ($style == 'FD' or $style == 'DF')
            $op = 'B';
        else
            $op = 'S';
        $MyArc = 4 / 3 * (sqrt(2) - 1);
        $this->_out(sprintf('%.2f %.2f m', ($x + $r) * $k, ($hp - $y) * $k));

        $xc = $x + $w - $r;
        $yc = $y + $r;
        $this->_out(sprintf('%.2f %.2f l', $xc * $k, ($hp - $y) * $k));
        if (strpos($angle, '2') === false)
            $this->_out(sprintf('%.2f %.2f l', ($x + $w) * $k, ($hp - $y) * $k));
        else
            $this->_Arc($xc + $r * $MyArc, $yc - $r, $xc + $r, $yc - $r * $MyArc, $xc + $r, $yc);

        $xc = $x + $w - $r;
        $yc = $y + $h - $r;
        $this->_out(sprintf('%.2f %.2f l', ($x + $w) * $k, ($hp - $yc) * $k));
        if (strpos($angle, '3') === false)
            $this->_out(sprintf('%.2f %.2f l', ($x + $w) * $k, ($hp - ($y + $h)) * $k));
        else
            $this->_Arc($xc + $r, $yc + $r * $MyArc, $xc + $r * $MyArc, $yc + $r, $xc, $yc + $r);

        $xc = $x + $r;
        $yc = $y + $h - $r;
        $this->_out(sprintf('%.2f %.2f l', $xc * $k, ($hp - ($y + $h)) * $k));
        if (strpos($angle, '4') === false)
            $this->_out(sprintf('%.2f %.2f l', ($x) * $k, ($hp - ($y + $h)) * $k));
        else
            $this->_Arc($xc - $r * $MyArc, $yc + $r, $xc - $r, $yc + $r * $MyArc, $xc - $r, $yc);

        $xc = $x + $r;
        $yc = $y + $r;
        $this->_out(sprintf('%.2f %.2f l', ($x) * $k, ($hp - $yc) * $k));
        if (strpos($angle, '1') === false) {
            $this->_out(sprintf('%.2f %.2f l', ($x) * $k, ($hp - $y) * $k));
            $this->_out(sprintf('%.2f %.2f l', ($x + $r) * $k, ($hp - $y) * $k));
        } else
            $this->_Arc($xc - $r, $yc - $r * $MyArc, $xc - $r * $MyArc, $yc - $r, $xc, $yc - $r);
        $this->_out($op);
    }

    function _Arc($x1, $y1, $x2, $y2, $x3, $y3)
    {
        $h = $this->h;
        $this->_out(
            sprintf(
                '%.2f %.2f %.2f %.2f %.2f %.2f c ',
                $x1 * $this->k,
                ($h - $y1) * $this->k,
                $x2 * $this->k,
                ($h - $y2) * $this->k,
                $x3 * $this->k,
                ($h - $y3) * $this->k
            )
        );
    }
}
