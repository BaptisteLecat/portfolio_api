<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\CourseRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Core\Annotation\ApiSubresource;

/**
 * @ApiResource(
 * normalizationContext={"groups"={"course:get"}, "skip_null_values" = false },
 *      collectionOperations={
 *          "get"={"groups"={"courses:get"}},
 *          "post"={"security"="is_granted('ROLE_ADMIN')", "denormalization_context"={"groups"="denormalization_courses:post"}},
 *      },
 *      itemOperations={
 *          "get"={"groups"={"course:get"}},
 *          "put"={"groups"={"course:put"}, "security"="is_granted('ROLE_ADMIN')", "denormalization_context"={"groups"="denormalization_barcode:put"}},
 *          "delete"={"security"="is_granted('ROLE_ADMIN')"},
 *      }
 * )
 * @ORM\Entity(repositoryClass=CourseRepository::class)
 */
class Course
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"course:get","courses:get"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"course:get","courses:get", "denormalization_courses:post", "course:put"})
     */
    private $title;

    /**
     * @ORM\Column(type="text")
     * @Groups({"course:get","courses:get", "denormalization_courses:post", "course:put"})
     */
    private $picture;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"course:get","courses:get", "denormalization_courses:post", "course:put"})
     */
    private $time;

    /**
     * @ORM\Column(type="text")
     * @Groups({"course:get","courses:get", "denormalization_courses:post", "course:put"})
     */
    private $description;

    /**
     * @ORM\ManyToOne(targetEntity=Location::class, inversedBy="courses")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"course:get","courses:get", "denormalization_courses:post", "course:put"})
     */
    private $location;

    /**
     * @ORM\ManyToOne(targetEntity=School::class, inversedBy="courses")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"course:get","courses:get", "denormalization_courses:post", "course:put"})
     */
    private $school;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getPicture(): ?string
    {
        return $this->picture;
    }

    public function setPicture(string $picture): self
    {
        $this->picture = $picture;

        return $this;
    }

    public function getTime(): ?string
    {
        return $this->time;
    }

    public function setTime(string $time): self
    {
        $this->time = $time;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getLocation(): ?Location
    {
        return $this->location;
    }

    public function setLocation(?Location $location): self
    {
        $this->location = $location;

        return $this;
    }

    public function getSchool(): ?School
    {
        return $this->school;
    }

    public function setSchool(?School $school): self
    {
        $this->school = $school;

        return $this;
    }
}
