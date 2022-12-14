<?php

namespace App\Entity;

use App\Repository\GigRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: GigRepository::class)]
class Gig
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $dateStart = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $dateEnd = null;

    #[ORM\ManyToOne(inversedBy: 'gigs')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Pub $pub = null;

    #[ORM\OneToMany(mappedBy: 'gig', targetEntity: Participant::class, orphanRemoval: true)]
    private Collection $participants;
    private $gigs;

    public function __construct()
    {
        $this->participants = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateStart(): ?\DateTimeInterface
    {
        return $this->dateStart;
    }

    public function setDateStart(\DateTimeInterface $dateStart): self
    {
        $this->dateStart = $dateStart;

        return $this;
    }

    public function getDateEnd(): ?\DateTimeInterface
    {
        return $this->dateEnd;
    }

    public function setDateEnd(?\DateTimeInterface $dateEnd): self
    {
        $this->dateEnd = $dateEnd;

        return $this;
    }

    public function getPub(): ?Pub
    {
        return $this->pub;
    }

    public function setPub(?Pub $pub): self
    {
        $this->pub = $pub;

        return $this;
    }
    public function getManager(): ?Manager
    {
        return $this->manager;
    }

    public function setManager(?Manager $manager): self
    {
        $this->manager = $manager;

        return $this;
    }

    /**
     * @return Collection<int, Participant>
     */
    public function getParticipants(): Collection
    {
        return $this->participants;
    }

    public function addParticipant(Participant $participant): self
    {
        if (!$this->participants->contains($participant)) {
            $this->participants->add($participant);
            $participant->setGig($this);
        }

        return $this;
    }

    public function removeParticipant(Participant $participant): self
    {
        if ($this->participants->removeElement($participant)) {
            // set the owning side to null (unless already changed)
            if ($participant->getGig() === $this) {
                $participant->setGig(null);
            }
        }

        return $this;
    }

    public function getFullName(): string
    {
        return $this->getFirstName() . ' ' . $this->getLastName();

    }

    public function addGig(Gig $gig): self //ajoute le concert dans la table concert
    {
        if (!$this->gigs->contains($gig)) {
            $this->gigs->add($gig);
            $gig->setPub($this);
        }

        return $this;
    }

    public function removeGig(Gig $gig): self
    {
        if ($this->gigs->removeElement($gig)) {
            // set the owning side to null (unless already changed)
            if ($gig->getPub() === $this) {
                $gig->setPub(null);
            }
        }

        return $this;
    }


}
