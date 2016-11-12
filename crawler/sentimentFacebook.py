# coding: utf-8
import mysql.connector
import json
import requests


def analyseFacebook():
    cnx = mysql.connector.connect(user='root',port="3307", password='', database='csmcaen',use_unicode=True)
    cursor = cnx.cursor(buffered=True)

    query = ("SELECT * FROM post")

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
            feel = "1"
            pass
        if response['label'] == "neutral":
            feel = "0"
            pass
        if response['label'] == "neg":
            feel = "-1"
            pass
        update_post =("UPDATE post SET neg=%(neg)s, neutral=%(neutral)s, pos=%(pos)s, feel=%(feel)s WHERE id=%(id)s")
        data_post = {
            'neg' : response['probability']['neg'],
            'neutral' : response['probability']['neutral'],
            'pos' : response['probability']['pos'],
            'feel' : feel,
            'id' : post[0],
        }
        cursor.execute(update_post, data_post)
        cnx.commit()


    cursor.close()
    cnx.close()

analyseFacebook()
