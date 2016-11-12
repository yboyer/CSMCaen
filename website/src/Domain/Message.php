<?php

namespace YF\Domain;

class Message extends Domain
{
    private $id;
    private $content;
    private $date;
    private $positive;
    private $negative;
    private $neutral;
    private $sentiment;

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    public function getContent()
    {
        return $this->content;
    }

    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    public function getDate()
    {
        return $this->date;
    }

    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    public function getPositive()
    {
        return $this->positive;
    }

    public function setPositive($positive)
    {
        $this->positive = $positive;

        return $this;
    }

    public function getNegative()
    {
        return $this->negative;
    }

    public function setNegative($negative)
    {
        $this->negative = $negative;

        return $this;
    }

    public function getNeutral()
    {
        return $this->neutral;
    }

    public function setNeutral($neutral)
    {
        $this->neutral = $neutral;

        return $this;
    }

    public function getSentiment()
    {
        return $this->sentiment;
    }

    public function setSentiment($sentiment)
    {
        $this->sentiment = $sentiment;

        return $this;
    }
}
