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
    public function getCompanyAction($id)
	{
		$company = $this->companyRepository->find($id);       
		return $this->view($company); 
	}

	/**
	* @Rest\Post("/companies")
    * @ParamConverter("company", converter="fos_rest.request_body")
    * @Rest\View(serializerGroups={"company"})
	*/
	public function postCompaniesAction(Company $company)
	{
		$this->em->persist($company);
        $this->em->flush();
	}

	/*
	* @Rest\View(serializerGroups={"master"})
	*/
	public function putCompanyAction(Request $request, int $id)
	{
		$currentUser = $this->getUser();
		$company = $this->companyRepository->find($id);

		$name = $request->get('name');
        $slogan = $request->get('slogan');
        $phone_number = $request->get('phone_number');
        $adress = $request->get('adress');
        $website_url = $request->get('website_url');
        $picture_url = $request->get('picture_url');

        if($currentUser->getCompany()->getId() === $id)
        {
        	if(isset($name))
        	{
           		$company->setName($name);
           	}
           	if(isset($slogan))
        	{
           		$company->setSlogan($slogan);
           	}
           	if(isset($phone_number))
        	{
           		$company->setPhoneNumber($phone_number);
           	}
           	if(isset($adress))
        	{
           		$company->setAdress($adress);
           	}
           	if(isset($website_url))
           	{
           		$company->setWebsiteUrl($adress);
           	}
           	if(isset($picture_url))
           	{
           		$company->setPictureUrl($picture_url);
           	}
           	/*
           	if(isset($company_id))
        	{
           		$company->setcompany($company_id);
           		//$company->setCompany($currentUser->getCompany())
           	}
           	*/
           	$this->em->persist($company);
            $this->em->flush();

        	//return $this->view($company);
        } else {
        	echo 'NON !'; // trow exception !
        }
	}

}