<?php

namespace YF\DAO;

use YF\Domain\Tweet;

class MessagesDAO extends DAO
{
    public function findAllTweets()
    {
        $sql = 'SELECT * FROM Tweets';
        $res = $this->db->fetchAll($sql);

        $tweets = [];
        foreach ($res as $data) {
            $tweets[] = new Tweet($data);
        }
        return $tweets;
    }

    public function getMatches()
    {


    }

    public function findAll()
    {
        return [
            'tweets' => $this->findAllTweets()
        ];
    }
}
