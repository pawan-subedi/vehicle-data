<?php


abstract class JsonDecode
{
    /**
     * @param string|array $json
     * @return $this
     */
    public static function Decode($json)
    {
        $className = get_called_class();
        $classInstance = new $className();
        if (is_string($json))
            $json = json_decode($json);

        foreach ($json as $key => $value) {
            if (!property_exists($classInstance, $key)) {
                continue;
            }
            $setter = 'set' . ucwords(str_replace('_','',$key));
            try {
                $classInstance->$setter($value);
            } catch (Throwable $e) {
                $hold = true;
            }


        }
        return $classInstance;
    }
}