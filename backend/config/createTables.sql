/*
 * fakeTwitter Table creation script.
 */
/* SET foreign_key_checks=0; */

USE fakeTwitter;

CREATE TABLE IF NOT EXISTS users (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    firstName VARCHAR(30) NOT NULL,
    lastName VARCHAR(30) NOT NULL,
    username VARCHAR(20) NOT NULL,
    createdOn DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS followers (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    followee_id INT UNSIGNED NOT NULL,
    follower_id INT UNSIGNED NOT NULL,
    CONSTRAINT followee_id_TO_user_id FOREIGN KEY (followee_id) REFERENCES users(id)
    ON UPDATE CASCADE 
    ON DELETE CASCADE,
    CONSTRAINT follower_id_TO_user_id FOREIGN KEY (follower_id) REFERENCES users(id)
    ON UPDATE CASCADE 
    ON DELETE CASCADE
) ENGINE=InnoDB;

/* 
CREATE TABLE IF NOT EXISTS followees (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    user_id INT UNSIGNED NOT NULL,
    followee_id INT UNSIGNED NOT NULL,
    CONSTRAINT FK_user_id FOREIGN KEY (user_id) REFERENCES users(id)
    ON UPDATE CASCADE 
    ON DELETE CASCADE,
    CONSTRAINT FK_followee_id FOREIGN KEY (followee_id) REFERENCES users(id)
    ON UPDATE CASCADE 
    ON DELETE CASCADE
) ENGINE=InnoDB; */


CREATE TABLE IF NOT EXISTS posts (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    body VARCHAR(280) NOT NULL,
    author_id INT UNSIGNED NOT NULL,
    createdOn DATETIME DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT author_id_TO_user_id 
    FOREIGN KEY (author_id) REFERENCES users(id)
    ON UPDATE CASCADE
    ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS replies (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    body VARCHAR(280) NOT NULL,
    commentor_id INT UNSIGNED NOT NULL,
    post_id INT UNSIGNED NOT NULL,
    createdOn DATETIME DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT post_id_TO_post_id 
    FOREIGN KEY (post_id) REFERENCES posts(id)
    ON UPDATE CASCADE
    ON DELETE CASCADE,
    CONSTRAINT commentor_id_TO_user_id
    FOREIGN KEY (commentor_id) REFERENCES users(id)
    ON UPDATE CASCADE
    ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS likes (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    user_id INT UNSIGNED NOT NULL,
    postLiked_id INT UNSIGNED NOT NULL,
    replyLiked_id INT UNSIGNED NOT NULL,
    CONSTRAINT user_id_TO_user_id 
    FOREIGN KEY (user_id) REFERENCES users(id)
    ON UPDATE CASCADE
    ON DELETE CASCADE,
    CONSTRAINT postLiked_TO_user_id 
    FOREIGN KEY (postLiked_id) REFERENCES posts(id)
    ON UPDATE CASCADE
    ON DELETE CASCADE,
    CONSTRAINT replyLiked_id_TO_user_id 
    FOREIGN KEY (replyLiked_id) REFERENCES replies(id)
    ON UPDATE CASCADE
    ON DELETE CASCADE
) ENGINE=InnoDB;

/* Add test users */

INSERT INTO users (firstName, lastName, username) VALUES (
    "John", "Doe", "johndoe"
);

INSERT INTO users (firstName, lastName, username) VALUES (
    "Jane", "Doe", "janedoe"
);

INSERT INTO users (firstName, lastName, username) VALUES (
    "Bob", "Loblaw", "bobloblaw"
);

/* Add test posts */

INSERT INTO posts (body, author_id) VALUES (
    "Testing these posts!", "1"
);

INSERT INTO posts (body, author_id) VALUES (
    "Testing a post!", "2"
);

INSERT INTO posts (body, author_id) VALUES (
    "Everyone needs more testing in their lives!", "2"
);

INSERT INTO posts (body, author_id) VALUES (
    "How many posts does it take to test a lightbulb", "3"
);

INSERT INTO posts (body, author_id) VALUES (
    "Welcome to post 17, you have been chosen, or have chosen...#HL2", "2"
);