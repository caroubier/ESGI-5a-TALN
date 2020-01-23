<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\LyricEntityRepository")
 */
class LyricEntity
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

     /**
     * @ORM\Column(type="string", length=250, nullable=true)
     */
    private $id1;

    /**
     * @ORM\Column(type="string", length=250, nullable=true)
     */
    private $song;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $annee;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $artist;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $genre;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $word0;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $word1;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $word2;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $word3;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $word4;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $word5;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $word6;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $word7;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $word8;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $word9;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getId1(): ?string
    {
        return $this->id1;
    }

    public function setId1(?string $id1): self
    {
        $this->id1 = $id1;

        return $this;
    }


    public function getSong(): ?string
    {
        return $this->song;
    }

    public function setSong(?string $song): self
    {
        $this->song = $song;

        return $this;
    }

    public function getAnnee(): ?string
    {
        return $this->annee;
    }

    public function setAnnee(string $annee): self
    {
        $this->annee = $annee;

        return $this;
    }

    public function getArtist(): ?string
    {
        return $this->artist;
    }

    public function setArtist(string $artist): self
    {
        $this->artist = $artist;

        return $this;
    }

    public function getGenre(): ?string
    {
        return $this->genre;
    }

    public function setGenre(string $genre): self
    {
        $this->genre = $genre;

        return $this;
    }

    public function getWord0(): ?string
    {
        return $this->word0;
    }

    public function setWord0(string $word0): self
    {
        $this->word0 = $word0;

        return $this;
    }

    public function getWord1(): ?string
    {
        return $this->word1;
    }

    public function setWord1(string $word1): self
    {
        $this->word1 = $word1;

        return $this;
    }

    public function getWord2(): ?string
    {
        return $this->word2;
    }

    public function setWord2(string $word2): self
    {
        $this->word2 = $word2;

        return $this;
    }

    public function getWord3(): ?string
    {
        return $this->word3;
    }

    public function setWord3(string $word3): self
    {
        $this->word3 = $word3;

        return $this;
    }

    public function getWord4(): ?string
    {
        return $this->word4;
    }

    public function setWord4(string $word4): self
    {
        $this->word4 = $word4;

        return $this;
    }

    public function getWord5(): ?string
    {
        return $this->word5;
    }

    public function setWord5(string $word5): self
    {
        $this->word5 = $word5;

        return $this;
    }

    public function getWord6(): ?string
    {
        return $this->word6;
    }

    public function setWord6(string $word6): self
    {
        $this->word6 = $word6;

        return $this;
    }

    public function getWord7(): ?string
    {
        return $this->word7;
    }

    public function setWord7(string $word7): self
    {
        $this->word7 = $word7;

        return $this;
    }

    public function getWord8(): ?string
    {
        return $this->word8;
    }

    public function setWord8(string $word8): self
    {
        $this->word8 = $word8;

        return $this;
    }

    public function getWord9(): ?string
    {
        return $this->word9;
    }

    public function setWord9(string $word9): self
    {
        $this->word9 = $word9;

        return $this;
    }
}
