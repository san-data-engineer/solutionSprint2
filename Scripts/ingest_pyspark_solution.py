"""
Created on Sun Oct 24 12:24:55 2021

@author: sansdba
"""
import pandas as pd
import requests
import pyodbc
import json
from pyspark.sql.functions import col, explode, arrays_zip
from pyspark.sql.types import StructType, StructField, StringType, ArrayType
from pyspark import SparkContext
from pyspark.sql import SparkSession

usuario = 'user_engage_dev'
senha = 'admin2021'
server = 'sqlserver-solution.c7tb1ncdsun6.sa-east-1.rds.amazonaws.com'
db = 'DB_ENGAGE_DEV'

conMSSQL = pyodbc.connect('DRIVER={ODBC Driver 17 for SQL Server}'
                      ';SERVER=tcp:' + server +
                      ';DATABASE=' + db +
                      ';UID=' + usuario +
                      ';PWD=' + senha)

#Leitura de arquivo JSON
r = requests.get("https://87dyrojjxk.execute-api.us-east-1.amazonaws.com/dev/fiap/raw")
r2 = requests.get("https://87dyrojjxk.execute-api.us-east-1.amazonaws.com/dev/fiap/raw")
ds_raw = pd.read_json('https://87dyrojjxk.execute-api.us-east-1.amazonaws.com/dev/fiap/raw', encoding='utf-8')

#Inicializando Pyspark
sc = SparkContext.getOrCreate()
ss= SparkSession.builder.getOrCreate()

answers = ArrayType(
        StructType()
        .add("ID_USUARIO", StringType(), True)
        .add("ID_ATIVIDADE", StringType(), True)
        .add("DT_RESPOSTA", StringType(), True)
        .add("NU_PORCENTAGEM_ACERTOS", StringType(), True)
)
  
activities = ArrayType(
        StructType()
        .add("ID_USUARIO", StringType(), True)
        .add("ID_ATIVIDADE", StringType(), True)
        .add("NU_PESO", StringType(), True)
        .add("answers", answers, True)
)
  
rounds = ArrayType(
        StructType()
        .add("roundId", StringType(), True)
        .add("name", StringType(), True)
        .add("status", StringType(), True)
        .add("roundscorebonus", StringType(), True)
        .add("lastattemptstatus", StringType(), True)
        .add("approved", StringType(), True)
        .add("waiting", StringType(), True)
        .add("answerdate", StringType(), True)
        .add("showstars", StringType(), True)
        .add("showscore", StringType(), True)
        .add("stars", StringType(), True)
        .add("activities", activities, True)
)
  
schema = (
        StructType()
        .add("userid", StringType(), True)
        .add("userstatus", StringType(), True)
        .add("maxScore", StringType(), True)
        .add("score", StringType(), True)
        .add("image", StringType(), True)
        .add("position", StringType(), True)
        .add("myRanking", StringType(), True)
        .add("round", StringType(), True)
        .add("rounds", rounds, True)
)

df = ss.createDataFrame([json.loads(line) for line in r.iter_lines()][0], schema)
#df.printSchema()
#df.show()

# Criação DataFrame User
df.createOrReplaceTempView("user")
ss.sql("SELECT * FROM user").show(10)

### ROUNDS
# Criação DataFrame Rounds
df_rounds = ss.sql("""SELECT 
                   rounds.roundId, 
                   rounds.name,
                   rounds.status,
                   rounds.roundscorebonus,
                   rounds.lastattemptstatus,
                   rounds.approved,
                   rounds.waiting,
                   rounds.answerdate,
                   rounds.showstars,
                   rounds.showscore,
                   rounds.stars,
                   rounds.activities
                   FROM user""")

df_roundsArray = (df_rounds.withColumn("new", arrays_zip("roundId",
                                                           "name",
                                                           "status",
                                                           "roundscorebonus",
                                                           "lastattemptstatus",
                                                           "approved",
                                                           "waiting",
                                                           "answerdate",
                                                           "showstars",
                                                           "showscore",
                                                           "stars",
                                                           "activities"
                                                           )
                                         )
                             .withColumn("new", explode("new"))
                             .select(col("new.roundId").alias("roundId"),
                                     col("new.name").alias("name"),
                                     col("new.status").alias("status"),
                                     col("new.roundscorebonus").alias("roundscorebonus"),
                                     col("new.lastattemptstatus").alias("lastattemptstatus"),
                                     col("new.waiting").alias("waiting"),
                                     col("new.answerdate").alias("answerdate"),
                                     col("new.showstars").alias("showstars"),
                                     col("new.showscore").alias("showscore"),
                                     col("new.stars").alias("stars"),
                                     col("new.activities").alias("activities"),
                                     )
                             )

df_roundsArray.createOrReplaceTempView("Rounds")
ss.sql("SELECT * FROM Rounds").show(20)


#ACTIVITIES
df_activities = ss.sql("""SELECT 
                   activities.ID_USUARIO, 
                   activities.ID_ATIVIDADE, 
                   activities.NU_PESO,
                   activities.answers
                   FROM Rounds""")

df_activitiesArray = (df_activities.withColumn("new", arrays_zip("ID_USUARIO",
                                                           "ID_ATIVIDADE",
                                                           "NU_PESO",
                                                           "answers"
                                                           )
                                         )
                             .withColumn("new", explode("new"))
                             .select(col("new.ID_USUARIO").alias("id_usuario"),
                                     col("new.ID_ATIVIDADE").alias("id_atividade"),
                                     col("new.NU_PESO").alias("nu_peso"),
                                     col("new.answers").alias("answers")
                                     )
                             )

df_activitiesArray.createOrReplaceTempView("Activities")
ss.sql("SELECT * FROM Activities").show(10)


#ANSWERS
df_answers= ss.sql("""SELECT 
                   answers.ID_USUARIO, 
                   answers.ID_ATIVIDADE, 
                   answers.DT_RESPOSTA,
                   answers.NU_PORCENTAGEM_ACERTOS
                   FROM Activities""")

df_activitiesArray = (df_answers.withColumn("new", arrays_zip("ID_USUARIO",
                                                           "ID_ATIVIDADE",
                                                           "DT_RESPOSTA",
                                                           "NU_PORCENTAGEM_ACERTOS"
                                                           )
                                         )
                             .withColumn("new", explode("new"))
                             .select(col("new.ID_USUARIO").alias("ID_USUARIO"),
                                     col("new.ID_ATIVIDADE").alias("ID_ATIVIDADE"),
                                     col("new.DT_RESPOSTA").alias("DT_RESPOSTA"),
                                     col("new.NU_PORCENTAGEM_ACERTOS").alias("NU_PORCENTAGEM_ACERTOS")
                                     )
                             )

df_activitiesArray.createOrReplaceTempView("Answers")
ss.sql("SELECT * FROM Answers").show(10)

############ INSERÇÃO USER
df_users_insert = ss.sql("""SELECT 
        userid,
        userstatus,
        maxScore,
        score,
        image,
        position,
        myRanking,
        round
     FROM user""")

cursor = conMSSQL.cursor()
# Insert Dataframe into SQL Server:
for index, row in df_users_insert.toPandas().iterrows():
     cursor.execute("INSERT INTO dbo.T_ENG_USER (id_user,nm_user) values(?,?)", row.userid, row.image)
conMSSQL.commit()
conMSSQL.close()