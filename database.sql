-- TripWave Database Setup
-- Create database and tables for the TripWave application

CREATE DATABASE IF NOT EXISTS tripwaveeeeeeee;
USE tripwaveeeeeeee;

-- Users table
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    profile_image VARCHAR(255) DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tours table
CREATE TABLE IF NOT EXISTS tours (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(200) NOT NULL,
    description TEXT,
    price DECIMAL(10, 2),
    rating DECIMAL(3, 2) DEFAULT 0,
    image VARCHAR(255),
    duration VARCHAR(100),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Hotels table
CREATE TABLE IF NOT EXISTS hotels (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(200) NOT NULL,
    description TEXT,
    location VARCHAR(255),
    price DECIMAL(10, 2),
    rating DECIMAL(3, 2) DEFAULT 0,
    image VARCHAR(255),
    amenities TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Restaurants table
CREATE TABLE IF NOT EXISTS restaurants (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(200) NOT NULL,
    description TEXT,
    address VARCHAR(255),
    price DECIMAL(10, 2),
    rating DECIMAL(3, 2) DEFAULT 0,
    image VARCHAR(255),
    cuisine_type VARCHAR(100),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Activities table
CREATE TABLE IF NOT EXISTS activities (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(200) NOT NULL,
    description TEXT,
    location VARCHAR(255),
    price DECIMAL(10, 2),
    rating DECIMAL(3, 2) DEFAULT 0,
    image VARCHAR(255),
    duration VARCHAR(100),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Booking table
CREATE TABLE IF NOT EXISTS booking (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    item_id INT NOT NULL,
    item_type VARCHAR(50) NOT NULL,
    booking_date DATE NOT NULL,
    booking_time TIME DEFAULT NULL,
    num_of_people INT DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Community posts table
CREATE TABLE IF NOT EXISTS community_posts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    post_text TEXT NOT NULL,
    language VARCHAR(50) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Insert sample data for Tours
INSERT INTO tours (name, description, price, rating, image, duration) VALUES
('Temple of the Tooth Tour', 'Visit the sacred Temple of the Tooth Relic, one of the most important Buddhist sites in Sri Lanka.', 1500.00, 4.8, 'assets/images/tooth-temple.jpg', '2-3 hours'),
('Royal Botanical Gardens', 'Explore the beautiful Royal Botanical Gardens in Peradeniya with over 4000 species of plants.', 1000.00, 4.7, 'assets/images/botanical-garden.jpg', '3-4 hours'),
('Kandy Cultural Show', 'Experience traditional Kandyan dance and fire walking performances.', 2000.00, 4.6, 'assets/images/cultural-show.jpg', '1-2 hours'),
('Bahirawakanda Temple', 'Visit the giant white Buddha statue with panoramic views of Kandy city.', 500.00, 4.5, 'assets/images/bahirawakanda.jpg', '1-2 hours'),
('Udawattakele Forest Reserve', 'Nature walk through this historic forest sanctuary in the heart of Kandy.', 800.00, 4.4, 'assets/images/forest-reserve.jpg', '2-3 hours');

-- Insert sample data for Hotels
INSERT INTO hotels (name, description, location, price, rating, image, amenities) VALUES
('Earl''s Regency Hotel', 'Luxury hotel with stunning views of Kandy Lake and the surrounding mountains.', 'Tennekumbura, Kandy', 15000.00, 4.7, 'assets/images/earls-regency.jpg', 'Pool, Spa, Restaurant, Free WiFi, Gym'),
('The Golden Crown Hotel', 'Modern hotel in the heart of Kandy with easy access to major attractions.', 'Temple Street, Kandy', 8000.00, 4.5, 'assets/images/golden-crown.jpg', 'Restaurant, Free WiFi, Parking'),
('Topaz Hotel', 'Comfortable stay with traditional Sri Lankan hospitality near Kandy Lake.', 'Aniwatta, Kandy', 6000.00, 4.3, 'assets/images/topaz.jpg', 'Restaurant, WiFi, Room Service'),
('Thilanka Hotel', 'Beautiful property overlooking the city with excellent facilities.', 'Peradeniya Road, Kandy', 12000.00, 4.6, 'assets/images/thilanka.jpg', 'Pool, Restaurant, Bar, WiFi, Spa'),
('Oak Ray Regency Hotel', 'Centrally located hotel with modern amenities and friendly service.', 'Dalada Veediya, Kandy', 7000.00, 4.4, 'assets/images/oakray.jpg', 'Restaurant, WiFi, Parking, AC');

-- Insert sample data for Restaurants
INSERT INTO restaurants (name, description, address, price, rating, image, cuisine_type) VALUES
('Slightly Chilled', 'Popular restaurant with a variety of Sri Lankan and international dishes.', 'Dalada Veediya, Kandy', 1500.00, 4.6, 'assets/images/slightly-chilled.jpg', 'Sri Lankan, International'),
('The Empire Cafe', 'Colonial-style cafe with a relaxing ambiance and great coffee.', 'Temple Street, Kandy', 1200.00, 4.5, 'assets/images/empire-cafe.jpg', 'Cafe, Western'),
('Balaji Dosai', 'Authentic South Indian vegetarian restaurant known for its dosas.', 'KCC Complex, Kandy', 800.00, 4.7, 'assets/images/balaji.jpg', 'Indian, Vegetarian'),
('Devon Restaurant', 'Traditional Sri Lankan rice and curry with stunning lake views.', 'Dalada Veediya, Kandy', 1000.00, 4.4, 'assets/images/devon.jpg', 'Sri Lankan'),
('White House Restaurant', 'Fine dining with international cuisine and excellent service.', 'Peradeniya Road, Kandy', 2000.00, 4.8, 'assets/images/whitehouse.jpg', 'International, Fine Dining');

-- Insert sample data for Activities
INSERT INTO activities (name, description, location, price, rating, image, duration) VALUES
('Kandy Lake Boat Ride', 'Peaceful boat ride around the historic Kandy Lake.', 'Kandy Lake', 500.00, 4.5, 'assets/images/boat-ride.jpg', '30 minutes'),
('Spice Garden Tour', 'Learn about Sri Lankan spices and their uses in traditional medicine.', 'Peradeniya', 1500.00, 4.6, 'assets/images/spice-garden.jpg', '1-2 hours'),
('Tea Plantation Tour', 'Visit a working tea plantation and factory near Kandy.', 'Hantana', 2000.00, 4.7, 'assets/images/tea-plantation.jpg', '3-4 hours'),
('Elephant Orphanage Visit', 'See rescued elephants at the Pinnawala Elephant Orphanage.', 'Pinnawala', 3000.00, 4.8, 'assets/images/elephant-orphanage.jpg', 'Half day'),
('Market Walking Tour', 'Explore the vibrant local markets and street food of Kandy.', 'Kandy City Center', 800.00, 4.4, 'assets/images/market-tour.jpg', '2 hours');
