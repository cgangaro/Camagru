CREATE TABLE users (
    userId int(11) PRIMARY KEY AUTO_INCREMENT NOT NULL,
    userName varchar(128) NOT NULL,
    userEmail varchar(128) NOT NULL,
    userPwd varchar(128) NOT NULL,
    token varchar(128) NOT NULL,
    checked boolean NOT NULL,
    notif boolean NOT NULL
);

CREATE TABLE images (
    id int(11) PRIMARY KEY AUTO_INCREMENT NOT NULL,
    file_data LONGBLOB NOT NULL,
    author_id int(11) NOT NULL
);

CREATE TABLE comments (
    id int(11) PRIMARY KEY AUTO_INCREMENT NOT NULL,
    image_id int(11) NOT NULL,
    author_id int(11) NOT NULL,
    comment varchar(128) NOT NULL
);

CREATE TABLE likes (
    id int(11) PRIMARY KEY AUTO_INCREMENT NOT NULL,
    image_id int(11) NOT NULL,
    author_id int(11) NOT NULL
);
