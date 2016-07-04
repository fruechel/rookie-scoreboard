CREATE TABLE IF NOT EXISTS "users" (
    id SERIAL PRIMARY KEY,
    name VARCHAR(255) UNIQUE,
    pass VARCHAR(255),
    is_admin INTEGER DEFAULT 0
);
CREATE TABLE IF NOT EXISTS challenges (
    id SERIAL PRIMARY KEY,
    title VARCHAR(255),
    "desc" TEXT,
    flag TEXT,
    points INTEGER,
    ctf VARCHAR(255),
    UNIQUE (title, ctf)
);
CREATE TABLE IF NOT EXISTS solves (
    user_id INTEGER,
    challenge_id INTEGER,
    PRIMARY KEY (user_id, challenge_id)
);
