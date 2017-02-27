<?php

class Member extends BaseModel {

    public $id, $band_id, $membername, $instruments, $joined, $resigned;

    public function __construct($attributes) {
        parent::__construct($attributes);
        $this->validators = array('validate_name', 'validate_instruments', 'validate_date', 'validate_resigned');
    }

    // Function to find data objects in table Member, based on the band's id    
    public static function find_all_by_band($id) {

        $query = DB::connection()->prepare('SELECT * FROM Member WHERE band_id = :band_id');
        $query->execute(array('band_id' => $id));

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

    // Function to find a data object in table Member, based on the id    
    public static function find_with_id($id) {

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

    // Function to store a new data object in table Member, checks whether date of resignation is provided    
    public function save() {
        if ($this->resigned == NULL) {
            $query = DB::connection()->prepare('INSERT INTO Member (band_id, membername, instruments, joined)'
                    . 'VALUES (:band, :name, :instr, :joined) RETURNING id');
            $query->execute(array(
                'band' => $this->band_id,
                'name' => $this->membername,
                'instr' => $this->instruments,
                'joined' => $this->joined));
        } else {
            $query = DB::connection()->prepare('INSERT INTO Member (band_id, membername, instruments, joined, resigned)'
                    . 'VALUES (:band, :name, :instr, :joined, :resigned) RETURNING id');
            $query->execute(array(
                'band' => $this->band_id,
                'name' => $this->membername,
                'instr' => $this->instruments,
                'joined' => $this->joined,
                'resigned' => $this->resigned));
        }

        $row = $query->fetch();

        $this->id = $row['id'];
    }

    // Function to delete a data object from table Member, based on the id    
    public function delete() {

        $query = DB::connection()->prepare('DELETE FROM Member WHERE id = :id');

        $query->execute(array('id' => $this->id));
    }
    
    // Function to update a data object in table Member, based on the id    
    public function update() {
        if ($this->resigned == NULL) {
            $query = DB::connection()->prepare('UPDATE Member SET membername = :name, instruments = :instr, joined = :joined WHERE id = :id');

            $query->execute(array(
                'name' => $this->membername,
                'instr' => $this->instruments,
                'joined' => $this->joined,
                'id' => $this->id));
        } else {
            $query = DB::connection()->prepare('UPDATE Member SET membername = :name, instruments = :instr, joined = :joined, resigned = :resigned WHERE id = :id');

            $query->execute(array(
                'name' => $this->membername,
                'instr' => $this->instruments,
                'joined' => $this->joined,
                'resigned' => $this->resigned,
                'id' => $this->id));
        }
    }

    // Function to validate the string length of member's name    
    public function validate_name() {
        if (parent::validate_string_length($this->membername, 2, 50) == false) {
            return 'Please insert a valid name (2-50 characters)';
        }
    }

    // Function to validate the string length of member's instruments attribute    
    public function validate_instruments() {
        if (parent::validate_string_length($this->instruments, 2, 100) == false) {
            return 'Please insert a valid instrument/s (2-100 characters)';
        }
    }

    // Function to validate the date of joining    
    public function validate_date() {
        return parent::validate_date($this->joined);
    }

    // Function to validate the date of resignation (can be NULL)   
    public function validate_resigned() {
        if ($this->resigned != NULL) {
            return parent::validate_date($this->resigned);
        }
    }

}
