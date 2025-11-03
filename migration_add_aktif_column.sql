-- Migration: Add aktif column to users table
-- Date: 2025-11-03
-- Purpose: Fix registration error - Unknown column 'aktif' in 'field list'

USE perkara_db;

-- Add aktif column to users table
ALTER TABLE users 
ADD COLUMN aktif ENUM('Y', 'N') DEFAULT 'Y' 
COMMENT 'Status aktif user (Y=Aktif, N=Nonaktif)' 
AFTER pengadilan_id;

-- Verify the column was added
DESCRIBE users;

-- Update existing users to active status (if any)
UPDATE users SET aktif = 'Y' WHERE aktif IS NULL;

-- Show result
SELECT 
    id, 
    username, 
    role, 
    pengadilan_id, 
    aktif, 
    created_at 
FROM users 
LIMIT 10;
