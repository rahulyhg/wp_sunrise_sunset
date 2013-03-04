<?php

class City
{
    private $_name;
    private $_latitude;
    private $_longitude;
    private $_timezone;
    private $_summerTimezone;

    function __construct($name, $latitude, $longitude, $timezone, $summerTimezone)
    {
        $this->_name = trim($name);
        $this->_latitude = trim($latitude);
        $this->_longitude = trim($longitude);
        $this->_timezone = trim($timezone);
        $this->_summerTimezone = trim($summerTimezone);
    }


    public function setSummerTimezone($summerTimezone)
    {
        $this->_summerTimezone = $summerTimezone;
    }

    public function getSummerTimezone()
    {
        return $this->_summerTimezone;
    }

    public function setTimezone($timezone)
    {
        $this->_timezone = $timezone;
    }

    public function getTimezone()
    {
        return $this->_timezone;
    }

    public function setLatitude($latitude)
    {
        $this->_latitude = $latitude;
    }

    public function getLatitude()
    {
        return $this->_latitude;
    }

    public function setLongitude($longitude)
    {
        $this->_longitude = $longitude;
    }

    public function getLongitude()
    {
        return $this->_longitude;
    }

    public function setName($name)
    {
        $this->_name = $name;
    }

    public function getName()
    {
        return $this->_name;
    }
}
