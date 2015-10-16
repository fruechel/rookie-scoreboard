CREATE TABLE IF NOT EXISTS users (
    id INTEGER PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) UNIQUE,
    pass VARCHAR(255),
    is_admin TINYINT DEFAULT 0
);
CREATE TABLE IF NOT EXISTS challenges (
    id INTEGER PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(255),
    `desc` TEXT,
    flag TEXT,
    points INTEGER,
    ctf VARCHAR(255),
    UNIQUE (title, ctf)
);
CREATE TABLE IF NOT EXISTS solves (
    user_id INTEGER,
    challenge_id INTEGER,
    reported TINYINT DEFAULT 0,
    PRIMARY KEY (user_id, challenge_id)
);
