# coding: utf-8
import mysql.connector
import json
import requests


def analyseTweets():
    cnx = mysql.connector.connect(user='root',port="3307", password='', database='csmcaen',use_unicode=True)
    cursor = cnx.cursor(buffered=True)

    query = ("SELECT * FROM tweet")

    cursor.execute(query)
    results = cursor.fetchall()

    for tweet in results:
        url = "http://text-processing.com/api/sentiment/"
        msg = {'text' : tweet[1].encode('utf8'), 'language' : 'french'}
        datas = requests.post(url,data=msg)
        response = json.loads(datas.text)
        print(tweet[0])
        print(response)
        if response['label'] == "pos":
            feel = "1"
            pass
        if response['label'] == "neutral":
            feel = "0"
            pass
        if response['label'] == "neg":
            feel = "-1"
            pass
        update_tweet =("UPDATE tweet SET neg=%(neg)s, neutral=%(neutral)s, pos=%(pos)s, feel=%(feel)s WHERE id=%(id)s")
        data_tweet = {
            'neg' : response['probability']['neg'],
            'neutral' : response['probability']['neutral'],
            'pos' : response['probability']['pos'],
            'feel' : feel,
            'id' : tweet[0],
        }
        cursor.execute(update_tweet, data_tweet)
        cnx.commit()


    cursor.close()
    cnx.close()

analyseTweets()
