<?php

// ------------------------------------------------
//	BASIC CONFIGURATION
// ------------------------------------------------

// Domain name of your site.
// This must be the same domain name that the browser uses to 
// fetch your website, without the protocol specifier (don't use 'http(s)://').
// For development on the local machine, use 'localhost'.
// Takes the same format as the 'domain' parameter of the PHP setcookie function.
#define('UL_DOMAIN', 'medievalsourcesbibliography.org');
define('UL_DOMAIN', 'omsb-dev.alchemycs.com');

// Set to the path of the "ulogin" directory containing the source files.
// Do not use a trailing slash.
define('UL_INC_DIR', '/home/httpd/omsb-dev/ulogin');

// A random string. Make it as random as possible and keep it secure.
// This is a crypthographic key that uLogin will use to generate some data
// and later verify its identity.
// The longer the better, should be 40+ characters.
// Once set and your site is live, do not change this.
define('UL_SITE_KEY', 'ncgQVEM/V/pQrwYs+KOxDZTg2jGBtWjESu605yt753y6OGl2A6Nz3VZZ<br>+Ybt9bbqWi9GchJ7mJWHM8LJHmExcWTPQ6/DUCzfzatjTy61XpDVq5xA<br>pvKWJKioyDCd9uOA6u2L/MyMSqslwY2zigZM5Vn+a+8yodULaCvD5Gom<br>BF3yiW2j5pcaU0v5PUaNzyK5Mspg98zxEtancquxJKkMrAd39/KPetsj<br>5dIKkwXD3BFyXzyP3Uv6Uk89VyDzp/p8aFDQxVNmQFA4yrFdUDUfVTyz<br>CuZAOZwcfSxPrA0155Ta4WTOAU7wKVyAuMY9wFcU9+RrqclW8n83KbVd<br>hgeCTRE2Qvft1hFdNN0hjC292vNZOJIdfA1z+TUJlpWqx/pvRq35l9T+<br>cPBPs27YZnM2qvFzzwBimYOh5FtJfw87+A4htuCqXKHhNXXXcRXticL6<br>fOQr5En4Y1wmL/ss12ZTSNU+dHbMWRkKrTgaEClx50veEoVGqDn1K+tJ<br>e3z7rnov+j2rU5WwRvuGbBJjKsG4eiZAe3zYdNMzX46itOrpJoKKZGZf');

// ------------------------------------------------
//	GENERAL CONFIGURATION
// ------------------------------------------------

// Does the website use AJAX?
// This merely serves as information for the installCheck script,
// so that it can warn about settings that need special attention when
// used with AJAX.
define('UL_USES_AJAX', false);

// Default storage backend for user database.
// This only selects the default backend. Regardless of what is specified here,
// applications can still select and use any at runtime.
// Choose: 'ulPdoLoginBackend',    'ulLdapLoginBackend',
//         'ulOpenIdLoginBackend', 'ulSsh2LoginBackend',
//         'ulDuoSecLoginBackend'
define('UL_AUTH_BACKEND', 'ulPdoLoginBackend');

// If enabled, all pages that include uLogin will be redirected
// by the server to a SSL-secured connection.
// It is highly recommended to enable this, but to prevent
// warnings to the user, a correct web server certificate
// must be installed on the server.
define('UL_HTTPS', false);

// Enable HTTP Strict Transport Security.
// If enabled and supported by the client's browser,
// all requests in the next specified number of seconds
// will be redirected by the browser to a SSL-secured connection.
// In contrast to UL_HTTPS this option will cause even those pages
// in the current domain to be redirected that do not include uLogin.
// It will also redirect all references inside pages.
// This option provides better protection than UL_HTTPS but
// requires browser support and a perfectly valid SSL certificate.
// Note that self-signed certificates do not work with HSTS unless they are
// manually pre-imported into the client.
// Zero disables HSTS, otherwise UL_HSTS implies UL_HTTPS.
define('UL_HSTS', 0);

// If set to true, will send x-frame-options header to prevent
// secure pages from being framed in a foreign website.
// Recommended to turn on, but a relatively recent browser
// is needed to actually take effect.
define('UL_PREVENT_CLICKJACK', true);

// Set to true to enable session replay prevention.
// On each request the client will receive a new token that
// will be checked by the server on the next request. This
// will increase security, with the downside that clients must
// wait until they receive each server answer. If they do not wait,
// their session will get invalidated. Thus when turned on, it might
// present complications for websites that use AJAX, for example.
define('UL_PREVENT_REPLAY', true);

// Login throttling. Delay execution this many seconds on each failed login.
// Slows down brute force attackers. For timing attack prevention
// this value should be higher than the maximum time a successfull
// login takes. A couple of seconds should be enough.
// Zero disables login throttling and timing attack prevention.
define('UL_LOGIN_DELAY', 5);

// Generated nonces will expire after this many
// seconds by default.
define('UL_NONCE_EXPIRE', 900);

// How many seconds should autologin be valid for a user.
define('UL_AUTOLOGIN_EXPIRE', 5356800);

// Maximum username length. Any username longer than
// this limit will be considered invalid user input.
define('UL_MAX_USERNAME_LENGTH', 100);

// If true, the library will check that usernames only contain
// alphanumeric characters, and will return an error if not.
// If false, input validation is left completely to the host application.
define('UL_ALPHANUMERIC_USER', true);

// If UL_ALPHANUMERIC_USER is set to true, this is a list of characters
// to accept even though they are not alphanumeric.
define('UL_USERNAME_EXTRA_CHARS', '@-_./:?=');

// Defines the hash function to be used for HMAC calculations.
// Changing this for a live site might invalidate user data.
define('UL_HMAC_FUNC', 'sha256');

// Password stretching factor.
// A larger value is slower but more secure.
// Must be in the range of 04-31.
define('UL_BCRYPT_ROUNDS', 11);

// ------------------------------------------------
//	DEBUG
// ------------------------------------------------

// Enabling debugging outputs useful error messages
// in the browser if there are errors, but it can be used
// by a malicious user to gain non-public information.
// Enable during development and testing, disable for
// for production websites.
define('UL_DEBUG', true);
define('UL_GENERIC_ERROR_MSG', 'An error occured. Please try again or contact the administrator.');

// Set to the upper most root path of the website. This is only used to mask
// out the given path portion in error messages, for the case a user happens
// to see an error generated by uLogin.
define('UL_SITE_ROOT_DIR', '/var/www/mywebdir/htdocs');

// ------------------------------------------------
//	SESSIONS
// ------------------------------------------------

// If true, a secure session will be automatically started on every page
// without having to call sses_start().
define('UL_SESSION_AUTOSTART', true);

// Do we want secure sessions to expire automatically?
// If there is no user activity (page load), the session
// will become invalid after this many seconds.
// To disable automatic expiry, set it to a sufficiently
// large value (eg. 86400 = 1 day).
// Only positive values are valid.
define('UL_SESSION_EXPIRE', 28800);

// Probability that the session id will be regenerated
// when a session is started. Zero will disable automatic
// session id regeneration, it is the least secure but
// it is the only setting guaranteed not to cause problems for
// AJAX requests. 100 is the most secure as it will generate a new
// session id on each request but will increase server load.
// Choose a value larger than 0 if not using AJAX.
// Note, you can override this value in the parameter of
// sses_start(), so that you can use 0 for AJAX pages but non-zero
// for everything else.
define('UL_SESSION_REGEN_PROB', 0);

// Defines the storage mechanism to use for sessions.
// Storing sessions into a custom database provides
// higher protection for sensitive session data and allows
// for distributed server operation.
// Choose: 'ulPhpDefaultSessionStorage', 'ulPdoSessionStorage' (recommended)
define('UL_SESSION_BACKEND', 'ulPdoSessionStorage');

// Defines if the HTTP referrers' domain must always be consistent.
// Disable this if your website expects customers to leave to another domain,
// then be redirected back while still continuing their old session.
// For example, you'd want to disable this if you accept PayPal checkouts or
// other forms of online payment. Otherwise, keep this enabled for added
// security.
define('UL_SESSION_CHECK_REFERER', true);

// Defines if the user's IP must always be consistent.
// Disable this if you get a lot of complaints from users behind load balancing
// configurations. Otherwise, keep this enabled for added security.
define('UL_SESSION_CHECK_IP', true);

// ------------------------------------------------
//	LOGGING AND LOCKOUT
// ------------------------------------------------

// If you have access to an SQL database, it is highly recommended to enable logging.
// Logging not only enables tracebility of past user behaviour, but it
// enables additional brute-force prevention measures.
define('UL_LOG', true);

// Maximum time to keep logs for, in seconds.
// 5356800 is 62 days (appr. 2 months).
// Zero to disable limiting the age of logs.
// Depending on how often and when you clean up, the
// actual log might temporarily grow larger until
// a clean is performed.
define('UL_MAX_LOG_AGE', 5356800);

// Maximum number of records to keep in log.
// Zero to disable limiting the number of records.
// Depending on how often and when you clean up, the
// actual log might temporarily grow larger until
// a clean is performed.
define('UL_MAX_LOG_RECORDS', 200000);

// Most recent time window to check for brute force
// activity, in seconds.
define('UL_BF_WINDOW', 300);

// Maximum number of login attempts allowed in UL_BF_WINDOW.
define('UL_BF_IP_ATTEMPTS', 5);

// If a user gets UL_BF_ATTEMPTS number of attempts in
// UL_BF_WINDOW seconds, that IP will be banned for this
// many seconds. Zero disables lockout.
define('UL_BF_IP_LOCKOUT', 18000);

// Maximum number of login attempts allowed in UL_BF_WINDOW.
define('UL_BF_USER_ATTEMPTS', 10);

// If a user gets UL_BF_USER_ATTEMPTS number of attempts in
// UL_BF_WINDOW seconds, that user will be banned for this
// many seconds, even if the attempts originate from different
// IP addresses. Zero disables lockout.
define('UL_BF_USER_LOCKOUT', 18000);

// ------------------------------------------------
//	DO NOT MODIFY BELOW
// ------------------------------------------------
// The values below are chosen based on implementation requirements
// within uLogin. Modifying anything below will most probably break your
// uLogin and your website.
// ------------------------------------------------

// The effective password length limit for the user ranges 36-54
// and depends on whether there are 8bit chars in the password.
define('UL_MAX_PASSWORD_LENGTH', 54);

// String format to store dates in in database tables.
define('UL_DATETIME_FORMAT', 'c');

?>
