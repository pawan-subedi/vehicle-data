<?php
include_once(dirname(__FILE__) .'/../tools/JsonDecode.php');
class Make extends JsonDecode
{
    /** @var int */
    protected $Make_ID;
    /** @var string */
    protected $Make_Name;

    /**
     * @return int
     */
    public function getMakeID(): int
    {
        return $this->Make_ID;
    }

    /**
     * @param int $Make_ID
     * @return Make
     */
    public function setMakeID(int $Make_ID): Make
    {
        $this->Make_ID = $Make_ID;
        return $this;
    }

    /**
     * @return string
     */
    public function getMakeName(): string
    {
        return $this->Make_Name;
    }

    /**
     * @param string $Make_Name
     * @return Make
     */
    public function setMakeName(string $Make_Name): Make
    {
        $this->Make_Name = $Make_Name;
        return $this;
    }



}