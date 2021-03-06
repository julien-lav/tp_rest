<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Entity(repositoryClass="App\Repository\CompanyRepository")
 */
class Company
{
    /**
     * @ORM\Id()
     * @Groups("master")
     * @Groups("company")
     * @Groups("creditcard")
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Assert\Length(min="2")
     * @Groups("master") 
     * @Groups("company")
     * @Groups("creditcard")
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @Assert\NotBlank()
     * @Assert\Length(min="5")
     * @Groups("company") 
     * @ORM\Column(type="string", length=255)
     */
    private $slogan;

    /**
     * @Assert\NotBlank()
     * @Assert\Length(min = 8, max = 12)
     * @Groups("company") 
     * @ORM\Column(type="string", length=255)
     */
    private $phoneNumber;

    /**
     * @Groups("company") 
     * @ORM\Column(type="string", length=255)
     */
    private $adress;

    /**
     * @Assert\Url()
     * @Groups("company") 
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $websiteUrl;

    /**
     * @Assert\Url()
     * @Groups("company") 
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $pictureUrl;

    /**
     * @Groups("company") 
     * @ORM\OneToOne(targetEntity="App\Entity\Master", inversedBy="company", cascade={"persist"})
     */
    private $master;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Creditcard", mappedBy="company", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $creditcards;

    public function __construct()
    {
        $this->creditcards = new ArrayCollection();
    }

    public function getCreditcards(): ?array
    {
        return $this->creditcards;
    }

    /*
    public function setCreditcards(Creditcards $creditcards): self
    {
        $this->creditcards = $creditcards;
        return $this;
    }
    */

    public function addCreditcard(Creditcard $creditcard): self
    {
        if (!$this->creditcard->contains($creditcard)) {
            $this->creditcard[] = $creditcard;
            $creditcard->setCompany($this);
        }
        return $this;
    }
    public function removeCreditcard(Creditcard $creditcard): self
    {
        if ($this->creditcard->contains($creditcard)) {
            $this->creditcard->removeElement($creditcard);
            // set the owning side to null (unless already changed)
            if ($creditcard->getCompany() === $this) {
                $creditcard->setCompany(null);
            }
        }
        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function getSlogan(): ?string
    {
        return $this->slogan;
    }

    public function setSlogan(string $slogan): self
    {
        $this->slogan = $slogan;
        return $this;
    }

    public function getPhoneNumber(): ?string
    {
        return $this->phoneNumber;
    }

    public function setPhoneNumber(string $phoneNumber): self
    {
        $this->phoneNumber = $phoneNumber;
        return $this;
    }

    public function getAdress(): ?string
    {
        return $this->adress;
    }

    public function setAdress(string $adress): self
    {
        $this->adress = $adress;
        return $this;
    }

    public function getWebsiteUrl(): ?string
    {
        return $this->websiteUrl;
    }

    public function setWebsiteUrl(string $websiteUrl): self
    {
        $this->websiteUrl = $websiteUrl;
        return $this;
    }

    public function getPictureUrl(): ?string
    {
        return $this->pictureUrl;
    }

    public function setPictureUrl(?string $pictureUrl): self
    {
        $this->pictureUrl = $pictureUrl;
        return $this;
    }

    public function getMaster(): ?Master
    {
        return $this->master;
    }

    public function setMaster(?Master $master): self
    {
        $this->master = $master;
        return $this;
    }
  
}
