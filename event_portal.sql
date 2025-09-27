CREATE DATABASE event_system;
USE event_system;

-- Admin table
CREATE TABLE admins (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL
);

-- Insert default admin (username: admin, password: admin123)
INSERT INTO admins (username, password) 
VALUES ('admin', SHA2('admin123', 256));

-- Events table
CREATE TABLE events (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    capacity INT NOT NULL
);

INSERT INTO events (name, capacity) VALUES
('Tech Talk 2025', 3),
('Workshop AI Basics', 2);

-- Participants table
CREATE TABLE participants (
    id INT AUTO_INCREMENT PRIMARY KEY,
    event_id INT,
    name VARCHAR(100),
    email VARCHAR(100),
    phone VARCHAR(20),
    status ENUM('waiting','registered','rejected') DEFAULT 'waiting',
    FOREIGN KEY (event_id) REFERENCES events(id) ON DELETE CASCADE
);
