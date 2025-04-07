-- Create the database
CREATE DATABASE studentdb;

-- Use the newly created database
USE studentdb;

-- Create the students table
CREATE TABLE students (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100),
  email VARCHAR(100)
);

-- Insert some sample data
INSERT INTO students (name, email) VALUES
('Alice Smith', 'alice@example.com'),
('Bob Johnson', 'bob@example.com');

