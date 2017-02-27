<?php

class Gig extends BaseModel {

    public $id, $band_id, $time, $date, $location;

    public function __construct($attributes) {
        parent::__construct($attributes);
        $this->validators = array('validate_time', 'validate_date', 'validate_location');
    }

    // Function to find data object from table Concert when id is known
    public static function find_with_id($id) {
        
        $query = DB::connection()->prepare('SELECT * FROM Concert WHERE id = :id');
        $query->execute(array('id' => $id));
        
        $row = $query->fetch();
        
        if ($row) {
            $gig = new Gig(array(
                'id' => $row['id'],
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

    // Function to find data objects from table Concert when band is known
    public static function find_all_by_band($id) {

        $query = DB::connection()->prepare('SELECT * FROM Concert WHERE band_id = :id');
        $query->execute(array('id' => $id));

        $rows = $query->fetchAll();
        $gigs = array();

        foreach ($rows as $row) {
            $gigs[] = new Gig(array('id' => $row['id'], 'band_id' => $row['band_id'], 'time' =>
                $row['gigtime'], 'date' => $row['gigdate'], 'location' => $row['location']));
        }

        return $gigs;
    }
    
    // Function to find next concert for band with band's id    
    public static function find_bands_next_gig($id) {
        
        $query = DB::connection()->prepare('SELECT * FROM Concert WHERE band_id = :id ORDER BY (gigdate) DESC LIMIT 1');
        $query->execute(array('id' => $id));
        
        $row = $query->fetch();
        
        if ($row) {
            $gig = new Gig(array(
                'id' => $row['id'],
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

    // Function to save a new data object into table Concert    
    public function save() {

        $query = DB::connection()->prepare('INSERT INTO Concert (band_id, gigtime, gigdate, location) '
                . 'VALUES (:band_id, :time, :date, :location) RETURNING id');
        $query->execute(array(
            'band_id' => $this->band_id,
            'time' => $this->time,
            'date' => $this->date,
            'location' => $this->location));
        
        $row = $query->fetch();
        
        $this->id = $row['id'];
    }

    // Function to update a data object based on its id    
    public static function update($params) {

        $updates = array(
            'time' => $params['time'],
            'date' => $params['date'],
            'location' => $params['location'],
            'id' => $params['id']
        );
        
        $query = DB::connection()->prepare('UPDATE Concert SET gigtime = :time, '
                . 'gigdate = :date, location = :location WHERE id = :id');

        $query->execute($updates);        
    }

    // Function to delete a data object    
    public static function delete($id) {

        $query = DB::connection()->prepare('DELETE FROM Concert WHERE id = :id');

        $query->execute(array('id' => $id));
    }
    
    // Function to validate the string length of concert location    
    public function validate_location() {
        if (parent::validate_string_length($this->location, 2, 100) == false) {
            return 'Please enter a valid location (2-100 characters)';
        }
    }
    
    // Function to validate the time of concert, 24hr clock    
    public function validate_time() {
        return parent::validate_time($this->time);
    }
    
    // Function to validate the date of concert    
    public function validate_date() {
        return parent::validate_date($this->date);
    }
}
