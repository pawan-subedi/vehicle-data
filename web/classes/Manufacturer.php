<?php
include_once(dirname(__FILE__) .'/../tools/JsonDecode.php');
class Manufacturer extends JsonDecode implements JsonSerializable
{
    /** @var string */
    protected $Country;
    /** @var string */
    protected $Mfr_CommonName;
    /** @var string */
    protected $Mfr_ID;
    /** @var string */
    protected $Mfr_Name;
    /** @var array */
    protected $VehicleTypes;

    /**
     * @return string
     */
    public function getCountry(): string
    {
        return $this->Country;
    }

    /**
     * @param string $Country
     * @return Manufacturer
     */
    public function setCountry($Country): Manufacturer
    {
        $this->Country = $Country;
        return $this;
    }

    /**
     * @return string
     */
    public function getMfrCommonName(): string
    {
        return $this->Mfr_CommonName;
    }

    /**
     * @param string $Mfr_CommonName
     * @return Manufacturer
     */
    public function setMfrCommonName($Mfr_CommonName): Manufacturer
    {
        $this->Mfr_CommonName = $Mfr_CommonName;
        return $this;
    }

    /**
     * @return string
     */
    public function getMfrID(): string
    {
        return $this->Mfr_ID;
    }

    /**
     * @param string $Mfr_ID
     * @return Manufacturer
     */
    public function setMfrID($Mfr_ID): Manufacturer
    {
        $this->Mfr_ID = $Mfr_ID;
        return $this;
    }

    /**
     * @return string
     */
    public function getMfrName(): string
    {
        return $this->Mfr_Name;
    }

    /**
     * @param string $Mfr_Name
     * @return Manufacturer
     */
    public function setMfrName($Mfr_Name): Manufacturer
    {
        $this->Mfr_Name = $Mfr_Name;
        return $this;
    }

    /**
     * @return array
     */
    public function getVehicleTypes(): array
    {
        return $this->VehicleTypes;
    }

    /**
     * @param array $VehicleTypes
     * @return Manufacturer
     */
    public function setVehicleTypes(array $VehicleTypes): Manufacturer
    {
        $this->VehicleTypes = $VehicleTypes;
        return $this;
    }


    public function jsonSerialize()
    {
        $json = [];
        $reflect = new ReflectionClass($this);
        $properties = $reflect->getProperties(ReflectionProperty::IS_PROTECTED);
        foreach ($properties as $property) {
            $json[$property->getName()] = $this->{$property->getName()};
        }
        return $json;
    }
}