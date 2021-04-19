<?php
include_once(dirname(__FILE__) .'/data.php');
class Series implements JsonSerializable
{
    /** @var string */
    protected $name;

    /** @var Data[] */
    protected $data = array();

    /** @var int */
    protected $id;

    /**
     * @var bool
     */
    protected $visible = false;


    public function jsonSerialize()
    {
        return [
            'name' => $this->name,
            'data' => $this->data,
            'visible' => $this->visible,
        ];
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return Data[]
     */
    public function getData(): array
    {
        return $this->data;
    }

    /**
     * @param Data[] $data
     */
    public function setData(array $data): void
    {
        $this->data = $data;
    }

    public function pushData(Data $data)
    {
        array_push($this->data, $data);
    }

    /**
     * @return bool
     */
    public function isVisible(): bool
    {
        return $this->visible;
    }

    /**
     * @param bool $visible
     */
    public function setVisible(bool $visible): void
    {
        $this->visible = $visible;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }


}