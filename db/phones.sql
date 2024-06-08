CREATE DATABASE IF NOT EXISTS flowphone;

USE flowphone;

CREATE TABLE
    IF NOT EXISTS phones (
        id INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
        brand VARCHAR(50),
        model VARCHAR(50),
        release_year INT,
        screen_size DECIMAL(3, 1), -- in inches
        battery_capacity INT, -- in mAh
        ram INT, -- in GB
        storage INT, -- in GB
        camera_mp INT, -- in Megapixels
        price DECIMAL(10, 2), -- in euros
        os VARCHAR(50), -- Operating System
        ratings INT, -- Ratings out of 5
        image_url VARCHAR(255) -- Image URL
    );

CREATE TABLE
    IF NOT EXISTS reviews (
        id INT UNSIGNED PRIMARY KEY,
        phone_id INT UNSIGNED,
        author VARCHAR(100),
        review TEXT,
        rating INT,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (phone_id) REFERENCES phones (id)
    );

CREATE TABLE
    IF NOT EXISTS users (
        id INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
        name VARCHAR(50),
        email VARCHAR(100) UNIQUE,
        password VARCHAR(100),
        isVerified BOOLEAN DEFAULT FALSE,
        isGoogleAccount BOOLEAN DEFAULT FALSE
    );

CREATE TABLE
    IF NOT EXISTS users_adress (
        id INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
        user_id INT UNSIGNED,
        address VARCHAR(255),
        city VARCHAR(100),
        state VARCHAR(100),
        country VARCHAR(100),
        zipcode VARCHAR(10),
        FOREIGN KEY (user_id) REFERENCES users (id)
    );

CREATE TABLE
    IF NOT EXISTS carts (
        id INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
        user_id INT UNSIGNED,
        phone_id INT UNSIGNED,
        quantity INT,
        FOREIGN KEY (user_id) REFERENCES users (id),
        FOREIGN KEY (phone_id) REFERENCES phones (id)
    );

-- Insert 20 records into the 'phones' table
INSERT INTO
    phones (
        id,
        brand,
        model,
        release_year,
        screen_size,
        battery_capacity,
        ram,
        storage,
        camera_mp,
        price,
        os,
        ratings,
        image_url
    )
VALUES
    (
        1,
        'Apple',
        'iPhone 13',
        2021,
        6.1,
        3095,
        4,
        128,
        12,
        799.00,
        'iOS',
        5,
        'images/phones/apple_iphone13.webp'
    ),
    (
        2,
        'Samsung',
        'Galaxy S21',
        2021,
        6.2,
        4000,
        8,
        128,
        64,
        799.99,
        'Android',
        4,
        'images/phones/samsung_galaxyS21.webp'
    ),
    (
        3,
        'Google',
        'Pixel 6',
        2021,
        6.4,
        4614,
        8,
        128,
        50,
        599.00,
        'Android',
        4,
        'images/phones/google_pixel6.webp'
    ),
    (
        4,
        'OnePlus',
        '9 Pro',
        2021,
        6.7,
        4500,
        12,
        256,
        48,
        1069.00,
        'Android',
        5,
        'images/phones/oneplus_9pro.webp'
    ),
    (
        5,
        'Apple',
        'iPhone 12',
        2020,
        6.1,
        2815,
        4,
        64,
        12,
        699.00,
        'iOS',
        4,
        'images/phones/apple_iphone12.webp'
    ),
    (
        6,
        'Samsung',
        'Galaxy Note 20',
        2020,
        6.7,
        4300,
        8,
        256,
        108,
        999.99,
        'Android',
        5,
        'images/phones/samsung_galaxynote20.webp'
    ),
    (
        7,
        'Google',
        'Pixel 5',
        2020,
        6.0,
        4080,
        8,
        128,
        16,
        699.00,
        'Android',
        4,
        'images/phones/google_pixel5.webp'
    ),
    (
        8,
        'OnePlus',
        '8T',
        2020,
        6.55,
        4500,
        12,
        256,
        48,
        749.00,
        'Android',
        4,
        'images/phones/oneplus_8t.webp'
    ),
    (
        9,
        'Apple',
        'iPhone SE',
        2020,
        4.7,
        1821,
        3,
        64,
        12,
        399.00,
        'iOS',
        3,
        'images/phones/apple_iphonese.webp'
    ),
    (
        10,
        'Samsung',
        'Galaxy A52',
        2021,
        6.5,
        4500,
        6,
        128,
        64,
        499.99,
        'Android',
        4,
        'images/phones/samsung_galaxya52.webp'
    ),
    (
        11,
        'Sony',
        'Xperia 1 III',
        2021,
        6.5,
        4500,
        12,
        256,
        12,
        1299.99,
        'Android',
        5,
        'images/phones/sony_xperia1iii.webp'
    ),
    (
        12,
        'LG',
        'Velvet',
        2020,
        6.8,
        4300,
        6,
        128,
        48,
        599.00,
        'Android',
        4,
        'images/phones/lg_velvet.webp'
    ),
    (
        13,
        'Huawei',
        'P40 Pro',
        2020,
        6.58,
        4200,
        8,
        256,
        50,
        899.00,
        'Android',
        5,
        'images/phones/huawei_p40pro.webp'
    ),
    (
        14,
        'Xiaomi',
        'Mi 11',
        2021,
        6.81,
        4600,
        8,
        256,
        108,
        749.00,
        'Android',
        4,
        'images/phones/xiaomi_mi11.webp'
    ),
    (
        15,
        'Apple',
        'iPhone 11',
        2019,
        6.1,
        3110,
        4,
        64,
        12,
        599.00,
        'iOS',
        4,
        'images/phones/apple_iphone11.webp'
    ),
    (
        16,
        'Samsung',
        'Galaxy S10',
        2019,
        6.1,
        3400,
        8,
        128,
        16,
        749.99,
        'Android',
        4,
        'images/phones/samsung_galaxys10.webp'
    ),
    (
        17,
        'Google',
        'Pixel 4',
        2019,
        5.7,
        2800,
        6,
        64,
        16,
        799.00,
        'Android',
        3,
        'images/phones/google_pixel4.webp'
    ),
    (
        18,
        'OnePlus',
        '7 Pro',
        2019,
        6.67,
        4000,
        12,
        256,
        48,
        669.00,
        'Android',
        4,
        'images/phones/oneplus_7pro.webp'
    ),
    (
        19,
        'Huawei',
        'Mate 30 Pro',
        2019,
        6.53,
        4500,
        8,
        256,
        40,
        1099.00,
        'Android',
        5,
        'images/phones/huawei_mate30pro.webp'
    ),
    (
        20,
        'Xiaomi',
        'Redmi Note 10',
        2021,
        6.43,
        5000,
        4,
        64,
        48,
        199.00,
        'Android',
        4,
        'images/phones/xiaomi_redminote10.webp'
    );
