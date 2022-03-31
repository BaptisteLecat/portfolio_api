<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\SchoolRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Core\Annotation\ApiSubresource;

/**
 * @ApiResource(
 * normalizationContext={"groups"={"school:get"}, "skip_null_values" = false },
 *      attributes={"security"="is_granted('ROLE_ADMIN')"},
 *      collectionOperations={
 *          "get"={"groups"={"schools:get"}, "security"="is_granted('ROLE_USER')"},
 *          "post"={"denormalization_context"={"groups"="denormalization_schools:post"}},
 *      },
 *      itemOperations={
 *          "get"={"groups"={"school:get"}, "security"="is_granted('ROLE_USER') or object.getUser() == user"},
 *          "put"={"groups"={"school:put"}, "security"="is_granted('ROLE_ADMIN')", "denormalization_context"={"groups"="denormalization_barcode:put"}},
 *          "delete"={"security"="is_granted('ROLE_ADMIN') or object.getUser() == user"},
 *      }
 * )
 * @ORM\Entity(repositoryClass=SchoolRepository::class)
 */
class School
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"school:get","schools:get", "course:get","courses:get"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"school:get","schools:get", "denormalization_schools:post", "school:put", "course:get","courses:get"})
     */
    private $name;

    /**
     * @ORM\Column(type="text")
     * @Groups({"school:get","schools:get", "denormalization_schools:post", "school:put", "course:get","courses:get"})
     */
    private $description;

    /**
     * @ORM\ManyToOne(targetEntity=Location::class, inversedBy="schools")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"school:get","schools:get", "denormalization_schools:post", "school:put", "course:get","courses:get"})
     */
    private $location;

    /**
     * @ORM\OneToMany(targetEntity=Course::class, mappedBy="school", orphanRemoval=true)
     * @ApiSubresource(maxDepth=1)
     */
    private $courses;

    public function __construct()
    {
        $this->courses = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

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

    /**
     * @return Collection<int, Course>
     */
    public function getCourses(): Collection
    {
        return $this->courses;
    }

    public function addCourse(Course $course): self
    {
        if (!$this->courses->contains($course)) {
            $this->courses[] = $course;
            $course->setSchool($this);
        }

        return $this;
    }

    public function removeCourse(Course $course): self
    {
        if ($this->courses->removeElement($course)) {
            // set the owning side to null (unless already changed)
            if ($course->getSchool() === $this) {
                $course->setSchool(null);
            }
        }

        return $this;
    }

}
