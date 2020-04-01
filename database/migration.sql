CREATE USER 'labfy'@'localhost' IDENTIFIED BY 'Labfy$';
GRANT ALL PRIVILEGES ON * . * TO 'labfy'@'localhost';
FLUSH PRIVILEGES;

CREATE DATABASE labfy;


USE `labfy`;

CREATE TABLE `boards` (
   `board_id` INT(11) NOT NULL AUTO_INCREMENT,
   `title` VARCHAR(255) NOT NULL,
   `created_at`  TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
   `updated_at`  TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
   `archived_at` TIMESTAMP NULL,
    PRIMARY KEY (board_id)
); 

CREATE TABLE `cards` (
    `card_id` INT(11) NOT NULL AUTO_INCREMENT,
    `title`  VARCHAR(255) NOT NULL,
    `list_state` ENUM('TODO','DOING','DONE', 'FRIDGE') NOT NULL DEFAULT 'TODO',
    `content` VARCHAR(500) NOT NULL,
    `label` ENUM('#7159c1', '#54e1f7', '#3c8dbc') NOT NULL DEFAULT '#3c8dbc',
    `created_by` VARCHAR(255) NOT NULL,
    `updated_at`  TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `created_at`  TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (card_id)
);



INSERT INTO `boards` (`title`) VALUES ('Labfy');

INSERT INTO `cards` (`title`, `content`, `label`, `created_by`) VALUE ('Desenvolver kanbam', 'Desenvolver um quadro que possa cadastrar todas as tarefas pendentes', '#54e1f7', 'Neto');
INSERT INTO `cards` (`title`, `content`, `label`, `created_by`) VALUE ('Task #1', 'Task generica ', '#7159c1', 'Jocelino');
INSERT INTO `cards` (`title`, `content`, `label`, `created_by`) VALUE ('Task #2', 'Task generica ', '#7159c1', 'Neto Jocelino');
INSERT INTO `cards` (`title`, `content`, `label`, `created_by`) VALUE ('Task #3', 'Task generica ', '#3c8dbc', 'Edilayne');
INSERT INTO `cards` (`title`, `content`, `label`, `created_by`) VALUE ('Task #4', 'Task generica ', '#7159c1', 'Ricardo');
INSERT INTO `cards` (`title`, `content`, `label`, `created_by`) VALUE ('Task #5', 'Task generica ', '#7159c1', 'Ricardo');
INSERT INTO `cards` (`title`, `content`, `label`, `created_by`) VALUE ('Task #6', 'Task generica ', '#54e1f7', 'Edilayne');
