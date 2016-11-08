from pymongo import MongoClient
from config import *
import requests
from dateutil.parser import parse
import mysql.connector
import re

import json

def facebookCrawler():

    ##Connection to db
    cnx = mysql.connector.connect(user='root',port="3307", password='', database='csmcaen',use_unicode=True)
    cursor = cnx.cursor()
    cursor.execute('SET NAMES utf8mb4')
    cursor.execute("SET CHARACTER SET utf8mb4")
    cursor.execute("SET character_set_connection=utf8mb4")


    #custom the webservice call
    token = fb_app_id + "|" + fb_secret
    page = "SMCaen.officiel"
    start_date= "2016:11:06 00:00:00"
    end_date = "2016:11:06 23:59:59"
    hashtag = "SMCOGCN"
    team = re.sub("SMC",'', hashtag)


    url = "https://graph.facebook.com/v2.8/"+page
    query = "/?fields=posts.since(" + start_date + ").until(" + end_date + "){comments.limit(500){message.limit(500),like_count},reactions.limit(500),message}&access_token=" + token
    datas = requests.get(url + query).json()

    #add posts
    for data in datas["posts"]["data"]:
        add_post =("INSERT INTO post"
        "(content, date, team)"
        "VALUES (%(content)s, %(date)s, %(team)s)"
        )
        data_post = {
            'content' : data["message"],
            'date' : parse(start_date).strftime("%Y-%m-%d"),
            'team' : team,
        }
        cursor.execute(add_post, data_post)
        cnx.commit()

        ##add post comments like posts
        for com in data["comments"]["data"]:
            add_comm =("INSERT INTO post"
            "(content, date, team)"
            "VALUES (%(contentcomm)s, %(datecomm)s, %(teamcomm)s)"
            )
            data_comm = {
                'contentcomm' : com["message"],
                'datecomm' : parse(start_date).strftime("%Y-%m-%d"),
                'teamcomm' : team,
            }
            cursor.execute(add_comm, data_comm)
            cnx.commit()



facebookCrawler()
