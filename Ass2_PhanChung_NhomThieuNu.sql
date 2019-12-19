--- DROP TABLE

DROP TABLE IF EXISTS comments_topics
DROP TABLE IF EXISTS comments_lessons
DROP TABLE IF EXISTS comments_users
DROP TABLE IF EXISTS join_in
DROP TABLE IF EXISTS manage_courses
DROP TABLE IF EXISTS censor_topics
DROP TABLE IF EXISTS censor_comments
DROP TABLE IF EXISTS orders_courses
DROP TABLE IF EXISTS orders
DROP TABLE IF EXISTS documents
DROP TABLE IF EXISTS videos
DROP TABLE IF EXISTS comments
DROP TABLE IF EXISTS topics
DROP TABLE IF EXISTS dotests
DROP TABLE IF EXISTS tests
DROP TABLE IF EXISTS lessons
DROP TABLE IF EXISTS courses
DROP TABLE IF EXISTS employees
DROP TABLE IF EXISTS lectures
DROP TABLE IF EXISTS students
DROP TABLE IF EXISTS users


--- CREATE TABLE---
CREATE TABLE users
(
	users_id					CHAR(9)			NOT NULL,
	users_password				VARCHAR(30)		NOT NULL,
	users_email					VARCHAR(50)		NOT NULL,
	users_display_name			NVARCHAR(50)	NOT NULL,
	users_age					SMALLINT		CHECK(users_age > 0),
	users_sex					int 			CHECK(users_sex = 0 OR users_sex = 1),
		--- 0: Nu
		--  1: Nam
	users_job					NVARCHAR(50),
	users_phone_number			CHAR(10)	CHECK (users_phone_number NOT LIKE '%[^0-9]%' AND LEN(users_phone_number) = 10),
	users_address_district		NVARCHAR(50),
	users_address_city			NVARCHAR(50),
	users_type					INT				NOT NULL	CHECK(users_type IN (0,1,2)), 
		---0: NHAN_VIEN
		---1: HOC_VIEN, 
		---2: GIAO_VIEN,
	users_money 				SMALLMONEY 		NOT NULL DEFAULT 0 CHECK(users_money >= 0),
	PRIMARY KEY(users_id)
);

CREATE TABLE students
(
	students_id					CHAR(9)		NOT NULL,
	students_score				INT	DEFAULT 0,
	students_level				VARCHAR(100)	DEFAULT 'Beginner', 
		-- Beginner -> Elementary -> Intermediate -> Upper Intermediate
	students_bought_courses INT DEFAULT 0,
	PRIMARY KEY(students_id),
	CONSTRAINT fk_stu_users_id
		FOREIGN KEY (students_id) REFERENCES users(users_id)
		ON DELETE CASCADE
)

CREATE TABLE lectures
(
	lectures_id					CHAR(9)		NOT NULL,
	lectures_certificate		NVARCHAR(100)	NOT NULL,
	lectures_description		NVARCHAR(1000)	NOT NULL,
	PRIMARY KEY(lectures_id),
	CONSTRAINT fk_lec_users_id
		FOREIGN KEY (lectures_id) REFERENCES users(users_id)
		ON DELETE CASCADE	
);

CREATE TABLE employees
(
	employees_id				CHAR(9)			NOT NULL,
	employees_position			NVARCHAR(30)	NOT NULL,
	PRIMARY KEY (employees_id),
	CONSTRAINT fk_empl_users_id 
		FOREIGN KEY (employees_id) REFERENCES users(users_id) 
		ON DELETE CASCADE
);
CREATE TABLE courses
(
	courses_id					CHAR(9)			NOT NULL,
	courses_name				VARCHAR(200)	NOT NULL,
	courses_prices				money			DEFAULT 0, 
	courses_category			VARCHAR(200)	NOT NULL,
	courses_amount				INT				DEFAULT 0,
	courses_description			VARCHAR(1000),
	courses_release				datetime		DEFAULT getdate(),
	courses_total_time			INT		NOT NULL,
	courses_level				SMALLINT		DEFAULT 0,
	courses_state				INT				NOT NULL,
		--- 0: sap mo dang ky, 
		-- 1: dang mo dang ky, 
		-- 2: dang bao tri, 
		-- 3: dang code

	courses_responsible				CHAR(9)			NOT NULL,
	courses_num_lessons INT DEFAULT 0,
	PRIMARY KEY(courses_id),
	CONSTRAINT fk_cour_lectures_id 
		FOREIGN KEY (courses_responsible) REFERENCES lectures(lectures_id)
		ON DELETE CASCADE
	
)

CREATE TABLE lessons
(
	lessons_id					CHAR(9) 	NOT NULL,
	lessons_courses_id			CHAR(9)		NOT NULL,
	lessons_ordinal_number		INT,
	lessons_name				NVARCHAR(1000) NOT NULL,
	lessons_level				INT DEFAULT 0,
	lessons_release			DATETIME DEFAULT GETDATE(),
	lessons_description		NVARCHAR(1000),
	lessons_num_comments INT DEFAULT 0,
	PRIMARY KEY(lessons_id),
	CONSTRAINT fk_less_courses_id
		FOREIGN KEY(lessons_courses_id) REFERENCES courses(courses_id)
		ON DELETE CASCADE
	
)

CREATE TABLE tests
(
	tests_id				CHAR(9)		NOT NULL,
	tests_time_limit		CHAR(9)		NOT NULL,
	tests_answers			INT			NOT NULL,
	tests_courses_id		CHAR(9)		NOT NULL,
	tests_time				INT		,
	PRIMARY KEY(tests_id)		,
	CONSTRAINT fk_test_courses_id
		FOREIGN KEY(tests_courses_id) REFERENCES courses(courses_id)
		ON DELETE CASCADE	
)


CREATE TABLE dotests
(
	dotests_id				CHAR(9)		NOT NULL,
	dotests_students_id		CHAR(9)		NOT NULL,
	dotests_answer			INT			NOT NULL,
	dotests_score			CHAR(9)		NOT NULL,
	dotests_time			TIME(0)		,
	PRIMARY KEY(dotests_id)		,
	CONSTRAINT fk_dotest_students_id
		FOREIGN KEY(dotests_students_id) REFERENCES students(students_id)  -------users_id -> students_id
		ON DELETE CASCADE
)

CREATE TABLE topics
(
	topics_id				CHAR(9)			NOT NULL,
	topics_name				CHAR(100)			NOT NULL,
	topics_content			NVARCHAR(1000)	NOT NULL,
	topics_status_censor	INT				NOT NULL,
	topics_courses_id		CHAR(9)			NOT NULL,
	topics_users_id			CHAR(9)			NOT NULL,
	topics_date_post		DATETIME DEFAULT GETDATE(),
	topics_num_comments	INT	DEFAULT 0,
	PRIMARY KEY(topics_id)		,
	CONSTRAINT fk_topic_courses_id
		FOREIGN KEY(topics_courses_id) REFERENCES courses(courses_id)
		---ON DELETE CASCADE
	,
	CONSTRAINT fk_topic_users_id
		FOREIGN KEY(topics_users_id)	REFERENCES	users(users_id)
		---ON DELETE CASCADE
);

CREATE TABLE comments
(
	comments_id					CHAR(9)		NOT NULL,
	comments_content			NVARCHAR(1000)	NOT NULL,
	comments_date_post			DATETIME DEFAULT GETDATE(),
	comments_topics_id			CHAR(9)		,
	comments_lessons_id			CHAR(9)		,
	comments_users_id			CHAR(9)		NOT NULL,
	
	PRIMARY KEY(comments_id)		,
	CONSTRAINT fk_comments_lessons_id
		FOREIGN KEY(comments_lessons_id) REFERENCES  lessons(lessons_id)
		---ON DELETE CASCADE
	,
	CONSTRAINT fk_comments_users_id
		FOREIGN KEY(comments_users_id)	REFERENCES	users(users_id)
		---ON DELETE CASCADE
	,
	CONSTRAINT fk_comments_topics_id
		FOREIGN KEY(comments_topics_id)	REFERENCES	topics(topics_id)
		---ON DELETE CASCADE
)

CREATE TABLE documents
(
	documents_id						CHAR(9)		NOT NULL,
	documents_lessons_id				CHAR(9)		NOT NULL,
	documents_content					NVARCHAR(1000),
	documents_time_release				DATETIME	DEFAULT GETDATE()

	PRIMARY KEY (documents_id),
	CONSTRAINT fk_documents_lessons_id
		FOREIGN KEY (documents_lessons_id) REFERENCES lessons(lessons_id)
		ON DELETE CASCADE
	
)
CREATE TABLE videos
(
	videos_id					CHAR(9)		NOT NULL,
	videos_title				NVARCHAR(100)	NOT NULL,
	videos_description			NVARCHAR(1000),	
	videos_date_release			DATETIME	,
	videos_lectures_id			CHAR(9)		NOT NULL,
	videos_status_seen			CHAR(9)		NOT NULL,
	videos_time					TIME(0),
	videos_number_view			INT			DEFAULT 0,
	videos_lessons_id			CHAR(9)		NOT NULL,
	PRIMARY KEY(videos_id)		,
	CONSTRAINT fk_videos_lectures_id
		FOREIGN KEY(videos_lectures_id)	REFERENCES  lectures(lectures_id)
		ON DELETE CASCADE
	,
	CONSTRAINT fk_videos_lessons_id
		FOREIGN KEY(videos_lessons_id)	REFERENCES	lessons(lessons_id)
		--ON DELETE CASCADE
)	

CREATE TABLE orders
(
	orders_id					CHAR(9)		NOT NULL,
	orders_users_id				CHAR(9)		NOT NULL,
	orders_times				DATETIME	DEFAULT GETDATE(),
	orders_status				INT			DEFAULT 0,
	orders_courses_id			CHAR(9)		NOT NULL,
	-- 					0  is processing
	-- 				   -1  is deny
	-- 					1  is done

	PRIMARY KEY (orders_id),
	CONSTRAINT fk_orders_users_id
		FOREIGN KEY (orders_users_id) REFERENCES users(users_id)
		ON DELETE CASCADE,
	CONSTRAINT fk_orders_courses_id
		FOREIGN KEY (orders_courses_id) REFERENCES courses(courses_id)
		ON UPDATE CASCADE
)

CREATE TABLE comments_topics
(
	comments_topics_comments_id					CHAR(9) 	NOT NULL,
	comments_topics_topics_id					CHAR(9)		NOT NULL,
	CONSTRAINT fk_comments_topics_comments_id
		FOREIGN KEY (comments_topics_comments_id) REFERENCES comments(comments_id)
		ON DELETE CASCADE
	,
	CONSTRAINT fk_comments_topics_topics_id
		FOREIGN KEY (comments_topics_topics_id) REFERENCES	topics(topics_id)
		ON DELETE CASCADE
)
GO

CREATE TABLE comments_lessons
(
	comments_lessons_comments_id					CHAR(9) 	NOT NULL,
	comments_lessons_lessons_id						CHAR(9)		NOT NULL,

	CONSTRAINT fk_comments_lessons_comments_id
		FOREIGN KEY (comments_lessons_comments_id) REFERENCES comments(comments_id)
		ON DELETE CASCADE
	,
	CONSTRAINT fk_comments_courses_courses_id
		FOREIGN KEY (comments_lessons_lessons_id) REFERENCES	lessons(lessons_id)
		ON DELETE CASCADE
)


CREATE TABLE comments_users
(
	comments_users_comments_id					CHAR(9) 	NOT NULL,
	comments_users_users_id						CHAR(9)		NOT NULL,
	CONSTRAINT fk_comments_users_comments_id
		FOREIGN KEY (comments_users_comments_id) REFERENCES comments(comments_id)
		ON DELETE CASCADE
		,
	CONSTRAINT fk_comments_users_users_id
		FOREIGN KEY (comments_users_users_id) REFERENCES	users(users_id)
		ON DELETE CASCADE	
)

CREATE TABLE join_in
(
	join_in_user_id				CHAR(9)		NOT NULL,
	join_in_courses_id			CHAR(9)		NOT NULL,
	join_in_rate_of_progress	INT			DEFAULT 0,
	join_in_time_register		DATETIME	DEFAULT GETDATE()

	CONSTRAINT fk_join_in_user_id
		FOREIGN KEY(join_in_user_id) REFERENCES students(students_id)
		ON DELETE CASCADE
	,
	CONSTRAINT fk_join_in_courses_id
		FOREIGN	KEY(join_in_courses_id)	REFERENCES courses(courses_id)
		---ON DELETE CASCADE	
)

CREATE TABLE manage_courses
(
	manage_courses_id			CHAR(9) 	NOT NULL,
	manage_courses_users_id		CHAR(9)		NOT NULL

	CONSTRAINT fk_manage_courses_id
		FOREIGN KEY(manage_courses_id) REFERENCES courses(courses_id)
		ON DELETE CASCADE
	,
	CONSTRAINT fk_manage_courses_users_id
		FOREIGN KEY(manage_courses_users_id) REFERENCES users(users_id)
		---ON DELETE CASCADE
)

GO
CREATE	TABLE censor_topics
(
	censor_topics_id			CHAR(9)		NOT NULL,
	censor_topics_users_id		CHAR(9)		NOT NULL,
	censor_topics_time_censor	DATETIME 	DEFAULT GETDATE(),
	CONSTRAINT fk_censor_topics_id
		FOREIGN KEY (censor_topics_id) REFERENCES topics(topics_id)
		ON DELETE CASCADE
	,
	CONSTRAINT fk_censor_topics_users_id
		FOREIGN KEY (censor_topics_users_id) REFERENCES users(users_id)
		ON DELETE CASCADE
)


CREATE TABLE censor_comments
(
	censor_comments_id			CHAR(9)		NOT NULL,
	censor_comments_users_id	CHAR(9)		NOT NULL,
	censor_comments_time_censor	DATETIME	DEFAULT GETDATE(),
	censor_comments_status		INT			DEFAULT 0,
		-- 			 0 is censoring
		-- 			-1 is deny
		-- 			 1 is agree
	
	PRIMARY KEY (censor_comments_id),
	CONSTRAINT fk_censor_comments_users_id
		FOREIGN KEY (censor_comments_users_id) REFERENCES users(users_id)
		ON DELETE CASCADE
)	


