<?php


namespace App\Manager;


use App\Document\Task;
use Doctrine\ODM\MongoDB\DocumentManager;


class TaskManager
{
    /**
     * @var DocumentManager
     */
    private $dm ;

    /**
     * TaskManager constructor.
     * @param DocumentManager $dm
     */
    public function __construct(DocumentManager $dm)
    {
        $this->dm = $dm;
    }

    /**
     * return Task Repository
     */
    public function getTaskRepository(){
        return $this->dm->getRepository(Task::class);
    }

    /**
     * @return object[]
     *
     */
    public function findAll(){
        return  $this->getTaskRepository()->findAll();
    }

    /**
     * @param $id
     * @return object|null
     */
    public function getById($id){
        return $this->getTaskRepository()->find($id);
    }

    /**
     * @param $id
     * @return array|bool
     */
    public function remove($id){
        try{
            $task = $this->getById($id);
            if(!$task)
                throw new \Exception('task not found');
            $this->dm->remove($task);
            $this->dm->flush();
            return true;
        }catch(\Throwable $th){
          return [
              'error' => true ,
              'message' => $th->getMessage()
              ] ;
        }
    }

    /**
     * @return array|bool
     */
    public function removeCompleted(){
        try{
           $this->getTaskRepository()->removeCompleted();
           return true;
        }catch(\Throwable $th)
        {
            return [
                'error' => true,
                'message' => $th->getMessage()
                ];
        }
    }

    /**
     * @param $id
     * @return array|bool
     */
    public function updateCompleteField($id){
        try{
            /**
             * @var Task $task
             */
            $task = $this->getById($id);
            if(!$task)
                throw new \Exception('task not found');

            $task->setComplete(!$task->isComplete());
            $this->dm->persist($task);
            $this->dm->flush();
            return true;

        }catch(\Throwable $th)
        {
            return [
                'error' => true,
                'message' => $th->getMessage()
                ];
        }
    }

    /**
     * @param $task
     * @throws \Doctrine\ODM\MongoDB\MongoDBException
     */
    public function create($task){
        try {
            $this->dm->persist($task);
            $this->dm->flush();
            return true;
        }catch (\Throwable $th)
        {
            return [
                'error' => true,
                'message' => $th->getMessage()
            ];
        }

    }

}