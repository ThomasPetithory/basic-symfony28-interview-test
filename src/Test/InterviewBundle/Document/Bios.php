<?php
namespace Test\InterviewBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

/**
 * @MongoDB\Document(repositoryClass="Test\InterviewBundle\Repository\BiosRepository")
 */
class Bios
{
    /**
     * @MongoDB\Id
     */
    protected $id;

    /**
     * @MongoDB\Field(name="death", type="date")
     */
    protected $death;

    /**
     * @MongoDB\Field(name="name", type="collection")
     */
    protected $name;

    /**
     * @MongoDB\Field(name="contribs", type="collection")
     */
    protected $contribs;

    /**
     * @MongoDB\Field(name="awards", type="collection")
     */
    protected $awards;


    /**
     * Get id
     *
     * @return id $id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set death
     *
     * @param date $death
     * @return $this
     */
    public function setDeath($death)
    {
        $this->death = $death;
        return $this;
    }

    /**
     * Get death
     *
     * @return date $death
     */
    public function getDeath()
    {
        return $this->death;
    }

    /**
     * Set name
     *
     * @param collection $name
     * @return $this
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * Get name
     *
     * @return collection $name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set contribs
     *
     * @param collection $contribs
     * @return $this
     */
    public function setContribs($contribs)
    {
        $this->contribs = $contribs;
        return $this;
    }

    /**
     * Get contribs
     *
     * @return collection $contribs
     */
    public function getContribs()
    {
        return $this->contribs;
    }

    /**
     * Set awards
     *
     * @param collection $awards
     * @return $this
     */
    public function setAwards($awards)
    {
        $this->awards = $awards;
        return $this;
    }

    /**
     * Get awards
     *
     * @return collection $awards
     */
    public function getAwards()
    {
        return $this->awards;
    }
}
