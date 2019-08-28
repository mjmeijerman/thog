<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="hoofdmenuitems")
 */
class HoofdmenuItem
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

    /**
     * @ORM\OneToMany(targetEntity="SubmenuItem", mappedBy="hoofdmenuItem", cascade={"persist", "remove"}, orphanRemoval=TRUE)
     * @ORM\OrderBy({"positie" = "ASC"})
     */
    private $submenuItems;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->submenuItems = new ArrayCollection();
    }

    public function getAll()
    {
        $menuItems = [
            'id' => $this->id,
            'naam' => $this->naam,
            'submenuItems' => array(),
        ];
        foreach ($this->submenuItems as $submenuItem) {
            $menuItems['submenuItems'][] = $submenuItem->getAll();
        }
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
     * @return HoofdmenuItem
     */
    public function setNaam($naam)
    {
        $this->naam = $naam;

        return $this;
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
     * @return HoofdmenuItem
     */
    public function setPostitie($positie)
    {
        $this->positie = $positie;

        return $this;
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

    /**
     * Add submenuItems
     *
     * @param SubmenuItem $submenuItems
     *
     * @return HoofdmenuItem
     */
    public function addSubmenuItem(SubmenuItem $submenuItems)
    {
        $this->submenuItems[] = $submenuItems;

        return $this;
    }

    /**
     * Remove submenuItems
     *
     * @param SubmenuItem $submenuItems
     */
    public function removeSubmenuItem(SubmenuItem $submenuItems)
    {
        $this->submenuItems->removeElement($submenuItems);
    }

    /**
     * Get submenuItems
     *
     * @return Collection
     */
    public function getSubmenuItems()
    {
        return $this->submenuItems;
    }
}
