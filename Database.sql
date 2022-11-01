CREATE DATABASE php_login_management;

CREATE DATABASE php_login_management_test;

CREATE TABLE users
(
    username            VARCHAR(255) PRIMARY KEY,
    email               VARCHAR(255) UNIQUE NOT NULL,
    password            VARCHAR(255)        NOT NULL,
    created_at          VARCHAR(255)        NOT NULL,
    email_updated_at    VARCHAR(255)        NULL,
    password_updated_at VARCHAR(255)        NULL
) ENGINE InnoDB;

CREATE TABLE sessions
(
    id       VARCHAR(255) PRIMARY KEY,
    username VARCHAR(255) NOT NULL
) ENGINE InnoDB;

ALTER TABLE sessions
    ADD CONSTRAINT fk_sessions_user
        FOREIGN KEY (username)
            REFERENCES users (username);

drop table users;
# drop table users_detail;
drop table sessions;

INSERT INTO users(username, password)
VALUES ('abc', 'abc');