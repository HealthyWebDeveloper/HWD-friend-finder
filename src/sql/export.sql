


SELECT 
	`encodedId` AS 'csv_post_title', 
	`aboutMe` AS 'csv_post_post', 
	`aboutMe` AS 'csv_post_excerpt', 
	'friend' AS 'csv_post_type', 
	`userTimestamp` AS 'csv_post_date', 
	`displayName` AS 'displayName', 
	`encodedId` AS 'encodedId', 
	`gender` as 'gender', 
	`age` AS 'age',
	`avatar` AS 'avatar',
	`avatar150` AS 'avatar150',
	`averageDailySteps` AS 'averageDailySteps',
	`city` AS 'city',
	`country` AS 'country',
	`dateOfBirth` AS 'dateOfBirth'


	FROM `users` 


-- "csv_post_title","csv_post_post","csv_post_type","csv_post_excerpt","csv_post_categories","csv_post_tags","csv_post_date","custom_field_1","custom_field_2"
