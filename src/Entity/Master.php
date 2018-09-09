<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @UniqueEntity("email")
 * @ORM\Entity(repositoryClass="App\Repository\MasterRepository")
 */
class Master implements UserInterface
{
    /**
     * @Groups("master")
     * @Groups("company")
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Assert\NotBlank()
     * @Assert\Length(min="2")
     * @Groups("master") 
     * @Groups("creditcard")
     * @ORM\Column(type="string", length=255)
     */
    private $firstname;

    /**
     * @Assert\NotBlank()
     * @Assert\Length(min="4")
     * @Groups("master") 
     * @ORM\Column(type="string", length=255)
     */
    private $lastname;

    /**
     * @Assert\Email()
     * @Groups("master")
     * @ORM\Column(type="string", length=255)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $apiKey;

    /**
     * @Groups("master") 
     * @ORM\Column(type="simple_array")
     */
    private $roles;

    /**
     * @Groups("master") 
     * @ORM\OneToOne(targetEntity="App\Entity\Company", inversedBy="master", cascade={"persist", "remove"})
     */
    private $company;


    public function __construct()
    {
        $this->roles = array('ROLE_USER');
        $this->apiKey = uniqid('', true);
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getRoles(): ?array
    {
        return $this->roles;
    }
    public function setRoles(array $roles): self
    {
        $this->roles = $roles;
        return $this;
    }

    public function getApiKey(): ?string
    {
        return $this->apiKey;
    }

    public function setApiKey(string $apiKey): self
    {
        $this->apiKey = $apiKey;
        return $this;
    }

    public function getPassword()
    {
        // TODO: Implement getPassword() method.
    }
    public function getSalt()
    {
        // TODO: Implement getSalt() method.
    }
    public function getUsername()
    {
        // TODO: Implement getUsername() method.
    }
    public function eraseCredentials()
    {
        // TODO: Implement eraseCredentials() method.
    }

    public function getCompany(): ?Company
    {
        return $this->company;
    }

    public function setCompany(?Company $company): self
    {
        $this->company = $company;
        /*$newMaster = $company === null ? null : $this;
        if ($newMaster !== $company->getMaster()) {
            $company->setMaster($newMaster);
        }*/
        return $this;
    }
}
