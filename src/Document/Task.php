<?php


namespace App\Document;


use DateTime;
use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use App\Repository\TaskRepository;
/**
 * @MongoDB\Document(repositoryClass=TaskRepository::class)
 * @MongoDB\HasLifecycleCallbacks
 */
class Task implements  \JsonSerializable
{
    /**
     * @MongoDB\Id
     */
    protected String $id;

    /**
     * @MongoDB\Field(type="string")
     */
    protected String $content;

    /**
     * @MongoDB\Field(type="boolean")
     */
    protected bool $complete;


    /**
     * @MongoDB\Field(type="date")
     */
    protected DateTime $creationDate;

    /**
     * Task constructor.
     */
    public function __construct()
    {
        $this->complete = false;
    }


    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getContent() : String
    {
        return $this->content;
    }

    /**
     * @param mixed $content
     */
    public function setContent($content) : void
    {
        $this->content = $content;
    }

    /**
     * @return mixed
     */
    public function getCreationDate() : \DateTime
    {
        return $this->creationDate;
    }

    /**
     * @param $creationDate
     * @MongoDB\PrePersist
     */
    public function setCreationDate(): void
    {
        $this->creationDate = new DateTime('now');
    }


    public function jsonSerialize()
    {
      return [
          "id" => $this->getId(),
          "content" => $this->getContent(),
          "complete" => $this->isComplete(),
          "creationDate" => $this->getCreationDate()
          ];
    }

    /**
     * @MongoDB\PrePersist
     */
    public function validate() : void {
        if(empty($this->getContent())){
            throw new \Error("Content cannot be empty");
        }

    }

    /**
     * @return bool
     */
    public function isComplete(): bool
    {
        return $this->complete;
    }

    /**
     * @param bool $complete
     */
    public function setComplete(bool $complete): void
    {
        $this->complete = $complete;
    }
}