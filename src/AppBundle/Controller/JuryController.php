<?php

declare(strict_types=1);

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

final class JuryController extends BaseController
{
    /**
     * @Route("/jury/bevestig/{confirmationId}/", name="confirmJudge", methods={"GET", "POST"})
     */
    public function confirmJudge(Request $request, $confirmationId)
    {
        $this->setBasicPageData('Organisatie');
        $result = $this->getDoctrine()
            ->getRepository('AppBundle:User')
            ->findOneBy(
                array('id' => $id)
            );
        if ($result) {
            if ($request->getMethod() == 'POST') {
                if ($request->request->get('bevestig')) {
                    $this->removeFromDB($result);
                    return $this->redirectToRoute('organisatieGetContent', ['page' => 'Inschrijvingen']);
                }
            }
            $contactpersoon = [
                'naam'       => $result->getVoornaam() . ' ' . $result->getAchternaam(),
                'vereniging' => $result->getVereniging()->getNaam() . ', ' . $result->getVereniging()->getPlaats(),
            ];
            return $this->render(
                'organisatie/removeContactpersoon.html.twig',
                array(
                    'menuItems'                       => $this->menuItems,
                    'contactpersoon'                  => $contactpersoon,
                    'totaalAantalVerenigingen'        => $this->aantalVerenigingen,
                    'totaalAantalTurnsters'           => $this->aantalTurnsters,
                    'totaalAantalTurnstersWachtlijst' => $this->aantalWachtlijst,
                    'totaalAantalJuryleden'           => $this->aantalJury,
                )
            );
        }
        return $this->redirectToRoute('organisatieGetContent', ['page' => 'Inschrijvingen']);
    }
}
