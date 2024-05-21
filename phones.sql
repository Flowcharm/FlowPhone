-- Create a table named 'phones'
CREATE TABLE phones (
                        id INT PRIMARY KEY,
                        brand VARCHAR(50),
                        model VARCHAR(50),
                        release_year INT,
                        screen_size DECIMAL(3,1), -- in inches
                        battery_capacity INT, -- in mAh
                        ram INT, -- in GB
                        storage INT, -- in GB
                        camera_mp INT, -- in Megapixels
                        price DECIMAL(10,2), -- in euros
                        os VARCHAR(50), -- Operating System
                        ratings INT, -- Ratings out of 5
                        image_url VARCHAR(255) -- Image URL
);

-- Insert 20 records into the 'phones' table
INSERT INTO phones (id, brand, model, release_year, screen_size, battery_capacity, ram, storage, camera_mp, price, os, ratings, image_url) VALUES
                                                                                                                                               (1, 'Apple', 'iPhone 13', 2021, 6.1, 3095, 4, 128, 12, 799.00, 'iOS', 5, 'https://example.com/images/iphone13.jpg'),
                                                                                                                                               (2, 'Samsung', 'Galaxy S21', 2021, 6.2, 4000, 8, 128, 64, 799.99, 'Android', 4, 'https://example.com/images/galaxy_s21.jpg'),
                                                                                                                                               (3, 'Google', 'Pixel 6', 2021, 6.4, 4614, 8, 128, 50, 599.00, 'Android', 4, 'https://example.com/images/pixel6.jpg'),
                                                                                                                                               (4, 'OnePlus', '9 Pro', 2021, 6.7, 4500, 12, 256, 48, 1069.00, 'Android', 5, 'https://example.com/images/oneplus_9_pro.jpg'),
                                                                                                                                               (5, 'Apple', 'iPhone 12', 2020, 6.1, 2815, 4, 64, 12, 699.00, 'iOS', 4, 'https://example.com/images/iphone12.jpg'),
                                                                                                                                               (6, 'Samsung', 'Galaxy Note 20', 2020, 6.7, 4300, 8, 256, 108, 999.99, 'Android', 5, 'https://example.com/images/galaxy_note20.jpg'),
                                                                                                                                               (7, 'Google', 'Pixel 5', 2020, 6.0, 4080, 8, 128, 16, 699.00, 'Android', 4, 'https://example.com/images/pixel5.jpg'),
                                                                                                                                               (8, 'OnePlus', '8T', 2020, 6.55, 4500, 12, 256, 48, 749.00, 'Android', 4, 'https://example.com/images/oneplus_8t.jpg'),
                                                                                                                                               (9, 'Apple', 'iPhone SE', 2020, 4.7, 1821, 3, 64, 12, 399.00, 'iOS', 3, 'https://example.com/images/iphone_se.jpg'),
                                                                                                                                               (10, 'Samsung', 'Galaxy A52', 2021, 6.5, 4500, 6, 128, 64, 499.99, 'Android', 4, 'https://example.com/images/galaxy_a52.jpg'),
                                                                                                                                               (11, 'Sony', 'Xperia 1 III', 2021, 6.5, 4500, 12, 256, 12, 1299.99, 'Android', 5, 'https://example.com/images/xperia_1_iii.jpg'),
                                                                                                                                               (12, 'LG', 'Velvet', 2020, 6.8, 4300, 6, 128, 48, 599.00, 'Android', 4, 'https://example.com/images/lg_velvet.jpg'),
                                                                                                                                               (13, 'Huawei', 'P40 Pro', 2020, 6.58, 4200, 8, 256, 50, 899.00, 'Android', 5, 'https://example.com/images/p40_pro.jpg'),
                                                                                                                                               (14, 'Xiaomi', 'Mi 11', 2021, 6.81, 4600, 8, 256, 108, 749.00, 'Android', 4, 'https://example.com/images/mi_11.jpg'),
                                                                                                                                               (15, 'Apple', 'iPhone 11', 2019, 6.1, 3110, 4, 64, 12, 599.00, 'iOS', 4, 'https://example.com/images/iphone11.jpg'),
                                                                                                                                               (16, 'Samsung', 'Galaxy S10', 2019, 6.1, 3400, 8, 128, 16, 749.99, 'Android', 4, 'https://example.com/images/galaxy_s10.jpg'),
                                                                                                                                               (17, 'Google', 'Pixel 4', 2019, 5.7, 2800, 6, 64, 16, 799.00, 'Android', 3, 'https://example.com/images/pixel4.jpg'),
                                                                                                                                               (18, 'OnePlus', '7 Pro', 2019, 6.67, 4000, 12, 256, 48, 669.00, 'Android', 4, 'https://example.com/images/oneplus_7_pro.jpg'),
                                                                                                                                               (19, 'Huawei', 'Mate 30 Pro', 2019, 6.53, 4500, 8, 256, 40, 1099.00, 'Android', 5, 'https://example.com/images/mate_30_pro.jpg'),
                                                                                                                                               (20, 'Xiaomi', 'Redmi Note 10', 2021, 6.43, 5000, 4, 64, 48, 199.00, 'Android', 4, 'https://example.com/images/redmi_note_10.jpg');
