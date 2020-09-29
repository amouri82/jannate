<?php

namespace App\Controller\Employee\Support;

use App\Entity\Country;
use App\Form\CountryType;
use App\Repository\CountryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class CountryController extends AbstractController
{

    /**
     * @var CountryRepository
     */
    private $repository;

    /**
     * @var EntityManagerInterface
     */
    private $em;

    public function __construct(
        CountryRepository $repository,
        EntityManagerInterface $em
    ) {
        $this->repository = $repository;
        $this->em = $em;
    }

    /**
     * @Route("/employee/support/country/new", name="support.country.new")
     * @param Country  $country
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function create(Country $country = null, Request $request)
    {

        $country = new Country();
        $form = $this->createForm(CountryType::class, $country);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $this->em->persist($country);
            $this->em->flush();
            $this->addFlash('success' , "Country Service successfully created");            
            return $this->redirectToRoute('support.countries.index');
        }
        return $this->render('employee/support/country/create.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
