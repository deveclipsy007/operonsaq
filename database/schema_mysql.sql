-- ============================================
-- OPERON CORTEX - MySQL Schema Completo
-- Para colar no phpMyAdmin da Hostinger
-- ============================================
-- Criado em: 2026-01-27
-- Versão: 1.0 (Produção)
-- ============================================

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "-03:00";

-- ============================================
-- Tabela: clients
-- Clientes que acessam o portal
-- ============================================
CREATE TABLE IF NOT EXISTS `clients` (
    `id` INT(11) NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(100) NOT NULL,
    `email` VARCHAR(150) NOT NULL,
    `password_hash` VARCHAR(255) DEFAULT NULL,
    `access_token` VARCHAR(64) NOT NULL,
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    UNIQUE KEY `email` (`email`),
    UNIQUE KEY `access_token` (`access_token`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- Tabela: users
-- Usuários administrativos
-- ============================================
CREATE TABLE IF NOT EXISTS `users` (
    `id` INT(11) NOT NULL AUTO_INCREMENT,
    `email` VARCHAR(150) NOT NULL,
    `password_hash` VARCHAR(255) NOT NULL,
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- Tabela: projects
-- Projetos dos clientes
-- ============================================
CREATE TABLE IF NOT EXISTS `projects` (
    `id` INT(11) NOT NULL AUTO_INCREMENT,
    `client_id` INT(11) NOT NULL,
    `name` VARCHAR(150) NOT NULL,
    `description` TEXT,
    `thalamic_setting` VARCHAR(20) DEFAULT 'hybrid',
    `status` VARCHAR(20) DEFAULT 'active',
    `start_date` DATE DEFAULT NULL,
    `deadline` DATE DEFAULT NULL,
    `current_phase` VARCHAR(50) DEFAULT 'discovery',
    
    -- Campos Financeiros
    `phases_count` INT(11) DEFAULT 0,
    `project_value` DECIMAL(10,2) DEFAULT 0.00,
    `payment_method` VARCHAR(50) DEFAULT 'Pix',
    `installments` INT(11) DEFAULT 1,
    `installments_paid` INT(11) DEFAULT 0,
    `contract_url` TEXT,
    `notes` TEXT,
    
    -- Gerente
    `manager_name` VARCHAR(255) DEFAULT 'A definir',
    `manager_phone` VARCHAR(50) DEFAULT '',
    
    -- Links
    `github_url` VARCHAR(255) DEFAULT NULL,
    `provisional_url` VARCHAR(255) DEFAULT NULL,
    `definitive_url` VARCHAR(255) DEFAULT NULL,
    
    -- Próxima Ação
    `next_action` TEXT,
    `next_action_deadline` DATE DEFAULT NULL,
    `next_action_type` VARCHAR(20) DEFAULT 'info',
    `next_action_link` TEXT,
    `next_action_data` TEXT,
    
    -- KPIs
    `health_status` VARCHAR(20) DEFAULT 'on_track',
    `custom_progress` INT(11) DEFAULT NULL,
    `custom_completed_items` INT(11) DEFAULT NULL,
    `custom_total_items` INT(11) DEFAULT NULL,
    
    -- Mensagem Destaque
    `featured_message` TEXT,
    
    -- Internacionalização
    `locale` VARCHAR(10) DEFAULT 'pt-BR',
    
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
    
    PRIMARY KEY (`id`),
    KEY `client_id` (`client_id`),
    CONSTRAINT `fk_projects_client` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- Tabela: timeline_events
-- Eventos da timeline do projeto
-- ============================================
CREATE TABLE IF NOT EXISTS `timeline_events` (
    `id` INT(11) NOT NULL AUTO_INCREMENT,
    `project_id` INT(11) NOT NULL,
    `title` VARCHAR(200) NOT NULL,
    `description` TEXT,
    `type` VARCHAR(20) NOT NULL,
    `status` VARCHAR(20) DEFAULT 'pending',
    `completed_at` DATETIME DEFAULT NULL,
    `metadata` TEXT,
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `project_id` (`project_id`),
    CONSTRAINT `fk_events_project` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- Tabela: project_feedback
-- Histórico de feedback/votos/aprovações
-- ============================================
CREATE TABLE IF NOT EXISTS `project_feedback` (
    `id` INT(11) NOT NULL AUTO_INCREMENT,
    `project_id` INT(11) NOT NULL,
    `type` VARCHAR(50) NOT NULL,
    `content` TEXT,
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `project_id` (`project_id`),
    CONSTRAINT `fk_feedback_project` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- Tabela: project_ideas
-- Ideias submetidas pelos clientes
-- ============================================
CREATE TABLE IF NOT EXISTS `project_ideas` (
    `id` INT(11) NOT NULL AUTO_INCREMENT,
    `project_id` INT(11) NOT NULL,
    `title` VARCHAR(200) NOT NULL,
    `description` TEXT,
    `status` VARCHAR(20) DEFAULT 'new',
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `project_id` (`project_id`),
    CONSTRAINT `fk_ideas_project` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- Tabela: tickets
-- Tickets de suporte
-- ============================================
CREATE TABLE IF NOT EXISTS `tickets` (
    `id` INT(11) NOT NULL AUTO_INCREMENT,
    `project_id` INT(11) NOT NULL,
    `subject` VARCHAR(255) NOT NULL,
    `category` VARCHAR(50) DEFAULT 'support',
    `status` VARCHAR(20) DEFAULT 'open',
    `priority` VARCHAR(20) DEFAULT 'normal',
    `client_read` TINYINT(1) DEFAULT 1,
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `project_id` (`project_id`),
    CONSTRAINT `fk_tickets_project` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- Tabela: ticket_messages
-- Mensagens dos tickets
-- ============================================
CREATE TABLE IF NOT EXISTS `ticket_messages` (
    `id` INT(11) NOT NULL AUTO_INCREMENT,
    `ticket_id` INT(11) NOT NULL,
    `sender_type` VARCHAR(20) NOT NULL,
    `message` TEXT NOT NULL,
    `attachment_path` TEXT,
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `ticket_id` (`ticket_id`),
    CONSTRAINT `fk_messages_ticket` FOREIGN KEY (`ticket_id`) REFERENCES `tickets` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- Tabela: ticket_attachments
-- Anexos de tickets
-- ============================================
CREATE TABLE IF NOT EXISTS `ticket_attachments` (
    `id` INT(11) NOT NULL AUTO_INCREMENT,
    `ticket_id` INT(11) NOT NULL,
    `message_id` INT(11) DEFAULT NULL,
    `file_name` VARCHAR(255) NOT NULL,
    `file_path` TEXT NOT NULL,
    `file_size` INT(11) DEFAULT NULL,
    `file_type` VARCHAR(100) DEFAULT NULL,
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `ticket_id` (`ticket_id`),
    CONSTRAINT `fk_attachments_ticket` FOREIGN KEY (`ticket_id`) REFERENCES `tickets` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- Tabela: project_checkpoints
-- Checkpoints de progresso
-- ============================================
CREATE TABLE IF NOT EXISTS `project_checkpoints` (
    `id` INT(11) NOT NULL AUTO_INCREMENT,
    `project_id` INT(11) NOT NULL,
    `title` VARCHAR(200) NOT NULL,
    `description` TEXT,
    `status` VARCHAR(20) DEFAULT 'pending',
    `order_index` INT(11) DEFAULT 0,
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `project_id` (`project_id`),
    CONSTRAINT `fk_checkpoints_project` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- Dados Iniciais (Seed)
-- ============================================

-- Admin padrão (senha: admin123)
INSERT INTO `users` (`email`, `password_hash`) VALUES 
('admin@operon.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi');

COMMIT;

-- ============================================
-- FIM DO SCHEMA
-- ============================================
