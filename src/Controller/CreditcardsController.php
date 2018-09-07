<?php

namespace App\Controller;

use App\Entity\Creditcard;

use App\Repository\CreditcardRepository;

use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\Serializer\Annotation\Groups;
use FOS\RestBundle\Controller\FOSRestController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;


class CreditcardsController extends FOSRestController
{
	private $creditcardRepository; 
	private $em;  


	public function __construct(creditcardRepository $creditcardRepository, EntityManagerInterface $em)
	{
		$this->creditcardRepository = $creditcardRepository;   
		$this->em = $em;
	} 

	/**
	* @Rest\View(serializerGroups={"creditcard"})
	*/
	public function getCreditcardsAction()
	{
		$cards = $this->creditcardRepository->findAll();       
		return $this->view($cards); 
	}

    public function getCreditcardAction($id)
	{
		$card = $this->creditcardRepository->find($id);       
		return $this->view($card); 
	}

	/**
	* @Rest\Post("/creditcards")
    * @ParamConverter("creditcard", converter="fos_rest.request_body")
    * @Rest\View(serializerGroups={"creditcard"})
	*/
	public function postCreditcardsAction(Creditcard $creditcard)
	{		
		$master = $this->getUser();
		$master->getCompany();

		$creditcard->setCompany($master->getCompany());

		$this->em->persist($creditcard);
        $this->em->flush();
        return $this->view($creditcard, 201);
	}


}