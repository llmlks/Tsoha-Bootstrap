<?php

class Band extends BaseModel {

    public $bandname, $description, $origin, $likes, $id, $username, $password, $genres,
            $nextgig, $members;

    public function __construct($attributes) {
        parent::__construct($attributes);
        $this->validators = array('validate_name', 'validate_username', 'validate_password');
    }

    public static function find_all($page) {

        $page_size = 10;
        $offset = $page_size * ($page - 1);
        
        $query = DB::connection()->prepare('SELECT * FROM Band ORDER BY likes DESC LIMIT :limit OFFSET :offset');
        $query->execute(array('limit' => $page_size, 'offset' => $offset));

        $rows = $query->fetchAll();
        $bands = array();

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

    public static function find_with_id($id) {

        $query = DB::connection()->prepare('SELECT * FROM Band WHERE id = :id '
                . 'LIMIT 1');
        $query->execute(array('id' => $id));

        $row = $query->fetch();

        if ($row) {
            $band = new Band(array(
                'bandname' => $row['bandname'],
                'description' => $row['description'],
                'origin' => $row['origin'],
                'likes' => $row['likes'],
                'id' => $row['id'],
                'username' => $row['username'],
                'password' => $row['password']
            ));
            return $band;
        }

        return null;
    }

    public static function find_with_name($bandname) {

        $bandname = '%' . strtolower($bandname) . '%';

        $query = DB::connection()->prepare('SELECT * FROM Band WHERE LOWER(bandname) LIKE :bandname ORDER BY likes');
        $query->execute(array('bandname' => $bandname));

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

    public static function delete($id) {
        
        $query = DB::connection()->prepare('DELETE FROM BandGenre WHERE band_id = :id');
        
        $query->execute(array('id' => $id));
        
        $query = DB::connection()->prepare('DELETE FROM Concert WHERE band_id = :id');
        
        $query->execute(array('id' => $id));
        
        $query = DB::connection()->prepare('DELETE FROM BandFavourite WHERE band_id = :id');

        $query->execute(array('id' => $id));

        $query = DB::connection()->prepare('DELETE FROM BandFavourite WHERE favourite = :id');

        $query->execute(array('id' => $id));

        $query = DB::connection()->prepare('DELETE FROM BandLink WHERE band_id = :id');

        $query->execute(array('id' => $id));

        $query = DB::connection()->prepare('DELETE FROM Member WHERE band_id = :id');

        $query->execute(array('id' => $id));

        $query = DB::connection()->prepare('DELETE FROM Band WHERE id = :id');

        $query->execute(array('id' => $id));
    }

    public static function update($params) {
        
        $updates = array('bandname' => $params['bandname'],
            'description' => $params['description'],
            'origin' => $params['origin'],
            'id' => $params['id']);

        $query = DB::connection()->prepare('UPDATE Band SET bandname = :bandname, '
                . 'description = :description, origin = :origin WHERE id = :id');

        $query->execute($updates);
    }

    public static function upvote($id) {
        $query = DB::connection()->prepare('UPDATE Band SET likes = (likes + 1) WHERE id = :id');

        $query->execute(array('id' => $id));
    }
    
    public static function downvote($id) {
        $query = DB::connection()->prepare('UPDATE Band SET likes = (likes - 1) WHERE id = :id');

        $query->execute(array('id' => $id));
    }
    
    public static function count() {
        $query = DB::connection()->prepare('SELECT COUNT(*) FROM Band');
        $query->execute();
        
        $row = $query->fetch();
        return $row['count'];
    }
    
    public static function authenticate($username, $password) {
        
        $query = DB::connection()->prepare('SELECT * FROM Band WHERE username = :username AND password = :password');
        $query->execute(array('username' => $username, 'password' => $password));
        
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
        } else {
            return null;
        }
    }    
    
    public function validate_name() {
        if (parent::validate_string_length($this->bandname, 2, 50) == false) {
            return 'Please insert a valid name (2-50 characters)';
        }
    }
    
    public function validate_username() {
        
        $query = DB::connection()->prepare('SELECT * FROM Band WHERE username = :username');
        $query->execute(array('username' => $this->username));
        $row = $query->fetch();
        
        if ($row) {
            return 'The username has already been taken. Please try another one';
        }
        
        if (parent::validate_string_length($this->username, 2, 20) == false) {
            return 'Please insert a valid username (4-20 characters)';
        }        
    }
    
    public function validate_password() {
        if (parent::validate_string_length($this->password, 6, 12) == false) {
            return 'Please insert a valid password (6-12 characters)';
        }        
    }
}
