<?php

namespace AppBundle\Entity;

use AppBundle\AppBundle;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;
use AppBundle\Entity\Turnster;

/**
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 * @ORM\Table(name="vloermuziek")
 */
class Vloermuziek
{
    private $temp;

    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(length=300)
     */
    protected $locatie;

    /**
     * @Assert\File(
     *      maxSize="5M",
     *      )
     */
    private $file;

    /**
     * @ORM\OneToOne(targetEntity="Turnster", mappedBy="vloermuziek", cascade={"persist"})
     * @var Turnster
     */
    private $turnster;

    public function getAll()
    {
        $items = new \stdClass();
        $items->id = $this->id;
        $items->locatie = $this->locatie;
        return $items;
    }

    public function getAbsolutePath()
    {
        return null === $this->locatie
            ? null
            : $this->getUploadRootDir() . '/' . $this->locatie;
    }

    public function getWebPath()
    {
        return null === $this->locatie
            ? null
            : $this->getUploadDir() . '/' . $this->locatie;
    }

    public function getUploadRootDir()
    {
        // the absolute directory path where uploaded
        // documents should be saved
        return __DIR__ . '/../../../web/' . $this->getUploadDir();
    }

    protected function getUploadDir()
    {
        // get rid of the __DIR__ so it doesn't screw up
        // when displaying uploaded doc/image in the view.
        return 'uploads/vloermuziek/' . $this->turnster->getScores()->getWedstrijddag() . '/wedstrijdronde_' .
        $this->turnster->getScores()->getWedstrijdronde() . '/baan_' . $this->turnster->getScores()->getBaan() .
        '/groep_' .
        $this->getTurnster()->getScores()->getGroep();
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
     * @param $locatie
     * @return $this
     */
    public function setLocatie($locatie)
    {
        $this->locatie = $locatie;

        return $this;
    }

    /**
     * Get locatie
     *
     * @return string
     */
    public function getLocatie()
    {
        return $this->locatie;
    }

    /**
     * Sets file.
     *
     * @param UploadedFile $file
     */
    public function setFile(UploadedFile $file = null)
    {
        $this->file = $file;
        if (isset($this->locatie)) {
            $this->temp = $this->locatie;
            $this->locatie = null;
        } else {
            $this->locatie = 'initial';
        }
    }

    /**
     * Get file.
     *
     * @return UploadedFile
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function preUpload()
    {
        if (null !== $this->getFile()) {
            $filename = $this->turnster->getScores()->getWedstrijdnummer() . '_' . $this->turnster->getVoornaam() . '_' .
                $this->turnster->getAchternaam();
            $this->locatie = $filename . '.' . $this->getFile()->getClientOriginalExtension();
        }
    }

    /**
     * @ORM\PostPersist()
     * @ORM\PostUpdate()
     */
    public function upload()
    {
        if (null === $this->getFile()) {
            return;
        }
        $this->getFile()->move($this->getUploadRootDir(), $this->locatie);
        if (isset($this->temp)) {
            unlink($this->getUploadRootDir() . '/' . $this->temp);
            $this->temp = null;
        }
        $this->file = null;
    }

    /**
     * @ORM\PreRemove()
     */
    public function storeFilenameForRemove()
    {
        $this->temp = $this->getAbsolutePath();
    }

    /**
     * @ORM\PostRemove()
     */
    public function removeUpload()
    {
        if (isset($this->temp)) {
            unlink($this->temp);
        }
    }

    /**
     * Set turnster
     *
     * @param \AppBundle\Entity\Turnster $turnster
     * @return Vloermuziek
     */
    public function setTurnster(\AppBundle\Entity\Turnster $turnster = null)
    {
        $this->turnster = $turnster;

        return $this;
    }

    /**
     * Get turnster
     *
     * @return \AppBundle\Entity\Turnster 
     */
    public function getTurnster()
    {
        return $this->turnster;
    }
}
