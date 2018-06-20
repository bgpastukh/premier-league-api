<?php declare(strict_types=1);
/**
 * Created by PhpStorm.
 * User: bgph
 * Date: 6/20/18
 * Time: 22:41
 */

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="team")
 */
class Team
{
    /**
     * @var int
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    private $strip;

    /**
     * @var League
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\League")
     * @ORM\JoinColumn(name="league_id", referencedColumnName="id")
     */
    private $league;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return Team
     */
    public function setId(int $id): self
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return Team
     */
    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getStrip(): string
    {
        return $this->strip;
    }

    /**
     * @param string $strip
     * @return Team
     */
    public function setStrip(string $strip): self
    {
        $this->strip = $strip;
        return $this;
    }

    /**
     * @return League
     */
    public function getLeague(): League
    {
        return $this->league;
    }

    /**
     * @param League $league
     * @return Team
     */
    public function setLeague(League $league): self
    {
        $this->league = $league;
        return $this;
    }
}