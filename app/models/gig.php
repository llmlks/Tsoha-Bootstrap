<?php

class Gig extends BaseModel {

    public $band_id, $time, $date, $location;

    public function __construct($attributes) {
        parent::__construct($attributes);
    }

    public static function findAllByBand($id) {

        $query = DB::connection()->prepare('SELECT * FROM Concert WHERE band_id = :id');
        $query->execute(array('id' => $id));

        $rows = $query->fetchAll();
        $gigs = array();

        foreach ($rows as $row) {
            $gigs[] = new Gig(array('band_id' => $row['band_id'], 'time' =>
                $row['gigtime'], 'date' => $row['gigdate'], 'location' => $row['location']));
        }

        return $gigs;
    }
    
    public static function findBandsNextGig($id) {
        
        $query = DB::connection()->prepare('SELECT * FROM Concert WHERE band_id = :id ORDER BY (gigdate) DESC LIMIT 1');
        $query->execute(array('id' => $id));
        
        $row = $query->fetch();
        
        if ($row) {
            $gig = new Gig(array(
                'band_id' => $row['band_id'],
                'time' => $row['gigtime'],
                'date' => $row['gigdate'],
                'location' => $row['location']
            ));
            return $gig;
        } else {
            return null;
        }
    }

    public static function save() {

        $query = DB::connection()->prepare('INSERT INTO Concert (band_id, gigtime, gigdate, location) '
                . 'VALUES (:band_id, :time, :date, :location)');
        $query->execute(array(
            'band_id' => $this->band_id,
            'time' => $this->time,
            'date' => $this->date,
            'location' => $this->location));
    }

    public static function delete() {

        $query = DB::connection()->prepare('DELETE FROM Concert WHERE band_id = :id AND gigtime = :time AND gigdate = :date');

        $query->execute(array('id' => $this->band_id,
            'time' => $this->time,
            'date' => $this->date));
    }

    public static function validate_name($string, $min, $max) {
        parent::validate_string_length($string, 2, 50);
    }

}
