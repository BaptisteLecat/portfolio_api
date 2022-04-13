<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\ProjectRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Core\Annotation\ApiSubresource;

/**
 * @ApiResource(
 * normalizationContext={"groups"={"project:get"}, "skip_null_values" = false },
 *      collectionOperations={
 *          "get"={"groups"={"projects:get"}},
 *          "post"={"security"="is_granted('ROLE_ADMIN')", "denormalization_context"={"groups"="denormalization_projects:post"}},
 *      },
 *      itemOperations={
 *          "get"={"groups"={"project:get"}},
 *          "put"={"groups"={"project:put"}, "security"="is_granted('ROLE_ADMIN')", "denormalization_context"={"groups"="denormalization_project:put"}},
 *          "delete"={"security"="is_granted('ROLE_ADMIN')"},
 *      }
 * )
 * @ORM\Entity(repositoryClass=ProjectRepository::class)
 */
class Project
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"project:get","projects:get","rubric:get","rubrics:get"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"project:get","projects:get","rubric:get","rubrics:get", "denormalization_projects:post"})
     */
    private $name;

    /**
     * @ORM\Column(type="text")
     * @Groups({"project:get","projects:get","rubric:get","rubrics:get", "denormalization_projects:post"})
     */
    private $description;

    /**
     * @ORM\Column(type="text")
     * @Groups({"project:get","projects:get","rubric:get","rubrics:get", "denormalization_projects:post"})
     */
    private $picture;

    /**
     * @ORM\OneToMany(targetEntity=Rubrics::class, mappedBy="project", orphanRemoval=true)
     * @ApiSubresource(maxDepth=1)
     */
    private $rubrics;

    /**
     * @ORM\Column(type="date")
     * @Groups({"project:get","projects:get","rubric:get","rubrics:get", "denormalization_projects:post"})
     */
    private $start;

    /**
     * @ORM\Column(type="date", nullable=true)
     * @Groups({"project:get","projects:get","rubric:get","rubrics:get", "denormalization_projects:post"})
     */
    private $end;

    /**
     * @ORM\ManyToOne(targetEntity=Company::class, inversedBy="projects")
     * @Groups({"project:get","projects:get","rubric:get","rubrics:get", "denormalization_projects:post"})
     */
    private $company;

    /**
     * @ORM\ManyToOne(targetEntity=School::class, inversedBy="projects")
     * @Groups({"project:get","projects:get","rubric:get","rubrics:get", "denormalization_projects:post"})
     */
    private $school;

    public function __construct()
    {
        $this->rubrics = new ArrayCollection();
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

    public function getPicture(): ?string
    {
        return $this->picture;
    }

    public function setPicture(string $picture): self
    {
        $this->picture = $picture;

        return $this;
    }

    /**
     * @return Collection<int, Rubrics>
     */
    public function getRubrics(): Collection
    {
        return $this->rubrics;
    }

    public function addRubric(Rubrics $rubric): self
    {
        if (!$this->rubrics->contains($rubric)) {
            $this->rubrics[] = $rubric;
            $rubric->setProject($this);
        }

        return $this;
    }

    public function removeRubric(Rubrics $rubric): self
    {
        if ($this->rubrics->removeElement($rubric)) {
            // set the owning side to null (unless already changed)
            if ($rubric->getProject() === $this) {
                $rubric->setProject(null);
            }
        }

        return $this;
    }

    public function getStart(): ?\DateTimeInterface
    {
        return $this->start;
    }

    public function setStart(\DateTimeInterface $start): self
    {
        $this->start = $start;

        return $this;
    }

    public function getEnd(): ?\DateTimeInterface
    {
        return $this->end;
    }

    public function setEnd(\DateTimeInterface $end): self
    {
        $this->end = $end;

        return $this;
    }

    public function getCompany(): ?Company
    {
        return $this->company;
    }

    public function setCompany(?Company $company): self
    {
        $this->company = $company;

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
