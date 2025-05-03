# run this docker command at the project root

docker-compose up -d

# What This Command Does:

1. Builds the Web Container: Uses the Dockerfile to create an image with PHP 8.2, Apache, PDO, and the MySQL extension.

2. Starts the MySQL Container: Launches a MySQL 8 container with your custom environment variables.

3. Starts phpMyAdmin: Launches phpMyAdmin connected to your MySQL container.

4. Volume Mappings: Ensures that your web files (./www) and MySQL data (./mysql-data) are mapped to the correct paths inside the containers.

5. Port Mapping: Your web server is accessible via port 8080, and phpMyAdmin via port 8081.


