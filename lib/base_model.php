<?php

class BaseModel {

    // "protected"-attribuutti on käytössä vain luokan ja sen perivien luokkien sisällä
    protected $validators;

    public function __construct($attributes = null) {
        // Käydään assosiaatiolistan avaimet läpi
        foreach ($attributes as $attribute => $value) {
            // Jos avaimen niminen attribuutti on olemassa...
            if (property_exists($this, $attribute)) {
                // ... lisätään avaimen nimiseen attribuuttin siihen liittyvä arvo
                $this->{$attribute} = $value;
            }
        }
    }

    public function errors() {
        // Lisätään $errors muuttujaan kaikki virheilmoitukset taulukkona
        $errors = array();

        foreach ($this->validators as $validator) {
            if ($this->{$validator}()) {
                $errors[] = $this->{$validator}();
            }
        }

        return $errors;
    }

    public function validate_string_length($string, $min, $max) {
        if ($string == null) {
            return false;
        }
        if (strlen($string) < $min || strlen($string) > $max) {
            return false;
        }

        return true;
    }

    public function validate_time($time) {
        if (preg_match("/(2[0-3]|[01][0-9]):([0-5][0-9])/", $time) == false) {
            return 'Please enter a valid time in HH:MM format';
        }
    }

    public function validate_date($date) {
        $d = DateTime::createFromFormat('Y-m-d', $date);
        if (($d && $d->format('Y-m-d') === $date) == false) {
            return 'Please enter a valid date in YYYY-MM-DD format';
        }
    }

}
