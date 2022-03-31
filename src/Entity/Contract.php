<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\ContractRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Core\Annotation\ApiSubresource;

/**
 * @ApiResource(
 * normalizationContext={"groups"={"contract:get"}, "skip_null_values" = false },
 *      collectionOperations={
 *          "get"={"groups"={"contracts:get"}},
 *          "post"={"security"="is_granted('ROLE_ADMIN')", "denormalization_context"={"groups"="denormalization_contracts:post"}},
 *      },
 *      itemOperations={
 *          "get"={"groups"={"contract:get"}},
 *          "put"={"groups"={"contract:put"}, "denormalization_context"={"groups"="denormalization_barcode:put"}},
 *          "delete"={"security"="is_granted('ROLE_ADMIN')"},
 *      }
 * )
 * @ORM\Entity(repositoryClass=ContractRepository::class)
 */
class Contract
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"contract:get","contracts:get", "work:get","works:get"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"contract:get","contracts:get", "denormalization_contracts:post", "contract:put", "work:get","works:get"})
     */
    private $label;

    /**
     * @ORM\OneToMany(targetEntity=Work::class, mappedBy="contract", orphanRemoval=true)
     * @ApiSubresource(maxDepth=1)
     */
    private $works;

    public function __construct()
    {
        $this->works = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function setLabel(string $label): self
    {
        $this->label = $label;

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
            $work->setContract($this);
        }

        return $this;
    }

    public function removeWork(Work $work): self
    {
        if ($this->works->removeElement($work)) {
            // set the owning side to null (unless already changed)
            if ($work->getContract() === $this) {
                $work->setContract(null);
            }
        }

        return $this;
    }
}
