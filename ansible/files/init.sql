CREATE DATABASE IF NOT EXISTS studentdb;
USE studentdb;

CREATE TABLE IF NOT EXISTS students (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100),
  email VARCHAR(100)
);

INSERT INTO students (name, email) VALUES
('Ifeoluwa Adewole', 'adewoleife@gmail.com'),
('Joke Desaolu', 'dast272@gmail.com'),
('Tamunodiepiriye Wakama', 'wakamadiepiriye@gmail.com'),
('Amarachi Ejieji', 'amaraejieji@gmail.com');
