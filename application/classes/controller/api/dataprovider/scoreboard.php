<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Keyston
 * Date: 7/18/11
 * Time: 7:21 AM
 */

class Controller_Api_DataProvider_ScoreBoard extends Controller_Api_DataProvider_Base
{


    public function fetch_overall()
    {


        $date = $this->epoch();
        $dist = new Api_Fetchers_Distribution(
            $this->mongo,
            array($this->location),
            $this->industry());
        $doc = $dist->range($date)->period('overall')->fetch();

        $doc['score'] = number_format($doc['score'], 2);
        $ogsi = new Api_Fetchers_Ogsi($this->mongo, $this->location, $this->industry());

        $ogsi->competition(array_keys($this->getCompetition()))->range($date)->period('overall');

        return array(
            'ogsi' => number_format($ogsi->fetch(), 2),
            'rating' => $doc,
            'reviews' => $doc['count']

        );


    }

    public function action_overall()
    {
        $this->apiResponse = array('overall' => $this->fetch_overall());
    }

    public function action_current()
    {
        $this->apiResponse = array('current' => $this->fetch_current());
    }

    public function action_index()
    {
        $this->apiResponse = array(
            'overall' => $this->fetch_overall(),
            'current' => $this->fetch_current()
        );

    }

    public function fetch_current()
    {

        $dist = new Api_Fetchers_Distribution($this->mongo, array($this->location), $this->industry());
        $dist->range($this->startDate, $this->endDate);

        $values = $dist->fetch();
        $values['score'] = number_format($values['score'], 2);


        $ogsi = new Api_Fetchers_Ogsi($this->mongo, $this->location, $this->industry());

        $ogsi->competition(
            array_keys($this->getCompetition())
        )->range($this->startDate, $this->endDate);
        $response = array(
            'ogsi' => number_format($ogsi->fetch(), 2),
            'rating' => $values,
            'reviews' => $values['count']

        );


        return $response;
    }
}
