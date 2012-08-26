-- --
-- When importing this file in phpMyAdmin, use the ANSI dialect
-- --

CREATE TABLE ul_blocked_ips (
  ip varchar(39) CHARACTER SET ascii NOT NULL,
  block_expires varchar(26) CHARACTER SET ascii NOT NULL,
  PRIMARY KEY (ip)
);


CREATE TABLE ul_log (
  timestamp varchar(26) CHARACTER SET ascii NOT NULL,
  action varchar(20) NOT NULL,
  comment varchar(255) NOT NULL DEFAULT '',
  user varchar(40) NOT NULL,
  ip varchar(39) NOT NULL
);


CREATE TABLE ul_logins (
  id int(11) NOT NULL AUTO_INCREMENT,
  username varchar(40) NOT NULL,
  password varchar(60) NOT NULL,
  date_created varchar(26) CHARACTER SET ascii NOT NULL,
  last_login varchar(26) CHARACTER SET ascii NOT NULL,
  block_expires varchar(26) CHARACTER SET ascii NOT NULL,
  PRIMARY KEY (id),
  UNIQUE KEY username (username)
);


CREATE TABLE ul_nonces (
  code varchar(100) NOT NULL,
  action varchar(50) NOT NULL,
  nonce_expires varchar(26) CHARACTER SET ascii NOT NULL,
  PRIMARY KEY (code),
  UNIQUE KEY action (action)
);


CREATE TABLE ul_sessions (
  id varchar(64) CHARACTER SET ascii NOT NULL DEFAULT '',
  data blob NOT NULL,
  session_expires varchar(26) CHARACTER SET ascii NOT NULL,
  lock_expires varchar(26) CHARACTER SET ascii NOT NULL,
  PRIMARY KEY (id)
);
