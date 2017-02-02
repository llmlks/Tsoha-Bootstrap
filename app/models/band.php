<?php

class Band extends BaseModel {
    
    public $bandname, $description, $origin, $id, $username, $password;
    
    public function __construct($attributes) {
        parent::__construct($attributes);
    }
    
    public static function findall() {
        
        $query = DB::connection()->prepare('SELECT * FROM Band');
        $query->execute();
        
        $rows = $query->fetchAll();
        $bands = array();
        
        foreach ($rows as $row) {
            $bands[] = new Band(array(
                'bandname' => $row['bandname'],
                'description' => $row['description'],
                'origin' => $row['origin'],
                'id' => $row['id'],
                'username' => $row['username'],
                'password' => $row['password']
            ));
        }
        
        return $bands;
    }
    
    public static function findwithid($id) {
        
        $query = DB::connection()->prepare('SELECT * FROM Band WHERE id = :id '
                . 'LIMIT 1');
        $query->execute(array('id' => $id));
        
        $row = $query->fetch();
        
        if ($row) {
            $band = new Band(array(
                'bandname' => $row['bandname'],
                'description' => $row['description'],
                'origin' => $row['origin'],
                'id' => $row['id'],
                'username' => $row['username'],
                'password' => $row['password']
            ));
            return $band;
        }
        
        return null;
    }

    public static function findwithname($bandname) {
        
        $bandname = '%' . $bandname . '%';
        
        $query = DB::connection()->prepare('SELECT * FROM Band WHERE bandname = :bandname');
        $query->execute(array('bandname' => $bandname));
        
        $rows = $query->fetch();
        
        $bands = array();
        
        if ($rows == null) {
            return NULL;
        }
        
        foreach ($rows as $row) {
            $bands[] = new Band(array(
                'bandname' => $row['bandname'],
                'description' => $row['description'],
                'origin' => $row['origin'],
                'id' => $row['id'],
                'username' => $row['username'],
                'password' => $row['password']
            ));
        }
        
        return $bands;
    }

    public function save() {
        
        $query = DB::connection()->prepare('INSERT INTO Band (bandname, '
                . 'description, origin, username, password) VALUES (:bandname, '
                . ':description, :origin, :username, :password) RETURNING id');
        
        $query->execute(array('bandname' => $this->bandname, 'description' => 
            $this->description, 'origin' => $this->origin, 'username' => 
            $this->username, 'password' => $this->password));
        
        $row = $query->fetch();
        
        $this->id = $row['id'];
    }
    
    public static function favourites($id) {
        
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
}