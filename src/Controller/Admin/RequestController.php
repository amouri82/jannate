<?php

namespace App\Controller\Admin;

use App\Entity\Request as RequestEntity;
use App\Entity\RequestNote as RequestNote;
use App\Repository\RequestRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

class RequestController extends AbstractController
{
    /**
     * @var RequestRepository
     */
    private $repository;

    /**
     * @var EntityManagerInterface
     */
    private $em;

    public function __construct(
        RequestRepository $repository,
        EntityManagerInterface $em
    ) {
        $this->repository = $repository;
        $this->em = $em;
    }

    /**
     * @Route("/admin/request/index", name="admin.requests.index")
     * @param RequestEntity  $requestEntity
     * @param PaginatorInterface $paginator
     * @param Request            $request
     *
     * @return Response
     */
    public function index(PaginatorInterface $paginator, Request $request)
    {
        $count_active = $this->repository->count(['status' => 'active']);
        $count_responsed = $this->repository->count(['status' => 'responsed']);
        $count_allocated = $this->repository->count(['status' => 'allocated']);
        $count_later = $this->repository->count(['status' => 'later']);
        $count_teaching = $this->repository->count(['status' => 'teaching']);            
        $count_archive = $this->repository->count(['status' => 'archive']);
        
        $status = $request->query->get('status');
        $status = $status ?: 'active';

        $requests = $paginator->paginate(
            $this->repository->findBy(['status' => $status],['id' => 'DESC']),
            $request->query->getInt('page', 1), /*page number*/
            20 /*limit per page*/
        );

        return $this->render('admin/request/index.html.twig', [
            'requests' => $requests,
            'count_active' => $count_active,
            'count_responsed' => $count_responsed,
            'count_allocated' => $count_allocated,
            'count_later' => $count_later,
            'count_teaching' => $count_teaching,
            'count_archive' => $count_archive,
            'controller_name' => 'RequestController',
        ]);
    }

    /**
     * @Route("/admin/request/status/{id}", name="admin.request.status", methods="Update")
     * @param RequestEntity  $requestEntity
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function status(RequestEntity $requestEntity, Request $request){
        
        $submittedToken = $request->request->get('token');
        $status = $request->request->get('status');
        
        if($this->isCsrfTokenValid('status', $submittedToken)){
            $requestEntity->setStatus($status);
            $this->em->persist($requestEntity);
            $this->em->flush();
            $this->addFlash('success' , "Status Successfully updated");
        }

        return $this->redirectToRoute('admin.requests.index');
    }   


    /**
     * @Route("/admin/request/delete/{id}", name="admin.request.delete", methods="DELETE")
     * @param RequestEntity  $requestEntity
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function delete(RequestEntity $requestEntity, Request $request){
        $submittedToken = $request->request->get('token');
        if($this->isCsrfTokenValid('delete', $submittedToken)){
            $this->em->remove($requestEntity);
            $this->em->flush();
            $this->addFlash('success' , "Request Successfully deleted");
        }
        return $this->redirectToRoute('admin.requests.index');
    }
    
    /**
     * @Route("/admin/request/sendemail/{id}", name="admin.request.sendemail")
     * @param RequestEntity  $requestEntity
     * @param Request $request
     * @param \Swift_Mailer $mailer
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function sendEmail(RequestEntity $requestEntity, Request $request, \Swift_Mailer $mailer)
    {
        $message = (new \Swift_Message('Online Quran Classes'))
            ->setFrom($this->getParameter('email_sched'), $this->getParameter('company_name_sched'))
            ->setTo($requestEntity->getEmail())
            ->setBody(
                $this->renderView(
                    // templates/emails/registration.html.twig
                    'admin/emails/request.html.twig',
                    ['name' => $requestEntity->getName()]
                ),
                'text/html'
            );
        
        
            // Send email
        $mailer->send($message);
        
        // update sent status
        $requestEntity->setSent(1);
        $this->em->persist($requestEntity);
        $this->em->flush();

        $this->addFlash('success' , "Message sent Successfully");
        return $this->redirectToRoute('admin.requests.index');
    }

    /**
     * @Route("/admin/request/account/{id}", name="admin.request.account")
     * @param RequestEntity  $requestEntity
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function account(RequestEntity $requestEntity, Request $request)
    {
        $parent = [
            'name' => $requestEntity->getName(),
            'email' => $requestEntity->getEmail(),
            'phone' => $requestEntity->getPhone(),
            'city' => $requestEntity->getCity()
        ];
               
        $response = $this->forward('App\Controller\Admin\FamilyController::create', array(
            'createAccountData'  => $parent
        ));

        return $response;        
    }


    /**
     * @Route("/admin/request/note", name="admin.request.note")
     * @param Request $request
     * @return Symfony\Component\HttpFoundation\JsonResponse
     */
    public function note(Request $request)
    {
        
        try {
            parse_str($request->getContent(), $noteForm);
            $request = $this->repository->find( (int) $noteForm['request_id']);
            $note = new RequestNote();
            $note->setRequest($request);
            $note->setComment($noteForm['note']);
            $note->setCreatedAt(new \DateTime("now"));
            $this->em->persist($note);
            $this->em->flush();
            $response = ['status' => 'success'];
        } catch(Exception $e) {
            $response = ['status' => 'error', 'message' => $e->getMessage()];
        }
        
        $response = new JsonResponse($response);
        return $response;
    }

    /**
     * @Route("/admin/request/noteslist", name="admin.request.noteslist")
     * @param Request $request     
     * @return Symfony\Component\HttpFoundation\JsonResponse
     */
    public function notesList(Request $request)
    {
        $request_id = $request->request->get('request_id');
        $request = $this->repository->find( (int) $request_id); 
        $notes = [];
        foreach($request->getRequestNotes() as $note) {
            $date = $note->getCreatedAt();
            $notes[] = ['comment' => $note->getComment(), 'date' => $date->format('Y-m-d H:i:s')];
        }

        $response = new JsonResponse(["notes" => $notes]);        
        return $response;        
    }

    /**
     * @param Request $request     
     * @return Response
     */    
    public function countNewRequests(Request $request) 
    {
        $count = $this->repository->count(['status' => 'active']);

        return $this->render('admin/request/count.html.twig', [
            'count' => $count,
        ]);        
    }

}
