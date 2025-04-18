CREATE DATABASE ecommerce_db;
USE ecommerce_db;

CREATE TABLE products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    description TEXT,
    image_url VARCHAR(255),
    price DECIMAL(10,2) NOT NULL
);

INSERT INTO products (name, description, image_url, price) VALUES
('Laptop', 'High-performance laptop', 'assets/image 5.jpg', 800.00),
('Smartphone', 'Latest smartphone model', 'assets/image 4.jpg', 500.00),
('Headphones', 'Noise-cancelling headphones', 'assets/image 1.jpg', 100.00),
('Smartwatch', 'Fitness and notifications', 'assets/image 3.jpg', 150.00),
('Gaming Mouse', 'Ergonomic gaming mouse', 'assets/image 11.jpg', 50.00);
('Bluetooth speaker','portable bluetooth speaker','assets/image 2.jpg', 80.00),
('4K Monitor','27 inch 4K monitor','assets/image 6.jpg', 300.00),
('Mechanical Keyboard','RGB mechanical keyboard','assets/image 7.jpg', 120.00),
('Webcam','1080p HD webcam','assets/image 8.jpg', 60.00),
('External Hard Drive','1TB external hard drive','assets/image 9.jpg', 70.00),
('USB-C Hub','Multi-port USB-C hub','assets/image 10.jpg', 40.00);
('camera','DSLR camera with lens','assets/image 12.jpg', 900.00);

