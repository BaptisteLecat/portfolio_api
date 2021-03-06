<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\LocationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Core\Annotation\ApiSubresource;

/**
 * @ApiResource(
 * normalizationContext={"groups"={"location:get"}, "skip_null_values" = false },
 *      collectionOperations={
 *          "get"={"groups"={"locations:get"}},
 *          "post"={"security"="is_granted('ROLE_ADMIN')", "denormalization_context"={"groups"="denormalization_locations:post"}},
 *      },
 *      itemOperations={
 *          "get"={"groups"={"location:get"}},
 *          "put"={"groups"={"location:put"}, "security"="is_granted('ROLE_ADMIN')", "denormalization_context"={"groups"="denormalization_barcode:put"}},
 *          "delete"={"security"="is_granted('ROLE_ADMIN')"},
 *      }
 * )
 * @ORM\Entity(repositoryClass=LocationRepository::class)
 */
class Location
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"location:get","locations:get", "company:get","companies:get", "course:get","courses:get", "school:get","schools:get", "work:get","works:get"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"location:get","locations:get", "denormalization_locations:post", "location:put", "company:get","companies:get", "course:get","courses:get", "school:get","schools:get", "work:get","works:get"})
     */
    private $label;

    /**
     * @ORM\Column(type="float", nullable=true)
     * @Groups({"location:get","locations:get", "denormalization_locations:post", "location:put", "company:get","companies:get", "course:get","courses:get", "school:get","schools:get", "work:get","works:get"})
     */
    private $latitude;

    /**
     * @ORM\Column(type="float", nullable=true)
     * @Groups({"location:get","locations:get", "denormalization_locations:post", "location:put", "company:get","companies:get", "course:get","courses:get", "school:get","schools:get", "work:get","works:get"})
     */
    private $longitude;

    /**
     * @ORM\OneToMany(targetEntity=School::class, mappedBy="location", orphanRemoval=true)
     * @ApiSubresource(maxDepth=1)
     */
    private $schools;

    /**
     * @ORM\OneToMany(targetEntity=Company::class, mappedBy="location", orphanRemoval=true)
     * @ApiSubresource(maxDepth=1)
     */
    private $companies;

    /**
     * @ORM\OneToMany(targetEntity=Work::class, mappedBy="location", orphanRemoval=true)
     * @ApiSubresource(maxDepth=1)
     */
    private $works;

    /**
     * @ORM\OneToMany(targetEntity=Course::class, mappedBy="location", orphanRemoval=true)
     * @ApiSubresource(maxDepth=1)
     */
    private $courses;

    public function __construct()
    {
        $this->schools = new ArrayCollection();
        $this->companies = new ArrayCollection();
        $this->works = new ArrayCollection();
        $this->courses = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function setLabel(?string $label): self
    {
        $this->label = $label;

        return $this;
    }

    public function getLatitude(): ?float
    {
        return $this->latitude;
    }

    public function setLatitude(?float $latitude): self
    {
        $this->latitude = $latitude;

        return $this;
    }

    public function getLongitude(): ?float
    {
        return $this->longitude;
    }

    public function setLongitude(?float $longitude): self
    {
        $this->longitude = $longitude;

        return $this;
    }

    /**
     * @return Collection<int, School>
     */
    public function getSchools(): Collection
    {
        return $this->schools;
    }

    public function addSchool(School $school): self
    {
        if (!$this->schools->contains($school)) {
            $this->schools[] = $school;
            $school->setLocation($this);
        }

        return $this;
    }

    public function removeSchool(School $school): self
    {
        if ($this->schools->removeElement($school)) {
            // set the owning side to null (unless already changed)
            if ($school->getLocation() === $this) {
                $school->setLocation(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Company>
     */
    public function getCompanies(): Collection
    {
        return $this->companies;
    }

    public function addCompany(Company $company): self
    {
        if (!$this->companies->contains($company)) {
            $this->companies[] = $company;
            $company->setLocation($this);
        }

        return $this;
    }

    public function removeCompany(Company $company): self
    {
        if ($this->companies->removeElement($company)) {
            // set the owning side to null (unless already changed)
            if ($company->getLocation() === $this) {
                $company->setLocation(null);
            }
        }

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
            $work->setLocation($this);
        }

        return $this;
    }

    public function removeWork(Work $work): self
    {
        if ($this->works->removeElement($work)) {
            // set the owning side to null (unless already changed)
            if ($work->getLocation() === $this) {
                $work->setLocation(null);
            }
        }

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
            $course->setLocation($this);
        }

        return $this;
    }

    public function removeCourse(Course $course): self
    {
        if ($this->courses->removeElement($course)) {
            // set the owning side to null (unless already changed)
            if ($course->getLocation() === $this) {
                $course->setLocation(null);
            }
        }

        return $this;
    }
}
