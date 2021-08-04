<?php


namespace App\Repository;


use Doctrine\ODM\MongoDB\Repository\DocumentRepository;

class TaskRepository extends  DocumentRepository
{

     public function removeCompleted(){
         return $this->createQueryBuilder()
             ->remove()
             ->field('complete')
             ->equals(true)
             ->getQuery()
             ->execute();
     }
}