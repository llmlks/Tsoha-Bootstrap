<?php

class BandLink extends BaseModel {

    public $id, $band_id, $url, $linkname;

    public function __construct($attributes) {
        parent::__construct($attributes);
        $this->validators = array('validate_name', 'validate_url');
    }

    // Function to find all data objects in table BandLink when band's id is known  
    public static function find_all_by_band($band_id) {

        $query = DB::connection()->prepare('SELECT * FROM BandLink WHERE band_id = :id');
        $query->execute(array('id' => $band_id));

        $rows = $query->fetchAll();
        $links = array();

        foreach ($rows as $row) {
            $links[] = new BandLink(array(
                'id' => $row['id'],
                'band_id' => $row['band_id'],
                'url' => $row['url'],
                'linkname' => $row['linkname']
            ));
        }

        return $links;
    }

    // Function to store a new data object into table BandLink  
    public function save() {

        $query = DB::connection()->prepare('INSERT INTO BandLink (band_id, linkname, url) VALUES (:band, :name, :url) RETURNING id');

        $query->execute(array(
            'band' => $this->band_id, 
            'name' => $this->linkname, 
            'url' => $this->url));
        
        $id = $query->fetch();
        $this->id = $id;
    }

    // Function to delete a data object from table BandLink  
    public function delete() {

        $query = DB::connection()->prepare('DELETE FROM BandLink WHERE id = :id');

        $query->execute(array('id' => $this->id));
    }

    // Function to validate string length of link's name  
    public function validate_name() {
        if (parent::validate_string_length($this->linkname, 2, 50) == false) {
            return 'Please insert a valid name for the link (2-50 characters)';
        }
    }
    
    // Function to validate string length of link's URL  
    public function validate_url() {
        if (filter_var($this->url, FILTER_VALIDATE_URL) === FALSE) {
            return 'Please insert a valid url';
        }
    }
}