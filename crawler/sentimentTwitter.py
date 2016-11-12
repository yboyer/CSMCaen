# coding: utf-8
import mysql.connector
import json
import requests


def analyseTweets():
    cnx = mysql.connector.connect(user='root',port="3307", password='', database='CSMCaen',use_unicode=True)
    cursor = cnx.cursor(buffered=True)

    query = ("SELECT * FROM Tweet")

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
            sentiment = "1"
            pass
        if response['label'] == "neutral":
            sentiment = "0"
            pass
        if response['label'] == "neg":
            sentiment = "-1"
            pass
        update_tweet =("UPDATE Tweet SET negative=%(negative)s, neutral=%(neutral)s, positive=%(positive)s, sentiment=%(sentiment)s WHERE id=%(id)s")
        data_tweet = {
            'negative' : response['probability']['neg'],
            'neutral' : response['probability']['neutral'],
            'positive' : response['probability']['pos'],
            'sentiment' : sentiment,
            'id' : tweet[0],
        }
        cursor.execute(update_tweet, data_tweet)
        cnx.commit()


    cursor.close()
    cnx.close()

analyseTweets()
