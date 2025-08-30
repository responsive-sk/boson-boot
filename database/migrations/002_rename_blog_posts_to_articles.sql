-- Migration: Rename blog_posts table to articles
-- This migration renames the blog_posts table to articles for better semantic naming

-- Rename the main table
ALTER TABLE blog_posts RENAME TO articles;

-- Update the FTS table to match
DROP TABLE IF EXISTS articles_fts;
CREATE VIRTUAL TABLE articles_fts USING fts5(
    title, 
    excerpt, 
    content, 
    content='articles', 
    content_rowid='id'
);

-- Populate the FTS table with existing data
INSERT INTO articles_fts(rowid, title, excerpt, content)
SELECT id, title, excerpt, content FROM articles WHERE status = 'published';

-- Update FTS triggers
DROP TRIGGER IF EXISTS articles_fts_insert;
DROP TRIGGER IF EXISTS articles_fts_delete;
DROP TRIGGER IF EXISTS articles_fts_update;

-- Create new FTS triggers
CREATE TRIGGER articles_fts_insert AFTER INSERT ON articles 
WHEN NEW.status = 'published'
BEGIN
    INSERT INTO articles_fts(rowid, title, excerpt, content) 
    VALUES (NEW.id, NEW.title, NEW.excerpt, NEW.content);
END;

CREATE TRIGGER articles_fts_delete AFTER DELETE ON articles BEGIN
    DELETE FROM articles_fts WHERE rowid = OLD.id;
END;

CREATE TRIGGER articles_fts_update AFTER UPDATE ON articles BEGIN
    DELETE FROM articles_fts WHERE rowid = OLD.id;
    
    -- Only insert if the article is published
    INSERT INTO articles_fts(rowid, title, excerpt, content) 
    SELECT NEW.id, NEW.title, NEW.excerpt, NEW.content
    WHERE NEW.status = 'published';
END;

-- Update foreign key references in other tables if they exist
-- Note: SQLite doesn't support ALTER TABLE for foreign keys, 
-- so we'll handle this in the application layer
