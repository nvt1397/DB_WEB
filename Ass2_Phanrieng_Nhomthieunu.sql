Nguyễn Văn Thuần - 1713376
------------ CREATE PROCEDURE p_add_users -----------------
--DROP PROCEDURE IF EXISTS p_add_users
CREATE PROCEDURE p_add_users
    @id                     CHAR(9),
	@password				VARCHAR(30),
	@email					VARCHAR(50),
	@display_name			NVARCHAR(50),
	@age					SMALLINT,
	@sex					INT,
		--- 0: Nu
		--  1: Nam
	@job					NVARCHAR(50),
	@phone_number			CHAR(10),
	@address_district		NVARCHAR(50),
	@address_city			NVARCHAR(50),
	@type					INT	, 
		---0: NHAN_VIEN
		---1: HOC_VIEN, 
		---2: GIAO_VIEN,
	@money                SMALLMONEY
AS
BEGIN
    IF EXISTS (SELECT * FROM users WHERE users_email = @email or users_id = @id)
        RAISERROR ('User was registered',16,1)
    ELSE
    BEGIN
        INSERT INTO users
        (
            users_id,
            users_password,
            users_email,
            users_display_name,
            users_age,
            users_sex,
            users_job,
            users_phone_number,
            users_address_district,
            users_address_city,
            users_type,
            users_money
        )
        VALUES
        (
            @id,
            @password,
            @email,
            @display_name,
            @age,
            @sex,
            @job,
            @phone_number,
            @address_district,
            @address_city,
            @type,
            @money  
        )
    END
END

GO
EXEC p_add_users 'user123','blyat1234','ucantseeme@gmail.com', 'John Cena',20,1,'Wrestler','0123456789','District 1','HCMC', 0,10
-------------- PROCEDURE VIEW USER --------------------
--DROP PROCEDURE IF EXISTS p_view_student_user_by_job
CREATE PROCEDURE p_view_student_user_by_job
    @job              NVARCHAR(50)
AS
BEGIN

	IF EXISTS (SELECT * FROM users WHERE users_job=@job AND users_type = '1') 
		SELECT
			users_id,
			users_email,
			users_display_name,
			users_age,
			users_sex,
			users_phone_number,
			users_address_city,
			users_address_district,
			users_money
		FROM users
		WHERE users_job=@job AND users_type = '1'
	ELSE
		BEGIN
		PRINT 'ERROR:CANT FIND USERS '
		RETURN -1
		END
	
END

GO

EXEC p_view_student_user_by_job 'student'
-- -------------- TRIGGER ----------------------

-- FOR --
CREATE TRIGGER delete_id_users_trigger ON employees
FOR DELETE
AS
BEGIN
    DECLARE @employees_id       CHAR(9)
    SELECT @employees_id = employees_id FROM deleted
    IF EXISTS (SELECT users_id FROM users, employees WHERE employees_id = users_id)
        BEGIN
            DELETE FROM users WHERE users.users_id = @employees_id
        END
END



delete from employees where employees_id = 'user0011'
-- - AFTER --
CREATE TRIGGER insert_users_Trigger ON users
AFTER INSERT
AS 
BEGIN
    IF EXISTS (SELECT users_type FROM inserted WHERE 
    users_type = 0)
        BEGIN
            INSERT INTO employees
            (
                employees_id,
                employees_position
            )
            SELECT
                users_id,
                'DEFAULT'
            FROM inserted;
        END

    IF EXISTS (SELECT users_type FROM inserted WHERE 
    users_type = 1)
        BEGIN
            INSERT INTO students
            (
                students_id
		students_score
		students_level
		students_bought_courses
            )
            SELECT
                users_id
		0
		'beginner'
		0		
            FROM inserted;
        END

    IF EXISTS (SELECT users_type FROM inserted WHERE 
    users_type = 2)
        BEGIN
            INSERT INTO lectures
            (
                lectures_id,
                lectures_certificate,
                lectures_description
            )
            SELECT
                users_id,
                'DEFAULT',
                'DEFAULT'
            FROM inserted;
        END
END

EXEC p_add_users 'user1975','aaaaa1234','admin12@gmail.com', 'Sarah Fortune',28,0,'Manager','02154411519','District 5','HCMC', 0, 0
--DROP TRIGGER delete_id_users_trigger

--DROP FUNCTION rate_male_in_user_type
CREATE FUNCTION rate_male_in_user_type
(
    @users_type     INT
)
    RETURNS FLOAT
AS
BEGIN
    IF @users_type IN (0, 1, 2)
    BEGIN
        DECLARE @total_males    FLOAT
            SET @total_males = (SELECT COUNT(users_sex) FROM users WHERE users_sex = 1 AND users_type = @users_type)
        
        DECLARE @total_females  FLOAT
            SET @total_females = (SELECT COUNT(users_sex) FROM users WHERE users_sex = 0 AND users_type = @users_type)
        
        DECLARE @rate FLOAT
            SET @rate = @total_males/(@total_males + @total_females)
        RETURN @rate
    END
    RETURN 0
END 

GO

SELECT DISTINCT users_type  AS 'Type', dbo.rate_male_in_user_type(users_type) AS 'Percentage of Males' FROM users
	ORDER BY dbo.rate_male_in_user_type(users_type)



--DROP FUNCTION total_money_user
CREATE FUNCTION total_money_user
(
    @user_id    CHAR (9)
)
RETURNS SMALLMONEY
AS
BEGIN
    DECLARE @total SMALLMONEY
    SET @total = 
        (
            SELECT SUM(a.courses_prices)
            FROM courses a, join_in b
            WHERE  b.join_in_courses_id = a.courses_id and b.join_in_user_id = @user_id 
        )
	IF @total IS NULL
	SET @total = 0
    RETURN @total
END

GO

SELECT users_display_name  AS 'Name', dbo.total_money_user(users_id) AS 'Money Spent' FROM users
	ORDER BY dbo.total_money_user(users_id) DESC
-----------------------------a------------------------------------------------------------------------------
SELECT users_display_name AS 'Name', users_money AS 'Money' FROM dbo.users JOIN dbo.join_in ON users.users_id = join_in.join_in_user_id
        WHERE users_money >= 10 AND join_in_courses_id = 'CS1321'
        ORDER BY users_money


-----------------------------b------------------------------------------------------------------------------
SELECT users_display_name, COUNT(join_in_courses_id) AS 'Number of Courses Joined' FROM dbo.join_in JOIN users ON join_in_user_id = users_id
	WHERE users_age > 18
    	GROUP BY users_display_name
    	HAVING COUNT(join_in_courses_id) >= 2
    	ORDER BY COUNT(join_in_courses_id) DESC


SELECT join_in_courses_id, AVG(users_age) AS 'Age' FROM dbo.users JOIN dbo.join_in ON users.users_id = join_in.join_in_user_id
    	WHERE join_in.join_in_time_register >= '2019-01-01'
	GROUP BY join_in_courses_id
	HAVING AVG(users_age) >= 18	
    	ORDER BY AVG(users_age)	
-------Đỗ Minh Thắng - 1713217

-------- PROCEDURE -----------
-- Create 
CREATE PROCEDURE p_create_courses
    @courses_id					CHAR(9)			,
	@courses_name				VARCHAR(200)	,
	@courses_prices				MONEY           , 
	@courses_category			VARCHAR(200)	,
	@courses_amount				INT				,
	@courses_description		VARCHAR(1000)   ,
	@courses_release			DATETIME        ,
	@courses_total_time			INT		        ,
	@courses_level				SMALLINT        ,
	@courses_state              INT             ,
    @courses_responsible        CHAR(9)

AS
BEGIN
    IF EXISTS (SELECT * FROM dbo.courses WHERE  @courses_id = courses_id)
        RAISERROR ('Courese was existed',16,1)
    ELSE
        BEGIN
            INSERT INTO dbo.courses
            (
                courses_id					,
                courses_name				,
                courses_prices				, 
                courses_category			,
                courses_amount				,
                courses_description			,
                courses_release				,
                courses_total_time			,
                courses_level				,
                courses_state				,
                    --- 0: sap mo dang ky, 
                    -- 1: dang mo dang ky, 
                    -- 2: dang bao tri, 
                    -- 3: dang code

                courses_responsible	
            )
            VALUES
            (
                @courses_id					,
                @courses_name				,
                @courses_prices				, 
                @courses_category			,
                @courses_amount				,
                @courses_description		,
                @courses_release			,
                @courses_total_time			,
                @courses_level				,
                @courses_state              ,
                @courses_responsible
            )
        END
END
GO

-- view ---
CREATE PROCEDURE p_view_information_course
    @courses_id             CHAR(9)
AS 
BEGIN
    IF EXISTS (SELECT * FROM dbo.courses WHERE @courses_id = courses.courses_id)
        SELECT * FROM dbo.courses WHERE @courses_id = courses.courses_id
    ELSE 
        RAISERROR ('Can not found courses',16,1)
END
GO



--------- TRIGGER -------------
--- AFTER ----
CREATE TRIGGER up_courses_amount_trigger ON dbo.join_in
AFTER INSERT
AS 
BEGIN
    DECLARE @courses_id         CHAR(9)
        SELECT @courses_id = join_in_courses_id FROM inserted
    
    DECLARE @students_id        CHAR(9)
        SELECT @students_id = join_in_user_id FROM inserted
    
    IF EXISTS (SELECT courses.courses_id FROM courses WHERE courses.courses_id = @courses_id)
        UPDATE dbo.courses
            SET courses_amount = courses_amount + 1
            WHERE @courses_id = courses_id
        UPDATE dbo.students
            SET students_bought_courses = students_bought_courses + 1
            WHERE @students_id = students_id
END
GO

--- FOR ----
CREATE TRIGGER down_bought_courses_trigger ON dbo.join_in
FOR DELETE
AS
BEGIN
    DECLARE @courses_id         CHAR(9)
        SELECT @courses_id = join_in_courses_id FROM deleted
    DECLARE @students_id        CHAR(9)
        SELECT @students_id = join_in_user_id FROM deleted
    
    IF EXISTS (SELECT courses.courses_id FROM courses WHERE courses.courses_id = @courses_id)
        UPDATE dbo.courses
            SET courses_amount = courses_amount - 1
            WHERE @courses_id = courses_id
        UPDATE dbo.students
            SET students_bought_courses = students_bought_courses - 1
            WHERE @students_id = students_id
END
GO


-- SELECT thong tin cua cac hoc sinh tham gia khoa hoc
SELECT courses_name AS 'Course Name', join_in_time_register, users_display_name
    FROM courses c
    LEFT JOIN join_in j ON j.join_in_courses_id = c.courses_id
    LEFT JOIN users u ON u.users_id=j.join_in_user_id
    WHERE c.courses_id = 'CS1301'
ORDER BY j.join_in_time_register DESC

-- Select khoa hoc gan day nhat trong vong 1 tuan va dang mo dang ky cua cac giao vien
SELECT users_display_name as 'Lecturer name', MAX(courses_release) as 'date course release'
FROM courses c
LEFT JOIN users u ON u.users_id=c.courses_responsible
GROUP BY u.users_display_name
HAVING Max(CONVERT(DATE, c.courses_release)) BETWEEN DATEADD(DAY, -7, CONVERT(DATE, GETDATE())) AND CONVERT(DATE, GETDATE())
ORDER BY users_display_name

-- select giao vien co hoc sinh/1 khoa hoc dong nhat
SELECT users_display_name AS 'Lecturer' ,MAX(courses_amount) AS 'Num_student'
FROM courses c
LEFT JOIN users u ON u.users_id=c.courses_responsible
GROUP BY users_display_name
HAVING MAX(c.courses_amount)>0
ORDER BY u.users_display_name 
GO

--------- FUNCTION -------------
CREATE FUNCTION f_number_of_category_same_courses
(
    @courses_category           VARCHAR(200)
)
    RETURNS INT
AS
BEGIN 
    IF EXISTS ( SELECT * FROM dbo.courses WHERE courses_category = @courses_category)
        BEGIN
            DECLARE @result      INT =  0
                SET @result = (SELECT COUNT(*) FROM dbo.courses WHERE courses_category = @courses_category)
            RETURN @result
        END
    RETURN 0
END
GO


CREATE FUNCTION f_avg_student
(
    @courses_category        VARCHAR(200)
)
    RETURNS INT
AS
BEGIN
    IF EXISTS (SELECT * FROM dbo.courses WHERE courses_category = @courses_category)
        BEGIN
            DECLARE @result             INT
                SET @result =  (SELECT SUM(courses_amount)/COUNT(*)  FROM courses 
                                WHERE courses_category = @courses_category)
            RETURN @result
        END
    RETURN CAST('Courses category is not exists' AS INT)
END
GO

PRINT dbo.f_avg_student('Computer Science')

------Ten: Nguyen khai Vy - 1714050										
CREATE PROCEDURE add_new_lesson
		@id char(9),
		@courses_id char(9),
		@ordinal_number int,
		@name nvarchar(1000),
		@level int,
		@release datetime,
		@description nvarchar(1000)
		
AS
BEGIN
	--SET NOCOUNT ON added to prevent extra result sets from
	-- interfering with SELECT statements
	SET NOCOUNT ON;
	
	IF EXISTS (SELECT * FROM lessons WHERE lessons_id=@id) 
		BEGIN
		PRINT 'ERROR: Duplicate lessons ID'
		RETURN -1
		END
	IF EXISTS (
		SELECT * FROM lessons 
		WHERE lessons_ordinal_number=@ordinal_number AND
				lessons_courses_id=@courses_id)
		BEGIN
		PRINT 'ERROR: Lesson exists'
		RETURN -1
		END
	INSERT INTO lessons(
		lessons_id,
		lessons_courses_id,
		lessons_ordinal_number,
		lessons_name,
		lessons_level,
		lessons_release,
		lessons_description,
		lessons_num_comments
	)
	VALUES(
		@id,
		@courses_id,
		@ordinal_number,
		@name,
		@level,
		@release,
		@description,
		0)

	RETURN @@ROWCOUNT
END
GO
CREATE PROCEDURE display_all_lessons_of_course
		@courses_id char(9)
AS
BEGIN

	IF NOT EXISTS (SELECT * FROM lessons WHERE lessons_courses_id=@courses_id) 
		BEGIN
		PRINT 'ERROR:Cant find any lesson! '
		RETURN -1
		END
	SELECT
		lessons_id,
		lessons_courses_id,
		lessons_ordinal_number,
		lessons_name,
		lessons_level,
		lessons_release,
		lessons_description,
		lessons_num_comments
	FROM lessons
	WHERE lessons_courses_id=@courses_id

END
GO
CREATE TRIGGER lessons_insert_trigger 
ON lessons
AFTER INSERT
AS
BEGIN
	SELECT *
	FROM lessons

	UPDATE courses
	SET courses_num_lessons=
		(SELECT COUNT(*)
		FROM lessons ls
		WHERE ls.lessons_courses_id=inserted.lessons_courses_id
		)
	FROM courses
	INNER JOIN inserted
	ON courses.courses_id=inserted.lessons_courses_id
END;
GO
CREATE TRIGGER lessons_delete_trigger
ON lessons
FOR DELETE
AS
BEGIN
	SELECT *
	FROM lessons

	UPDATE courses
	SET courses_num_lessons=
		(SELECT COUNT(*)
		FROM lessons ls
		WHERE ls.lessons_courses_id=deleted.lessons_courses_id
		)
	FROM courses
	INNER JOIN deleted
	ON courses.courses_id=deleted.lessons_courses_id
END;
GO
CREATE FUNCTION total_lessons_of_course
( 
@id char(9) 
)
RETURNS INT
AS

BEGIN
	IF NOT EXISTS (SELECT* FROM lessons WHERE lessons_courses_id=@id)
		RETURN 0
	
	DECLARE @total INT;
	SET @total= (SELECT COUNT(*) FROM lessons WHERE lessons_courses_id=@id)
	RETURN @total

END;
GO
CREATE FUNCTION checkif_course_has_numberoflessons_gt
( 
@id char(9),
@bound int
)
RETURNS bit
AS

BEGIN
	IF NOT EXISTS (SELECT* FROM lessons WHERE lessons_courses_id=@id)
		RETURN 0
	
	DECLARE @total INT;
	DECLARE @ret BIT;
	SET @total= (SELECT COUNT(*) FROM lessons WHERE lessons_courses_id=@id)
	IF @total > @bound
		SET @ret=1
	ELSE
		SET @ret=0
	RETURN @ret
END;
GO
CREATE FUNCTION checkif_course_lt_avg
( 
@id char(9)
)
RETURNS bit
AS

BEGIN
	IF NOT EXISTS (SELECT* FROM lessons WHERE lessons_courses_id=@id)
		RETURN 0
	DECLARE @this_course_avg INT;
	DECLARE @total_avg INT;
	DECLARE @ret BIT;
	SET @total_avg=
		(SELECT AVG(tbl.avg_level)
		FROM
			(	SELECT lessons_courses_id as courses_id,AVG(lessons_level) as avg_level
				FROM lessons 
				GROUP BY lessons_courses_id
				HAVING COUNT(lessons_ordinal_number)>0
			) as tbl)

	SET @this_course_avg=
			(	SELECT AVG(lessons_level) as avg_level
				FROM lessons 
				WHERE lessons_courses_id=@id
			) 


	IF @this_course_avg <= @total_avg
		SET @ret=1
	ELSE
		SET @ret=0
	RETURN @ret
END;
GO
------SELECT
select *
FROM lessons
WHERE lessons_courses_id='AR1121'
ORDER BY lessons_ordinal_number desc

--find total lessons of each course has, only show the courses have greater than 5 lessons
select tbla.*,courses.courses_name
FROM
	(SELECT lessons_courses_id as courses_id,COUNT(lessons_ordinal_number) as total_num
	FROM lessons 
	--WHERE lessons_level <2
	GROUP BY lessons_courses_id
	HAVING COUNT(lessons_ordinal_number)>5
	) as tbla, courses
WHERE tbla.courses_id=courses.courses_id
ORDER BY total_num

--find courses which have greater than 5 lessons , and calculate the avarage level for each course
select tbla.*,courses.courses_name
FROM
	(SELECT lessons_courses_id as courses_id,AVG(lessons_level) as avg_level
	FROM lessons 
	--WHERE lessons_level <2
	GROUP BY lessons_courses_id
	HAVING COUNT(lessons_ordinal_number)>5
	) as tbla, courses
WHERE tbla.courses_id=courses.courses_id
ORDER BY avg_level




-------- Trần Thị Thắm - 1713214  


---1A PROCEDURE
CREATE PROCEDURE add_new_comment
	@comments_id				CHAR(9),
	@comments_content			NVARCHAR(1000),
	@comments_topics_id			CHAR(9),
	@comments_lessons_id		CHAR(9),
	@comments_users_id			CHAR(9)
AS
BEGIN

	IF NOT EXISTS (SELECT * FROM comments WHERE comments_id=@comments_id ) 
	BEGIN
		IF @comments_topics_id != '' AND @comments_lessons_id  !=''
			BEGIN
			RAISERROR(N'one comment can not exist in both topics and lessons',16,1)
			END
	
		ELSE IF @comments_content LIKE '%[#$%^&*@]%'
			BEGIN
				RAISERROR(N'comment cannot contains special characters #$%^&*@ ',16,1)
			END
		
		ELSE IF LEN(@comments_content)> 900
			BEGIN
				RAISERROR(N'your comment is too long ',16,1)
			END
		
		ELSE IF CHARINDEX('hell',@comments_content)>0
			BEGIN
				RAISERROR(N'your comment contains sensitive words ',16,1)
			END
	
		ELSE IF (@comments_topics_id = '')
			BEGIN
				INSERT INTO comments(
					comments_id,
					comments_content,
					comments_topics_id,
					comments_lessons_id,
					comments_users_id
				) VALUES (
					@comments_id, @comments_content,
					Null, @comments_lessons_id, @comments_users_id
				)
			 END
		ELSE IF (@comments_lessons_id = '')
			BEGIN
				INSERT INTO comments(
					comments_id,
					comments_content,
					comments_topics_id,
					comments_lessons_id,
					comments_users_id
				) VALUES (
					@comments_id, @comments_content,
					@comments_topics_id,Null, @comments_users_id
				)
			END	
	END
	ELSE RETURN 0
END
---DROP PROCEDURE IF EXISTS add_new_comment
---exec

-- exec add_new_comment 'cmt0038','Theres no %&name2 column in either CUSTOMER table you need to rearrange the customer name columns, swapping for null to match the desired output. Once that is done, you do provide an alternative to the LEFT JOINs most of us came up with.', 'topic0001','','user0023'
-- exec add_new_comment 'cmt0045','name2 is an unknown column in the first half of that union (and name1 in the second half) ', 'topic0001','lesson001','user0012'
-- exec add_new_comment 'cmt0042','name2 an unknown column in the first half of that union (and name1 in the second half) ', 'topic0001','','user0035'
-- exec add_new_comment 'cmt0036','name2 is an unknown column in the first half of that union (and name1 in the second half) ', 'topic0001','','user0007'

exec add_new_comment 'cmt0100','name22222 is an unknown column in the first half of that union (and name1 in the second half) ', 'topic0001','','user0010'


CREATE PROCEDURE showcomment
	@comments_id				CHAR(9)
AS
BEGIN
	SELECT users.users_display_name as UserName, comments.comments_date_post as DateOfComment, comments.comments_content as CommentContent
	FROM (comments right join users on comments.comments_users_id=users.users_id)
	WHERE comments.comments_id=@comments_id
	ORDER BY comments.comments_date_post desc
END
exec showcomment 'cmt0002'

------------TRIGGER 1
CREATE TRIGGER insert_1 ON comments
	AFTER INSERT,UPDATE
	AS
	BEGIN
		declare @lessons_id char(9), @topics_id char(9),@comments_id char(9),@count INT
		SELECT @lessons_id = comments_lessons_id
		FROM inserted i
		SELECT @topics_id = comments_topics_id
		FROM inserted i
		SELECT @comments_id = comments_id
		FROM inserted i
		IF @lessons_id IS NOT NULL
			BEGIN
				SELECT @count = COUNT(comments_id) FROM comments WHERE comments_lessons_id = @lessons_id
				UPDATE lessons
				SET lessons_num_comments=@count 
				WHERE lessons_id = @lessons_id
				INSERT INTO comments_lessons VALUES(@comments_id,@lessons_id)
			END
		ELSE IF @topics_id IS NOT NULL
			BEGIN
				SELECT @count = COUNT(comments_id) FROM comments WHERE comments_topics_id = @topics_id
				UPDATE topics
				SET topics_num_comments=@count 
				WHERE topics_id = @topics_id
				INSERT INTO comments_topics VALUES(@comments_id,@topics_id)
			END
	END

---DROP TRIGGER IF EXISTS insert_1


---INSERT INTO comments VALUES ('cmt0300','Help me plz', convert(datetime,'12/12/2019',103),Null,'lesson007','user0029')
---DELETE FROM comments WHERE comments_id='cmt0300'


------------TRIGGER 2
CREATE TRIGGER afterdelete ON comments
	FOR DELETE
	AS
	BEGIN
		declare @lessons_id char(9), @topics_id char(9),@comments_id char(9),@count INT
		SELECT @lessons_id = comments_lessons_id
		FROM deleted
		SELECT @topics_id = comments_topics_id
		FROM deleted
		IF @lessons_id IS NOT NULL
			BEGIN
				SELECT @count = COUNT(comments_id) FROM comments WHERE comments_lessons_id = @lessons_id
				UPDATE lessons
				SET lessons_num_comments=@count 
				WHERE lessons_id = @lessons_id
				DELETE FROM comments_lessons WHERE comments_lessons_comments_id = @comments_id
			END
		ELSE IF @topics_id IS NOT NULL
			BEGIN			
				SELECT @count = COUNT(comments_id) FROM comments WHERE comments_topics_id = @topics_id
				UPDATE topics
				SET topics_num_comments=@count 
				WHERE topics_id = @topics_id
				DELETE FROM comments_topics WHERE comments_topics_comments_id = @comments_id
			END
	END

---DROP TRIGGER IF EXISTS afterdelete



------------QUERY 1
SELECT comments_id, users_display_name, comments_content, lessons_name, topics_name, comments_date_post
FROM comments c
LEFT JOIN lessons l ON l.lessons_id=c.comments_lessons_id
LEFT JOIN topics t ON t.topics_id=c.comments_topics_id
LEFT JOIN users u ON u.users_id=c.comments_users_id
WHERE CONVERT(DATE, c.comments_date_post) BETWEEN DATEADD(DAY, -7, CONVERT(DATE, GETDATE())) AND CONVERT(DATE, GETDATE())
ORDER BY c.comments_date_post

------------QUERY 2
SELECT users_display_name, COUNT(c.comments_id) AS 'num_comments_user'
FROM comments c
LEFT JOIN users u ON u.users_id=c.comments_users_id
GROUP BY users_display_name
HAVING COUNT(c.comments_id)>1
ORDER BY COUNT(c.comments_id) DESC, u.users_display_name

------------QUERY 3
SELECT MAX(comments_date_post) as 'date', users_display_name as 'user_name'
FROM comments c
LEFT JOIN users u ON u.users_id=c.comments_users_id
GROUP BY u.users_display_name
HAVING Max(CONVERT(DATE, c.comments_date_post)) BETWEEN DATEADD(DAY, -4, CONVERT(DATE, GETDATE())) AND CONVERT(DATE, GETDATE())
ORDER BY users_display_name

--------FUNCTION 1
CREATE FUNCTION calAvgCmtTopic
(
	@courses_id CHAR(9)
)
RETURNS @AvgComment table
(
	Name_courses NVARCHAR(255),
	Avg_Comment_Topic FLOAT
)
AS 
BEGIN
	IF EXISTS(SELECT * FROM courses WHERE courses_id=@courses_id)
	BEGIN
		DECLARE  @total_comment INT
		DECLARE  @total_topic INT
		DECLARE  @name_courses NVARCHAR(255)
		DECLARE  @avg_Comment_Topic FLOAT
		SET  @total_comment=0
		SELECT  @total_topic=COUNT(topics_id) FROM topics WHERE @courses_id=topics_courses_id
		IF @total_topic=0 RETURN
		DECLARE count_avg cursor FOR SELECT topics_num_comments FROM topics WHERE @courses_id=topics_courses_id
		OPEN count_avg 
		DECLARE @getTopicNumCmt INT
		FETCH NEXT FROM count_avg INTO @getTopicNumCmt
		WHILE @@FETCH_STATUS=0
		BEGIN
			SELECT @total_comment= @total_comment+@getTopicNumCmt
			FETCH NEXT FROM count_avg into @getTopicNumCMt
		END
		SELECT @avg_Comment_Topic= @total_comment/@total_topic 
		SELECT @name_courses=courses_name FROM courses WHERE courses_id=@courses_id
		INSERT INTO @AvgComment VALUES(@name_courses,@avg_Comment_Topic)
	END
	RETURN 
END
---DROP FUNCTION IF EXISTS  calAvgCmtTopic
---SELECT * FROM calAvgCmtTopic('CS1301');

--------FUNCTION 2
CREATE FUNCTION calAvgCmtLesson
(
	@courses_id CHAR(9)
)
RETURNS @AvgComment table
(
	Name_courses NVARCHAR(255),
	Avg_Comment_Lesson FLOAT
)
AS 
BEGIN
	IF EXISTS(SELECT * FROM courses WHERE courses_id=@courses_id)
	BEGIN
		DECLARE  @total_comment INT
		DECLARE  @total_lessons INT
		DECLARE  @name_courses NVARCHAR(255)
		DECLARE  @avg_Comment_Lesson FLOAT
		SET  @total_comment=0
		SELECT  @total_lessons=COUNT(lessons_id) FROM lessons WHERE @courses_id= lessons_courses_id
		IF @total_lessons=0 RETURN
		DECLARE count_avg cursor FOR SELECT lessons_num_comments FROM lessons WHERE @courses_id=lessons_courses_id
		OPEN count_avg 
		DECLARE @getLessonNumCmt INT
		FETCH NEXT FROM count_avg INTO @getLessonNumCmt
		WHILE @@FETCH_STATUS=0
		BEGIN
			SELECT @total_comment= @total_comment+@getLessonNumCmt
			FETCH NEXT FROM count_avg into @getLessonNumCMt
		END
		SELECT @avg_Comment_Lesson= @total_comment/@total_Lessons 
		SELECT @name_courses=courses_name FROM courses WHERE courses_id=@courses_id
		INSERT INTO @AvgComment VALUES(@name_courses,@avg_Comment_Lesson)
	END
	RETURN 
END
----DROP FUNCTION IF EXISTS  calAvgCmtLesson
----SELECT * FROM calAvgCmtLesson('MK1201');