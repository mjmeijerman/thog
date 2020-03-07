<?php

namespace AppBundle\Controller;

class JurybadgePdfController extends AlphaPDFController
{
    private $tournamentDate;

    /**
     * @param mixed $tournamentDate
     */
    public function setTournamentDate($tournamentDate)
    {
        $this->tournamentDate = $tournamentDate;
    }

    function Header()
    {
        //BACKGROUND
        $this->Image('images/JuryBadge_background.png', 0, 0,53.98);

        //LOGO
        $this->Image('images/JuryBadge_logo.png', 13, 0,31);
    }

    function Footer()
    {

    }

    function badgeContent($jurylid)
    {
        //NAAM EN BREVET
        //TEKST
        $this->Ln(50);
        $this->SetFont('Barlow', '', 10);
        $this->SetTextColor(245,36,142);
        $this->Cell(53.98, 5, strtoupper(utf8_decode($jurylid['naam'])), 0, 1, 'C');

        $this->SetFontSize(18);
        $this->SetTextColor(95,99,253);
        $this->Cell(53.98, 5, 'JURYLID', 0, 1, 'C');

        $this->SetFontSize(6);
        $this->SetTextColor(245,36,142);
        $this->Cell(53.98,4, BaseController::TOURNAMENT_SHORT_NAME . ' - '.strtoupper($this->tournamentDate),0,1,'C');

        //TAAK
        //$pdf->Text(28.25,37,'HOOFD JURY'); // HOOFD JURY

        //DAG
        $this->SetFontSize(14);
        $this->SetTextColor(245,36,142);
        if($jurylid['dag'] == 'Zaterdag') { $this->Text(16, 84, strtoupper($jurylid['dag'])); }
        if($jurylid['dag'] == 'Zondag') { $this->Text(18, 84, strtoupper($jurylid['dag'])); }

        //LUNCH EN DINER
        //FILL
        $this->SetAlpha(0.5);
        $this->SetFillColor(0);
        $this->SetAlpha(1);

        //TEKST
        $this->SetTextColor(245,36,142);
        $this->SetFontSize(8);

        //LUNCH
        $this->Text(2, 84, 'LUNCH');

        //DINER
        $this->Text(44, 84, 'DINER');
    }
}
