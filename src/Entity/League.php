<?php declare(strict_types=1);
/**
 * Created by PhpStorm.
 * User: bgph
 * Date: 6/20/18
 * Time: 22:40
 */

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\PersistentCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="Doctrine\ORM\EntityRepository")
 * @ORM\Table(name="league")
 */
class League
{
    public const GROUP_SHOW_LEAGUE = 'show_league';

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
     * @Assert\Length(min="3", max="20",
     *     maxMessage="League's name should be longer then 3", minMessage="League's name should be shorter then 20")
     * @Assert\NotBlank(message="League's name shouldn't be empty")
     * @Groups({League::GROUP_SHOW_LEAGUE, Team::GROUP_SHOW_TEAM})
     * @ORM\Column(type="string")
     */
    private $name;

    /**
     * @var Team[]
     *
     * @Groups({League::GROUP_SHOW_LEAGUE})
     * @ORM\OneToMany(targetEntity="App\Entity\Team", mappedBy="league", cascade={"remove"})
     */
    private $teams;

    public function __construct()
    {
        $this->teams = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return PersistentCollection|Team[]
     */
    public function getTeams(): PersistentCollection
    {
        return $this->teams;
    }
}