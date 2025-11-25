CREATE DATABASE students;
CREATE TABLE students (
  id INT AUTO_INCREMENT PRIMARY KEY,
  student_id VARCHAR(50) NOT NULL UNIQUE,
  full_name VARCHAR(200) NOT NULL,
  email VARCHAR(150) NOT NULL,
  dob DATE,
  course VARCHAR(150),
  enrollment_date DATE,
  status ENUM('Active','Pending','Inactive') DEFAULT 'Pending',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Sample data
INSERT INTO students (student_id, full_name, email, dob, course, enrollment_date, status)
VALUES
('S2025001','Alice Johnson','alice@example.edu','2003-05-10','Computer Science','2025-02-01','Active'),
('S2025002','Bob Smith','bob@example.edu','2002-11-20','Mathematics','2025-02-01','Pending');