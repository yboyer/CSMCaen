<?php

namespace YF\DAO;

use YF\Domain\Match;

class MatchesDAO extends DAO
{
    public function findAll()
    {
        $sqlTweets = 'SELECT count(*) AS count, date, Team.name as team FROM Tweet, Team WHERE Tweet.team = Team.id GROUP BY date, team';
        $sqlPosts = 'SELECT count(*) AS count, date, Team.name as team FROM Post, Team WHERE Post.team = Team.id GROUP BY date, team';
        $resTweets = $this->db->fetchAll($sqlTweets);
        $resPosts = $this->db->fetchAll($sqlPosts);

        // Merge tweets and posts
        $data = [];
        foreach ($resTweets as $tweet) {
            $data[$tweet['date']] = [
                'team' => $tweet['team'],
                'count' => (int) $tweet['count'],
            ];
        }
        foreach ($resPosts as $post) {
            if (isset($data[$post['date']])) {
                $data[$post['date']]['count'] += (int) $post['count'];
            } else {
                $data[$post['date']] = [
                    'team' => $post['team'],
                    'count' => $post['count'],
                ];
            }
        }

        // Merge day matches
        $dates = [];
        $oneDay = 60 * 60 * 24;
        foreach ($data as $date => $data) {
            $dateM1 = date('Y-m-d', (strtotime($date) - $oneDay));
            $dateP1 = date('Y-m-d', (strtotime($date) + $oneDay));

            if (!isset($dates[$dateM1]) && !isset($dates[$date]) && !isset($dates[$dateP1])) {
                $dates[$dateP1] = $data;
            } else {
                if (isset($dates[$date])) {
                    $dates[$date]['count'] += $data['count'];
                } else {
                    $dates[$dateM1]['count'] += $data['count'];
                }
            }
        }

        // Create match objects
        $matches = [];
        foreach ($dates as $date => $data) {
            $matches[] = new Match([
                'date' => $date,
                'team' => $data['team'],
                'nbMessages' => $data['count'],
            ]);
        }

        return $matches;
    }
}
