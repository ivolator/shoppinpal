CREATE TABLE authors
(
    id         INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name       VARCHAR(30) NOT NULL,
    updated_on TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    created_on TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);


CREATE TABLE books
(
    id           INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    author_id    int(6) UNSIGNED NOT NULL,
    title        VARCHAR(30) NOT NULL,
    isbn         VARCHAR(50),
    release_date TIMESTAMP,
    updated_on   TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    created_on   TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);



ALTER TABLE books
    ADD FOREIGN KEY (author_id) REFERENCES authors (id);

ALTER TABLE books
    ADD CONSTRAINT u_isbn UNIQUE (author_id, isbn);

ALTER TABLE authors
    ADD CONSTRAINT a_name UNIQUE (name);
