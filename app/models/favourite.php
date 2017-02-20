<?php

class Favourite extends BaseModel {

    public $band_id, $favourite;

    public function __construct($attributes) {
        parent::__construct($attributes);
    }

    public static function find_all($id) {

        $query = DB::connection()->prepare('SELECT * FROM Band WHERE id IN '
                . '(SELECT favourite FROM BandFavourite WHERE band_id = :id)');
        $query->execute(array('id' => $id));

        $rows = $query->fetchAll();
        $favourites = array();

        foreach ($rows as $row) {
            $favourites[] = new Band(array(
                'bandname' => $row['bandname'],
                'description' => $row['description'],
                'origin' => $row['origin'],
                'id' => $row['id'],
                'username' => $row['username'],
                'password' => $row['password']
            ));
        }

        return $favourites;
    }
    
    public static function is_in_favourites($id) {
        
        $query = DB::connection()->prepare('SELECT favourite FROM BandFavourite WHERE band_id = :id');
        $query->execute(array('id' => $_SESSION['user']));
        
        $rows = $query->fetchAll();
        
        foreach ($rows as $row) {
            if ($row['favourite'] == $id) {
                return true;
            }
        }
        return false;
    }

    public function save() {

        $query = DB::connection()->prepare('INSERT INTO BandFavourite (band_id, favourite) VALUES (:band, :favourite)');

        $query->execute(array('band' => $this->band_id, 'favourite' =>
            $this->favourite));
    }

    public function delete() {

        $query = DB::connection()->prepare('DELETE FROM BandFavourite WHERE favourite = :favourite AND band_id = :band_id');

        $query->execute(array('band_id' => $this->band_id, 'favourite' => $this->favourite));
    }

}
