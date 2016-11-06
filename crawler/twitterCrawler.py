from twitter import *
from pymongo import MongoClient
from config import *

import json

def twitterCrawler():
    t= Twitter(
    auth=OAuth(token,secret_token,key,secret_key))
    search = t.search.tweets(q="SMCOGCN -filter:retweets AND -filter:replies",since="2016-11-06",until="2016-11-07",count=1000)
    tweets = search['statuses']
    betterTweets = []
    for tweet in tweets:
        betterTweets.append({'name':tweet["user"]["screen_name"], 'text' : tweet["text"], 'date' : tweet["created_at"]})
    MONGODB_SERVER = 'localhost'
    MONGODB_PORT = 27017
    MONGODB_DB = 'csmCaen'
    MONGODB_COLLECTION = "tweets"
    connection = MongoClient(
            MONGODB_SERVER,
            MONGODB_PORT)
    db = connection[MONGODB_DB]
    collection = db[MONGODB_COLLECTION]
    collection.insert_many(betterTweets)
twitterCrawler()
