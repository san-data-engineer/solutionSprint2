USE DB_ENGAGE_DEV
GO
--USER VALIDATION
SELECT id_user,count(*) 
FROM dbo.T_ING_USER 
GROUP BY id_user
HAVING count(*) >1;

SELECT * 
FROM dbo.T_ING_USER;

SELECT id_user,count(*) 
FROM dbo.T_ING_USER 
GROUP BY id_user;

ALTER TABLE t_ing_user ALTER COLUMN nr_max_score float;

--ROUND VALIDATION
SELECT count(*) 
FROM dbo.T_ING_ROUND;

SELECT * 
FROM dbo.T_ING_ROUND;

SELECT id_round,count(*) 
FROM dbo.T_ING_ROUND 
GROUP BY id_round
HAVING count(*) >0;


--ACITIVITY VALIDATION
SELECT count(*) 
FROM dbo.T_ING_activity;

SELECT * 
FROM dbo.T_ING_activity;

SELECT nr_peso,count(1) 
FROM dbo.T_ING_ACTIVITY 
GROUP BY nr_peso;

SELECT id_activity,count(*) 
FROM dbo.T_ING_activity 
GROUP BY id_activity;

--ANSWER VALIDATION
SELECT count(*) 
FROM dbo.T_ING_answer;



SELECT * 
FROM dbo.T_ING_answer;

SELECT id_activity,count(1) 
FROM dbo.T_ING_answer 
GROUP BY id_activity
HAVING count(1) >0;

SELECT id_answer,count(*) 
FROM dbo.T_ING_answer 
GROUP BY id_answer;

--CLEANING TABLES
DELETE FROM dbo.t_ing_round;
DELETE FROM dbo.t_ing_user;
DELETE FROM dbo.T_ING_ACTIVITY;
DELETE FROM dbo.T_ING_ANSWER;






