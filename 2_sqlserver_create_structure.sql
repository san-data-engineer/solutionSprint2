USE [master]
GO

/* Creating user application*/
CREATE LOGIN [user_engage_dev] WITH PASSWORD=N'admin2021', DEFAULT_DATABASE=[DB_ENGAGE_DEV], DEFAULT_LANGUAGE=[us_english], CHECK_EXPIRATION=OFF, CHECK_POLICY=OFF
GO

USE [DB_ENGAGE_DEV]
GO
/****** Object:  User [user_engage_dev]    Script Date: 11/5/2021 6:00:55 AM ******/
CREATE USER [user_engage_dev] FOR LOGIN [user_engage_dev] WITH DEFAULT_SCHEMA=[dbo]
GO
ALTER ROLE [db_owner] ADD MEMBER [user_engage_dev]
GO
/****** Object:  Table [dbo].[T_ING_ACTIVITY]    Script Date: 11/5/2021 6:00:55 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[T_ING_ACTIVITY](
	[id_user] [int] NOT NULL,
	[id_activity] [int] NOT NULL,
	[nr_peso] [int] NOT NULL
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[T_ING_ANSWER]    Script Date: 11/5/2021 6:00:55 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[T_ING_ANSWER](
	[id_user] [int] NOT NULL,
	[id_activity] [int] NULL,
	[dt_answer] [datetime] NULL,
	[nr_perc_right] [int] NULL
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[T_ING_ROUND]    Script Date: 11/5/2021 6:00:55 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[T_ING_ROUND](
	[id_round] [int] NOT NULL,
	[nm_round] [varchar](200) NOT NULL,
	[st_round] [varchar](50) NOT NULL,
	[vl_score_bonus] [int] NOT NULL,
	[st_show_star] [varchar](10) NOT NULL,
	[st_show_score] [varchar](10) NOT NULL,
	[nr_star] [int] NOT NULL,
	[st_last_attempt] [varchar](20) NULL,
	[st_approved] [varchar](20) NOT NULL,
	[st_waiting] [varchar](20) NOT NULL,
	[dt_answer] [date] NULL
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[T_ING_USER]    Script Date: 11/5/2021 6:00:55 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[T_ING_USER](
	[id_user] [int] NOT NULL,
	[st_user] [varchar](50) NOT NULL,
	[nr_max_score] [float] NULL,
	[nr_score] [float] NULL,
	[nm_image] [varchar](200) NOT NULL,
	[nr_position] [int] NOT NULL,
	[st_myranking] [varchar](50) NOT NULL,
	[round] [varchar](200) NULL
) ON [PRIMARY]
GO
