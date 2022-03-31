<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\TechnologyRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Core\Annotation\ApiSubresource;

/**
 * @ApiResource(
 * normalizationContext={"groups"={"technology:get"}, "skip_null_values" = false },
 *      collectionOperations={
 *          "get"={"groups"={"technologies:get"}},
 *          "post"={"security"="is_granted('ROLE_ADMIN')", "denormalization_context"={"groups"="denormalization_technologies:post"}},
 *      },
 *      itemOperations={
 *          "get"={"groups"={"technology:get"}},
 *          "put"={"groups"={"technology:put"}, "security"="is_granted('ROLE_ADMIN')", "denormalization_context"={"groups"="denormalization_barcode:put"}},
 *          "delete"={"security"="is_granted('ROLE_ADMIN')"},
 *      }
 * )
 * @ORM\Entity(repositoryClass=TechnologyRepository::class)
 */
class Technology
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"technology:get","technologies:get"})
     */ 
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"technology:get","technologies:get", "denormalization_technologies:post", "technology:put"})
     */
    private $title;

    /**
     * @ORM\Column(type="text")
     * @Groups({"technology:get","technologies:get", "denormalization_technologies:post", "technology:put"})
     */
    private $picture;

    /**
     * @ORM\Column(type="text")
     * @Groups({"technology:get","technologies:get", "denormalization_technologies:post", "technology:put"})
     */
    private $description;

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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }
}
