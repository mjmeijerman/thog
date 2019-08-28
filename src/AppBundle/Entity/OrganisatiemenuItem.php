<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use stdClass;

/**
 * @ORM\Entity
 * @ORM\Table(name="organisatiemenuitems")
 */
class OrganisatiemenuItem
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(length=156)
     */
    private $naam;

    /**
     * @ORM\Column(type="integer")
     */
    private $positie;

    public function getAll()
    {
        $menuItems = new stdClass();
        $menuItems->id = $this->id;
        $menuItems->naam = $this->naam;
        return $menuItems;
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set naam
     *
     * @param string $naam
     */
    public function setNaam($naam)
    {
        $this->naam = $naam;
    }

    /**
     * Get naam
     *
     * @return string 
     */
    public function getNaam()
    {
        return $this->naam;
    }

    /**
     * Set positie
     *
     * @param integer $positie
     */
    public function setPostitie($positie)
    {
        $this->positie = $positie;
    }

    /**
     * Get positie
     *
     * @return integer 
     */
    public function getPositie()
    {
        return $this->positie;
    }

}
