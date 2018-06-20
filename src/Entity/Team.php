<?php declare(strict_types=1);
/**
 * Created by PhpStorm.
 * User: bgph
 * Date: 6/20/18
 * Time: 22:41
 */

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="team")
 */
class Team
{
    public const GROUP_SHOW_TEAM = 'show_team';

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
     * @Assert\Length(min="3", max="30",
     *     maxMessage="Team's name should be longer then 3", minMessage="Team's name should be shorter then 30")
     * @Assert\NotBlank(message="Team's name shouldn't be empty")
     * @Groups({League::GROUP_SHOW_LEAGUE, Team::GROUP_SHOW_TEAM})
     * @ORM\Column(type="string")
     */
    private $name;

    /**
     * @var string
     *
     * @Assert\Length(min="3", max="20",
     *     maxMessage="Team's strip should be longer then 3", minMessage="Team's strip should be shorter then 20")
     * @Assert\NotBlank(message="Team's strip shouldn't be empty")
     * @Groups({League::GROUP_SHOW_LEAGUE, Team::GROUP_SHOW_TEAM})
     * @ORM\Column(type="string")
     */
    private $strip;

    /**
     * @var League
     *
     * @Assert\NotBlank(message="Team's league should be selected")
     * @Groups({Team::GROUP_SHOW_TEAM})
     * @ORM\ManyToOne(targetEntity="App\Entity\League")
     * @ORM\JoinColumn(name="league_id", referencedColumnName="id", onDelete="CASCADE")
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
     * @return mixed
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getStrip(): string
    {
        return $this->strip;
    }

    /**
     * @return League
     */
    public function getLeague(): League
    {
        return $this->league;
    }
}