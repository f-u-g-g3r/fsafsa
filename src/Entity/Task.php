<?php

namespace App\Entity;

use App\Repository\TaskRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TaskRepository::class)]
class Task
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $task = null;

    #[ORM\Column(length: 255)]
    private ?string $dueDate = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTask(): ?string
    {
        return $this->task;
    }

    public function setTask(string $task): static
    {
        $this->task = $task;

        return $this;
    }

    public function getDueDate(): ?string
    {
        return $this->dueDate;
    }

    public function setDueDate(string $dueDate): static
    {
        $this->dueDate = $dueDate;

        return $this;
    }

    public function __toString(): string
    {
        return
'{
    "id": "'.$this->id.'", 
    "task": "'.$this->task.'", 
    "dueDate": "'.$this->dueDate.'"
}';
    }


}
