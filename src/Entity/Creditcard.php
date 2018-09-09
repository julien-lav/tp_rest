<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Entity(repositoryClass="App\Repository\CreditcardRepository")
 */
class Creditcard
{
    /**
     * @ORM\Id()
     * @Groups("company")
     * @Groups("creditcard")
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Groups("creditcard")
     * @Groups("company")
     * @Assert\NotBlank()
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @Groups({"creditcard"})
     * @Assert\NotBlank()
     * @Assert\Length(min="3")
     * @ORM\Column(type="string", length=255)
     */
    private $creditCardType;

    /**
     * @Groups({"creditcard"})
     * @Assert\NotBlank()
     * @ORM\Column(type="string", length=255)
     */
    private $creditCardNumber;

    /**
     * @Assert\NotBlank()
     * @Groups({"creditcard"})
     * @ORM\ManyToOne(targetEntity="App\Entity\Company", inversedBy="creditcards")
     * @ORM\JoinColumn(nullable=false)
     */
    private $company;


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

    public function getCreditCardType(): ?string
    {
        return $this->creditCardType;
    }

    public function setCreditCardType(string $creditCardType): self
    {
        $this->creditCardType = $creditCardType;

        return $this;
    }

    public function getCreditCardNumber(): ?string
    {
        return $this->creditCardNumber;
    }

    public function setCreditCardNumber(string $creditCardNumber): self
    {
        $this->creditCardNumber = $creditCardNumber;

        return $this;
    }

    public function getCompany()
    {
        return $this->company;
    }

    public function setcompany($company)
    {
        $this->company = $company;
        return $this;
    }

/*
    public function addCompany(Company $company): self
    {
        if (!$this->company->contains($company)) {
            $this->company[] = $company;
            $company->setCreditcard($this);
        }

        return $this;
    }

    public function removeCompany(Company $company): self
    {
        if ($this->company->contains($company)) {
            $this->company->removeElement($company);
            // set the owning side to null (unless already changed)
            if ($company->getCreditcard() === $this) {
                $company->setCreditcard(null);
            }
        }

        return $this;
    }
*/
}
