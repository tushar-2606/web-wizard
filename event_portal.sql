DROP DATABASE IF EXISTS event_portal;
CREATE DATABASE event_portal;
USE event_portal;

CREATE TABLE events (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    description TEXT NOT NULL,
    max_capacity INT NOT NULL,
    date DATE NOT NULL,
    time_start TIME NOT NULL,
    time_end TIME NOT NULL,
    location VARCHAR(255) NOT NULL
);

CREATE TABLE participants (
    id INT AUTO_INCREMENT PRIMARY KEY,
    event_id INT NOT NULL,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    phone VARCHAR(20),
    status ENUM('registered','waiting') DEFAULT 'registered',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (event_id) REFERENCES events(id) ON DELETE CASCADE
);

-- Sample events
INSERT INTO events (name, description, max_capacity, date, time_start, time_end, location) VALUES
('AI & Machine Learning Conference 2024', 'Join industry leaders and researchers...', 500, '2024-03-15', '09:00:00','18:00:00','Tech Convention Center, San Francisco'),
('React & Frontend Development Workshop', 'Hands-on workshop covering modern React development...', 30, '2024-03-20','10:00:00','16:00:00','CodeSpace Learning Hub, Austin'),
('Professional Networking Mixer', 'Connect with like-minded professionals across industries...',150,'2024-03-22','18:00:00','21:00:00','Skyline Rooftop, New York');
