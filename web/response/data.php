<?php


class Data implements JsonSerializable
{
    /** @var int */
    protected $year;

    /**
     * @var int
     */
    protected $value;

    public function __construct($year,$value)
    {
        $this->year = $year;
        $this->value = $value;
    }

    /**
     * @inheritDoc
     */
    public function jsonSerialize()
    {
        return [$this->year,$this->value];
    }

    /**
     * @return int
     */
    public function getYear(): int
    {
        return $this->year;
    }

    /**
     * @param int $year
     */
    public function setYear(int $year): void
    {
        $this->year = $year;
    }

    /**
     * @return int
     */
    public function getValue(): int
    {
        return $this->value;
    }

    /**
     * @param int $value
     */
    public function setValue(int $value): void
    {
        $this->value = $value;
    }

    
}