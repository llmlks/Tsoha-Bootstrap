<?php

class HelloWorldController extends BaseController {

    public static function sandbox() {

        $band = new Band(array(
            'bandname' => 'Punk4life',
            'description' => 'Bringing joy to the world',
            'origin' => 'Brisbane, Australia',
            'username' => 'punk',
            'password' => 'fourlife'
        ));

        $gig = new Gig(array(
            'band_id' => 1,
            'time' => '8.00',
            'date' => '23.03.2016',
            'location' => ''
        ));

        $bands = BandGenre::findbandsbygenre(1);
        Kint::dump($band->errors());
        Kint::dump($gig->errors());
        Kint::dump($bands);
    }

}
