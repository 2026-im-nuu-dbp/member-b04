
-- Main news table
-- 需要修改
CREATE TABLE news (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(200) NOT NULL,
    content TEXT NOT NULL,
    author VARCHAR(100) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_created_at (created_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Replies table
-- 需要修改
CREATE TABLE replies (
    id INT AUTO_INCREMENT PRIMARY KEY,
    news_id INT NOT NULL,
    content TEXT NOT NULL,
    author VARCHAR(100) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (news_id) REFERENCES news(id) ON DELETE CASCADE,
    INDEX idx_news_id (news_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- -- Members table
-- -- 需要設計你的會員系統資料表
CREATE TABLE `membership` (
  `id` INT AUTO_INCREMENT PRIMARY KEY COMMENT '會員唯一識別碼',
  `account` VARCHAR(50) NOT NULL UNIQUE COMMENT '帳號(不可重複)',
  `password` VARCHAR(255) NOT NULL COMMENT '密碼(加密後的雜湊值)',
  `nickname` VARCHAR(50) NOT NULL COMMENT '暱稱',
  `favorite_color` VARCHAR(20) DEFAULT NULL COMMENT '喜歡顏色(可存放Hex碼或英文)',
  `avatar_url` VARCHAR(255) DEFAULT NULL COMMENT '大頭貼檔案路徑或網址',
  `status` VARCHAR(20) DEFAULT 'active' COMMENT '帳號狀態(active, inactive)',
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP COMMENT '建立時間',
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新時間'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
