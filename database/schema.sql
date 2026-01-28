-- Operon Schema

CREATE TABLE IF NOT EXISTS clients (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    access_token VARCHAR(64) NOT NULL UNIQUE,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS projects (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    client_id INTEGER NOT NULL,
    name VARCHAR(150) NOT NULL,
    description TEXT,
    thalamic_setting VARCHAR(20) DEFAULT 'hybrid', -- 'macro', 'micro', 'hybrid'
    status VARCHAR(20) DEFAULT 'active', -- 'active', 'paused', 'completed'
    start_date DATE,
    deadline DATE,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (client_id) REFERENCES clients(id)
);

CREATE TABLE IF NOT EXISTS timeline_events (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    project_id INTEGER NOT NULL,
    title VARCHAR(200) NOT NULL,
    description TEXT,
    type VARCHAR(10) NOT NULL, -- 'MACRO' or 'MICRO'
    status VARCHAR(20) DEFAULT 'pending', -- 'pending', 'in_progress', 'done'
    completed_at DATETIME NULL,
    metadata TEXT, -- JSON: tags, images, mermaid
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (project_id) REFERENCES projects(id)
);

CREATE TABLE IF NOT EXISTS users (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    email VARCHAR(150) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- Seed Initial User (admin / admin)
-- Password hash for 'admin' (BCRYPT)
INSERT OR IGNORE INTO users (email, password_hash) VALUES 
('admin@operon.com', '$2y$10$8.randomhashplaceholder...'); 
