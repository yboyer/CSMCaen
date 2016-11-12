<?php

namespace YF\DAO;

use YF\Domain\Message;

class MessagesDAO extends DAO
{
    private function findMessages($date, $type)
    {
        $dates = $this->getMatchDates($date);

        $sql = "SELECT * FROM $type WHERE date = '$dates[0]' or date = '$dates[1]' or date = '$dates[2]' ORDER BY date";
        $res = $this->db->fetchAll($sql);

        $messages = [];
        foreach ($res as $data) {
            $data['id'] = $type[0].$data['id'];
            $messages[] = new Message($data);
        }

        return $messages;
    }
    public function findTweets($date)
    {
        return $this->findMessages($date, 'Tweet');
    }
    public function findPosts($date)
    {
        return $this->findMessages($date, 'Post');
    }

    private function findMessage($id, $type)
    {
        $sql = "SELECT negative as '-1', neutral as '0', positive as '1' FROM $type WHERE id='$id' LIMIT 1";
        $res = $this->db->fetchAssoc($sql);

        return $res;
    }

    private function getNegativeMessages($date)
    {
        $dates = $this->getMatchDates($date);
        $messages = [];

        $where = "WHERE sentiment='-1' AND (date = '$dates[0]' or date = '$dates[1]' or date = '$dates[2]') ORDER BY negative DESC";

        $sqlTweets = "SELECT * FROM Tweet $where";
        $resTweets = $this->db->fetchAll($sqlTweets);
        foreach ($resTweets as $data) {
            $messages[] = new Message($data);
        }

        $sqlPosts = "SELECT * FROM Post $where";
        $resPosts = $this->db->fetchAll($sqlPosts);
        foreach ($resPosts as $data) {
            $messages[] = new Message($data);
        }


        $negatives = [];
        foreach ($messages as $key => $row) {
            $negatives[$key] = $row->getNegative();
        }
        array_multisort($negatives, SORT_DESC, $messages);

        return $messages;
    }

    private function getNeutralMessages($date)
    {
        $dates = $this->getMatchDates($date);
        $messages = [];

        $where = "WHERE sentiment='0' AND (date = '$dates[0]' or date = '$dates[1]' or date = '$dates[2]') ORDER BY neutral DESC";

        $sqlTweets = "SELECT * FROM Tweet $where";
        $resTweets = $this->db->fetchAll($sqlTweets);
        foreach ($resTweets as $data) {
            $messages[] = new Message($data);
        }

        $sqlPosts = "SELECT * FROM Post $where";
        $resPosts = $this->db->fetchAll($sqlPosts);
        foreach ($resPosts as $data) {
            $messages[] = new Message($data);
        }


        $neutrals = [];
        foreach ($messages as $key => $row) {
            $neutrals[$key] = $row->getNeutral();
        }
        array_multisort($neutrals, SORT_DESC, $messages);

        return $messages;
    }

    private function getPositiveMessages($date)
    {
        $dates = $this->getMatchDates($date);
        $messages = [];

        $where = "WHERE sentiment='1' AND (date = '$dates[0]' or date = '$dates[1]' or date = '$dates[2]') ORDER BY positive DESC";

        $sqlTweets = "SELECT * FROM Tweet $where";
        $resTweets = $this->db->fetchAll($sqlTweets);
        foreach ($resTweets as $data) {
            $messages[] = new Message($data);
        }

        $sqlPosts = "SELECT * FROM Post $where";
        $resPosts = $this->db->fetchAll($sqlPosts);
        foreach ($resPosts as $data) {
            $messages[] = new Message($data);
        }


        $positives = [];
        foreach ($messages as $key => $row) {
            $positives[$key] = $row->getPositive();
        }
        array_multisort($positives, SORT_DESC, $messages);

        return $messages;
    }

    private function getMatchDates($date)
    {
        $oneDay = 60 * 60 * 24;
        $dateM1 = date('Y-m-d', (strtotime($date) - $oneDay));
        $dateP1 = date('Y-m-d', (strtotime($date) + $oneDay));

        return [
            $dateM1,
            $date,
            $dateP1,
        ];
    }

    private function getTeam($date)
    {
        $dates = $this->getMatchDates($date);

        $sql = "SELECT Team.name FROM Post, Team WHERE Post.team = Team.id AND (date = '$dates[0]' or date = '$dates[1]' or date = '$dates[2]') LIMIT 1";
        $team = $this->db->fetchColumn($sql);

        return $team;
    }

    private function getGlobalSentiment($array)
    {
        $sentiment = [
            -1 => 0,
            0 => 0,
            1 => 0,
        ];
        foreach ($array as $value) {
            if (!is_null($value->getSentiment())) {
                ++$sentiment[$value->getSentiment()];
            }
        }

        return $sentiment;
    }

    public function getSentiment($date)
    {
        $tweets = $this->findTweets($date);
        $posts = $this->findPosts($date);
        $messages = array_merge($tweets, $posts);

        return $this->getGlobalSentiment($messages);
    }

    public function getSentimentById($date, $id)
    {
        $type = $id[0] === 'P' ? 'Post': 'Tweet';
        $id = substr($id, 1);

        $message = $this->findMessage($id, $type);

        return $message;
    }

    public function find($date)
    {
        $tweets = $this->findTweets($date);
        $posts = $this->findPosts($date);
        $messages = array_merge($tweets, $posts);

        $dates = [];
        foreach ($messages as $key => $row) {
            $dates[$key] = $row->getDate();
        }
        array_multisort($dates, SORT_DESC, $messages);

        $tweetSentiments = $this->getGlobalSentiment($tweets);
        $postSentiments = $this->getGlobalSentiment($posts);

        return [
            'dates' => $this->getMatchDates($date),
            'team' => $this->getTeam($date),
            'messages' => $messages,
            'top10' => [$messages[5]],
            'negatives' => array_slice($this->getNegativeMessages($date), 0, 20),
            'neutrals' => array_slice($this->getNeutralMessages($date), 0, 20),
            'positives' => array_slice($this->getPositiveMessages($date), 0, 20),
            'tweets' => [
                'total' => count($tweets),
                'negatives' => $tweetSentiments[-1],
                'neutrals' => $tweetSentiments[0],
                'positives' => $tweetSentiments[1],
            ],
            'posts' => [
                'total' => count($posts),
                'negatives' => $postSentiments[-1],
                'neutrals' => $postSentiments[0],
                'positives' => $postSentiments[1],
            ],
        ];
    }
}
