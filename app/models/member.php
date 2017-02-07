<?php

class Member extends BaseModel {
    
    public $id, $band_id, $membername, $instruments, $joined, $resigned;
    
    public function __construct($attributes) {
        parent::__construct($attributes);
    }
    
    public static function findallbyband() {
        
        $query = DB::connection()->prepare('SELECT * FROM Member WHERE band_id = :band_id');
        $query->execute(array('band_id' => $this->band_id));
        
        $rows = $query->fetchAll();
        $members = array();
        
        foreach ($rows as $row) {
            $members[] = new Member(array(
                'id' => $row['id'], 
                'band_id' => $row['band_id'],
                'membername' => $row['membername'],
                'instruments' => $row['instruments'],
                'joined' => $row['joined'],
                'resigned' => $row['resigned']));
        }
        
        return $members;
    }
    
    public static function findwithid($id) {
        
        $query = DB::connection()->prepare('SELECT * FROM Member WHERE id = :id '
                . 'LIMIT 1');
        $query->execute(array('id' => $id));
        
        $row = $query->fetch();
        if ($row) {
            $member = new Member(array(
                'id' => $row['id'], 
                'band_id' => $row['band_id'],
                'membername' => $row['membername'],
                'instruments' => $row['instruments'],
                'joined' => $row['joined'],
                'resigned' => $row['resigned']));
            return $member;
        }
        return null;
    }
    
    public static function save() {
        
        $query = DB::connection()->prepare('INSERT INTO Member (band_id, membername, instruments, joined, resigned)'
                . 'VALUES (:band, :name, :instr, :joined, :resigned) RETURNING id');
        $query->execute(array(
            'band' => $this->band_id,
            'name' => $this->membername,
            'instr' => $this->instruments,
            'joined' => $this->joined,
            'resigned' => $this->resigned));
        
        $row = $query->fetch();
        
        $this->id = $row['id'];
    }
    
    public static function delete() {

        $query = DB::connection()->prepare('DELETE FROM Member WHERE id = :id');

        $query->execute(array('id' => $this->id));
    }

    public static function update() {

        $query = DB::connection()->prepare('UPDATE Member (membername, instruments, joined, resigned) VALUES (:name, :instr, :joined, :resigned) WHERE id = :id');

        $query->execute(array(
            'name' => $this->membername,
            'instr' => $this->instruments,
            'joined' => $this->joined,
            'resigned' => $this->resigned,
            'id' => $this->id));
    }
    
    public static function validate_name($string, $min, $max) {
        parent::validate_string_length($string, 2, 50);
    }
}
