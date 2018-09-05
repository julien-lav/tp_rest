<?php 

namespace App\Controller;

use App\Entity\Master;

use App\Repository\MasterRepository;
use Doctrine\ORM\EntityManagerInterface; 
use FOS\RestBundle\Controller\Annotations as Rest; 
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;


use FOS\RestBundle\Controller\FOSRestController; 



class MastersController extends FOSRestController 
{
	private $masterRepository;   

	public function __construct(MasterRepository $masterRepository, EntityManagerInterface $em)   
	{
		$this->masterRepository = $masterRepository;   
		$this->em = $em;
	} 

	public function getUsersAction()
	{
		$users = $this->masterRepository->findAll();       
		return $this->view($users); 
	}

	public function getUserAction($id)
	{
		$user = $this->masterRepository->find($id);    
		return $this->view($user); 
	}

	public function putUserAction($id)
	{

	}

	public function deleteUserAction($id)
	{

	}

}