<?php

declare(strict_types=1);

namespace AppBundle\Controller;

use AppBundle\Entity\Jurylid;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

final class JuryController extends BaseController
{
    /**
     * @Route("/jury/bevestig/{confirmationId}/", name="confirmJudge", methods={"GET", "POST"})
     */
    public function confirmJudge(Request $request, $confirmationId)
    {
        $this->setBasicPageData();

        /** @var Jurylid $juryLid */
        $juryLid = $this->getDoctrine()->getRepository(Jurylid::class)->findOneBy(['confirmationId' => $confirmationId]);
        if (!$juryLid) {
            return $this->render(
                'jury/not_found.html.twig',
                array(
                    'menuItems'           => $this->menuItems,
                    'sponsors'            => $this->sponsors,
                )
            );
        }

        if ($request->getMethod() === 'POST') {

            // todo: gegevens opslaan
            // todo: confirmed op true zetten
            // todo: email sturen naar jurylid ter bevestiging

            return $this->redirectToRoute('getIndexPage');
        }

        if ($juryLid->getIsConfirmed()) {
            return $this->render(
                'jury/allready_confirmed.html.twig',
                array(
                    'menuItems'           => $this->menuItems,
                    'sponsors'            => $this->sponsors,
                )
            );
        }

        return $this->render(
            'jury/confirm.html.twig',
            array(
                'menuItems'           => $this->menuItems,
                'sponsors'            => $this->sponsors,
            )
        );
    }
}
