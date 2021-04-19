<?php
include_once(dirname(__FILE__) .'/series.php');
include_once(dirname(__FILE__) .'/../classes/Manufacturer.php');
class Response implements JsonSerializable
{
    /**
     * @var Series[]
     */
    protected $series = array();

    /**
     * @inheritDoc
     */
    public function jsonSerialize()
    {
        return array_values($this->series);
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name): void
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getSeries()
    {
        return $this->series;
    }

    /**
     * @param mixed $series
     */
    public function setSeries($series): void
    {
        $this->series = $series;
    }

    /**
     * @param Manufacturer $details
     * @return Series
     */
    public function findSeries(Manufacturer $details)
    {
        if (isset($this->series[$details->getMfrID()])) {
            return $this->series[$details->getMfrID()];
        }
        $series = new Series();
        $series->setId($details->getMfrID());
        $series->setName($details->getMfrName());
        $this->series[$details->getMfrID()] = $series;
        return $series;
    }
}