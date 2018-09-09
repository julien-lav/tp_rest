<?php 

namespace App\Controller;

use App\Entity\Master;
use App\Repository\MasterRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Serializer\Annotation\Groups;

use FOS\RestBundle\Controller\Annotations as Rest;

use FOS\RestBundle\Controller\FOSRestController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;


class MastersController extends FOSRestController 
{
	private $masterRepository; 
	private $em;  


	public function __construct(MasterRepository $masterRepository, EntityManagerInterface $em)   
	{
		$this->masterRepository = $masterRepository;   
		$this->em = $em;
	} 

	/**
	* @Rest\View(serializerGroups={"master"})
	*/
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
		
        $currentUser = $this->getUser();
		$master = $this->masterRepository->find($id);

		$firstname = $request->get('firstname');
        $lastname = $request->get('lastname');
        $email = $request->get('email');
        //$company = $request->get('company_id');

        if($this->getUser()->getId() === $id || in_array('ROLE_ADMIN', $currentUser->getRoles()))
        { 
        	if(isset($firstname))
        	{
           		$master->setFirstname($firstname);
           	}
            if(isset($lastname))
            {
               $master->setLastname($lastname);
            }
            if(isset($email))
            {
               $master->setEmail($email);
            }
            /*
            if(isset($company))
            {
               $master->setCompany($company);
            }*/
            $this->em->persist($master);
            $this->em->flush();
        }
        return $this->view($master);
	}

	/*
	* @Rest\View(serializerGroups={"master"})
	*/
	public function deleteMasterAction($id)
	{
		$master = $this->masterRepository->find($id);
		$currentUser = $this->getUser();

		if ($this->getUser()->getId() === $id || in_array('ROLE_ADMIN', $currentUser->getRoles()))
		{        
           $this->em->remove($master);
           $this->em->flush();
       }
	}

}