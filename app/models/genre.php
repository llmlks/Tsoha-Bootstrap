<?php

class Genre extends BaseModel {
    
    public $id, $genrename;
    
    public function __construct($attributes) {
        parent::__construct($attributes);
    }
    
    public static function findall() {
        
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
    
    public static function findwithid($id) {
        
        $query = DB::connection()->prepare('SELECT * FROM Genre WHERE id = :id '
                . 'LIMIT 1');
        $query->execute(array('id' => $id));
        
        $row = $query->fetch();
        if ($row) {
            $genre = new Genre(array('id' => $row['id'], 'genrename' => 
                $row['genrename']));
            return $genre;
        }
        return null;
    }
    
    public static function findwithname($genrename) {
        
        $query = DB::connection()->prepare('SELECT * FROM Genre WHERE genrename'
                . ' = :genrename LIMIT 1');
        $query->execute(array('genrename' => '%' . $genrename . '%'));
        
        $row = $query->fetch();
        if ($row) {
            $genre = new Genre(array('id' => $row['id'], 'genrename' => 
                $row['genrename']));
            return $genre;
        }
        return null;        
    }
    
    public static function save() {
        
        $query = DB::connection()->prepare('INSERT INTO Genre (genrename) '
                . 'VALUES :genrename RETURNING id');
        $query->execute(array('genrename' => $this->genrename));
        
        $row = $query->fetch();
        
        $this->id = $row['id'];
    }
}
