<?php

class Comment
{
    private $id;
    private $who;
    private $cinema;
    private $score;
    private $time;
    private $good;
    private $content;

    public function __construct($id, $who, $cinema, $score, $time, $good, $content)
    {
        $this->id = $id;
        $this->who = $who;
        $this->cinema = $cinema;
        $this->score = $score;
        $this->time = $time;
        $this->good = $good;
        $this->content = $content;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getWho()
    {
        return $this->who;
    }

    /**
     * @return mixed
     */
    public function getCinema()
    {
        return $this->cinema;
    }

    /**
     * @return mixed
     */
    public function getScore()
    {
        return $this->score;
    }

    /**
     * @return mixed
     */
    public function getTime()
    {
        return $this->time;
    }

    /**
     * @return mixed
     */
    public function getGood()
    {
        return $this->good;
    }

    /**
     * @return mixed
     */
    public function getContent()
    {
        return $this->content;
    }

}