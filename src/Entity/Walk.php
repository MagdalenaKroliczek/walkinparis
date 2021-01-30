<?php

namespace App\Entity;

use App\Repository\WalkRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=WalkRepository::class)
 */
class Walk
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $image;

    /**
     * @ORM\ManyToOne(targetEntity=Account::class, cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $guide;

    /**
     * @ORM\Column(type="float")
     */
    private $price = 0;

    /**
     * @ORM\ManyToMany(targetEntity=Account::class)
     * @ORM\JoinTable(name="walk_visitors",
     *  joinColumns={@ORM\JoinColumn(name="walk_id", referencedColumnName="id")},
     *  inverseJoinColumns={@ORM\JoinColumn(name="account_id", referencedColumnName="id")}
     * )
     */
    private $visitors;

    public function __construct() {
        $this->date =  new \DateTime();
        $this->visitors = new ArrayCollection();
    }

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

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

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

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function hasImage(): bool {
        return $this->image != null;
    }

    public function getGuide(): ?Account
    {
        return $this->guide;
    }

    public function setGuide(Account $guide): self
    {
        $this->guide = $guide;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    /**
     * @return Collection|Account[]
     */
    public function getVisitors(): Collection
    {
        return $this->visitors;
    }

    public function addVisitor(Account $visitor): self
    {
        if (!$this->visitors->contains($visitor)) {
            $this->visitors[] = $visitor;
        }

        return $this;
    }

    public function removeVisitor(Account $visitor): self
    {
        $this->visitors->removeElement($visitor);

        return $this;
    }

    public function isAlreadyBookedBy(Account $visitor): bool {
        return $this->getVisitors()->contains($visitor);
    }
}
