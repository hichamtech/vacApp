<?php

namespace App\Entity;

use App\Repository\ReviewRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * @ORM\Entity(repositoryClass=ReviewRepository::class)
 * @Vich\Uploadable
 */
class Review
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="reviews")
     */
    private $reviewer;

    /**
     * @ORM\ManyToOne(targetEntity=Destination::class, inversedBy="reviews")
     */
    private $destination;

    /**
     * @ORM\Column(type="text")
     */
    private $content;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $notation;

    /**
     * @ORM\Column(type="string",length=255, nullable=true)
     * @var string
     */
    private $filename = null;

    /**
     * @Vich\UploadableField(mapping="review_image", fileNameProperty="filename")
     * @Assert\Image(
     * mimeTypes="image/jpeg")
     * @var File
     */
    private $imageFile;

    /**
     * @ORM\Column(type="datetime",nullable=true)
     */
    private $updatedAt;

    /**
     * @ORM\Column(type="integer")
     */
    private $likes = 0;

    /**
     * @ORM\Column(type="datetime",columnDefinition="DATETIME on update CURRENT_TIMESTAMP")
     */
    private $createdAt;

    /**
     * Review constructor.
     * @param $id
     */
    public function __construct()
    {
        $this->createdAt = new \DateTimeImmutable('now');

    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getReviewer(): ?User
    {
        return $this->reviewer;
    }

    public function setReviewer(?User $reviewer): self
    {
        $this->reviewer = $reviewer;

        return $this;
    }

    public function getDestination(): ?Destination
    {
        return $this->destination;
    }

    public function setDestination(?Destination $destination): self
    {
        $this->destination = $destination;

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

    public function getNotation(): ?string
    {
        return $this->notation;
    }

    public function setNotation(string $notation): self
    {
        $this->notation = $notation;

        return $this;
    }
    /**
     * @return string|null
     */
    public function getFilename(): ?string
    {
        return $this->filename;
    }

    /**
     *@return File|null
     */
    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }

    /**
     * @param null|string $filename
     * @return User
     */
    public function setFilename(?string $filename): Review
    {
        $this->filename = $filename;
        return $this;
    }

    /**
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile $imageFile
     */
    public function setImageFile(?File $imageFile = null): Review
    {
        $this->imageFile = $imageFile;
        if (null != $imageFile) {
            if ($this->imageFile instanceof UploadedFile) {
                $this->updatedAt = new \DateTime('now');
            }
        }
        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getLikes(): ?int
    {
        return $this->likes;
    }

    public function setLikes(int $likes): self
    {
        $this->likes = $likes;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }
}
