<?php

class Genre extends BaseModel {

    public $id, $genrename;

    public function __construct($attributes) {
        parent::__construct($attributes);
        $this->validators = array('validate_name');
    }

    // Function to find all data objects in table Genre  
    public static function find_all() {

        $query = DB::connection()->prepare('SELECT * FROM Genre');
        $query->execute();

        $rows = $query->fetchAll();
        $genres = array();

        foreach ($rows as $row) {
            $genres[] = new Genre(array('id' => $row['id'], 'genrename' =>
                $row['genrename']));
        }

        return $genres;
    }

    // Function to store a new data object in table Genre  
    public function save() {

        $query = DB::connection()->prepare('INSERT INTO Genre (genrename) '
                . 'VALUES (:genrename) RETURNING id');
        $query->execute(array('genrename' => $this->genrename));

        $row = $query->fetch();

        $this->id = $row['id'];
    }

    // Function to delete a data object from table Genre  
    public function delete() {
        
        $query = DB::connection()->prepare('DELETE FROM BandGenre WHERE genre_id = :id');
        
        $query->execute(array('id' => $this->id));

        $query = DB::connection()->prepare('DELETE FROM Genre WHERE id = :id');

        $query->execute(array('id' => $this->id));
    }

    // Function to validate string length of genre's name  
    public function validate_name() {
        if (!parent::validate_string_length($this->genrename, 2, 50)) {
            return 'Please insert a valid genre (2-50 characters)';
        }
    }

}
