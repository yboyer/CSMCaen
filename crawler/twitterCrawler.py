# -*- coding: utf-8 -*-
from twitter import *
from pymongo import MongoClient
from config import *
from dateutil.parser import parse
import mysql.connector
import re

import json

def twitterCrawler():
    ##Connection to db
    cnx = mysql.connector.connect(user='root',port="3307", password='', database='csmcaen',use_unicode=True)
    cursor = cnx.cursor()
    cursor.execute('SET NAMES utf8mb4')
    cursor.execute("SET CHARACTER SET utf8mb4")
    cursor.execute("SET character_set_connection=utf8mb4")

    ##twitter connection
    t= Twitter(
    auth=OAuth(token,secret_token,key,secret_key))

    ##twitter filters
    start_date = "2016-11-07"
    end_date = "2016-11-08"
    hashtag = "SMCOGCN"
    team = re.sub("SMC",'', hashtag)

    ##executing twitter crawling & storing all datas
    search = t.search.tweets(q=hashtag+" -filter:retweets AND -filter:replies",since=start_date,until=end_date,count=1000)
    tweets = search['statuses']
    betterTweets = []
    for tweet in tweets:
        add_tweet =("INSERT INTO tweet"
        "(content, username, date, team)"
        "VALUES (%(content)s, %(username)s, %(date)s, %(team)s)"
        )
        data_tweet = {
            'content' : tweet["text"],
            'username' : tweet["user"]["screen_name"],
            'date' : parse(start_date).strftime("%Y-%m-%d"),
            'team' : team,
        }
        cursor.execute(add_tweet, data_tweet)
        cnx.commit()

    cursor.close()
    cnx.close()
twitterCrawler()
