<?php

class Gig extends BaseModel {

    public $id, $band_id, $time, $date, $location;

    public function __construct($attributes) {
        parent::__construct($attributes);
    }

    public static function findwithid($id) {
        
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
    
    public static function findAllByBand($id) {

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
    
    public static function findBandsNextGig($id) {
        
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

    public static function delete($id) {

        $query = DB::connection()->prepare('DELETE FROM Concert WHERE id = :id');

        $query->execute(array('id' => $id));
    }
}
