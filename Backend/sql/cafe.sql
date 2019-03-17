SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

CREATE DATABASE IF NOT EXISTS `cafe` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `cafe`;
DROP VIEW IF EXISTS `avg_ing_prices`;
CREATE TABLE IF NOT EXISTS `avg_ing_prices` (
`ing_name` char(40)
,`unit_price` double
);

DROP TABLE IF EXISTS `categories`;
CREATE TABLE IF NOT EXISTS `categories` (
  `cat_name` char(30) NOT NULL,
  PRIMARY KEY (`cat_name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO `categories` (`cat_name`) VALUES('алкогольні напої');
INSERT INTO `categories` (`cat_name`) VALUES('вегетаріанські страви');
INSERT INTO `categories` (`cat_name`) VALUES('гарніри');
INSERT INTO `categories` (`cat_name`) VALUES('гарячі закуски');
INSERT INTO `categories` (`cat_name`) VALUES('гарячі напої');
INSERT INTO `categories` (`cat_name`) VALUES('гострі страви');
INSERT INTO `categories` (`cat_name`) VALUES('десерти');
INSERT INTO `categories` (`cat_name`) VALUES('другі страви');
INSERT INTO `categories` (`cat_name`) VALUES('жарені страви');
INSERT INTO `categories` (`cat_name`) VALUES('запечені страви');
INSERT INTO `categories` (`cat_name`) VALUES("м'ясні страви");
INSERT INTO `categories` (`cat_name`) VALUES('напої');
INSERT INTO `categories` (`cat_name`) VALUES('паста');
INSERT INTO `categories` (`cat_name`) VALUES('перші страви');
INSERT INTO `categories` (`cat_name`) VALUES('рибні страви');
INSERT INTO `categories` (`cat_name`) VALUES('салати');
INSERT INTO `categories` (`cat_name`) VALUES('соуси');
INSERT INTO `categories` (`cat_name`) VALUES('супи');
INSERT INTO `categories` (`cat_name`) VALUES('фрукти');
INSERT INTO `categories` (`cat_name`) VALUES('хлібобулочні вироби');
INSERT INTO `categories` (`cat_name`) VALUES('холодні закуски');
INSERT INTO `categories` (`cat_name`) VALUES('холодні напої');

DROP TABLE IF EXISTS `deliveries`;
CREATE TABLE IF NOT EXISTS `deliveries` (
  `delivery_num` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT,
  `is_received` bit(1) GENERATED ALWAYS AS (if(isnull(`receiving_date`),0x00,0x01)) VIRTUAL,
  `purchased` bit(1) GENERATED ALWAYS AS (if(isnull(`pay_date`),0x00,0x01)) VIRTUAL,
  `returned` bit(1) NOT NULL DEFAULT false,
  `invoice_num` int(10) UNSIGNED DEFAULT NULL,
  `receiving_date` date DEFAULT NULL,
  `pay_date` date DEFAULT NULL,
  `cost` decimal(16,2) UNSIGNED NOT NULL DEFAULT '0.00',
  `provider_code` char(8) DEFAULT NULL,
  PRIMARY KEY (`delivery_num`),
  KEY `provider_code` (`provider_code`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

INSERT INTO `deliveries` (`delivery_num`, `returned`, `invoice_num`, `receiving_date`, `pay_date`, `cost`, `provider_code`) VALUES(1, false, 10038493, '2019-02-23', '2019-02-23', '2139.00', '09836456');
INSERT INTO `deliveries` (`delivery_num`, `returned`, `invoice_num`, `receiving_date`, `pay_date`, `cost`, `provider_code`) VALUES(2, false, 32466432, '2019-02-23', '2019-02-23', '100.00', '46985133');
INSERT INTO `deliveries` (`delivery_num`, `returned`, `invoice_num`, `receiving_date`, `pay_date`, `cost`, `provider_code`) VALUES(3, false, 56435, '2019-02-23', '2019-02-23', '1100.00', '56453132');
INSERT INTO `deliveries` (`delivery_num`, `returned`, `invoice_num`, `receiving_date`, `pay_date`, `cost`, `provider_code`) VALUES(4, false, 43234, '2019-02-23', '2019-02-23', '231.25', '21343655');
INSERT INTO `deliveries` (`delivery_num`, `returned`, `invoice_num`, `receiving_date`, `pay_date`, `cost`, `provider_code`) VALUES(5, false, 3234234, '2019-02-23', '2019-02-23', '3500.00', '23435453');
INSERT INTO `deliveries` (`delivery_num`, `returned`, `invoice_num`, `receiving_date`, `pay_date`, `cost`, `provider_code`) VALUES(6, false, 453455324, '2019-02-23', '2019-02-23', '58.16', '87697842');
INSERT INTO `deliveries` (`delivery_num`, `returned`, `invoice_num`, `receiving_date`, `pay_date`, `cost`, `provider_code`) VALUES(7, false, 66755, '2019-02-23', '2019-02-23', '47.50', '78974346');
INSERT INTO `deliveries` (`delivery_num`, `returned`, `invoice_num`, `receiving_date`, `pay_date`, `cost`, `provider_code`) VALUES(8, false, 546322, '2019-02-23', '2019-02-23', '289.00', '87697842');
INSERT INTO `deliveries` (`delivery_num`, `returned`, `invoice_num`, `receiving_date`, `pay_date`, `cost`, `provider_code`) VALUES(9, false, NULL, NULL, NULL, '0.00', '87697842');
DROP TRIGGER IF EXISTS `create_deliv`;
DELIMITER $$
CREATE TRIGGER `create_deliv` BEFORE INSERT ON `deliveries` FOR EACH ROW BEGIN
  SET NEW.cost = 0;
END
$$
DELIMITER ;

DROP TABLE IF EXISTS `discarding`;
CREATE TABLE IF NOT EXISTS `discarding` (
  `unique_code` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT,
  `discard_date` date NOT NULL,
  `cost` decimal(16,2) UNSIGNED NOT NULL DEFAULT '0.00',
  `tab_num` char(3) NOT NULL,
  PRIMARY KEY (`unique_code`),
  KEY `tab_num` (`tab_num`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

INSERT INTO `discarding` (`unique_code`, `discard_date`, `cost`, `tab_num`) VALUES(1, '2019-02-24', '55.00', '105');
DROP TRIGGER IF EXISTS `create_discard`;
DELIMITER $$
CREATE TRIGGER `create_discard` BEFORE INSERT ON `discarding` FOR EACH ROW BEGIN
  SET NEW.cost = 0;
END
$$
DELIMITER ;

DROP TABLE IF EXISTS `discarding_goods`;
CREATE TABLE IF NOT EXISTS `discarding_goods` (
  `discard_code` mediumint(8) UNSIGNED NOT NULL,
  `good_code` mediumint(8) UNSIGNED NOT NULL,
  `amount` float UNSIGNED NOT NULL,
  `reason` char(100) NOT NULL,
  `cost` decimal(16,2) UNSIGNED NOT NULL DEFAULT '0.00',
  PRIMARY KEY (`discard_code`,`good_code`),
  KEY `good_code` (`good_code`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO `discarding_goods` (`discard_code`, `good_code`, `amount`, `reason`, `cost`) VALUES(1, 2, 0.5, 'собаці', '55.00');
DROP TRIGGER IF EXISTS `afr_del_dis_good`;
DELIMITER $$
CREATE TRIGGER `afr_del_dis_good` AFTER DELETE ON `discarding_goods` FOR EACH ROW BEGIN
  UPDATE discarding
  SET cost = COALESCE ((SELECT SUM(cost)
                        FROM discarding_goods
                        WHERE discard_code = OLD.discard_code), 0)
  WHERE unique_code = OLD.discard_code;
END
$$
DELIMITER ;
DROP TRIGGER IF EXISTS `afr_del_dis_good_amount`;
DELIMITER $$
CREATE TRIGGER `afr_del_dis_good_amount` AFTER DELETE ON `discarding_goods` FOR EACH ROW BEGIN
  UPDATE goods
  SET curr_amount = curr_amount + OLD.amount
  WHERE unique_code = OLD.good_code;
END
$$
DELIMITER ;
DROP TRIGGER IF EXISTS `afr_ins_dis_good`;
DELIMITER $$
CREATE TRIGGER `afr_ins_dis_good` AFTER INSERT ON `discarding_goods` FOR EACH ROW BEGIN
  UPDATE discarding
  SET cost = COALESCE ((SELECT SUM(cost)
                            FROM discarding_goods
                            WHERE discard_code = NEW.discard_code), 0)
  WHERE unique_code = NEW.discard_code;
END
$$
DELIMITER ;
DROP TRIGGER IF EXISTS `afr_ins_dis_good_amount`;
DELIMITER $$
CREATE TRIGGER `afr_ins_dis_good_amount` AFTER INSERT ON `discarding_goods` FOR EACH ROW BEGIN
  UPDATE goods
  SET curr_amount = curr_amount - NEW.amount
  WHERE unique_code = NEW.good_code;
END
$$
DELIMITER ;
DROP TRIGGER IF EXISTS `afr_upd_dis_good`;
DELIMITER $$
CREATE TRIGGER `afr_upd_dis_good` AFTER UPDATE ON `discarding_goods` FOR EACH ROW BEGIN
  IF NEW.amount <> OLD.amount OR NEW.good_code <> OLD.good_code THEN
      UPDATE discarding
      SET cost = COALESCE ((SELECT SUM(cost)
                            FROM discarding_goods
                            WHERE discard_code = NEW.discard_code), 0)
      WHERE unique_code = NEW.discard_code;
  END IF;

  IF NEW.discard_code <> OLD.discard_code THEN
      UPDATE discarding
      SET cost = COALESCE ((SELECT SUM(cost)
                            FROM discarding_goods
                            WHERE discard_code = NEW.discard_code), 0)
      WHERE unique_code IN (NEW.discard_code, OLD.discard_code);
  END IF;
END
$$
DELIMITER ;
DROP TRIGGER IF EXISTS `afr_upd_dis_good_amount`;
DELIMITER $$
CREATE TRIGGER `afr_upd_dis_good_amount` AFTER UPDATE ON `discarding_goods` FOR EACH ROW BEGIN
  IF NEW.amount <> OLD.amount THEN
      UPDATE goods
      SET curr_amount = curr_amount - (NEW.amount - OLD.amount)
      WHERE unique_code = NEW.good_code;
  END IF;

  IF NEW.good_code <> OLD.good_code THEN
      UPDATE goods
      SET curr_amount = curr_amount + OLD.amount
      WHERE unique_code = OLD.good_code;
      UPDATE goods
      SET curr_amount = curr_amount - NEW.amount
      WHERE unique_code = NEW.good_code;
  END IF;
END
$$
DELIMITER ;
DROP TRIGGER IF EXISTS `bfr_ins_dis_good`;
DELIMITER $$
CREATE TRIGGER `bfr_ins_dis_good` BEFORE INSERT ON `discarding_goods` FOR EACH ROW BEGIN
  SET NEW.cost = NEW.amount * (SELECT SUM(unit_price)
                               FROM goods
                               WHERE unique_code = NEW.good_code);
END
$$
DELIMITER ;
DROP TRIGGER IF EXISTS `bfr_upd_dis_good`;
DELIMITER $$
CREATE TRIGGER `bfr_upd_dis_good` BEFORE UPDATE ON `discarding_goods` FOR EACH ROW BEGIN
  IF NEW.amount <> OLD.amount OR NEW.good_code <> OLD.good_code THEN
      SET NEW.cost = NEW.amount * (SELECT SUM(unit_price)
                                   FROM goods
                                   WHERE unique_code = NEW.good_code);
  END IF;
END
$$
DELIMITER ;

DROP TABLE IF EXISTS `dishes`;
CREATE TABLE IF NOT EXISTS `dishes` (
  `tech_card_num` int(10) UNSIGNED NOT NULL,
  `calc_card_num` int(10) UNSIGNED NOT NULL,
  `dish_name` char(30) NOT NULL,
  `weight` smallint(5) UNSIGNED NOT NULL,
  `price` decimal(16,2) UNSIGNED NOT NULL,
  `is_in_menu` bit(1) NOT NULL,
  `department` enum('бар','кухня') NOT NULL DEFAULT 'кухня',
  `is_ing_available` bit(1) NOT NULL DEFAULT true,
  `calories` int(10) UNSIGNED NOT NULL,
  `cooking_time` int(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`tech_card_num`),
  UNIQUE KEY `calc_card_num` (`calc_card_num`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO `dishes` (`tech_card_num`, `calc_card_num`, `dish_name`, `weight`, `price`, `is_in_menu`, `department`, `is_ing_available`, `calories`, `cooking_time`) VALUES(121088, 121088, 'Борщ', 350, '30.00', true, 'кухня', false, 594, 60);
INSERT INTO `dishes` (`tech_card_num`, `calc_card_num`, `dish_name`, `weight`, `price`, `is_in_menu`, `department`, `is_ing_available`, `calories`, `cooking_time`) VALUES(124720, 124720, 'Салат \"Португальський', 300, '19.00', true, 'кухня', false, 459, 15);

DROP TABLE IF EXISTS `dishes_categories`;
CREATE TABLE IF NOT EXISTS `dishes_categories` (
  `tech_card_num` int(10) UNSIGNED NOT NULL,
  `cat_name` char(20) NOT NULL,
  PRIMARY KEY (`tech_card_num`,`cat_name`),
  KEY `cat_name` (`cat_name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO `dishes_categories` (`tech_card_num`, `cat_name`) VALUES(121088, 'Перші страви');
INSERT INTO `dishes_categories` (`tech_card_num`, `cat_name`) VALUES(124720, 'Холодні закуски');

DROP TABLE IF EXISTS `dishes_ingredients`;
CREATE TABLE IF NOT EXISTS `dishes_ingredients` (
  `tech_card_num` int(10) UNSIGNED NOT NULL,
  `ing_name` char(40) NOT NULL,
  `amount` mediumint(8) UNSIGNED NOT NULL,
  PRIMARY KEY (`tech_card_num`,`ing_name`),
  KEY `ing_name` (`ing_name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO `dishes_ingredients` (`tech_card_num`, `ing_name`, `amount`) VALUES(121088, 'картопля', 50);
INSERT INTO `dishes_ingredients` (`tech_card_num`, `ing_name`, `amount`) VALUES(121088, 'ошийок', 50);
INSERT INTO `dishes_ingredients` (`tech_card_num`, `ing_name`, `amount`) VALUES(121088, 'буряк', 50);
INSERT INTO `dishes_ingredients` (`tech_card_num`, `ing_name`, `amount`) VALUES(121088, 'капуста білокачана', 50);
INSERT INTO `dishes_ingredients` (`tech_card_num`, `ing_name`, `amount`) VALUES(121088, 'помідори', 20);
INSERT INTO `dishes_ingredients` (`tech_card_num`, `ing_name`, `amount`) VALUES(121088, 'фасоль стручкова', 50);
INSERT INTO `dishes_ingredients` (`tech_card_num`, `ing_name`, `amount`) VALUES(121088, 'цибуля городня', 50);
INSERT INTO `dishes_ingredients` (`tech_card_num`, `ing_name`, `amount`) VALUES(121088, 'кабачки', 50);
INSERT INTO `dishes_ingredients` (`tech_card_num`, `ing_name`, `amount`) VALUES(121088, 'вода', 100);
INSERT INTO `dishes_ingredients` (`tech_card_num`, `ing_name`, `amount`) VALUES(124720, 'нут', 20);
INSERT INTO `dishes_ingredients` (`tech_card_num`, `ing_name`, `amount`) VALUES(124720, 'тунець', 25);
INSERT INTO `dishes_ingredients` (`tech_card_num`, `ing_name`, `amount`) VALUES(124720, 'оливки', 12);
INSERT INTO `dishes_ingredients` (`tech_card_num`, `ing_name`, `amount`) VALUES(124720, 'цибуля червона', 20);
INSERT INTO `dishes_ingredients` (`tech_card_num`, `ing_name`, `amount`) VALUES(124720, 'оцет 9%', 10);
INSERT INTO `dishes_ingredients` (`tech_card_num`, `ing_name`, `amount`) VALUES(124720, 'яйця', 1);
INSERT INTO `dishes_ingredients` (`tech_card_num`, `ing_name`, `amount`) VALUES(124720, 'гірчиця гостра', 5);
INSERT INTO `dishes_ingredients` (`tech_card_num`, `ing_name`, `amount`) VALUES(124720, 'соняшникова олія', 9);
INSERT INTO `dishes_ingredients` (`tech_card_num`, `ing_name`, `amount`) VALUES(124720, 'петрушка', 10);
INSERT INTO `dishes_ingredients` (`tech_card_num`, `ing_name`, `amount`) VALUES(124720, 'сіль', 5);
INSERT INTO `dishes_ingredients` (`tech_card_num`, `ing_name`, `amount`) VALUES(124720, 'перець чорний мелений', 1);
INSERT INTO `dishes_ingredients` (`tech_card_num`, `ing_name`, `amount`) VALUES(124720, 'картопля', 30);
DROP TRIGGER IF EXISTS `aft_del_d_i`;
DELIMITER $$
CREATE TRIGGER `aft_del_d_i` AFTER DELETE ON `dishes_ingredients` FOR EACH ROW BEGIN
  UPDATE dishes Y
  SET is_ing_available = IF("NO" IN (SELECT IF(amount <= COALESCE((SELECT SUM(curr_amount)
                                                                   FROM ingredients
                                                                   WHERE ing_name = X.ing_name), 0),
                                               "YES", "NO")
                                     FROM dishes_ingredients X
                                     WHERE tech_card_num = Y.tech_card_num), 0b0, 0b1)
  WHERE tech_card_num = OLD.tech_card_num;
END
$$
DELIMITER ;
DROP TRIGGER IF EXISTS `aft_ins_d_i`;
DELIMITER $$
CREATE TRIGGER `aft_ins_d_i` AFTER INSERT ON `dishes_ingredients` FOR EACH ROW BEGIN
  UPDATE dishes Y
  SET is_ing_available = IF("NO" IN (SELECT IF(amount <= COALESCE((SELECT SUM(curr_amount)
                                                                   FROM ingredients
                                                                   WHERE ing_name = X.ing_name), 0),
                                               "YES", "NO")
                                     FROM dishes_ingredients X
                                     WHERE tech_card_num = Y.tech_card_num), 0b0, 0b1)
  WHERE tech_card_num = NEW.tech_card_num;
END
$$
DELIMITER ;
DROP TRIGGER IF EXISTS `aft_upd_d_i`;
DELIMITER $$
CREATE TRIGGER `aft_upd_d_i` AFTER UPDATE ON `dishes_ingredients` FOR EACH ROW BEGIN
  UPDATE dishes Y
  SET is_ing_available = IF("NO" IN (SELECT IF(amount <= COALESCE((SELECT SUM(curr_amount)
                                                                   FROM ingredients
                                                                   WHERE ing_name = X.ing_name), 0),
                                               "YES", "NO")
                                     FROM dishes_ingredients X
                                     WHERE tech_card_num = Y.tech_card_num), 0b0, 0b1)
  WHERE tech_card_num IN (NEW.tech_card_num, OLD.tech_card_num);
END
$$
DELIMITER ;

DROP TABLE IF EXISTS `goods`;
CREATE TABLE IF NOT EXISTS `goods` (
  `unique_code` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT,
  `goods_name` char(50) NOT NULL,
  `unit_price` decimal(16,2) UNSIGNED NOT NULL,
  `cost` decimal(16,2) UNSIGNED GENERATED ALWAYS AS ((`start_amount` * `unit_price`)) VIRTUAL,
  `expected_amount` float UNSIGNED NOT NULL DEFAULT '0',
  `curr_amount` float UNSIGNED NOT NULL DEFAULT '0',
  `start_amount` float UNSIGNED NOT NULL,
  `production_date` date DEFAULT NULL,
  `expiration_date` date DEFAULT NULL,
  `inventarization_date` date DEFAULT NULL,
  `ing_name` char(40) NOT NULL,
  `delivery_num` mediumint(8) UNSIGNED NOT NULL,
  `unit_name` char(2) NOT NULL,
  PRIMARY KEY (`unique_code`),
  KEY `ing_name` (`ing_name`),
  KEY `delivery_num` (`delivery_num`),
  KEY `unit_name` (`unit_name`)
) ENGINE=MyISAM AUTO_INCREMENT=22 DEFAULT CHARSET=utf8;

INSERT INTO `goods` (`unique_code`, `goods_name`, `unit_price`, `expected_amount`, `curr_amount`, `start_amount`, `production_date`, `expiration_date`, `inventarization_date`, `ing_name`, `delivery_num`, `unit_name`) VALUES(1, 'картопля', '9.00', 30, 0, 30, NULL, NULL, NULL, 'картопля', 1, 'кг');
INSERT INTO `goods` (`unique_code`, `goods_name`, `unit_price`, `expected_amount`, `curr_amount`, `start_amount`, `production_date`, `expiration_date`, `inventarization_date`, `ing_name`, `delivery_num`, `unit_name`) VALUES(2, 'ошийок', '110.00', 10, 9.5, 10, '2019-02-22', '2019-02-26', NULL, 'ошийок', 3, 'кг');
INSERT INTO `goods` (`unique_code`, `goods_name`, `unit_price`, `expected_amount`, `curr_amount`, `start_amount`, `production_date`, `expiration_date`, `inventarization_date`, `ing_name`, `delivery_num`, `unit_name`) VALUES(3, 'буряк', '9.00', 20, 20, 20, NULL, NULL, NULL, 'буряк', 1, 'кг');
INSERT INTO `goods` (`unique_code`, `goods_name`, `unit_price`, `expected_amount`, `curr_amount`, `start_amount`, `production_date`, `expiration_date`, `inventarization_date`, `ing_name`, `delivery_num`, `unit_name`) VALUES(4, 'капуста білокачана', '110.00', 10, 10, 10, NULL, NULL, NULL, 'капуста білокачана', 1, 'кг');
INSERT INTO `goods` (`unique_code`, `goods_name`, `unit_price`, `expected_amount`, `curr_amount`, `start_amount`, `production_date`, `expiration_date`, `inventarization_date`, `ing_name`, `delivery_num`, `unit_name`) VALUES(5, 'помідори', '40.00', 5, 0, 5, NULL, NULL, NULL, 'помідори', 1, 'кг');
INSERT INTO `goods` (`unique_code`, `goods_name`, `unit_price`, `expected_amount`, `curr_amount`, `start_amount`, `production_date`, `expiration_date`, `inventarization_date`, `ing_name`, `delivery_num`, `unit_name`) VALUES(6, 'фасоль стручкова', '25.00', 1, 1, 1, NULL, NULL, NULL, 'фасоль стручкова', 1, 'кг');
INSERT INTO `goods` (`unique_code`, `goods_name`, `unit_price`, `expected_amount`, `curr_amount`, `start_amount`, `production_date`, `expiration_date`, `inventarization_date`, `ing_name`, `delivery_num`, `unit_name`) VALUES(7, 'цибуля городня', '17.00', 10, 10, 10, NULL, NULL, NULL, 'цибуля городня', 1, 'кг');
INSERT INTO `goods` (`unique_code`, `goods_name`, `unit_price`, `expected_amount`, `curr_amount`, `start_amount`, `production_date`, `expiration_date`, `inventarization_date`, `ing_name`, `delivery_num`, `unit_name`) VALUES(8, 'кабачки', '70.00', 2, 2, 2, NULL, NULL, NULL, 'кабачки', 1, 'кг');
INSERT INTO `goods` (`unique_code`, `goods_name`, `unit_price`, `expected_amount`, `curr_amount`, `start_amount`, `production_date`, `expiration_date`, `inventarization_date`, `ing_name`, `delivery_num`, `unit_name`) VALUES(9, 'вода', '70.00', 50, 50, 50, NULL, NULL, NULL, 'вода', 5, 'л');
INSERT INTO `goods` (`unique_code`, `goods_name`, `unit_price`, `expected_amount`, `curr_amount`, `start_amount`, `production_date`, `expiration_date`, `inventarization_date`, `ing_name`, `delivery_num`, `unit_name`) VALUES(10, 'нут', '65.00', 3, 3, 3, NULL, NULL, NULL, 'нут', 8, 'кг');
INSERT INTO `goods` (`unique_code`, `goods_name`, `unit_price`, `expected_amount`, `curr_amount`, `start_amount`, `production_date`, `expiration_date`, `inventarization_date`, `ing_name`, `delivery_num`, `unit_name`) VALUES(11, 'тунець', '0.25', 925, 925, 925, NULL, NULL, NULL, 'тунець', 4, 'г');
INSERT INTO `goods` (`unique_code`, `goods_name`, `unit_price`, `expected_amount`, `curr_amount`, `start_amount`, `production_date`, `expiration_date`, `inventarization_date`, `ing_name`, `delivery_num`, `unit_name`) VALUES(12, 'оливки', '0.10', 900, 900, 900, NULL, NULL, NULL, 'оливки', 8, 'г');
INSERT INTO `goods` (`unique_code`, `goods_name`, `unit_price`, `expected_amount`, `curr_amount`, `start_amount`, `production_date`, `expiration_date`, `inventarization_date`, `ing_name`, `delivery_num`, `unit_name`) VALUES(13, 'цибуля червона', '26.00', 1, 1, 1, NULL, NULL, NULL, 'цибуля червона', 1, 'кг');
INSERT INTO `goods` (`unique_code`, `goods_name`, `unit_price`, `expected_amount`, `curr_amount`, `start_amount`, `production_date`, `expiration_date`, `inventarization_date`, `ing_name`, `delivery_num`, `unit_name`) VALUES(14, 'оцет 9%', '11.36', 1, 1, 1, NULL, NULL, NULL, 'оцет 9%', 6, 'л');
INSERT INTO `goods` (`unique_code`, `goods_name`, `unit_price`, `expected_amount`, `curr_amount`, `start_amount`, `production_date`, `expiration_date`, `inventarization_date`, `ing_name`, `delivery_num`, `unit_name`) VALUES(15, 'яйця', '2.00', 50, 50, 50, NULL, NULL, NULL, 'яйця', 2, 'шт');
INSERT INTO `goods` (`unique_code`, `goods_name`, `unit_price`, `expected_amount`, `curr_amount`, `start_amount`, `production_date`, `expiration_date`, `inventarization_date`, `ing_name`, `delivery_num`, `unit_name`) VALUES(16, 'гірчиця гостра', '0.06', 280, 280, 280, NULL, NULL, NULL, 'гірчиця гостра', 6, 'г');
INSERT INTO `goods` (`unique_code`, `goods_name`, `unit_price`, `expected_amount`, `curr_amount`, `start_amount`, `production_date`, `expiration_date`, `inventarization_date`, `ing_name`, `delivery_num`, `unit_name`) VALUES(17, 'соняшникова олія', '30.00', 1, 1, 1, NULL, NULL, NULL, 'соняшникова олія', 6, 'л');
INSERT INTO `goods` (`unique_code`, `goods_name`, `unit_price`, `expected_amount`, `curr_amount`, `start_amount`, `production_date`, `expiration_date`, `inventarization_date`, `ing_name`, `delivery_num`, `unit_name`) VALUES(18, 'петрушка', '0.14', 200, 200, 200, NULL, NULL, NULL, 'петрушка', 1, 'кг');
INSERT INTO `goods` (`unique_code`, `goods_name`, `unit_price`, `expected_amount`, `curr_amount`, `start_amount`, `production_date`, `expiration_date`, `inventarization_date`, `ing_name`, `delivery_num`, `unit_name`) VALUES(19, 'сіль', '5.00', 1.5, 1.5, 1.5, NULL, NULL, NULL, 'сіль', 7, 'кг');
INSERT INTO `goods` (`unique_code`, `goods_name`, `unit_price`, `expected_amount`, `curr_amount`, `start_amount`, `production_date`, `expiration_date`, `inventarization_date`, `ing_name`, `delivery_num`, `unit_name`) VALUES(20, 'перець чорний мелений', '0.40', 100, 100, 100, NULL, NULL, NULL, 'перець чорний мелений', 7, 'г');
INSERT INTO `goods` (`unique_code`, `goods_name`, `unit_price`, `expected_amount`, `curr_amount`, `start_amount`, `production_date`, `expiration_date`, `inventarization_date`, `ing_name`, `delivery_num`, `unit_name`) VALUES(21, 'перець чорний мелений', '0.40', 10, 10, 10, NULL, NULL, NULL, 'перець чорний мелений', 8, 'г');
DROP TRIGGER IF EXISTS `afr_del_good`;
DELIMITER $$
CREATE TRIGGER `afr_del_good` AFTER DELETE ON `goods` FOR EACH ROW BEGIN
  UPDATE ingredients
  SET curr_amount = curr_amount - (OLD.curr_amount * (SELECT SUM(graduation_rule)
                                                      FROM units
                                                      WHERE OLD.unit_name = unit_name))
  WHERE ing_name = OLD.ing_name;
END
$$
DELIMITER ;
DROP TRIGGER IF EXISTS `afr_del_good_price`;
DELIMITER $$
CREATE TRIGGER `afr_del_good_price` AFTER DELETE ON `goods` FOR EACH ROW BEGIN
  UPDATE deliveries
  SET cost = cost - OLD.cost
  WHERE delivery_num = OLD.delivery_num;
END
$$
DELIMITER ;
DROP TRIGGER IF EXISTS `afr_ins_good`;
DELIMITER $$
CREATE TRIGGER `afr_ins_good` AFTER INSERT ON `goods` FOR EACH ROW BEGIN
  UPDATE ingredients
  SET curr_amount = curr_amount + NEW.curr_amount * (SELECT SUM(graduation_rule)
                                                     FROM units
                                                     WHERE NEW.unit_name = unit_name)
  WHERE ing_name = NEW.ing_name;
END
$$
DELIMITER ;
DROP TRIGGER IF EXISTS `afr_ins_good_price`;
DELIMITER $$
CREATE TRIGGER `afr_ins_good_price` AFTER INSERT ON `goods` FOR EACH ROW BEGIN
  UPDATE deliveries
  SET cost = cost + NEW.cost
  WHERE delivery_num = NEW.delivery_num;
END
$$
DELIMITER ;
DROP TRIGGER IF EXISTS `afr_upd_good`;
DELIMITER $$
CREATE TRIGGER `afr_upd_good` AFTER UPDATE ON `goods` FOR EACH ROW BEGIN
  IF OLD.ing_name = NEW.ing_name THEN
      UPDATE ingredients
      SET curr_amount = curr_amount - (OLD.curr_amount * (SELECT SUM(graduation_rule)
                                                          FROM units
                                                          WHERE OLD.unit_name = unit_name) - NEW.curr_amount * (SELECT SUM(graduation_rule)
                                                                                                    FROM units
                                                                                                    WHERE NEW.unit_name = unit_name))
      WHERE ing_name = OLD.ing_name;
  ELSE
      UPDATE ingredients
      SET curr_amount = curr_amount - OLD.curr_amount * (SELECT SUM(graduation_rule)
                                                         FROM units
                                                         WHERE OLD.unit_name = unit_name)
      WHERE ing_name = OLD.ing_name;
      UPDATE ingredients
      SET curr_amount = curr_amount + NEW.curr_amount * (SELECT SUM(graduation_rule)
                                                         FROM units
                                                         WHERE NEW.unit_name = unit_name)
      WHERE ing_name = NEW.ing_name;
  END IF;
END
$$
DELIMITER ;
DROP TRIGGER IF EXISTS `afr_upd_good_price`;
DELIMITER $$
CREATE TRIGGER `afr_upd_good_price` AFTER UPDATE ON `goods` FOR EACH ROW BEGIN
  UPDATE deliveries
  SET cost = COALESCE((SELECT SUM(cost)
              FROM goods
              WHERE goods.delivery_num = NEW.delivery_num), 0)
  WHERE delivery_num = NEW.delivery_num;

  IF OLD.delivery_num <> NEW.delivery_num THEN
      UPDATE deliveries
      SET cost = COALESCE((SELECT SUM(cost)
                  FROM goods
                  WHERE goods.delivery_num = OLD.delivery_num), 0)
      WHERE delivery_num = OLD.delivery_num;
  END IF;
END
$$
DELIMITER ;
DROP TRIGGER IF EXISTS `bfr_ins_good`;
DELIMITER $$
CREATE TRIGGER `bfr_ins_good` BEFORE INSERT ON `goods` FOR EACH ROW BEGIN
  SET NEW.curr_amount = NEW.start_amount;
  SET NEW.expected_amount = NEW.start_amount;
END
$$
DELIMITER ;

DROP TABLE IF EXISTS `ingredients`;
CREATE TABLE IF NOT EXISTS `ingredients` (
  `ing_name` char(40) NOT NULL,
  `units` enum('г','мл','шт') NOT NULL DEFAULT 'г',
  `curr_amount` mediumint(8) UNSIGNED NOT NULL DEFAULT '0',
  PRIMARY KEY (`ing_name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO `ingredients` (`ing_name`, `units`, `curr_amount`) VALUES('картопля', 'г', 0);
INSERT INTO `ingredients` (`ing_name`, `units`, `curr_amount`) VALUES('ошийок', 'г', 9500);
INSERT INTO `ingredients` (`ing_name`, `units`, `curr_amount`) VALUES('буряк', 'г', 20000);
INSERT INTO `ingredients` (`ing_name`, `units`, `curr_amount`) VALUES('капуста білокачана', 'г', 10000);
INSERT INTO `ingredients` (`ing_name`, `units`, `curr_amount`) VALUES('помідори', 'г', 0);
INSERT INTO `ingredients` (`ing_name`, `units`, `curr_amount`) VALUES('фасоль стручкова', 'г', 1000);
INSERT INTO `ingredients` (`ing_name`, `units`, `curr_amount`) VALUES('цибуля городня', 'г', 10000);
INSERT INTO `ingredients` (`ing_name`, `units`, `curr_amount`) VALUES('кабачки', 'г', 2000);
INSERT INTO `ingredients` (`ing_name`, `units`, `curr_amount`) VALUES('вода', 'мл', 50000);
INSERT INTO `ingredients` (`ing_name`, `units`, `curr_amount`) VALUES('нут', 'г', 3000);
INSERT INTO `ingredients` (`ing_name`, `units`, `curr_amount`) VALUES('тунець', 'г', 925);
INSERT INTO `ingredients` (`ing_name`, `units`, `curr_amount`) VALUES('оливки', 'г', 900);
INSERT INTO `ingredients` (`ing_name`, `units`, `curr_amount`) VALUES('цибуля червона', 'г', 1000);
INSERT INTO `ingredients` (`ing_name`, `units`, `curr_amount`) VALUES('оцет 9%', 'мл', 1000);
INSERT INTO `ingredients` (`ing_name`, `units`, `curr_amount`) VALUES('яйця', 'шт', 50);
INSERT INTO `ingredients` (`ing_name`, `units`, `curr_amount`) VALUES('гірчиця гостра', 'г', 280);
INSERT INTO `ingredients` (`ing_name`, `units`, `curr_amount`) VALUES('соняшникова олія', 'мл', 1000);
INSERT INTO `ingredients` (`ing_name`, `units`, `curr_amount`) VALUES('петрушка', 'г', 200000);
INSERT INTO `ingredients` (`ing_name`, `units`, `curr_amount`) VALUES('сіль', 'г', 1500);
INSERT INTO `ingredients` (`ing_name`, `units`, `curr_amount`) VALUES('перець чорний мелений', 'г', 110);
DROP TRIGGER IF EXISTS `afr_del_i`;
DELIMITER $$
CREATE TRIGGER `afr_del_i` AFTER DELETE ON `ingredients` FOR EACH ROW BEGIN
  UPDATE dishes Y
  SET is_ing_available = IF("NO" IN (SELECT IF(amount <= COALESCE((SELECT SUM(curr_amount)
                                                                   FROM ingredients
                                                                   WHERE ing_name = X.ing_name), 0),
                                               "YES", "NO")
                                     FROM dishes_ingredients X
                                     WHERE tech_card_num = Y.tech_card_num), 0b0, 0b1)
  WHERE tech_card_num IN (SELECT tech_card_num
                          FROM dishes_ingredients
                          WHERE OLD.ing_name = ing_name);
END
$$
DELIMITER ;
DROP TRIGGER IF EXISTS `afr_upd_i`;
DELIMITER $$
CREATE TRIGGER `afr_upd_i` AFTER UPDATE ON `ingredients` FOR EACH ROW BEGIN
  UPDATE dishes Y
  SET is_ing_available = IF("NO" IN (SELECT IF(amount <= COALESCE((SELECT SUM(curr_amount)
                                                                   FROM ingredients
                                                                   WHERE ing_name = X.ing_name), 0),
                                               "YES", "NO")
                                     FROM dishes_ingredients X
                                     WHERE tech_card_num = Y.tech_card_num), 0b0, 0b1)
  WHERE tech_card_num IN (SELECT tech_card_num
                          FROM dishes_ingredients
                          WHERE ing_name IN (NEW.ing_name, OLD.ing_name));
END
$$
DELIMITER ;
DROP TRIGGER IF EXISTS `create_ing`;
DELIMITER $$
CREATE TRIGGER `create_ing` BEFORE INSERT ON `ingredients` FOR EACH ROW BEGIN
  SET NEW.curr_amount = 0;
END
$$
DELIMITER ;
DROP VIEW IF EXISTS `needed_ingredients`;
CREATE TABLE IF NOT EXISTS `needed_ingredients` (
`ing_name` char(40)
);

DROP TABLE IF EXISTS `orders`;
CREATE TABLE IF NOT EXISTS `orders` (
  `unique_num` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT,
  `order_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `table_num` smallint(5) UNSIGNED NOT NULL,
  `is_paid` bit(1) NOT NULL DEFAULT false,
  `cost` decimal(16,2) UNSIGNED NOT NULL DEFAULT '0.00',
  `n_people` smallint(5) UNSIGNED NOT NULL DEFAULT '1',
  `close_time` timestamp NULL DEFAULT NULL,
  `is_closed` bit(1) GENERATED ALWAYS AS (if(isnull(`close_time`),0x00,0x01)) VIRTUAL,
  `tab_num` char(3) NOT NULL,
  PRIMARY KEY (`unique_num`),
  KEY `tab_num` (`tab_num`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

INSERT INTO `orders` (`unique_num`, `order_time`, `table_num`, `is_paid`, `cost`, `n_people`, `close_time`, `tab_num`) VALUES(1, '2019-02-24 16:35:54', 1, true, '30.00', 1, '2019-02-24 17:36:38', '506');
INSERT INTO `orders` (`unique_num`, `order_time`, `table_num`, `is_paid`, `cost`, `n_people`, `close_time`, `tab_num`) VALUES(2, '2019-02-24 16:40:50', 2, true, '13.30', 1, '2019-02-24 17:19:00', '516');
INSERT INTO `orders` (`unique_num`, `order_time`, `table_num`, `is_paid`, `cost`, `n_people`, `close_time`, `tab_num`) VALUES(3, '2019-02-24 10:03:51', 1, true, '19.00', 1, '2019-02-24 10:33:47', '516');
INSERT INTO `orders` (`unique_num`, `order_time`, `table_num`, `is_paid`, `cost`, `n_people`, `close_time`, `tab_num`) VALUES(5, '2019-02-24 12:42:38', 3, false, '87.00', 3, NULL, '516');
DROP TRIGGER IF EXISTS `create_order`;
DELIMITER $$
CREATE TRIGGER `create_order` BEFORE INSERT ON `orders` FOR EACH ROW BEGIN
  SET NEW.cost = 0;
END
$$
DELIMITER ;

DROP TABLE IF EXISTS `portions`;
CREATE TABLE IF NOT EXISTS `portions` (
  `unique_num` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT,
  `is_ready` bit(1) NOT NULL DEFAULT false,
  `is_served` bit(1) NOT NULL DEFAULT false,
  `price` decimal(16,2) UNSIGNED NOT NULL DEFAULT '0.00',
  `special_wishes` char(200) DEFAULT NULL,
  `discount` decimal(3,2) UNSIGNED DEFAULT NULL,
  `order_num` mediumint(8) UNSIGNED NOT NULL,
  `tech_card_num` int(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`unique_num`),
  KEY `order_num` (`order_num`),
  KEY `tech_card_num` (`tech_card_num`)
) ENGINE=MyISAM AUTO_INCREMENT=18 DEFAULT CHARSET=utf8;

INSERT INTO `portions` (`unique_num`, `is_ready`, `is_served`, `price`, `special_wishes`, `discount`, `order_num`, `tech_card_num`) VALUES(8, true, true, '13.30', NULL, '0.30', 2, 124720);
INSERT INTO `portions` (`unique_num`, `is_ready`, `is_served`, `price`, `special_wishes`, `discount`, `order_num`, `tech_card_num`) VALUES(13, false, false, '30.00', NULL, NULL, 5, 121088);
INSERT INTO `portions` (`unique_num`, `is_ready`, `is_served`, `price`, `special_wishes`, `discount`, `order_num`, `tech_card_num`) VALUES(7, true, true, '30.00', NULL, NULL, 1, 121088);
INSERT INTO `portions` (`unique_num`, `is_ready`, `is_served`, `price`, `special_wishes`, `discount`, `order_num`, `tech_card_num`) VALUES(12, true, true, '19.00', NULL, NULL, 3, 124720);
INSERT INTO `portions` (`unique_num`, `is_ready`, `is_served`, `price`, `special_wishes`, `discount`, `order_num`, `tech_card_num`) VALUES(14, false, false, '19.00', NULL, NULL, 5, 124720);
INSERT INTO `portions` (`unique_num`, `is_ready`, `is_served`, `price`, `special_wishes`, `discount`, `order_num`, `tech_card_num`) VALUES(15, true, false, '19.00', NULL, NULL, 5, 124720);
INSERT INTO `portions` (`unique_num`, `is_ready`, `is_served`, `price`, `special_wishes`, `discount`, `order_num`, `tech_card_num`) VALUES(16, false, false, '19.00', 'Без нуту', NULL, 5, 124720);
DROP TRIGGER IF EXISTS `afr_del_price`;
DELIMITER $$
CREATE TRIGGER `afr_del_price` AFTER DELETE ON `portions` FOR EACH ROW BEGIN
  UPDATE orders
  SET cost = COALESCE((SELECT SUM(price)
               FROM portions
               WHERE order_num = orders.unique_num), 0)
  WHERE unique_num = OLD.order_num;
END
$$
DELIMITER ;
DROP TRIGGER IF EXISTS `afr_ins_price`;
DELIMITER $$
CREATE TRIGGER `afr_ins_price` AFTER INSERT ON `portions` FOR EACH ROW BEGIN
  UPDATE orders
  SET cost = COALESCE((SELECT SUM(price)
               FROM portions
               WHERE order_num = orders.unique_num), 0)
  WHERE unique_num = NEW.order_num;
END
$$
DELIMITER ;
DROP TRIGGER IF EXISTS `afr_upd_price`;
DELIMITER $$
CREATE TRIGGER `afr_upd_price` AFTER UPDATE ON `portions` FOR EACH ROW BEGIN
  IF NEW.price <> OLD.price THEN
      UPDATE orders
      SET cost = COALESCE((SELECT SUM(price)
                   FROM portions
                   WHERE order_num = orders.unique_num), 0)
      WHERE unique_num IN (NEW.order_num, OLD.order_num);
  END IF;
END
$$
DELIMITER ;
DROP TRIGGER IF EXISTS `before_create_portion`;
DELIMITER $$
CREATE TRIGGER `before_create_portion` BEFORE INSERT ON `portions` FOR EACH ROW BEGIN
  SET NEW.tech_card_num = IF(0b0 IN (SELECT is_ing_available
                                     FROM dishes
                                     WHERE dishes.tech_card_num = NEW.tech_card_num), NULL, NEW.tech_card_num);
END
$$
DELIMITER ;
DROP TRIGGER IF EXISTS `before_update_portion`;
DELIMITER $$
CREATE TRIGGER `before_update_portion` BEFORE UPDATE ON `portions` FOR EACH ROW BEGIN
  SET NEW.tech_card_num = IF(0b0 IN (SELECT is_ing_available
                                     FROM dishes
                                     WHERE dishes.tech_card_num = NEW.tech_card_num), NULL, NEW.tech_card_num);
END
$$
DELIMITER ;
DROP TRIGGER IF EXISTS `bfr_ins_price`;
DELIMITER $$
CREATE TRIGGER `bfr_ins_price` BEFORE INSERT ON `portions` FOR EACH ROW BEGIN
  SET NEW.price = (SELECT SUM(price) * (1.0 -  COALESCE(NEW.discount, 0))
                   FROM dishes
                   WHERE tech_card_num = NEW.tech_card_num);
END
$$
DELIMITER ;
DROP TRIGGER IF EXISTS `bfr_upd_price`;
DELIMITER $$
CREATE TRIGGER `bfr_upd_price` BEFORE UPDATE ON `portions` FOR EACH ROW BEGIN
  IF NEW.discount <> OLD.discount THEN
    SET NEW.price = (SELECT SUM(price) * (1.0 -  COALESCE(NEW.discount, 0))
                     FROM dishes
                     WHERE tech_card_num = NEW.tech_card_num);
  END IF;
END
$$
DELIMITER ;

DROP TABLE IF EXISTS `providers`;
CREATE TABLE IF NOT EXISTS `providers` (
  `code` char(8) NOT NULL,
  `company_name` char(100) NOT NULL,
  `address` char(100) NOT NULL,
  `contact_person_name` char(50) NOT NULL,
  `contact_person_tel` char(13) NOT NULL,
  `email` char(30) DEFAULT NULL,
  `sign_date` date NOT NULL,
  `break_date` date DEFAULT NULL,
  `break_reason` char(70) DEFAULT NULL,
  PRIMARY KEY (`code`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO `providers` (`code`, `company_name`, `address`, `contact_person_name`, `contact_person_tel`, `email`, `sign_date`, `break_date`, `break_reason`) VALUES('09836456', 'ТОВ \"ФармОрг\"', 'вул. Балукова 38', 'Фукс Бенедикт Ферапонтович', '0985678976', 'farm@gmail.com', '2017-02-15', NULL, NULL);
INSERT INTO `providers` (`code`, `company_name`, `address`, `contact_person_name`, `contact_person_tel`, `email`, `sign_date`, `break_date`, `break_reason`) VALUES('23435453', 'Всесвіт Груп', 'вул. Пирогівський шлях 135', 'Арапов Фотин Йосипович', '0982671435', 'info@vsesvit-group.com.ua', '2013-09-01', NULL, NULL);
INSERT INTO `providers` (`code`, `company_name`, `address`, `contact_person_name`, `contact_person_tel`, `email`, `sign_date`, `break_date`, `break_reason`) VALUES('54645663', 'PS Групп', 'П. Калнишевського 2', 'Киреевский Настасья Дмитрович', '0985273164', NULL, '2016-07-30', NULL, NULL);
INSERT INTO `providers` (`code`, `company_name`, `address`, `contact_person_name`, `contact_person_tel`, `email`, `sign_date`, `break_date`, `break_reason`) VALUES('66767435', 'Мантинга Украина', 'вул. Калачівська 13', 'Глібовське Прокопій Антипович', '0981342567', 'proco@mantinga.org', '2012-01-21', NULL, NULL);
INSERT INTO `providers` (`code`, `company_name`, `address`, `contact_person_name`, `contact_person_tel`, `email`, `sign_date`, `break_date`, `break_reason`) VALUES('23488424', 'Rich Art Group', 'вул. Кричевського 19 м. Житомирська', 'Чихачов Флавіан Логгіновіч', '0987654312', 'nick@richart-group.com', '2001-08-05', '2003-07-15', 'Підвищенна ціна');
INSERT INTO `providers` (`code`, `company_name`, `address`, `contact_person_name`, `contact_person_tel`, `email`, `sign_date`, `break_date`, `break_reason`) VALUES('97867453', 'Panna Cotta', 'вул. Федорова 32', 'Ватутін харс Матфеевіч', '0984126573', 'box@pannacotta.com.ua', '2015-02-15', '2018-03-29', 'Якість продукту погіршилася');
INSERT INTO `providers` (`code`, `company_name`, `address`, `contact_person_name`, `contact_person_tel`, `email`, `sign_date`, `break_date`, `break_reason`) VALUES('87217663', 'Чудова', 'вул. Миколи Василенка 2', 'Мяхков Тарасій Фадеевич', '0986154732', 'chudova@chudova.com.ua', '2003-04-07', '2007-04-30', 'Не якісне обслуговування');
INSERT INTO `providers` (`code`, `company_name`, `address`, `contact_person_name`, `contact_person_tel`, `email`, `sign_date`, `break_date`, `break_reason`) VALUES('56453132', 'Мясная Империя ООО', 'вул. Гната Хоткевича 8', 'Муханов Венедикт Броніславович', '0934536721', 'meat@buymeat.icu', '2002-04-27', NULL, NULL);
INSERT INTO `providers` (`code`, `company_name`, `address`, `contact_person_name`, `contact_person_tel`, `email`, `sign_date`, `break_date`, `break_reason`) VALUES('57861235', 'Збаразький Горілчаний Завод, ТОВ', 'вул. Набережно-Хрещатицька 33', 'Маєвський Овдокім Мавродіевіч', '0936374152', 'info@kalganoff.com', '2003-12-07', NULL, NULL);
INSERT INTO `providers` (`code`, `company_name`, `address`, `contact_person_name`, `contact_person_tel`, `email`, `sign_date`, `break_date`, `break_reason`) VALUES('46985133', "Страус, ТМ", "пров. В\'ячеслава Чорновола 54а", 'Золотарьов Ян Євгенович', '0931274653', NULL, '2015-08-26', NULL, NULL);
INSERT INTO `providers` (`code`, `company_name`, `address`, `contact_person_name`, `contact_person_tel`, `email`, `sign_date`, `break_date`, `break_reason`) VALUES('89451239', 'ЩИТ - захищена якість, ТОВ', 'вул. Василя Жуковського 22А', 'Бежін Самойло Дементійович', '0931476532', 'main@mk-schyt.com.ua', '2001-08-05', NULL, NULL);
INSERT INTO `providers` (`code`, `company_name`, `address`, `contact_person_name`, `contact_person_tel`, `email`, `sign_date`, `break_date`, `break_reason`) VALUES('43567765', 'БАРК, ТОВ', 'просп. Лобановського', 'Сазонов Агапий Парфенович', '0935176324', NULL, '2010-04-16', NULL, NULL);
INSERT INTO `providers` (`code`, `company_name`, `address`, `contact_person_name`, `contact_person_tel`, `email`, `sign_date`, `break_date`, `break_reason`) VALUES('34567786', 'Маяк, ТД', 'вул. Оранжерейна 3', 'Суворова Діна Саввічна', '0931572643', NULL, '2001-08-05', '2014-01-20', 'Завишена ціна');
INSERT INTO `providers` (`code`, `company_name`, `address`, `contact_person_name`, `contact_person_tel`, `email`, `sign_date`, `break_date`, `break_reason`) VALUES('32454567', 'Смарт Групп Украина, ООО', 'вул. Миколи Кибальчича 23/25', 'Селунская Мокрина Семенівна', '0933514726', NULL, '2005-11-25', NULL, NULL);
INSERT INTO `providers` (`code`, `company_name`, `address`, `contact_person_name`, `contact_person_tel`, `email`, `sign_date`, `break_date`, `break_reason`) VALUES('56789675', 'УПГ-Инвест, ООО', 'вул. Малинська 18', 'Ададурова Амалія Всеславовна', '0934712635', 'name@syaivir.com', '2007-08-21', NULL, NULL);
INSERT INTO `providers` (`code`, `company_name`, `address`, `contact_person_name`, `contact_person_tel`, `email`, `sign_date`, `break_date`, `break_reason`) VALUES('87697842', 'Праймфід, ТОВ', 'просп. Степана Бандери 16', 'Шульц Вілена Корніївна', '0932675431', 'vilena@primefeed.com.ua', '2004-08-24', NULL, NULL);
INSERT INTO `providers` (`code`, `company_name`, `address`, `contact_person_name`, `contact_person_tel`, `email`, `sign_date`, `break_date`, `break_reason`) VALUES('87678954', 'Перепілка-Агро, ТзОВ', 'вул. Новокостянтинівська 22/15', 'Жедрінская Фефёла Харламовна', '0667451263', NULL, '2001-08-05', NULL, NULL);
INSERT INTO `providers` (`code`, `company_name`, `address`, `contact_person_name`, `contact_person_tel`, `email`, `sign_date`, `break_date`, `break_reason`) VALUES('78974346', 'Компания Ирада, ООО', 'вул. Молодогвардійська 22', 'Френкель Віола Авенірівна', '0662356741', 'viola@irada.company', '2016-11-04', NULL, NULL);
INSERT INTO `providers` (`code`, `company_name`, `address`, `contact_person_name`, `contact_person_tel`, `email`, `sign_date`, `break_date`, `break_reason`) VALUES('87965357', 'Ариус Тур, ТОВ', 'вул. Райдужна 25А', 'Мініна Артемія Юхимівна', '0667341265', 'info@armenia.prom.ua', '2006-01-04', '2009-06-16', 'Більше не підтримують стандарт');
INSERT INTO `providers` (`code`, `company_name`, `address`, `contact_person_name`, `contact_person_tel`, `email`, `sign_date`, `break_date`, `break_reason`) VALUES('34545779', 'AgroDetal, ТМ', 'пров. Новопечерський 5', 'Шатрова Марлена Агафоновна', '0661275643', 'mar@agrodetal.net', '2001-08-05', '2006-11-28', 'Часті затримки');
INSERT INTO `providers` (`code`, `company_name`, `address`, `contact_person_name`, `contact_person_tel`, `email`, `sign_date`, `break_date`, `break_reason`) VALUES('23426689', 'Ніка, МТВПП', 'вул. Луценка 6', 'Краснопільська Меланія Даміановна', '0663416275', 'melania@gmail.com', '2014-01-08', NULL, NULL);
INSERT INTO `providers` (`code`, `company_name`, `address`, `contact_person_name`, `contact_person_tel`, `email`, `sign_date`, `break_date`, `break_reason`) VALUES('21343655', 'Venta, домашняя кулинария', 'вул. Ревуцького 26', 'Хілчевская Карина Аверьяновна', '0961732645', NULL, '2004-04-03', NULL, NULL);
INSERT INTO `providers` (`code`, `company_name`, `address`, `contact_person_name`, `contact_person_tel`, `email`, `sign_date`, `break_date`, `break_reason`) VALUES('12323545', 'Чугуевский мясокомбинат, ООО', 'просп. М. Бажана 24/1', 'Титова Секлетінья Агафоновна', '0961546372', 'oeder@chuguevskiy.zakupka.com', '2017-08-10', NULL, NULL);
INSERT INTO `providers` (`code`, `company_name`, `address`, `contact_person_name`, `contact_person_tel`, `email`, `sign_date`, `break_date`, `break_reason`) VALUES('32465468', 'Харьковский молочный завод, ООО', 'вул. Білоруська 21', 'Ступішіна Магдалина Христофорівна', '0963574216', 'info@khmz.prom.ua', '2014-08-29', NULL, NULL);
INSERT INTO `providers` (`code`, `company_name`, `address`, `contact_person_name`, `contact_person_tel`, `email`, `sign_date`, `break_date`, `break_reason`) VALUES('12312354', 'Домашні солодощі, ТМ', 'вул. М. Тимошенка 9', 'Філіппова Артемія Авраамовна', '0964532671', NULL, '2001-08-05', '2010-02-17', 'Знайшли поставщика з більшим асортиментом');
INSERT INTO `providers` (`code`, `company_name`, `address`, `contact_person_name`, `contact_person_tel`, `email`, `sign_date`, `break_date`, `break_reason`) VALUES('68896563', 'СПЕЦ ФУД, ООО', 'вул. Михайла Бойчука', 'Охлебініна Маріонілла Аполлінаріївна', '0964267135', 'maria@spetsfood.com', '2010-04-23', '2012-07-19', 'Закрилися');
INSERT INTO `providers` (`code`, `company_name`, `address`, `contact_person_name`, `contact_person_tel`, `email`, `sign_date`, `break_date`, `break_reason`) VALUES('87978944', 'Вест Прод Лайн, ТОВ', 'просп. Василя Порика 13в', 'Львова Августина Герасимівна', '0961467235', NULL, '2013-06-19', NULL, NULL);
INSERT INTO `providers` (`code`, `company_name`, `address`, `contact_person_name`, `contact_person_tel`, `email`, `sign_date`, `break_date`, `break_reason`) VALUES('78974356', 'РИМ-2015, ООО', "вул. Сім\'ї Сосніних 7а", 'Базилевская Розалінда Авреліевна', '0967345216', NULL, '2007-07-09', '2009-07-17', 'Закрилися');
INSERT INTO `providers` (`code`, `company_name`, `address`, `contact_person_name`, `contact_person_tel`, `email`, `sign_date`, `break_date`, `break_reason`) VALUES('67897894', 'Станіславська Випічка, ТМ', 'вул. Васильківська 34', 'Симанського Евеліна Лавровна', '0934351627', NULL, '2010-01-23', NULL, NULL);

DROP TABLE IF EXISTS `telephones`;
CREATE TABLE IF NOT EXISTS `telephones` (
  `tel_num` char(13) NOT NULL,
  `tab_num` char(3) NOT NULL,
  PRIMARY KEY (`tel_num`),
  KEY `tab_num` (`tab_num`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO `telephones` (`tel_num`, `tab_num`) VALUES('0932341576', '507');
INSERT INTO `telephones` (`tel_num`, `tab_num`) VALUES('0935341726', '510');
INSERT INTO `telephones` (`tel_num`, `tab_num`) VALUES('0934273516', '201');
INSERT INTO `telephones` (`tel_num`, `tab_num`) VALUES('0934623751', '511');
INSERT INTO `telephones` (`tel_num`, `tab_num`) VALUES('0934762135', '904');
INSERT INTO `telephones` (`tel_num`, `tab_num`) VALUES('0931732654', '513');
INSERT INTO `telephones` (`tel_num`, `tab_num`) VALUES('0935167243', '516');
INSERT INTO `telephones` (`tel_num`, `tab_num`) VALUES('0935214637', '404');
INSERT INTO `telephones` (`tel_num`, `tab_num`) VALUES('0931573624', '506');
INSERT INTO `telephones` (`tel_num`, `tab_num`) VALUES('0932564137', '605');
INSERT INTO `telephones` (`tel_num`, `tab_num`) VALUES('0667142563', '501');
INSERT INTO `telephones` (`tel_num`, `tab_num`) VALUES('0664756132', '406');
INSERT INTO `telephones` (`tel_num`, `tab_num`) VALUES('0666215347', '607');
INSERT INTO `telephones` (`tel_num`, `tab_num`) VALUES('0632746513', '608');
INSERT INTO `telephones` (`tel_num`, `tab_num`) VALUES('0635316427', '505');
INSERT INTO `telephones` (`tel_num`, `tab_num`) VALUES('0636142357', '301');
INSERT INTO `telephones` (`tel_num`, `tab_num`) VALUES('0634632175', '502');
INSERT INTO `telephones` (`tel_num`, `tab_num`) VALUES('0634623175', '405');
INSERT INTO `telephones` (`tel_num`, `tab_num`) VALUES('0637216354', '901');
INSERT INTO `telephones` (`tel_num`, `tab_num`) VALUES('0631324567', '503');
INSERT INTO `telephones` (`tel_num`, `tab_num`) VALUES('0633157426', '601');
INSERT INTO `telephones` (`tel_num`, `tab_num`) VALUES('0631763524', '403');
INSERT INTO `telephones` (`tel_num`, `tab_num`) VALUES('0636531427', '103');
INSERT INTO `telephones` (`tel_num`, `tab_num`) VALUES('0631675423', '509');
INSERT INTO `telephones` (`tel_num`, `tab_num`) VALUES('0633162754', '104');
INSERT INTO `telephones` (`tel_num`, `tab_num`) VALUES('0634561273', '303');
INSERT INTO `telephones` (`tel_num`, `tab_num`) VALUES('0933465172', '517');
INSERT INTO `telephones` (`tel_num`, `tab_num`) VALUES('0937162453', '105');
INSERT INTO `telephones` (`tel_num`, `tab_num`) VALUES('0932564371', '515');
INSERT INTO `telephones` (`tel_num`, `tab_num`) VALUES('0985175152', '000');
INSERT INTO `telephones` (`tel_num`, `tab_num`) VALUES('0931562347', '603');
INSERT INTO `telephones` (`tel_num`, `tab_num`) VALUES('0936234175', '902');
INSERT INTO `telephones` (`tel_num`, `tab_num`) VALUES('0984362571', '604');
INSERT INTO `telephones` (`tel_num`, `tab_num`) VALUES('0984173562', '407');
INSERT INTO `telephones` (`tel_num`, `tab_num`) VALUES('0982461375', '102');
INSERT INTO `telephones` (`tel_num`, `tab_num`) VALUES('0985361742', '101');
INSERT INTO `telephones` (`tel_num`, `tab_num`) VALUES('0987315264', '508');
INSERT INTO `telephones` (`tel_num`, `tab_num`) VALUES('0983564721', '402');
INSERT INTO `telephones` (`tel_num`, `tab_num`) VALUES('0981364257', '202');
INSERT INTO `telephones` (`tel_num`, `tab_num`) VALUES('0983562417', '512');
INSERT INTO `telephones` (`tel_num`, `tab_num`) VALUES('0987425136', '903');
INSERT INTO `telephones` (`tel_num`, `tab_num`) VALUES('0987314265', '504');
INSERT INTO `telephones` (`tel_num`, `tab_num`) VALUES('0944516327', '602');
INSERT INTO `telephones` (`tel_num`, `tab_num`) VALUES('0942764135', '302');
INSERT INTO `telephones` (`tel_num`, `tab_num`) VALUES('0947246351', '514');
INSERT INTO `telephones` (`tel_num`, `tab_num`) VALUES('0947641325', '606');
INSERT INTO `telephones` (`tel_num`, `tab_num`) VALUES('0947164235', '401');
INSERT INTO `telephones` (`tel_num`, `tab_num`) VALUES('1111111111', '1');

DROP TABLE IF EXISTS `units`;
CREATE TABLE IF NOT EXISTS `units` (
  `unit_name` char(2) NOT NULL,
  `graduation_rule` float NOT NULL,
  PRIMARY KEY (`unit_name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO `units` (`unit_name`, `graduation_rule`) VALUES('кг', 1000);
INSERT INTO `units` (`unit_name`, `graduation_rule`) VALUES('г', 1);
INSERT INTO `units` (`unit_name`, `graduation_rule`) VALUES('ц', 100000);
INSERT INTO `units` (`unit_name`, `graduation_rule`) VALUES('т', 1000000);
INSERT INTO `units` (`unit_name`, `graduation_rule`) VALUES('мл', 1);
INSERT INTO `units` (`unit_name`, `graduation_rule`) VALUES('л', 1000);
INSERT INTO `units` (`unit_name`, `graduation_rule`) VALUES('шт', 1);

DROP TABLE IF EXISTS `workers`;
CREATE TABLE IF NOT EXISTS `workers` (
  `tab_num` char(3) NOT NULL,
  `surname` char(20) NOT NULL,
  `first_name` char(20) NOT NULL,
  `father_name` char(20) DEFAULT NULL,
  `birth_date` date NOT NULL,
  `address` char(100) NOT NULL,
  `gender` enum('Ч','Ж') NOT NULL DEFAULT 'Ч',
  `position` enum('власник','адміністратор','бухгалтер','шеф-кухар','кухар','офіціант','бармен','прибиральниця') NOT NULL,
  `salary` decimal(16,2) UNSIGNED NOT NULL DEFAULT '6000.00',
  `hire_date` date NOT NULL,
  `fire_date` date DEFAULT NULL,
  PRIMARY KEY (`tab_num`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO `workers` (`tab_num`, `surname`, `first_name`, `father_name`, `birth_date`, `address`, `gender`, `position`, `salary`, `hire_date`, `fire_date`) VALUES('000', 'Бобров', 'Северин', 'Максиміліанович', '1955-06-07', 'пр-т Валерія Лобановського 51', 'Ч', 'власник', '0.00', '2001-08-05', NULL);
INSERT INTO `workers` (`tab_num`, `surname`, `first_name`, `father_name`, `birth_date`, `address`, `gender`, `position`, `salary`, `hire_date`, `fire_date`) VALUES('506', 'Бариков', 'Овсій', 'Анфімовіч', '1978-06-18', 'просп. Соборності 4', 'Ч', 'офіціант', '8000.00', '2006-02-01', NULL);
INSERT INTO `workers` (`tab_num`, `surname`, `first_name`, `father_name`, `birth_date`, `address`, `gender`, `position`, `salary`, `hire_date`, `fire_date`) VALUES('501', 'Болобанов', 'Паїсій', 'Ардальоновіч', '1974-04-24', 'вул. Кудряшова 16а', 'Ч', 'офіціант', '4000.00', '2001-08-05', '2002-03-07');
INSERT INTO `workers` (`tab_num`, `surname`, `first_name`, `father_name`, `birth_date`, `address`, `gender`, `position`, `salary`, `hire_date`, `fire_date`) VALUES('505', 'Наришкін', 'Вавила', 'Афоньевіч', '1979-07-29', 'вул. Бульварно-Кудрявська 5а', 'Ч', 'офіціант', '6800.00', '2002-03-07', '2006-02-01');
INSERT INTO `workers` (`tab_num`, `surname`, `first_name`, `father_name`, `birth_date`, `address`, `gender`, `position`, `salary`, `hire_date`, `fire_date`) VALUES('507', 'Богданович', 'Аристарх', 'Іларіевіч', '1983-06-26', 'вул. Новокостянтинівська 22/15', 'Ч', 'офіціант', '6400.00', '2010-07-25', '2012-04-27');
INSERT INTO `workers` (`tab_num`, `surname`, `first_name`, `father_name`, `birth_date`, `address`, `gender`, `position`, `salary`, `hire_date`, `fire_date`) VALUES('516', 'Храповицький', 'Агафія', 'Алферовна', '1994-06-04', 'просп. Комарова 38а', 'Ж', 'офіціант', '7500.00', '2012-04-27', NULL);
INSERT INTO `workers` (`tab_num`, `surname`, `first_name`, `father_name`, `birth_date`, `address`, `gender`, `position`, `salary`, `hire_date`, `fire_date`) VALUES('513', 'Острозька', 'Магда', 'Акінфіевна', '1980-04-26', 'вул. Євгена Сверстюка 11Б', 'Ж', 'офіціант', '7000.00', '2006-02-08', '2015-02-21');
INSERT INTO `workers` (`tab_num`, `surname`, `first_name`, `father_name`, `birth_date`, `address`, `gender`, `position`, `salary`, `hire_date`, `fire_date`) VALUES('514', 'Лобанова', 'Нимфодора', 'Устинівна', '1980-12-21', 'вул. Бульварно-Кудрявська 6', 'Ж', 'офіціант', '7300.00', '2007-04-30', '2010-07-25');
INSERT INTO `workers` (`tab_num`, `surname`, `first_name`, `father_name`, `birth_date`, `address`, `gender`, `position`, `salary`, `hire_date`, `fire_date`) VALUES('502', 'Магалі', 'Іраклій', 'Варламович', '1977-08-22', "вул. Сім\'ї Сосніних 7а", 'Ч', 'офіціант', '5600.00', '2001-08-05', '2011-09-10');
INSERT INTO `workers` (`tab_num`, `surname`, `first_name`, `father_name`, `birth_date`, `address`, `gender`, `position`, `salary`, `hire_date`, `fire_date`) VALUES('509', 'Тютчев', 'Іоан', 'Касьянович', '1989-06-09', 'вул. Інженерна 1', 'Ч', 'офіціант', '7500.00', '2014-07-03', NULL);
INSERT INTO `workers` (`tab_num`, `surname`, `first_name`, `father_name`, `birth_date`, `address`, `gender`, `position`, `salary`, `hire_date`, `fire_date`) VALUES('508', 'Захаров', 'Борис', 'Онисимович', '1982-12-28', 'вул. Дмитрівська 56', 'Ч', 'офіціант', '7700.00', '2011-09-10', NULL);
INSERT INTO `workers` (`tab_num`, `surname`, `first_name`, `father_name`, `birth_date`, `address`, `gender`, `position`, `salary`, `hire_date`, `fire_date`) VALUES('510', 'Скавронський', 'Борислав', 'Іонич', '1989-06-24', 'просп. Леся Курбаса 6г', 'Ч', 'офіціант', '6900.00', '2015-02-21', '2015-04-25');
INSERT INTO `workers` (`tab_num`, `surname`, `first_name`, `father_name`, `birth_date`, `address`, `gender`, `position`, `salary`, `hire_date`, `fire_date`) VALUES('515', 'Гутаковская', 'Берта', 'Любомирівна', '1982-04-29', 'просп. Повітрофлотський 48/2', 'Ж', 'офіціант', '6000.00', '2007-06-22', '2014-07-03');
INSERT INTO `workers` (`tab_num`, `surname`, `first_name`, `father_name`, `birth_date`, `address`, `gender`, `position`, `salary`, `hire_date`, `fire_date`) VALUES('512', 'Суворова', 'Діна', 'Саввічна', '1978-10-29', 'вул. Фучіка 3', 'Ж', 'офіціант', '5000.00', '2001-08-05', '2007-06-22');
INSERT INTO `workers` (`tab_num`, `surname`, `first_name`, `father_name`, `birth_date`, `address`, `gender`, `position`, `salary`, `hire_date`, `fire_date`) VALUES('503', 'Ельницкий', 'Аарон', 'Дормидонтович', '1974-01-28', 'вул. Будівельників 40', 'Ч', 'офіціант', '4500.00', '2001-08-05', '2007-04-30');
INSERT INTO `workers` (`tab_num`, `surname`, `first_name`, `father_name`, `birth_date`, `address`, `gender`, `position`, `salary`, `hire_date`, `fire_date`) VALUES('511', 'Боровітінов', 'Овсій', 'Абраміевіч', '1986-09-15', 'пл. Майдан Незалежності 1', 'Ч', 'офіціант', '7000.00', '2015-04-25', NULL);
INSERT INTO `workers` (`tab_num`, `surname`, `first_name`, `father_name`, `birth_date`, `address`, `gender`, `position`, `salary`, `hire_date`, `fire_date`) VALUES('504', 'Храповицький', 'Мар\'ян', 'Север\'янович', '1971-01-22', 'вул. Метрологічна 2а', 'Ч', 'офіціант', '4700.00', '2001-08-05', '2006-02-08');
INSERT INTO `workers` (`tab_num`, `surname`, `first_name`, `father_name`, `birth_date`, `address`, `gender`, `position`, `salary`, `hire_date`, `fire_date`) VALUES('517', 'Симанського', 'Евеліна', 'Лавровна', '1992-11-18', 'бульв. Дарницький 23', 'Ж', 'офіціант', '7300.00', '2015-07-07', NULL);
INSERT INTO `workers` (`tab_num`, `surname`, `first_name`, `father_name`, `birth_date`, `address`, `gender`, `position`, `salary`, `hire_date`, `fire_date`) VALUES('401', 'Комаровський', 'Кипріян', 'Яремович', '1977-05-11', 'просп. Петра Григоренка 33/44', 'Ч', 'кухар', '6000.00', '2001-08-05', '2005-07-22');
INSERT INTO `workers` (`tab_num`, `surname`, `first_name`, `father_name`, `birth_date`, `address`, `gender`, `position`, `salary`, `hire_date`, `fire_date`) VALUES('402', 'Глушков', 'Никандр', 'Петрович', '1977-07-13', 'вул. Космонавта Волкова 16а', 'Ч', 'кухар', '6700.00', '2001-08-05', '2014-05-27');
INSERT INTO `workers` (`tab_num`, `surname`, `first_name`, `father_name`, `birth_date`, `address`, `gender`, `position`, `salary`, `hire_date`, `fire_date`) VALUES('403', 'Чичагов', 'Мирослав', 'Едуардович', '1983-05-06', 'просп. Соборності 7а', 'Ч', 'кухар', '12000.00', '2005-07-22', NULL);
INSERT INTO `workers` (`tab_num`, `surname`, `first_name`, `father_name`, `birth_date`, `address`, `gender`, `position`, `salary`, `hire_date`, `fire_date`) VALUES('404', 'Скорняков', 'Наум', 'Анісіевіч', '1993-05-21', 'вул. Празька 24', 'Ч', 'кухар', '7000.00', '2014-05-27', '2015-06-09');
INSERT INTO `workers` (`tab_num`, `surname`, `first_name`, `father_name`, `birth_date`, `address`, `gender`, `position`, `salary`, `hire_date`, `fire_date`) VALUES('405', 'Леонович', 'Онисій', 'Гаврилович', '1986-03-02', 'просп. Науки 94/5', 'Ч', 'кухар', '6800.00', '2015-06-09', '2016-02-26');
INSERT INTO `workers` (`tab_num`, `surname`, `first_name`, `father_name`, `birth_date`, `address`, `gender`, `position`, `salary`, `hire_date`, `fire_date`) VALUES('406', 'Евлашева', 'Орина', 'Арефьевна', '1994-08-01', 'вул. Соборна 10а', 'Ж', 'кухар', '9000.00', '2016-02-26', '2018-07-02');
INSERT INTO `workers` (`tab_num`, `surname`, `first_name`, `father_name`, `birth_date`, `address`, `gender`, `position`, `salary`, `hire_date`, `fire_date`) VALUES('407', 'Войников', 'Ждан', 'Несторович', '1989-02-02', 'просп. Повітрофлотський 34', 'Ч', 'кухар', '10000.00', '2018-07-02', NULL);
INSERT INTO `workers` (`tab_num`, `surname`, `first_name`, `father_name`, `birth_date`, `address`, `gender`, `position`, `salary`, `hire_date`, `fire_date`) VALUES('301', 'Евлашева', 'Вілена', 'Броніславівна', '1973-03-01', 'вул. Маршала Гречко 24', 'Ж', 'шеф-кухар', '7000.00', '2001-08-05', '2009-04-12');
INSERT INTO `workers` (`tab_num`, `surname`, `first_name`, `father_name`, `birth_date`, `address`, `gender`, `position`, `salary`, `hire_date`, `fire_date`) VALUES('302', 'Лашкевич', 'Зенон', 'Силич', '1980-02-18', 'вул. Малиновського 11', 'Ч', 'шеф-кухар', '9000.00', '2009-04-12', '2015-10-18');
INSERT INTO `workers` (`tab_num`, `surname`, `first_name`, `father_name`, `birth_date`, `address`, `gender`, `position`, `salary`, `hire_date`, `fire_date`) VALUES('303', 'Донцов', 'Емілія', 'Кирилович', '1992-11-07', 'просп. Повітрофлотський 48/2', 'Ч', 'шеф-кухар', '15000.00', '2015-10-18', NULL);
INSERT INTO `workers` (`tab_num`, `surname`, `first_name`, `father_name`, `birth_date`, `address`, `gender`, `position`, `salary`, `hire_date`, `fire_date`) VALUES('901', 'Епанчин', 'Хрістодул', 'Геліевіч', '1974-07-09', 'вул. Дніпровська набережна 7е', 'Ч', 'прибиральниця', '4000.00', '2001-08-05', '2002-10-31');
INSERT INTO `workers` (`tab_num`, `surname`, `first_name`, `father_name`, `birth_date`, `address`, `gender`, `position`, `salary`, `hire_date`, `fire_date`) VALUES('902', 'Рубльова', 'Перпетуя', 'Мойсеївна', '1976-06-05', 'вул. Шота Руставелі 31а', 'Ж', 'прибиральниця', '5000.00', '2002-10-31', '2009-07-04');
INSERT INTO `workers` (`tab_num`, `surname`, `first_name`, `father_name`, `birth_date`, `address`, `gender`, `position`, `salary`, `hire_date`, `fire_date`) VALUES('903', 'Блудова', 'Гликерия', 'Самойловна', '1990-08-31', 'вул. Кільцева 12', 'Ж', 'прибиральниця', '5500.00', '2009-07-04', '2012-04-03');
INSERT INTO `workers` (`tab_num`, `surname`, `first_name`, `father_name`, `birth_date`, `address`, `gender`, `position`, `salary`, `hire_date`, `fire_date`) VALUES('904', 'Вістіцкая', 'Пульхерия', 'Абраміевна', '1979-06-24', 'вул. Глибочицька 28', 'Ж', 'прибиральниця', '6000.00', '2012-04-03', NULL);
INSERT INTO `workers` (`tab_num`, `surname`, `first_name`, `father_name`, `birth_date`, `address`, `gender`, `position`, `salary`, `hire_date`, `fire_date`) VALUES('101', 'Вальчіцкая', 'Макрина', 'Ноканоровна', '1983-02-23', 'просп. Оболонський 35', 'Ж', 'адміністратор', '5000.00', '2001-08-05', '2002-06-24');
INSERT INTO `workers` (`tab_num`, `surname`, `first_name`, `father_name`, `birth_date`, `address`, `gender`, `position`, `salary`, `hire_date`, `fire_date`) VALUES('102', 'Коломнін', 'Сатир', 'Никанорович', '1988-07-09', 'вул. Костянтинівська 24', 'Ч', 'адміністратор', '6700.00', '2002-06-24', '2008-02-18');
INSERT INTO `workers` (`tab_num`, `surname`, `first_name`, `father_name`, `birth_date`, `address`, `gender`, `position`, `salary`, `hire_date`, `fire_date`) VALUES('103', 'Наумов', 'Юрій', 'Захарович', '1987-05-23', 'вул. Вадима Гетьмана 13', 'Ч', 'адміністратор', '8000.00', '2008-02-18', '2009-01-03');
INSERT INTO `workers` (`tab_num`, `surname`, `first_name`, `father_name`, `birth_date`, `address`, `gender`, `position`, `salary`, `hire_date`, `fire_date`) VALUES('104', 'Тютчев', 'Іона', 'Касьянович', '1989-06-09', 'вул. Інженерна1', 'Ж', 'адміністратор', '8000.00', '2009-01-03', '2010-12-08');
INSERT INTO `workers` (`tab_num`, `surname`, `first_name`, `father_name`, `birth_date`, `address`, `gender`, `position`, `salary`, `hire_date`, `fire_date`) VALUES('105', 'Могилевський', 'Борислав', 'Ларіонович', '1993-07-12', 'пл. Майдан Незалежності 1', 'Ч', 'адміністратор', '10000.00', '2010-12-08', NULL);
INSERT INTO `workers` (`tab_num`, `surname`, `first_name`, `father_name`, `birth_date`, `address`, `gender`, `position`, `salary`, `hire_date`, `fire_date`) VALUES('201', 'Стороженко', 'Таїсія', 'Абакумовна', '1987-06-03', 'вул. Саксаганського 48/15', 'Ж', 'бухгалтер', '6000.00', '2001-08-05', '2014-10-20');
INSERT INTO `workers` (`tab_num`, `surname`, `first_name`, `father_name`, `birth_date`, `address`, `gender`, `position`, `salary`, `hire_date`, `fire_date`) VALUES('202', 'Головніна', 'Євгена', 'Протасовна', '1986-11-17', 'вул. Голосіївська 2', 'Ж', 'бухгалтер', '10000.00', '2014-10-20', NULL);
INSERT INTO `workers` (`tab_num`, `surname`, `first_name`, `father_name`, `birth_date`, `address`, `gender`, `position`, `salary`, `hire_date`, `fire_date`) VALUES('601', 'Гірські', 'Карина', 'Евлампіевна', '1972-08-16', 'пров. Новопечерський 5', 'Ж', 'бармен', '3000.00', '2001-08-05', '2002-10-26');
INSERT INTO `workers` (`tab_num`, `surname`, `first_name`, `father_name`, `birth_date`, `address`, `gender`, `position`, `salary`, `hire_date`, `fire_date`) VALUES('602', 'Дашкевич', 'Перпетуя', 'Серафимівна', '1974-06-23', 'вул. Тростянецька 6Г', 'Ж', 'бармен', '4500.00', '2001-08-05', '2006-03-12');
INSERT INTO `workers` (`tab_num`, `surname`, `first_name`, `father_name`, `birth_date`, `address`, `gender`, `position`, `salary`, `hire_date`, `fire_date`) VALUES('603', 'Чуфаровский', 'Омелян', 'Михайлович', '1975-08-04', 'просп. Академіка Палладіна 25а', 'Ч', 'бармен', '5000.00', '2002-10-26', '2012-09-18');
INSERT INTO `workers` (`tab_num`, `surname`, `first_name`, `father_name`, `birth_date`, `address`, `gender`, `position`, `salary`, `hire_date`, `fire_date`) VALUES('604', 'Шестакова', 'Амалія', 'Мойсеївна', '1980-09-14', 'вул. Вереснева 24', 'Ж', 'бармен', '5400.00', '2006-03-12', '2009-06-18');
INSERT INTO `workers` (`tab_num`, `surname`, `first_name`, `father_name`, `birth_date`, `address`, `gender`, `position`, `salary`, `hire_date`, `fire_date`) VALUES('605', 'Калечіцкій', 'Нектарій', 'Аполлонович', '1974-10-25', 'просп. Броварський 3в', 'Ч', 'бармен', '6000.00', '2009-06-18', '2011-07-25');
INSERT INTO `workers` (`tab_num`, `surname`, `first_name`, `father_name`, `birth_date`, `address`, `gender`, `position`, `salary`, `hire_date`, `fire_date`) VALUES('606', 'Перовська', 'Віолетта', 'Ферапонтівна', '1983-11-26', 'вул. Академіка Курчатова 19а', 'Ж', 'бармен', '7000.00', '2011-07-25', NULL);
INSERT INTO `workers` (`tab_num`, `surname`, `first_name`, `father_name`, `birth_date`, `address`, `gender`, `position`, `salary`, `hire_date`, `fire_date`) VALUES('607', 'Бутурлін', 'Прокопій', 'Артемійовича', '1990-12-24', 'вул. Тростянецька 6Г', 'Ч', 'бармен', '6400.00', '2012-09-18', '2016-06-08');
INSERT INTO `workers` (`tab_num`, `surname`, `first_name`, `father_name`, `birth_date`, `address`, `gender`, `position`, `salary`, `hire_date`, `fire_date`) VALUES('608', 'Митропольський', 'Карл', 'Артемоновіч', '1993-06-01', 'пл. Майдан Незалежності 1', 'Ч', 'бармен', '6800.00', '2016-06-08', NULL);
DROP TABLE IF EXISTS `avg_ing_prices`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `avg_ing_prices`  AS  select `goods`.`ing_name` AS `ing_name`,avg((`goods`.`unit_price` / `units`.`graduation_rule`)) AS `unit_price` from (`goods` join `units` on((`goods`.`unit_name` = `units`.`unit_name`))) group by `goods`.`ing_name` ;
DROP TABLE IF EXISTS `needed_ingredients`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `needed_ingredients`  AS  select distinct `x`.`ing_name` AS `ing_name` from `dishes_ingredients` `x` where ((`x`.`amount` > (select `ingredients`.`curr_amount` from `ingredients` where (`ingredients`.`ing_name` = `x`.`ing_name`))) and TRUE = all (select `dishes`.`is_in_menu` from `dishes` where (`dishes`.`tech_card_num` = `x`.`tech_card_num`))) ;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
