magic with sqlite
$magic = DatabaseProvider::GetLogDbConnection();

$magic->exec('CREATE TABLE IF NOT EXISTS request_logs (
                    id INTEGER PRIMARY KEY, 
                    ip TEXT, 
                    request_type TEXT, 
                    requested_module TEXT,
                    requested_function TEXT,
                    access_level TEXT,
                    uid INTEGER,
                    datetime TEXT)');

$magic = DatabaseProvider::GetConnection();                   
$magic->exec('CREATE TABLE IF NOT EXISTS `users` (
  `id` int(6) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `pass_hash` varchar(64) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `access` tinyint(3) unsigned NOT NULL,
  `firstname` varchar(50) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  `confirm` int(4) unsigned NOT NULL,
  `session_hash` varchar(64) NOT NULL,
  `reg_datetime` timestamp NOT NULL,
  `is_active` boolean NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`),
)');


$magic = DatabaseProvider::GetConnection();
$magic->exec('CREATE TABLE IF NOT EXISTS `places` (
  `id` int(6) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(128) NOT NULL,
  `address` varchar(255) NOT NULL,
  `phones` varchar(255) NOT NULL,
  `working_time` varchar(128) NOT NULL,
  `short_info` varchar(128) NOT NULL,
  `info` text(1024) NOT NULL,
  `wifi` bool NOT NULL,
  `type` varchar(16) NOT NULL,
  `sum_rating` int(10) NOT NULL,
  `count_rating` int(10) unsigned NOT NULL,
  `owner_id` int(6) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=0');