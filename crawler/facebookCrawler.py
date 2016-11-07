from pymongo import MongoClient
from config import *
import requests

import json

def facebookCrawler():
    #custom the webservice call
    token = fb_app_id + "|" + fb_secret
    page = "SMCaen.officiel"
    start_date= "2016:11:06 00:00:00"
    start_date_normalized ="2016-11-06"
    end_date = "2016:11:06 23:59:59"

    url = "https://graph.facebook.com/v2.8/"+page
    query = "/?fields=posts.since(" + start_date + ").until(" + end_date + "){comments.limit(500){message.limit(500),like_count},reactions.limit(500),message}&access_token=" + token
    datas = requests.get(url + query).json()
    print(url + query)
    betterDatas = []
    for data in datas["posts"]["data"]:
        betterDatas.append({'message' : data["message"], 'date' : start_date_normalized})
        for com in data["comments"]["data"]:
            betterDatas.append({'message' : com["message"], 'date' : start_date_normalized})
    # print(data)
    MONGODB_SERVER = 'localhost'
    MONGODB_PORT = 27017
    MONGODB_DB = 'csmCaenfb'
    MONGODB_COLLECTION = "coms"
    connection = MongoClient(
            MONGODB_SERVER,
            MONGODB_PORT)
    db = connection[MONGODB_DB]
    collection = db[MONGODB_COLLECTION]
    collection.insert_many(betterDatas)
facebookCrawler()
