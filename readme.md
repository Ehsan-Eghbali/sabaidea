    const host = 'localhost';
    const user = 'root';
    const passwd = '';
    const table = 'test';


CREATE TABLE users ( ID BIGINT UNSIGNED NOT NULL AUTO_INCREMENT , name VARCHAR(255) NOT NULL , PRIMARY KEY (ID)) ENGINE = InnoDB;


CREATE TABLE IF NOT EXISTS url_shorten (
id BIGINT NOT NULL AUTO_INCREMENT PRIMARY KEY,
url tinytext NOT NULL,
short_code varchar(50) NOT NULL,
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;