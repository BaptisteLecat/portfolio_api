<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\RubricsRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Core\Annotation\ApiSubresource;

/**
 * @ApiResource(
 * normalizationContext={"groups"={"rubric:get"}, "skip_null_values" = false },
 *      collectionOperations={
 *          "get"={"groups"={"rubrics:get"}},
 *          "post"={"security"="is_granted('ROLE_ADMIN')", "denormalization_context"={"groups"="denormalization_rubrics:post"}},
 *      },
 *      itemOperations={
 *          "get"={"groups"={"rubric:get"}},
 *          "put"={"groups"={"rubric:put"}, "security"="is_granted('ROLE_ADMIN')", "denormalization_context"={"groups"="denormalization_rubric:put"}},
 *          "delete"={"security"="is_granted('ROLE_ADMIN')"},
 *      }
 * )
 * @ORM\Entity(repositoryClass=RubricsRepository::class)
 */
class Rubrics
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"rubric:get","rubrics:get"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"rubric:get","rubrics:get"})
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"rubric:get","rubrics:get"})
     */
    private $subtitle;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"rubric:get","rubrics:get"})
     */
    private $picture;

    /**
     * @ORM\Column(type="text")
     * @Groups({"rubric:get","rubrics:get"})
     */
    private $content;

    /**
     * @ORM\ManyToOne(targetEntity=Project::class, inversedBy="rubrics")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"rubric:get","rubrics:get"})
     */
    private $project;

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

    public function getSubtitle(): ?string
    {
        return $this->subtitle;
    }

    public function setSubtitle(string $subtitle): self
    {
        $this->subtitle = $subtitle;

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

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getProject(): ?Project
    {
        return $this->project;
    }

    public function setProject(?Project $project): self
    {
        $this->project = $project;

        return $this;
    }
}
