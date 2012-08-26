<?php

// ------------------------------------------------
//	DATABASE ACCESS
// ------------------------------------------------

// TODO: rename dbname back to ulogin
// Connection string to use for connecting to a PDO database.
define('UL_PDO_CON_STRING', 'mysql:host=127.0.0.1;dbname=omsb_auth_test');

// SQL query to execute at the start of each PDO connection.
// For example, if you allow UTF-8 usernames and you are using MySQL,
// you could set this to "SET NAMES 'utf8'". Unused if empty.
define('UL_PDO_CON_INIT_QUERY', '');

// ------------------------------------------------
//	DATABASE USERS
// ------------------------------------------------

// Following database users should only have access to their specified table(s).
// Optimally, no other user should have access to the same tables, except
// where listed otherwise.

// If you do not want to create all the different users, you can of course
// create just one with appropriate credentials and supply the same username and password
// to all the following fields. However, that is not recommended. You should at least have
// a separate user for the AUTH user.

// You do not need to set logins for functionality that you do not use
// (for example, if you use a different user database).

// AUTH
// Used to log users in.
// Database user with SELECT access to the
// logins table.
define('UL_PDO_AUTH_USER', 'morgan');
define('UL_PDO_AUTH_PWD', 'ffagan23');

// LOGIN UPDATE
// Used to add new and modify login data.
// Database user with SELECT, UPDATE and INSERT access to the
// logins table.
define('UL_PDO_UPDATE_USER', 'morgan');
define('UL_PDO_UPDATE_PWD', 'ffagan23');

// LOGIN DELETE
// Used to remove logins.
// Database user with SELECT and DELETE access to the
// logins table
define('UL_PDO_DELETE_USER', 'morgan');
define('UL_PDO_DELETE_PWD', 'ffagan23');

// SESSION
// Database user with SELECT, UPDATE and DELETE permissions to the
// sessions and nonces tables.
define('UL_PDO_SESSIONS_USER', 'morgan');
define('UL_PDO_SESSIONS_PWD', 'ffagan23');

// LOG
// Used to log events and analyze previous activity.
// Database user with SELECT, INSERT and DELETE access to the
// logins-log table.
define('UL_PDO_LOG_USER', 'morgan');
define('UL_PDO_LOG_PWD', 'ffagan23');

?>
