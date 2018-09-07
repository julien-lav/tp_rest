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
		$currentUser = $this->getUser();

		if(!empty($currentUser))
		{
			$creditcard->setCompany($currentUser->getCompany());
		} 
		else 
		{
			// find a value by default
			// $company = $request->get('company_id');
			// $creditcard->setCompany($companny);	
		}

		$this->em->persist($creditcard);
        $this->em->flush();
        //return $this->view($creditcard, 201);
	}

	/*
	* @Rest\View(serializerGroups={"master"})
	*/
	public function putCreditcardAction(Request $request, int $id)
	{
		$currentUser = $this->getUser();
		$creditcard = $this->creditcardRepository->find($id);

		$name = $request->get('name');
        $credit_card_type = $request->get('credit_card_type');
        $credit_card_number = $request->get('credit_card_number');
        $company_id = $request->get('company_id');

        if($currentUser->getCompany() === $creditcard->getCompany())
        {
        	if(isset($name))
        	{
           		$creditcard->setName($name);
           	}
           	if(isset($credit_card_type))
        	{
           		$creditcard->setCreditCardType($credit_card_type);
           	}
           	if(isset($credit_card_number))
        	{
           		$creditcard->setCreditCardType($credit_card_number);
           	}
           	/*
           	if(isset($company_id))
        	{
           		$creditcard->setcompany($company_id);
           		//$creditcard->setCompany($currentUser->getCompany())
           	}
           	*/
           	$this->em->persist($creditcard);
            $this->em->flush();

        	//return $this->view($creditcard);
        } else {
        	echo 'NON !'; // trow exception !
        }
	}


}