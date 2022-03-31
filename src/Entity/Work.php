<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\WorkRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Core\Annotation\ApiSubresource;

/**
 * @ApiResource(
 * normalizationContext={"groups"={"work:get"}, "skip_null_values" = false },
 *      collectionOperations={
 *          "get"={"groups"={"works:get"}},
 *          "post"={"security"="is_granted('ROLE_ADMIN')", "denormalization_context"={"groups"="denormalization_works:post"}},
 *      },
 *      itemOperations={
 *          "get"={"groups"={"work:get"}},
 *          "put"={"groups"={"work:put"}, "security"="is_granted('ROLE_ADMIN')", "denormalization_context"={"groups"="denormalization_barcode:put"}},
 *          "delete"={"security"="is_granted('ROLE_ADMIN')"},
 *      }
 * )
 * @ORM\Entity(repositoryClass=WorkRepository::class)
 */
class Work
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"work:get","works:get"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"work:get","works:get", "denormalization_works:post", "work:put"})
     */
    private $title;

    /**
     * @ORM\Column(type="text")
     * @Groups({"work:get","works:get", "denormalization_works:post", "work:put"})
     */
    private $picture;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"work:get","works:get", "denormalization_works:post", "work:put"})
     */
    private $time;

    /**
     * @ORM\Column(type="text")
     * @Groups({"work:get","works:get", "denormalization_works:post", "work:put"})
     */
    private $description;

    /**
     * @ORM\ManyToOne(targetEntity=Company::class, inversedBy="works")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"work:get","works:get", "denormalization_works:post", "work:put"})
     */
    private $company;

    /**
     * @ORM\ManyToOne(targetEntity=Contract::class, inversedBy="works")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"work:get","works:get", "denormalization_works:post", "work:put"})
     */
    private $contract;

    /**
     * @ORM\ManyToOne(targetEntity=Location::class, inversedBy="works")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"work:get","works:get", "denormalization_works:post", "work:put"})
     */
    private $location;

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

    public function getCompany(): ?Company
    {
        return $this->company;
    }

    public function setCompany(?Company $company): self
    {
        $this->company = $company;

        return $this;
    }

    public function getContract(): ?Contract
    {
        return $this->contract;
    }

    public function setContract(?Contract $contract): self
    {
        $this->contract = $contract;

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
}
