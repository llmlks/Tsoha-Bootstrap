<?php

class BandGenre extends BaseModel {

    public $band_id, $genre_id;

    public function __construct($attributes) {
        parent::__construct($attributes);
    }

    // Function to find all genres for band, when band's id is known, using tables Genre and BandGenre  
    public static function find_genres_for_band($id) {

        $query = DB::connection()->prepare('SELECT * FROM Genre WHERE id IN (SELECT genre_id FROM BandGenre WHERE band_id = :band)');
        $query->execute(array('band' => $id));

        $rows = $query->fetchAll();
        $genres = array();

        foreach ($rows as $row) {
            $genres[] = new Genre(array(
                'genrename' => $row['genrename'],
                'id' => $row['id']
            ));
        }

        return $genres;
    }

    // Function to find all bands for genre, when genre's id is known, using tables Genre and BandGenre. Results are orderes by the bands' upvotes
    public static function find_bands_by_genre($id) {

        $query = DB::connection()->prepare('SELECT * FROM Band WHERE id IN (SELECT band_id FROM BandGenre WHERE genre_id = :genre) ORDER BY likes');
        $query->execute(array('genre' => $id));

        $rows = $query->fetchAll();
        $bands = array();

        if ($rows == null) {
            return NULL;
        }

        foreach ($rows as $row) {
            $bands[] = new Band(array(
                'bandname' => $row['bandname'],
                'description' => $row['description'],
                'origin' => $row['origin'],
                'likes' => $row['likes'],
                'id' => $row['id'],
                'username' => $row['username'],
                'password' => $row['password']
            ));
        }

        return $bands;
    }
    
    // Function to find all genres that are not linked to the band, whose id is known.  
    public static function find_genres_excluding_bands($id) {

        $query = DB::connection()->prepare('SELECT * FROM Genre WHERE id NOT IN (SELECT genre_id FROM BandGenre WHERE band_id = :band)');
        $query->execute(array('band' => $id));

        $rows = $query->fetchAll();
        $genres = array();

        foreach ($rows as $row) {
            $genres[] = new Genre(array(
                'genrename' => $row['genrename'],
                'id' => $row['id']
            ));
        }

        return $genres;
        
    }

    // Function to store a new data object into table BandGenre
    public function save() {

        $query = DB::connection()->prepare('INSERT INTO BandGenre (band_id, genre_id) VALUES (:band, :genre)');

        $query->execute(array('band' => $this->band_id, 'genre' =>
            $this->genre_id));
    }

    // Function to delete a data object from table BandGenre
    public function delete() {

        $query = DB::connection()->prepare('DELETE FROM BandGenre WHERE genre_id = :genre AND band_id = :band_id');

        $query->execute(array('band_id' => $this->band_id, 'genre' => $this->genre_id));
    }

}
