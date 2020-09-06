<?php

namespace App\Controller\Admin;

use App\Entity\Country;
use App\Form\CountryType;
use App\Repository\CountryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
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
     * @Route("/admin/countries", name="admin.countries.index")
     * @param PaginatorInterface $paginator
     * @param Request            $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index(PaginatorInterface $paginator, Request $request)
    {
        $count = $this->repository->count([]);

        $countries = $paginator->paginate(
            $this->repository->findAll(),
            $request->query->getInt('page', 1), /*page number*/
            100 /*limit per page*/
        );
        // parameters to template
        return $this->render('admin/country/index.html.twig', [
            'countries' => $countries,
            'count' => $count
        ]);
    }

    /**
     * @Route("/admin/country/new", name="admin.country.new")
     * @Route("/admin/country/{id}", name="admin.country.edit")
     * @param Country  $country
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function create(Country $country = null, Request $request)
    {
        $new = false;
        if(!$country) {
            $country = new Country();
            $new = true;
        }

        $form = $this->createForm(CountryType::class, $country);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $this->em->persist($country);
            $this->em->flush();
            if($new) {
                $this->addFlash('success' , "Country Service successfully created");
            } else {
                $this->addFlash('success' , "Country Service successfully updated");
            }
            return $this->redirectToRoute('admin.countries.index');
        }
        return $this->render('admin/country/create.html.twig', [
            'form' => $form->createView(),
            'new' => $new
        ]);
    }


    /**
     * @Route("/admin/country/delete/{id}", name="admin.country.delete", methods="DELETE")
     * @param Country  $country
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function delete(Country $country, Request $request){
        $submittedToken = $request->request->get('token');
        if($this->isCsrfTokenValid('delete', $submittedToken)){
            $this->em->remove($country);
            $this->em->flush();
            $this->addFlash('success' , "Record Successfully deleted");
        }
        return $this->redirectToRoute('admin.countries.index');
    }

}
