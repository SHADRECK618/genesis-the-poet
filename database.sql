CREATE DATABASE IF NOT EXISTS genesis_poet
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

USE genesis_poet;

DROP TABLE IF EXISTS poems;
DROP TABLE IF EXISTS categories;
DROP TABLE IF EXISTS admins;

CREATE TABLE admins (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(190) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL UNIQUE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE poems (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    category VARCHAR(100) NOT NULL,
    content TEXT NOT NULL,
    status ENUM('draft', 'published') NOT NULL DEFAULT 'draft',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO categories (name) VALUES
('Life'),
('Love'),
('Faith'),
('Healing'),
('Identity'),
('Inspiration'),
('Social Consciousness');

INSERT INTO poems (title, category, content, status) VALUES
(
    'Pieces Of My Past',
    'Life',
    'These are the pieces of my past,\nThe moments that shaped who I am.\nSome carried pain,\nSome carried lessons,\nAnd some taught me how to stand again.',
    'published'
),
(
    'Lost Pages Of My Life',
    'Life',
    'There are pages I wish I could rewrite,\nPages filled with questions and pain.\nBut every page became part of my journey,\nAnd every scar became part of my story.',
    'published'
),
(
    'Life Without Christ',
    'Faith',
    'A life without Christ can feel empty,\nSearching for meaning in the noise.\nBut when faith becomes the foundation,\nEven difficult roads can carry hope.',
    'published'
),
(
    'God Is Not Done With Me',
    'Faith',
    'I may not understand the road,\nAnd I may stumble along the way.\nBut I believe God is not done with me.\nThere is still purpose ahead.',
    'published'
);