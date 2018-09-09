<?php

namespace App\Command;

    
use App\Entity\Master;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class CreateAdminCommand extends Command
{
    protected static $defaultName = 'app:create-admin';

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        parent::__construct();
    }
    protected function configure()
    {
        $this
            ->setDescription('Create an admin')
            ->addArgument('email', InputArgument::REQUIRED, 'Email description')
            ->addArgument('firstname', InputArgument::REQUIRED, 'Firstname description')
            ->addArgument('lastname', InputArgument::REQUIRED, 'Fastname description')
        ;
    }
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);
        $email = $input->getArgument('email');
        $firstname = $input->getArgument('firstname');
        $lastname = $input->getArgument('lastname');
        
        $io->note(sprintf('Create a Admin for email: %s', $email));
        
        $master = new Master();
        
        $master->setEmail($email);
        $master->setFirstname($firstname);
        $master->setLastname($lastname);
        $master->setRoles(['ROLE_ADMIN']);
        
        $this->entityManager->persist($master);
        $this->entityManager->flush();

        $io->success(sprintf('You\'ve created an Admin-user with email: %s - firstname: %s - lastname: %s', $email, $firstname, $lastname));
    }
}