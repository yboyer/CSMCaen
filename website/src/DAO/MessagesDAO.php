<?php

namespace YF\DAO;

class MessagesDAO extends DAO
{
    public function findAllTweets()
    {
        $sql = 'SELECT * FROM Tweets';
        $res = $this->db->fetchAll($sql);

        $tweets = [];
        foreach ($res as $data) {
            var_dump($data);
        }
    }

    public function findAll()
    {
        return [
            'tweets' => $this->findAllTweets(),
        ];
    }
}
