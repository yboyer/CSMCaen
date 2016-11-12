# coding: utf-8
import mysql.connector
import json
import requests


def analyseFacebook():
    cnx = mysql.connector.connect(user='root',port="3307", password='', database='CSMCaen',use_unicode=True)
    cursor = cnx.cursor(buffered=True)

    query = ("SELECT * FROM Post")

    cursor.execute(query)
    results = cursor.fetchall()

    for post in results:
        url = "http://text-processing.com/api/sentiment/"
        msg = {'text' : post[1].encode('utf8'), 'language' : 'french'}
        datas = requests.post(url,data=msg)
        response = json.loads(datas.text)
        print(post[0])
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
        update_post =("UPDATE Post SET negative=%(negative)s, neutral=%(neutral)s, positive=%(positive)s, sentiment=%(sentiment)s WHERE id=%(id)s")
        data_post = {
            'negative' : response['probability']['neg'],
            'neutral' : response['probability']['neutral'],
            'positive' : response['probability']['pos'],
            'sentiment' : sentiment,
            'id' : post[0],
        }
        cursor.execute(update_post, data_post)
        cnx.commit()


    cursor.close()
    cnx.close()

analyseFacebook()
