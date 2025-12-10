-- SQL schema for online_store
CREATE DATABASE IF NOT EXISTS online_store CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE online_store;

-- users
CREATE TABLE IF NOT EXISTS users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(191) NOT NULL,
  email VARCHAR(191) NOT NULL UNIQUE,
  password VARCHAR(255) NOT NULL,
  role ENUM('user','seller','admin') DEFAULT 'user',
  created_at DATETIME,
  INDEX(email)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- sellers
CREATE TABLE IF NOT EXISTS sellers (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT NOT NULL,
  name VARCHAR(191),
  created_at DATETIME,
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- products
CREATE TABLE IF NOT EXISTS products (
  id INT AUTO_INCREMENT PRIMARY KEY,
  seller_id INT NULL,
  name VARCHAR(191) NOT NULL,
  description TEXT,
  price DECIMAL(10,2) NOT NULL DEFAULT 0,
  approved TINYINT(1) DEFAULT 0,
  created_at DATETIME,
  FOREIGN KEY (seller_id) REFERENCES sellers(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- cart is session-driven; create a lightweight table if desired
CREATE TABLE IF NOT EXISTS orders (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT NOT NULL,
  total_amount DECIMAL(12,2),
  created_at DATETIME,
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS order_items (
  id INT AUTO_INCREMENT PRIMARY KEY,
  order_id INT NOT NULL,
  product_id INT NOT NULL,
  qty INT NOT NULL,
  price DECIMAL(10,2),
  FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE,
  FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- initial admin user
INSERT INTO users (name,email,password,role,created_at) VALUES
('Admin','admin@example.com', 'REPLACE_WITH_HASH', 'admin', NOW());

-- For convenience: sample seller + products (passwords should be re-hashed after import)
INSERT INTO users (name,email,password,role,created_at) VALUES
('Seller One','seller@example.com','REPLACE_WITH_HASH','seller',NOW());

-- After importing, update the password hashes.
-- Example: run PHP to generate password_hash('adminpass', PASSWORD_DEFAULT) and replace REPLACE_WITH_HASH

