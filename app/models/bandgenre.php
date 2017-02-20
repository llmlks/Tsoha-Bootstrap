<?php

class BandGenre extends BaseModel {

    public $band_id, $genre_id;

    public function __construct($attributes) {
        parent::__construct($attributes);
    }

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

    public function save() {

        $query = DB::connection()->prepare('INSERT INTO BandGenre (band_id, genre_id) VALUES (:band, :genre)');

        $query->execute(array('band' => $this->band_id, 'genre' =>
            $this->genre_id));
    }

    public function delete() {

        $query = DB::connection()->prepare('DELETE FROM BandGenre WHERE genre_id = :genre AND band_id = :band_id');

        $query->execute(array('band_id' => $this->band_id, 'genre' => $this->genre_id));
    }

}
