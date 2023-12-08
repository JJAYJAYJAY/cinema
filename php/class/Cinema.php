<?php
class Cinema{
    private $id;
    private $name;
    private $time;
    private $director;
    private $country;
    private $length;
    private $introduce;

    public function __construct($id,$name,$time,$director,$country,$length,$introduce){
        $this->id=$id;
        $this->name=$name;
        $this->time=$time;
        $this->director=$director;
        $this->country=$country;
        $this->length=$length;
        $this->introduce=$introduce;
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
    public function getName()
    {
        return $this->name;
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
    public function getDirector()
    {
        return $this->director;
    }

    /**
     * @return mixed
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * @return mixed
     */
    public function getLength()
    {
        return $this->length;
    }

    /**
     * @return mixed
     */
    public function getIntroduce()
    {
        return $this->introduce;
    }


}
