-- Create the database
CREATE DATABASE IF NOT EXISTS `employee_management`;
USE `employee_management`;

-- Department table
CREATE TABLE IF NOT EXISTS `departments` (
    `department_id` INT AUTO_INCREMENT PRIMARY KEY,
    `department_name` VARCHAR(100) NOT NULL UNIQUE,
    `department_code` VARCHAR(10) NOT NULL UNIQUE,
    `manager_id` INT NULL,
    `budget` DECIMAL(15,2) DEFAULT 0.00,
    `established_date` DATE,
    `description` TEXT,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Job positions table
CREATE TABLE IF NOT EXISTS `positions` (
    `position_id` INT AUTO_INCREMENT PRIMARY KEY,
    `position_title` VARCHAR(100) NOT NULL,
    `position_code` VARCHAR(20) NOT NULL UNIQUE,
    `department_id` INT NOT NULL,
    `min_salary` DECIMAL(10,2),
    `max_salary` DECIMAL(10,2),
    `job_description` TEXT,
    `requirements` TEXT,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (`department_id`) REFERENCES `departments`(`department_id`) ON DELETE CASCADE
);

-- Employees table
CREATE TABLE IF NOT EXISTS `employees` (
    `employee_id` INT AUTO_INCREMENT PRIMARY KEY,
    `first_name` VARCHAR(50) NOT NULL,
    `last_name` VARCHAR(50) NOT NULL,
    `email` VARCHAR(100) NOT NULL UNIQUE,
    `phone` VARCHAR(20),
    `date_of_birth` DATE,
    `gender` ENUM('Male', 'Female', 'Other') NOT NULL,
    `national_id` VARCHAR(20) UNIQUE,
    `address` TEXT,
    `city` VARCHAR(50),
    `state` VARCHAR(50),
    `postal_code` VARCHAR(20),
    `country` VARCHAR(50) DEFAULT 'USA',
    
    -- Employment details
    `department_id` INT NOT NULL,
    `position_id` INT NOT NULL,
    `hire_date` DATE NOT NULL,
    `employment_type` ENUM('Full-Time', 'Part-Time', 'Contract', 'Temporary') DEFAULT 'Full-Time',
    `salary` DECIMAL(10,2) NOT NULL,
    `bank_account` VARCHAR(50),
    
    -- System fields
    `is_active` BOOLEAN DEFAULT TRUE,
    `profile_picture` VARCHAR(255),
    `emergency_contact_name` VARCHAR(100),
    `emergency_contact_phone` VARCHAR(20),
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    FOREIGN KEY (`department_id`) REFERENCES `departments`(`department_id`),
    FOREIGN KEY (`position_id`) REFERENCES `positions`(`position_id`)
);

-- Update departments table to add foreign key constraint for manager_id
ALTER TABLE `departments`
ADD CONSTRAINT `fk_department_manager`
FOREIGN KEY (`manager_id`) REFERENCES `employees`(`employee_id`) ON DELETE SET NULL;

-- Attendance table
CREATE TABLE IF NOT EXISTS `attendance` (
    `attendance_id` INT AUTO_INCREMENT PRIMARY KEY,
    `employee_id` INT NOT NULL,
    `date` DATE NOT NULL,
    `check_in` TIME,
    `check_out` TIME,
    `total_hours` DECIMAL(4,2),
    `status` ENUM('Present', 'Absent', 'Late', 'Half-Day', 'Holiday') DEFAULT 'Present',
    `notes` TEXT,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    UNIQUE KEY `unique_employee_date` (`employee_id`, `date`),
    FOREIGN KEY (`employee_id`) REFERENCES `employees`(`employee_id`) ON DELETE CASCADE
);

-- Leave management table
CREATE TABLE IF NOT EXISTS `leaves` (
    `leave_id` INT AUTO_INCREMENT PRIMARY KEY,
    `employee_id` INT NOT NULL,
    `leave_type` ENUM('Sick', 'Vacation', 'Personal', 'Maternity', 'Paternity', 'Bereavement', 'Other') NOT NULL,
    `start_date` DATE NOT NULL,
    `end_date` DATE NOT NULL,
    `total_days` INT NOT NULL,
    `reason` TEXT,
    `status` ENUM('Pending', 'Approved', 'Rejected', 'Cancelled') DEFAULT 'Pending',
    `approved_by` INT NULL,
    `approved_date` TIMESTAMP NULL,
    `applied_date` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `notes` TEXT,
    FOREIGN KEY (`employee_id`) REFERENCES `employees`(`employee_id`) ON DELETE CASCADE,
    FOREIGN KEY (`approved_by`) REFERENCES `employees`(`employee_id`) ON DELETE SET NULL
);

-- Salary and payroll table
CREATE TABLE IF NOT EXISTS `payroll` (
    `payroll_id` INT AUTO_INCREMENT PRIMARY KEY,
    `employee_id` INT NOT NULL,
    `pay_period_start` DATE NOT NULL,
    `pay_period_end` DATE NOT NULL,
    `basic_salary` DECIMAL(10,2) NOT NULL,
    `overtime_pay` DECIMAL(10,2) DEFAULT 0.00,
    `bonuses` DECIMAL(10,2) DEFAULT 0.00,
    `deductions` DECIMAL(10,2) DEFAULT 0.00,
    `tax_amount` DECIMAL(10,2) DEFAULT 0.00,
    `net_salary` DECIMAL(10,2) NOT NULL,
    `payment_date` DATE,
    `payment_method` ENUM('Bank Transfer', 'Check', 'Cash') DEFAULT 'Bank Transfer',
    `status` ENUM('Pending', 'Paid', 'Failed') DEFAULT 'Pending',
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (`employee_id`) REFERENCES `employees`(`employee_id`) ON DELETE CASCADE
);

-- Performance reviews table
CREATE TABLE IF NOT EXISTS `performance_reviews` (
    `review_id` INT AUTO_INCREMENT PRIMARY KEY,
    `employee_id` INT NOT NULL,
    `review_date` DATE NOT NULL,
    `reviewer_id` INT NOT NULL,
    `rating` DECIMAL(3,2) CHECK (rating >= 1 AND rating <= 5),
    `comments` TEXT,
    `goals` TEXT,
    `strengths` TEXT,
    `improvement_areas` TEXT,
    `next_review_date` DATE,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (`employee_id`) REFERENCES `employees`(`employee_id`) ON DELETE CASCADE,
    FOREIGN KEY (`reviewer_id`) REFERENCES `employees`(`employee_id`) ON DELETE CASCADE
);

-- Skills and qualifications table
CREATE TABLE IF NOT EXISTS `employee_skills` (
    `skill_id` INT AUTO_INCREMENT PRIMARY KEY,
    `employee_id` INT NOT NULL,
    `skill_name` VARCHAR(100) NOT NULL,
    `proficiency_level` ENUM('Beginner', 'Intermediate', 'Advanced', 'Expert') DEFAULT 'Intermediate',
    `certification` VARCHAR(255),
    `certification_date` DATE,
    `description` TEXT,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (`employee_id`) REFERENCES `employees`(`employee_id`) ON DELETE CASCADE
);

-- Projects table
CREATE TABLE IF NOT EXISTS `projects` (
    `project_id` INT AUTO_INCREMENT PRIMARY KEY,
    `project_name` VARCHAR(255) NOT NULL,
    `project_code` VARCHAR(50) UNIQUE NOT NULL,
    `description` TEXT,
    `department_id` INT NOT NULL,
    `project_manager_id` INT NOT NULL,
    `start_date` DATE,
    `end_date` DATE,
    `budget` DECIMAL(15,2),
    `status` ENUM('Planning', 'In Progress', 'On Hold', 'Completed', 'Cancelled') DEFAULT 'Planning',
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (`department_id`) REFERENCES `departments`(`department_id`),
    FOREIGN KEY (`project_manager_id`) REFERENCES `employees`(`employee_id`)
);

-- Project assignments table
CREATE TABLE IF NOT EXISTS `project_assignments` (
    `assignment_id` INT AUTO_INCREMENT PRIMARY KEY,
    `project_id` INT NOT NULL,
    `employee_id` INT NOT NULL,
    `role` VARCHAR(100) NOT NULL,
    `assignment_date` DATE NOT NULL,
    `hours_allocated` INT,
    `completion_percentage` DECIMAL(5,2) DEFAULT 0.00,
    `notes` TEXT,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (`project_id`) REFERENCES `projects`(`project_id`) ON DELETE CASCADE,
    FOREIGN KEY (`employee_id`) REFERENCES `employees`(`employee_id`) ON DELETE CASCADE
);

-- Users table for system access
CREATE TABLE IF NOT EXISTS `users` (
    `user_id` INT AUTO_INCREMENT PRIMARY KEY,
    `employee_id` INT NOT NULL UNIQUE,
    `username` VARCHAR(50) NOT NULL UNIQUE,
    `password_hash` VARCHAR(255) NOT NULL,
    `role` ENUM('Admin', 'Manager', 'Employee') DEFAULT 'Employee',
    `last_login` TIMESTAMP NULL,
    `is_active` BOOLEAN DEFAULT TRUE,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (`employee_id`) REFERENCES `employees`(`employee_id`) ON DELETE CASCADE
);

-- Insert sample data

-- Insert departments
INSERT INTO `departments` (`department_name`, `department_code`, `established_date`, `description`) VALUES
('Human Resources', 'HR', '2020-01-15', 'Handles recruitment, employee relations, and HR operations'),
('Information Technology', 'IT', '2020-01-15', 'Manages technology infrastructure and software development'),
('Finance', 'FIN', '2020-01-15', 'Handles financial planning, accounting, and budgeting'),
('Marketing', 'MKT', '2020-02-01', 'Responsible for marketing campaigns and brand management'),
('Sales', 'SALES', '2020-02-01', 'Handles sales operations and customer acquisition');

-- Insert positions
INSERT INTO `positions` (`position_title`, `position_code`, `department_id`, `min_salary`, `max_salary`, `job_description`) VALUES
('HR Manager', 'HR-MGR', 1, 60000, 90000, 'Oversees all HR operations and strategies'),
('HR Specialist', 'HR-SPEC', 1, 45000, 65000, 'Handles employee relations and HR processes'),
('IT Manager', 'IT-MGR', 2, 80000, 120000, 'Manages IT infrastructure and team'),
('Software Developer', 'DEV', 2, 60000, 95000, 'Develops and maintains software applications'),
('Finance Manager', 'FIN-MGR', 3, 70000, 110000, 'Oversees financial operations and planning'),
('Accountant', 'ACC', 3, 50000, 75000, 'Handles accounting and financial reporting'),
('Marketing Manager', 'MKT-MGR', 4, 65000, 100000, 'Leads marketing strategies and campaigns'),
('Sales Representative', 'SALES-REP', 5, 40000, 70000, 'Responsible for sales and customer relationships');

-- Insert employees
INSERT INTO `employees` (`first_name`, `last_name`, `email`, `phone`, `date_of_birth`, `gender`, `department_id`, `position_id`, `hire_date`, `salary`, `address`, `city`, `state`, `postal_code`) VALUES
('John', 'Smith', 'john.smith@company.com', '+1-555-0101', '1985-03-15', 'Male', 1, 1, '2020-03-01', 75000, '123 Main St', 'New York', 'NY', '10001'),
('Sarah', 'Johnson', 'sarah.johnson@company.com', '+1-555-0102', '1990-07-22', 'Female', 2, 3, '2020-04-15', 95000, '456 Oak Ave', 'New York', 'NY', '10002'),
('Mike', 'Davis', 'mike.davis@company.com', '+1-555-0103', '1988-11-30', 'Male', 2, 4, '2020-05-01', 80000, '789 Pine Rd', 'New York', 'NY', '10003'),
('Emily', 'Wilson', 'emily.wilson@company.com', '+1-555-0104', '1992-04-18', 'Female', 3, 5, '2020-06-01', 85000, '321 Elm St', 'New York', 'NY', '10004'),
('David', 'Brown', 'david.brown@company.com', '+1-555-0105', '1991-09-12', 'Male', 5, 8, '2020-07-15', 55000, '654 Maple Dr', 'New York', 'NY', '10005');

-- Update departments with managers
UPDATE `departments` SET `manager_id` = 1 WHERE `department_id` = 1;
UPDATE `departments` SET `manager_id` = 2 WHERE `department_id` = 2;
UPDATE `departments` SET `manager_id` = 4 WHERE `department_id` = 3;

-- Insert sample attendance
INSERT INTO `attendance` (`employee_id`, `date`, `check_in`, `check_out`, `total_hours`, `status`) VALUES
(1, '2024-01-15', '09:00:00', '17:00:00', 8.00, 'Present'),
(2, '2024-01-15', '08:55:00', '17:05:00', 8.17, 'Present'),
(3, '2024-01-15', '09:15:00', '17:00:00', 7.75, 'Late'),
(4, '2024-01-15', '09:00:00', '17:00:00', 8.00, 'Present'),
(5, '2024-01-15', '09:00:00', '17:00:00', 8.00, 'Present');

-- Insert sample leaves
INSERT INTO `leaves` (`employee_id`, `leave_type`, `start_date`, `end_date`, `total_days`, `reason`, `status`, `approved_by`) VALUES
(1, 'Vacation', '2024-02-01', '2024-02-05', 5, 'Family vacation', 'Approved', 2),
(3, 'Sick', '2024-01-20', '2024-01-21', 2, 'Flu', 'Approved', 2);

-- Insert sample payroll
INSERT INTO `payroll` (`employee_id`, `pay_period_start`, `pay_period_end`, `basic_salary`, `overtime_pay`, `bonuses`, `deductions`, `tax_amount`, `net_salary`, `payment_date`, `status`) VALUES
(1, '2024-01-01', '2024-01-15', 37500, 500, 1000, 800, 4500, 33700, '2024-01-20', 'Paid'),
(2, '2024-01-01', '2024-01-15', 47500, 750, 1500, 1000, 6000, 42750, '2024-01-20', 'Paid');

-- Insert sample performance reviews
INSERT INTO `performance_reviews` (`employee_id`, `review_date`, `reviewer_id`, `rating`, `comments`, `goals`) VALUES
(1, '2024-01-10', 2, 4.5, 'Excellent leadership and HR management skills', 'Improve employee training programs'),
(2, '2024-01-10', 1, 4.8, 'Outstanding technical leadership and team management', 'Implement new development methodologies');

-- Insert sample skills
INSERT INTO `employee_skills` (`employee_id`, `skill_name`, `proficiency_level`, `certification`) VALUES
(2, 'Java', 'Expert', 'Oracle Certified Professional'),
(2, 'Python', 'Advanced', NULL),
(3, 'JavaScript', 'Advanced', NULL),
(3, 'React', 'Intermediate', NULL);

-- Insert sample projects
INSERT INTO `projects` (`project_name`, `project_code`, `description`, `department_id`, `project_manager_id`, `start_date`, `end_date`, `budget`, `status`) VALUES
('HR System Upgrade', 'HR-UPGRADE-2024', 'Upgrade HR management system to latest version', 1, 1, '2024-01-01', '2024-06-30', 50000, 'In Progress'),
('E-commerce Platform', 'ECOMM-2024', 'Develop new e-commerce platform', 2, 2, '2024-02-01', '2024-12-31', 150000, 'Planning');

-- Insert sample project assignments
INSERT INTO `project_assignments` (`project_id`, `employee_id`, `role`, `assignment_date`, `hours_allocated`) VALUES
(1, 1, 'Project Manager', '2024-01-01', 200),
(2, 2, 'Project Manager', '2024-02-01', 500),
(2, 3, 'Lead Developer', '2024-02-01', 400);

-- Insert sample users
INSERT INTO `users` (`employee_id`, `username`, `password_hash`, `role`) VALUES
(1, 'john.smith', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Admin'),
(2, 'sarah.johnson', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Manager'),
(3, 'mike.davis', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Employee');

-- Create useful views

-- Employee details view
CREATE VIEW `employee_details` AS
SELECT 
    e.employee_id,
    CONCAT(e.first_name, ' ', e.last_name) AS full_name,
    e.email,
    e.phone,
    e.hire_date,
    e.salary,
    d.department_name,
    p.position_title,
    e.is_active
FROM employees e
JOIN departments d ON e.department_id = d.department_id
JOIN positions p ON e.position_id = p.position_id;

-- Department summary view
CREATE VIEW `department_summary` AS
SELECT 
    d.department_id,
    d.department_name,
    COUNT(e.employee_id) AS total_employees,
    AVG(e.salary) AS average_salary,
    CONCAT(m.first_name, ' ', m.last_name) AS manager_name
FROM departments d
LEFT JOIN employees e ON d.department_id = e.department_id AND e.is_active = TRUE
LEFT JOIN employees m ON d.manager_id = m.employee_id
GROUP BY d.department_id, d.department_name, manager_name;

-- Create indexes for better performance
CREATE INDEX `idx_employee_department` ON `employees` (`department_id`);
CREATE INDEX `idx_employee_position` ON `employees` (`position_id`);
CREATE INDEX `idx_attendance_employee_date` ON `attendance` (`employee_id`, `date`);
CREATE INDEX `idx_leave_employee_status` ON `leaves` (`employee_id`, `status`);
CREATE INDEX `idx_payroll_employee_period` ON `payroll` (`employee_id`, `pay_period_start`, `pay_period_end`);

-- Display success message
SELECT 'Employee Management System database created successfully!' AS message;