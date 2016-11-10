<?php

namespace YF\Domain;

class Match extends Domain
{
    private $date;
    private $team;
    private $nbMessages;

    /**
     * Get the value of Date.
     *
     * @return mixed
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set the value of Date.
     *
     * @param mixed date
     *
     * @return self
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get the value of Team.
     *
     * @return mixed
     */
    public function getTeam()
    {
        return $this->team;
    }

    /**
     * Set the value of Team.
     *
     * @param mixed team
     *
     * @return self
     */
    public function setTeam($team)
    {
        $this->team = $team;

        return $this;
    }

    /**
     * Get the value of Nb Messages.
     *
     * @return mixed
     */
    public function getNbMessages()
    {
        return $this->nbMessages;
    }

    /**
     * Set the value of Nb Messages.
     *
     * @param mixed nbMessages
     *
     * @return self
     */
    public function setNbMessages($nbMessages)
    {
        $this->nbMessages = $nbMessages;

        return $this;
    }
}
