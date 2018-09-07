<?php

namespace App\Controller;

use App\Entity\Company;
use App\Repository\CompanyRepository;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\Serializer\Annotation\Groups;
use FOS\RestBundle\Controller\FOSRestController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;


class CompaniesController extends FOSRestController
{
	private $companyRepository; 
	private $em;  

	
	public function __construct(companyRepository $companyRepository, EntityManagerInterface $em)   
	{
		$this->companyRepository = $companyRepository;   
		$this->em = $em;
	} 

	/**
	* @Rest\View(serializerGroups={"company"})
	*/
	public function getCompaniesAction()
	{
		$companies = $this->companyRepository->findAll();       
		return $this->view($companies); 
	}

	/**
	* @Rest\View(serializerGroups={"company"})
	*/
    public function getCompanieAction($id)
	{
		$company = $this->companyRepository->find($id);       
		return $this->view($company); 
	}

}