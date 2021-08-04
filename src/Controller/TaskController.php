<?php


namespace App\Controller;


use App\Service\TaskService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * Class TaskController
 * @package App\Controller
 * @Route("/task" , name="taskController")
 */
class TaskController extends AbstractController
{
    /**
     * @var TaskService
     */
    private $taskService;



    /**
     * TaskController constructor.
     */
    public function __construct(TaskService $taskService)
    {
        $this->taskService = $taskService;
    }


    /**
    * @return Response
    * @Route("/new", name="newTask" , methods={"POST"})
    */
   public function newTask(Request $request){
       $new = $this->taskService->create($request->getContent());
      if($new['error']){
          return new Response($new ,Response::HTTP_INTERNAL_SERVER_ERROR);
      }else{
          return new Response($new , Response::HTTP_OK);
      }

   }

    /**
     * @return Response
     * @Route("/{id}", name="editTask" , methods={"PUT"})
     */
    public function editTask(String $id){
         $updated = $this->taskService->update($id);

         if($updated['error'])
         {
             return  new JsonResponse($updated , Response::HTTP_INTERNAL_SERVER_ERROR);
         }
         else{

             return  new JsonResponse($updated, Response::HTTP_OK);
         }


    }

    /**
     * @return JsonResponse
     * @Route("/delete/{id}", name="" , methods={"DELETE"})
     */
    public function deleteTask(String $id){

          $deleted = $this->taskService->remove($id);

          if($deleted['error'])
          {
              return new JsonResponse($deleted, Response::HTTP_INTERNAL_SERVER_ERROR);

          }else{
              return new JsonResponse($deleted, Response::HTTP_OK);
          }
    }

    /**
     * @return Response
     * @Route("/" , name="tasks" , methods={"GET"})
     */
    public function getTasks() {
        $tasks = $this->taskService->findAll();
        return new JsonResponse($tasks);
    }

    /**
     * @return JsonResponse
     * @Route("/clear" , name="clearCompleted" , methods={"DELETE"})
     */
    public function deleteCompleted(){
        $deleted = $this->taskService->removeCompleted();

        if($deleted['error'])
        {
            return new JsonResponse($deleted, Response::HTTP_INTERNAL_SERVER_ERROR);

        }else{
            return new JsonResponse($deleted, Response::HTTP_OK);
  
      }
    }


}