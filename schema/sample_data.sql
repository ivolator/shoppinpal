ALTER TABLE authors AUTO_INCREMENT=0;
ALTER TABLE books AUTO_INCREMENT=0;

DELETE FROM authors;
DELETE FROM books;

INSERT INTO authors (name) VALUES
('Tolstoy');
INSERT INTO authors (name) VALUES
('Zinn');
INSERT INTO authors (name) VALUES
('Vazov');

INSERT INTO books (author_id, title, isbn, release_date) VALUES
(1,'War and Peace''m','1234', '1999-01-01'),
(2,'a people''s history','1234','1999-01-01');