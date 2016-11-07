from twitter import *
from pymongo import MongoClient
from config import *

import json

def twitterCrawler():
    t= Twitter(
    auth=OAuth(token,secret_token,key,secret_key))
    start_date = "2016-11-06"
    end_date = "2016-11-07"
    hashtag = "SMCOGCN"
    search = t.search.tweets(q=hashtag+" -filter:retweets AND -filter:replies",since=start_date,until=end_date,count=1000)
    tweets = search['statuses']
    betterTweets = []
    for tweet in tweets:
        betterTweets.append({'name':tweet["user"]["screen_name"], 'text' : tweet["text"], 'date' : start_date})
    MONGODB_SERVER = 'localhost'
    MONGODB_PORT = 27017
    MONGODB_DB = 'csmCaen2'
    MONGODB_COLLECTION = "tweets"
    connection = MongoClient(
            MONGODB_SERVER,
            MONGODB_PORT)
    db = connection[MONGODB_DB]
    collection = db[MONGODB_COLLECTION]
    collection.insert_many(betterTweets)
twitterCrawler()
