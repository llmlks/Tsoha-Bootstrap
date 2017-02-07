<?php

class BandLink extends BaseModel {

    private $band_id, $url, $linkname;

    public function __construct($attributes) {
        parent::__construct($attributes);
    }

    public static function findAllByBand($id) {

        $query = DB::connection()->prepare('SELECT * FROM BandLink WHERE band_id = :id)');
        $query->execute(array('id' => $id));

        $rows = $query->fetchAll();
        $links = array();

        foreach ($rows as $row) {
            $links[] = new Band(array(
                'band_id' => $row['band_id'],
                'url' => $row['url'],
                'linkname' => $row['linkname']
            ));
        }

        return $links;
    }

    public function save() {

        $query = DB::connection()->prepare('INSERT INTO BandLink (band_id, linkname, url) VALUES (:band, :name, :url)');

        $query->execute(array(
            'band' => $this->band_id, 
            'name' => $this->linkname, 
            'url' => $this->url));
    }

    public static function delete() {

        $query = DB::connection()->prepare('DELETE FROM BandLink WHERE url = :url AND band_id = :band_id');

        $query->execute(array('band_id' => $this->band_id, 'url' => $this->url));
    }

}