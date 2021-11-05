# -*- coding: utf-8 -*-
"""
Created on Wed Oct 27 14:03:48 2021

@author: sansdba
"""

#Import modules
#-*- coding: utf-8 -*-
import time
startTime_1 = time.time()
import numpy as np
import pandas as pd
#import json
import pymssql
from datetime import datetime
import requests
executionTime_1 = (time.time() - startTime_1)
print('Time to import modules: ' + str(executionTime_1))

#Starting time count
startTime_2 = time.time()
df = pd.DataFrame(np.random.randint(1,9999,size=(10000000, 1)), columns=['Random numbers'])
df['Random numbers'] = df['Random numbers'].astype(str)


#SQL Server database connection
conn = pymssql.connect("sqlserver-solution.c7tb1ncdsun6.sa-east-1.rds.amazonaws.com", "user_engage_dev", "admin2021", "DB_ENGAGE_DEV")
cursor = conn.cursor()



#Opening and loading json API
ds_raw = pd.read_json('https://87dyrojjxk.execute-api.us-east-1.amazonaws.com/dev/fiap/raw', encoding='utf-8')

ds_round = ds_raw['rounds']

f = requests.get("https://87dyrojjxk.execute-api.us-east-1.amazonaws.com/dev/fiap/raw")

data = f.json()


# Run all data frame
for users in data:
        v_userid = users['userid']    
        v_userstatus = users['userstatus']
        v_maxscore = users['maxScore']
        v_score = users['score']
        v_image = users['image']
        v_position = users['position']
        v_myranking = users['myRanking']
    
        try:  
            cursor.execute(f"insert into [dbo].[T_ING_USER] (id_user, st_user, nr_max_score, nr_score, nm_image, nr_position, st_myranking) values( '{v_userid}', '{v_userstatus}',  {v_maxscore}, '{v_score}', '{v_image}', '{v_position}', '{v_myranking}' );")           
            #conn.commit()
            
            for rounds in users['rounds']:
               v_roundid = rounds['roundId']
               v_name = rounds['name']
               v_status = rounds['status']
               v_roundscorebonus = rounds['roundscorebonus']
               v_waiting = rounds['waiting']
               v_answerdate = rounds['answerdate']
               v_showstars = rounds['showstars']
               v_showscore = rounds['showscore']
               v_stars = rounds['stars']
               v_approved = rounds['approved']
               
                        
               if 'lastattemptstatus' not in rounds:
                   v_lastattemptstatus = 'null'
               else:
                   v_lastattemptstatus = rounds['lastattemptstatus']
                 
               if not v_answerdate:
                   v_dt_answer = 'null'
               else:
                   v_dt_answer = datetime.strptime(v_answerdate, "%d/%m/%Y").strftime("%Y-%m-%d")
               
                
               try:
                   if  v_lastattemptstatus == 'null' and v_dt_answer == 'null':
                       cursor.execute(f"insert into [dbo].[T_ING_ROUND] (id_round, nm_round, st_round, vl_score_bonus, st_show_star, st_show_score, nr_star, st_approved, st_waiting) values( '{v_roundid}', '{v_name}', '{v_status}', {v_roundscorebonus}, '{v_showstars}', '{v_showscore}', '{v_stars}', '{v_approved}', '{v_waiting}' );")           
                       #conn.commit()
                   elif v_lastattemptstatus == 'null':
                       cursor.execute(f"insert into [dbo].[T_ING_ROUND] (id_round, nm_round, st_round, vl_score_bonus, st_show_star, st_show_score, nr_star, st_approved, st_waiting,dt_answer) values( '{v_roundid}', '{v_name}', '{v_status}', {v_roundscorebonus}, '{v_showstars}', '{v_showscore}', {v_stars}, '{v_approved}', '{v_waiting}', '{v_dt_answer}' );")
                       #conn.commit()
                   elif  v_dt_answer == 'null':
                       cursor.execute(f"insert into [dbo].[T_ING_ROUND] (id_round, nm_round, st_round, vl_score_bonus, st_show_star, st_show_score, nr_star, st_last_attempt, st_approved, st_waiting) values( '{v_roundid}', '{v_name}', '{v_status}', {v_roundscorebonus}, '{v_showstars}', '{v_showscore}', {v_stars}, '{v_lastattemptstatus}', '{v_approved}', '{v_waiting}' );")
                       #conn.commit()
                   else:
                       cursor.execute(f"insert into [dbo].[T_ING_ROUND] (id_round, nm_round, st_round, vl_score_bonus, st_show_star, st_show_score, nr_star, st_last_attempt, st_approved, st_waiting,dt_answer) values( '{v_roundid}', '{v_name}', '{v_status}', {v_roundscorebonus}, '{v_showstars}', '{v_showscore}', {v_stars}, '{v_lastattemptstatus}', '{v_approved}', '{v_waiting}', '{v_dt_answer}' );")
                       #conn.commit()
                  
                   #conn.commit()       
                   
                   for activities in rounds['activities']:
                           v_id_user = activities['ID_USUARIO']
                           v_id_activity = activities['ID_ATIVIDADE']
                           v_nu_peso = activities['NU_PESO']     
                           
                           try:
                               cursor.execute(f"insert into [dbo].[T_ING_ACTIVITY] (id_user, id_activity, nr_peso) values( '{v_id_user}', '{v_id_activity}',  {v_nu_peso} );")
                               #conn.commit()

                               for answers in activities['answers']:
                                   v_answer_user_id = answers['ID_ATIVIDADE']
                                   v_answer_activity_id = answers['ID_ATIVIDADE']
                                   v_answer_date = answers['DT_RESPOSTA']
                                   v_nr_right = answers['NU_PORCENTAGEM_ACERTOS']
                                   
                                   try:
                                       cursor.execute(f"insert into [dbo].[T_ING_ANSWER] (id_user, id_activity, dt_answer, nr_perc_right) values ( '{v_answer_user_id}', '{v_answer_activity_id}', '{v_answer_date}', {v_nr_right} );")
                                       #conn.commit()
                                   except:
                                       conn.rollback
   
                           except:
                               conn.rollback()            
                   #Commit activity block              
                   conn.commit()   
                   
               except:
                  conn.rollback()  
            #commit round block       
            conn.commit()
                

        
        except:
            conn.rollback()     
               
#commit by block user data frame
conn.commit()

conn.close()

# close file
f.close()

executionTime_2 = (time.time() - startTime_2)
print('Time to run the main Python script: ' + str(executionTime_2))
