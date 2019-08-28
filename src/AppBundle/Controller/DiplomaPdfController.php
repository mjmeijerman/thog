<?php

namespace AppBundle\Controller;

class DiplomaPdfController extends AlphaPDFController
{
    function HeaderDiploma()
    {
        //BACKGROUND
        $this->Image('images/DiplomaBackground.png', 0, 0);    //BACKGROUND2: 0,45		BACKGROUND3: 17,77
        //			$this->SetFillColor(127);
        //			$this->Rect(0,0,210,35,'F');
        //LOGO
        $this->SetFillColor(0);
        $this->SetAlpha(0.5);
        $this->Rect(0, 0, 297, 35, 'F');
        $this->SetAlpha(1);
        $this->Image('images/' . BaseController::TOURNAMENT_SHORT_NAME . 'DiplomaHeader.png', 0, 0);
    }

    function FooterDiploma($tournamentDate)
    {
        $this->SetX(3);
        $this->SetAlpha(0.6);
        $this->SetFont('Gotham', '', 12);
        $this->SetTextColor(0);

        //DONAR SITE
        $this->Text(5, 145, BaseController::TOURNAMENT_WEBSITE_URL);

        //TOURNAMENT SITE
        $this->Image(
            BaseController::TOURNAMENT_WEBSITE_URL . '/uploads/sponsors/ca64ecbb4276c8583d9eac5b142c5062839663cf_groot.gif',
            150,
            130,
            0,
            15
        );

        //DATUM
        $this->Text(85, 145, '- ' . utf8_decode($tournamentDate) . ' -');
    }

    function ContentDiploma($turnster)
    {
        $this->SetFontSize(20);

        //SPRONG

        //ACHTERGROND
        $this->SetDrawColor(255, 255, 0);
        $this->SetFillColor(255, 255, 0);
        $this->SetAlpha(0.5);
        $this->RoundedRect(7, 55, 70, 10, 2, 'F');
        $this->SetAlpha(1);

        //TEKST
        $this->Text(9.5, 62.5, 'Sprong');

        //LIJNTJE
        $this->SetFillColor(0);
        $this->Rect(45, 62.5, 25, .25, 'F');

        //BRUG

        //ACHTERGROND
        $this->SetDrawColor(255, 255, 0);
        $this->SetFillColor(255, 255, 0);
        $this->SetAlpha(0.5);
        $this->RoundedRect(7, 73, 70, 10, 2, 'F');
        $this->SetAlpha(1);

        //TEKST
        $this->Text(9.5, 80.5, 'Brug');

        //LIJNTJE
        $this->SetFillColor(0);
        $this->Rect(45, 80.5, 25, .25, 'F');

        //BALK

        //ACHTERGROND
        $this->SetDrawColor(255, 255, 0);
        $this->SetFillColor(255, 255, 0);
        $this->SetAlpha(0.5);
        $this->RoundedRect(7, 91, 70, 10, 2, 'F');
        $this->SetAlpha(1);

        //TEKST
        $this->Text(9.5, 98.5, 'Balk');

        //LIJNTJE
        $this->SetFillColor(0);
        $this->Rect(45, 98.5, 25, .25, 'F');

        //VLOER

        //ACHTERGROND
        $this->SetDrawColor(255, 255, 0);
        $this->SetFillColor(255, 255, 0);
        $this->SetAlpha(0.5);
        $this->RoundedRect(7, 109, 70, 10, 2, 'F');
        $this->SetAlpha(1);

        //TEKST
        $this->Text(9.5, 116.5, 'Vloer');

        //LIJNTJE
        $this->SetFillColor(0);
        $this->Rect(45, 116.5, 25, .25, 'F');

        //TOTAAL

        //ACHTERGROND
        $this->SetDrawColor(255, 255, 0);
        $this->SetFillColor(255, 255, 0);
        $this->SetAlpha(0.5);
        $this->RoundedRect(107, 109, 70, 10, 2, 'F');
        $this->SetAlpha(1);

        //TEKST
        $this->Text(109.5, 116.5, 'Totaal');

        //LIJNTJE
        $this->SetFillColor(0);
        $this->Rect(145, 116.5, 25, .25, 'F');

        //NAAM, VERENIGING, CATEGORIE EN NIVEAU

        //NAAM
        //FILL
        $this->Ln(70.5);
        $this->Cell(107, 2, '');

        //TEKST
        $this->SetFontSize(20);
        $this->Cell(70, 0, utf8_decode($turnster['naam']), 0, 1, 'C');

        //VERENIGING
        //FILL
        $this->Ln(10);
        $this->Cell(107, 2, '');

        //TEKST
        $this->SetFontSize(16);
        $this->Cell(70, 0, utf8_decode($turnster['vereniging']), 0, 1, 'C');

        //CATEGORIE EN NIVEAU
        //FILL
        $this->Ln(7);
        $this->Cell(107, 2, '');

        //TEKST
        $this->SetFontSize(16);
        $this->Cell(70, 0, utf8_decode($turnster['categorie']) . ' ' . utf8_decode($turnster['niveau']), 0, 1, 'C');

        //SPONSORS
        //FILL
        $this->Ln(36);
    }

    function Wedstrijdnummer($turnster)
    {
        $this->SetFont('Helvetica', '', 20);
        $this->Ln(15);
        $this->Cell(210, 15, utf8_decode($turnster['vereniging']), 0, 1, "C");
        $this->Ln(16);
        $this->SetFont('Helvetica', '', 200);
        $this->Cell(210, 62, utf8_decode($turnster['wedstrijdnummer']), 0, 1, "C");
        $this->Ln(10);
        $this->SetFont('Helvetica', '', 20);
        $this->Cell(210, 10, utf8_decode($turnster['naam']), 0, 0, "C");

        //IMAGES
        $this->Image(
            BaseController::TOURNAMENT_WEBSITE_URL . '/uploads/sponsors/9db8eb6e16a55cf34fd6ccb6edd3ce76dac79747_groot.png',
            22,
            114,
            0,
            30
        );
        $this->Image(
            BaseController::TOURNAMENT_WEBSITE_URL . '/uploads/sponsors/9fc2ed362cf8b06300477066fe8c675f15c0ea19_groot.jpg',
            150,
            127,
            0,
            14
        );
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
