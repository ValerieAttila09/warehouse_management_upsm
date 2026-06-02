-- DATABASE MIGRATION: Article User Relationship
-- This migration adds support for linking articles to the user who created them
-- It enables proper authorization (user can only edit/delete their own articles)

-- Add user_id column to tb_artikel if it doesn't exist
-- This creates a relationship between tb_artikel and tb_user
ALTER TABLE tb_artikel ADD COLUMN user_id INT UNSIGNED AFTER id_penulis;

-- Add foreign key constraint (optional but recommended)
-- ALTER TABLE tb_artikel ADD CONSTRAINT fk_artikel_user FOREIGN KEY (user_id) REFERENCES tb_user(id_user) ON DELETE SET NULL;

-- If you want to populate existing articles with user_id (optional):
-- First, find users who match the author names and link them
-- UPDATE tb_artikel a
-- JOIN tb_author_artikel p ON a.id_penulis = p.id
-- JOIN tb_user u ON CONCAT(u.first_name, ' ', u.last_name) = p.nama OR u.email = p.email
-- SET a.user_id = u.id_user
-- WHERE a.user_id IS NULL;

-- Note: After running this migration, articles created with the new system
-- will automatically have user_id set to the logged-in user's ID.
