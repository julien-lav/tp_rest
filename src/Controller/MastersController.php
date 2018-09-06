<?php 

namespace App\Controller;

use App\Entity\Master;
use App\Repository\MasterRepository;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;


class MastersController extends FOSRestController 
{
	private $masterRepository; 
	private $em;  


	/**
	* @Rest\View(serializerGroups={"master"})
	*/
	public function __construct(MasterRepository $masterRepository, EntityManagerInterface $em)   
	{
		$this->masterRepository = $masterRepository;   
		$this->em = $em;
	} 

	public function getMastersAction()
	{
		$masters = $this->masterRepository->findAll();       
		return $this->view($masters); 
	}


	public function getMasterAction($id)
	{
		$master = $this->masterRepository->find($id);    
		return $this->view($master); 
	}

	/**
	* @Rest\Post("/masters")
    * @ParamConverter("master", converter="fos_rest.request_body")
    * @Rest\View(serializerGroups={"master"})
	*/
	public function postMastersAction(Master $master)
	{
		$this->em->persist($master);
        $this->em->flush();
        return $this->view($master, 201);
	}

	/*
	* @Rest\View(serializerGroups={"master"})
	*/
	public function putMasterAction(Request $request, int $id)
	{

	}

	/*
	* @Rest\View(serializerGroups={"master"})
	*/
	public function deleteMasterAction($id)
	{

	}

}