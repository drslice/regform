-- --------------------------------------------------------
--
-- This Sqlite import file will create the necessary tables
-- 	2 users are created: admin and test
-- 	These users cannot log in until their password is set
-- 	Use "?force_login=admin" to set them manually
--
-- --------------------------------------------------------

DROP TABLE IF EXISTS fields;
CREATE TABLE fields (
  id INTEGER,
  form_id INTEGER,
  num INTEGER,
  name TEXT,
  type TEXT,
  size INTEGER,
  rows INTEGER,
  cols INTEGER,
  options TEXT,
  required INTEGER,
  PRIMARY KEY (id),
  FOREIGN KEY (form_id) REFERENCES forms,
  UNIQUE (form_id,name),
  UNIQUE (form_id,num)
);

INSERT INTO fields (id, form_id, num, name, type, size, rows, cols, options, required) VALUES
(1, 1, 1, 'Name', 'text', 50, 10, 60, '', 1);
INSERT INTO fields (id, form_id, num, name, type, size, rows, cols, options, required) VALUES
(2, 1, 2, 'Email', 'text', 50, 10, 60, '', 1);
INSERT INTO fields (id, form_id, num, name, type, size, rows, cols, options, required) VALUES
(3, 1, 3, 'Are you over the age of 21?', 'yesno', 0, 0, 0, '', 0);
INSERT INTO fields (id, form_id, num, name, type, size, rows, cols, options, required) VALUES
(4, 1, 4, 'What is your favorite color?', 'select', 0, 0, 0, 'red, yellow, blue, green, orange, purple, black, white', 0);
INSERT INTO fields (id, form_id, num, name, type, size, rows, cols, options, required) VALUES
(5, 1, 5, 'Please describe your hobbies.', 'textarea', 0, 10, 60, '', 0);

-- --------------------------------------------------------

DROP TABLE IF EXISTS forms;
CREATE TABLE forms (
  id INTEGER,
  user_id INTEGER,
  name TEXT,
  submit_value TEXT,
  created INTEGER,
  finalized INTEGER,
  published INTEGER,
  send_email INTEGER,
  PRIMARY KEY (id),
  FOREIGN KEY (user_id) REFERENCES users,
  UNIQUE (user_id,name)
);

INSERT INTO forms (id, user_id, name, submit_value, created, finalized, published, send_email) VALUES
(1, 2, 'Sample Form', 'Register', 1283376595, 0, 0, 0);

-- --------------------------------------------------------

DROP TABLE IF EXISTS levels;
CREATE TABLE levels (
  id INTEGER,
  name TEXT,
  max_forms INTEGER,
  max_fields INTEGER,
  price REAL,
  descr TEXT,
  PRIMARY KEY (id),
  UNIQUE (name)
);

INSERT INTO levels (id, name, max_forms, max_fields, price, descr) VALUES
(1, 'Trial', 3, 10, '0.00', 'You can create up to 3 forms with up to 10 fields per form but you can not publish them.');
INSERT INTO levels (id, name, max_forms, max_fields, price, descr) VALUES
(2, 'Basic', 3, 10, '10.00', 'You can create up to 3 forms with up to 10 fields per form.');
INSERT INTO levels (id, name, max_forms, max_fields, price, descr) VALUES
(3, 'Professional', 10, 20, '20.00', 'You can create up to 10 forms with up to 20 fields per form.');

-- --------------------------------------------------------

DROP TABLE IF EXISTS roles;
CREATE TABLE roles (
  id INTEGER,
  name TEXT,
  description TEXT,
  PRIMARY KEY (id),
  UNIQUE (name)
);

INSERT INTO roles (id, name, description) VALUES
(1, 'login', 'Login privileges, granted after account confirmation');
INSERT INTO roles (id, name, description) VALUES
(2, 'admin', 'Administrative user, has access to everything.');

-- --------------------------------------------------------

DROP TABLE IF EXISTS roles_users;
CREATE TABLE roles_users (
  user_id INTEGER,
  role_id INTEGER,
  PRIMARY KEY (user_id,role_id),
  FOREIGN KEY (user_id) REFERENCES users,
  FOREIGN KEY (role_id) REFERENCES roles
);

INSERT INTO roles_users (user_id, role_id) VALUES
(1, 1);
INSERT INTO roles_users (user_id, role_id) VALUES
(1, 2);
INSERT INTO roles_users (user_id, role_id) VALUES
(2, 1);

-- --------------------------------------------------------

DROP TABLE IF EXISTS users;
CREATE TABLE users (
  id INTEGER,
  level_id INTEGER,
  email TEXT,
  username TEXT,
  password TEXT,
  logo TEXT,
  logins INTEGER,
  last_login INTEGER,
  PRIMARY KEY (id),
  FOREIGN KEY (level_id) REFERENCES levels,
  UNIQUE (email),
  UNIQUE (username)
);

INSERT INTO users (id, level_id, email, username, password, logo, logins, last_login) VALUES
(1, 3, 'admin@reg.com', 'admin', '', '', 0, 0);
INSERT INTO users (id, level_id, email, username, password, logo, logins, last_login) VALUES
(2, 1, 'test@test.test', 'test', '', '', 0, 0);

-- --------------------------------------------------------

DROP TABLE IF EXISTS user_tokens;
CREATE TABLE user_tokens (
  id INTEGER,
  user_id INTEGER,
  user_agent TEXT,
  token TEXT,
  created INTEGER,
  expires INTEGER,
  PRIMARY KEY (id),
  FOREIGN KEY (user_id) REFERENCES users,
  UNIQUE (token)
);
