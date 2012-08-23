CREATE TABLE users (
    id INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
    username VARCHAR(128) NOT NULL UNIQUE,
    password VARCHAR(128) NOT NULL,
    email VARCHAR(128) NOT NULL UNIQUE,
	last_login_time DATETIME,
	create_time DATETIME,  
	update_time DATETIME 
);

CREATE TABLE directors (
   id INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
   tmdb_id INTEGER NOT NULL UNIQUE,
   tmdb_name VARCHAR(255) NOT NULL,
   tmdb_url VARCHAR(255) NOT NULL,
   tmdb_bio VARCHAR(255)
);

CREATE TABLE films (
   id INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
   tmdb_id INTEGER NOT NULL UNIQUE,
   tmdb_director_id INTEGER NOT NULL,
   tmdb_name VARCHAR(255) NOT NULL,
   tmdb_url VARCHAR(255),
   tmdb_released DATETIME,
   tmdb_homepage VARCHAR(255),
   tmdb_trailer VARCHAR(255)   
);

CREATE TABLE users_directors_films (
   id INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
   user_id INTEGER NOT NULL,
   director_id INTEGER NOT NULL,
   film_id INTEGER,
   UNIQUE (user_id,film_id)
   FOREIGN KEY(user_id) REFERENCES users(id),
   FOREIGN KEY(director_id) REFERENCES directors(tmdb_id),
   FOREIGN KEY(film_id) REFERENCES films(tmdb_id)   
); 

INSERT INTO directors (tmdb_id, tmdb_name, tmdb_url,tmdb_bio) VALUES ('1', 'gaspar', 'someurl','somebio');
INSERT INTO directors (tmdb_id, tmdb_name, tmdb_url,tmdb_bio) VALUES ('2', 'aasdad', 'someurl','somebio');
INSERT INTO directors (tmdb_id, tmdb_name, tmdb_url,tmdb_bio) VALUES ('3', 'asdad', 'someurl','somebio');
INSERT INTO directors (tmdb_id, tmdb_name, tmdb_url,tmdb_bio) VALUES ('4', 'asdadadsada', 'someurl','somebio');
INSERT INTO directors (tmdb_id, tmdb_name, tmdb_url,tmdb_bio) VALUES ('5', '1321123', 'someurl','somebio');


