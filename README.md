# CSMCaen

---
> *Document Numérique Avancé*
> *Master DNR2i, 2eme Année – Semestre 1*
> *Département d'Informatique*
> *Prof. Dr. Marc Spaniol*

> ### Project: “Social Media Sentiment Monitor” [about SM Caen]  

> #### Description:
> The project consists of two (sub-)tasks. In a first step, **social Web contents** about SM Caen need to **collected/crawled**. These contents (min 1.000 documents per match day) should cover at least three matches and should be, e.g., acquired from tweets containing an associated hashtag (#). For further analytics, the contents should be parsed and the “meaningful” text extracted in order to “Identify” the overall sentiment (resp. sentiments in different sub-communities).

> In a second step, a **Web-based search interface** needs to be developed. This interface should *at least* support **temporal search and analytics** for three match days (before and after). The analytics module should to this end be capable of visualizing the overall sentiment and/or retrieving the relevant documents, terms and/or entities associated with positive/negative sentiments. Enhancements include but are not limited to the identification of the most important entities, linking and/or incorporating match statistics as well trend analytics.

> #### Specification:
> The software you are supposed to develop should be deployed on the Web as a “Web search engine”. The interface needs to be productive (fast, usable and “appealing”). The minimum functionality specified above needs to be available, while additional “features” are a surplus. The choice of software is up to you, but if third party software/libraries is/are used, it must be open-source.

---

![](.github/screen.png)

---
## Technologies, libraries and APIs
  - `Python`
  - [`MySQL`](http://www.mysql.com/) - DBMS
  - [`Silex`](http://silex.sensiolabs.org/) - Micro-framework
  - [`D3.js`](https://d3js.org/) - Graph displays
  - [`node-sass`](https://github.com/sass/node-sass) - SASS compiler
  - [`SASS`](http://sass-lang.com/) - Better CSS
  - [`text-processing`](http://text-processing.com/docs/sentiment.html) - Sentiment analysis API
  - [`graph-api`](https://developers.facebook.com/docs/graph-api) - Facebook API to retrieve posts
  - [`twitter`](https://pypi.python.org/pypi/twitter/1.17.1) - Twitter library to retrieve tweets

## Prerequistes
  - [`Composer`](https://getcomposer.org/download/)
  - `Node.js`
  - `npm`
  - `pip`
    - `twitter`
    - `python-dateutil`
    - `mysql-connector`

## Usage:
### Install
##### Clone the GitHub repo:
```bash
git clone https://github.com/yboyer/csmcaen
cd csmcaen
```
##### Install dependencies:
```bash
cd website
npm i
```
### Fill Database
Import [`database.sql`](database.sql) to MySQL.

##### Crawling:
Edit `start_date` and `end_date` variables in `facebookCrawler.py` and `twitterCrawler.py` to crawl a given date.  
```bash
python twitterCrawler.py
python facebookCrawler.py
```
##### Sentiment analysis:
Update the database datas by adding sentimental analysis.
```bash
python sentimentTwitter.py
python sentimentfacebook.py
```
