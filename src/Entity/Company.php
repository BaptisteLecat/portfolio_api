<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\CompanyRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Core\Annotation\ApiSubresource;

/**
 * @ApiResource(
 * normalizationContext={"groups"={"company:get"}, "skip_null_values" = false },
 *      collectionOperations={
 *          "get"={"groups"={"companies:get"}},
 *          "post"={"security"="is_granted('ROLE_ADMIN')", "denormalization_context"={"groups"="denormalization_companies:post"}},
 *      },
 *      itemOperations={
 *          "get"={"groups"={"company:get"}},
 *          "put"={"groups"={"company:put"}, "security"="is_granted('ROLE_ADMIN')", "denormalization_context"={"groups"="denormalization_barcode:put"}},
 *          "delete"={"security"="is_granted('ROLE_ADMIN')"},
 *      }
 * )
 * @ORM\Entity(repositoryClass=CompanyRepository::class)
 */
class Company
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"company:get","companies:get", "work:get","works:get", "project:get","projects:get"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"company:get","companies:get", "denormalization_companies:post", "company:put", "work:get","works:get", "project:get","projects:get"})
     */
    private $name;

    /**
     * @ORM\Column(type="text")
     * @Groups({"company:get","companies:get", "denormalization_companies:post", "company:put", "work:get","works:get", "project:get","projects:get"})
     */
    private $description;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"company:get","companies:get", "denormalization_companies:post", "company:put", "work:get","works:get", "project:get","projects:get"})
     */
    private $employees;

    /**
     * @ORM\ManyToOne(targetEntity=Location::class, inversedBy="companies")
     * @Groups({"company:get","companies:get", "denormalization_companies:post", "company:put"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $location;

    /**
     * @ORM\OneToMany(targetEntity=Work::class, mappedBy="company", orphanRemoval=true)
     * @ApiSubresource(maxDepth=1)
     */
    private $works;

    /**
     * @ORM\OneToMany(targetEntity=Project::class, mappedBy="company")
     * @ApiSubresource(maxDepth=1)
     */
    private $projects;

    public function __construct()
    {
        $this->works = new ArrayCollection();
        $this->projects = new ArrayCollection();
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

    public function getEmployees(): ?int
    {
        return $this->employees;
    }

    public function setEmployees(int $employees): self
    {
        $this->employees = $employees;

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
     * @return Collection<int, Work>
     */
    public function getWorks(): Collection
    {
        return $this->works;
    }

    public function addWork(Work $work): self
    {
        if (!$this->works->contains($work)) {
            $this->works[] = $work;
            $work->setCompany($this);
        }

        return $this;
    }

    public function removeWork(Work $work): self
    {
        if ($this->works->removeElement($work)) {
            // set the owning side to null (unless already changed)
            if ($work->getCompany() === $this) {
                $work->setCompany(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Project>
     */
    public function getProjects(): Collection
    {
        return $this->projects;
    }

    public function addProject(Project $project): self
    {
        if (!$this->projects->contains($project)) {
            $this->projects[] = $project;
            $project->setCompany($this);
        }

        return $this;
    }

    public function removeProject(Project $project): self
    {
        if ($this->projects->removeElement($project)) {
            // set the owning side to null (unless already changed)
            if ($project->getCompany() === $this) {
                $project->setCompany(null);
            }
        }

        return $this;
    }
}
