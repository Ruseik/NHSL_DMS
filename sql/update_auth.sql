-- Update root user authentication
ALTER USER 'root'@'localhost' IDENTIFIED WITH caching_sha2_password BY '';

-- Update application user authentication
CREATE USER IF NOT EXISTS 'nhsl_dms'@'localhost' IDENTIFIED WITH caching_sha2_password BY 'nhsl@123';
GRANT ALL PRIVILEGES ON nhsl_dms.* TO 'nhsl_dms'@'localhost';
FLUSH PRIVILEGES;