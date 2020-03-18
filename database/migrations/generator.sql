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
