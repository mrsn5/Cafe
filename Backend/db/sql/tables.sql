CREATE DATABASE cafe;
ALTER DATABASE cafe CHARACTER SET utf8 COLLATE utf8_general_ci;
USE cafe;

CREATE TABLE workers
(
  tab_num CHAR(3) NOT NULL,
  surname CHAR(20) NOT NULL,
  first_name CHAR(20) NOT NULL,
  father_name CHAR(20) NULL,
  birth_date DATE NOT NULL,
  address CHAR(100) NOT NULL,
  gender ENUM('Ч', 'Ж') NOT NULL,
  position ENUM('власник', 'адміністратор', 'бухгалтер', 'шеф-кухар', 'кухар', 'офіціант', 'бармен', 'прибиральниця') NOT NULL,
  salary DECIMAL(16,2) UNSIGNED NOT NULL,
  hire_date DATE NOT NULL,
  fire_date DATE NULL,
  PRIMARY KEY (tab_num),
  CONSTRAINT CK_JUVENILE CHECK (year(current_timestamp) - year(birth_date) > 16) -- NOT perfect
);

CREATE TABLE telephones
(
  tel_num CHAR(13) NOT NULL,
  tab_num CHAR(3) NOT NULL,
  PRIMARY KEY (tel_num),
  FOREIGN KEY (tab_num) REFERENCES workers (tab_num)
    ON UPDATE NO ACTION
    ON DELETE CASCADE
);

CREATE TABLE orders
(
  unique_num MEDIUMINT UNSIGNED NOT NULL AUTO_INCREMENT,
  order_time timestamp NOT NULL,
  table_num smallint UNSIGNED NOT NULL,
  is_paid BIT(1) NOT NULL,
  cost DECIMAL(16,2) UNSIGNED NOT NULL,
  n_people smallint UNSIGNED NOT NULL,
  close_time timestamp NULL,
  is_closed BIT(1) NOT NULL,
  tab_num CHAR(3) NOT NULL,
  PRIMARY KEY (unique_num),
  FOREIGN KEY (tab_num) REFERENCES workers (tab_num)
    ON UPDATE NO ACTION
    ON DELETE NO ACTION,
  CONSTRAINT CK_ORDER_TIME CHECK (current_timestamp > order_time),
  CONSTRAINT CK_ORDER_TIME_DIFF CHECK (close_time > order_time OR close_time = NULL)
);

CREATE TABLE dishes
(
  tech_card_num INT UNSIGNED NOT NULL,
  calc_card_num INT UNSIGNED NOT NULL UNIQUE,
  dish_name CHAR(30) NOT NULL,
  weight SMALLINT UNSIGNED NOT NULL,
  price DECIMAL(16,2) UNSIGNED NOT NULL,
  is_in_menu BIT(1) NOT NULL,
  department ENUM('бар', 'кухня') NOT NULL,
  is_ing_available BIT(1) NOT NULL,
  calories INT UNSIGNED NOT NULL,
  cooking_time INT UNSIGNED NOT NULL,
  PRIMARY KEY (tech_card_num)
);

CREATE TABLE portions
(
  unique_num MEDIUMINT UNSIGNED NOT NULL AUTO_INCREMENT,
  is_ready BIT(1) NOT NULL,
  is_served BIT(1) NOT NULL,
  price DECIMAL(16,2) UNSIGNED NOT NULL,
  special_wishes CHAR(200) NULL,
  discount DECIMAL(3,2) UNSIGNED NULL,
  order_num MEDIUMINT UNSIGNED NOT NULL,
  tech_card_num INT UNSIGNED NOT NULL,

  PRIMARY KEY (unique_num),
  CONSTRAINT CK_DISCOUNT_FORMAT CHECK (discount >= 0 AND discount <= 1),

  FOREIGN KEY (order_num) REFERENCES orders (unique_num)
    ON UPDATE NO ACTION
    ON DELETE CASCADE,

  FOREIGN KEY (tech_card_num) REFERENCES dishes (tech_card_num)
    ON UPDATE NO ACTION
    ON DELETE CASCADE
);

CREATE TABLE categories
(
  cat_name CHAR(20) NOT NULL,
  PRIMARY KEY (cat_name)
);

CREATE TABLE dishes_categories
(
  tech_card_num INT UNSIGNED NOT NULL,
  cat_name CHAR(20) NOT NULL,
  PRIMARY KEY (tech_card_num, cat_name),
  FOREIGN KEY (cat_name) REFERENCES categories (cat_name)
    ON UPDATE CASCADE
    ON DELETE NO ACTION,

  FOREIGN KEY (tech_card_num) REFERENCES dishes (tech_card_num)
    ON UPDATE NO ACTION
    ON DELETE CASCADE
);

CREATE TABLE ingredients
(
  ing_name CHAR(20) NOT NULL,
  units CHAR(5) NOT NULL,
  curr_amount MEDIUMINT UNSIGNED NOT NULL,
  PRIMARY KEY (ing_name)
);


CREATE TABLE dishes_ingredients
(
  tech_card_num INT UNSIGNED NOT NULL,
  ing_name CHAR(20) NOT NULL,
  amount MEDIUMINT UNSIGNED NOT NULL,
  PRIMARY KEY (tech_card_num, ing_name),
  FOREIGN KEY (ing_name) REFERENCES ingredients (ing_name)
    ON UPDATE CASCADE
    ON DELETE NO ACTION,

  FOREIGN KEY (tech_card_num) REFERENCES dishes (tech_card_num)
    ON UPDATE NO ACTION
    ON DELETE CASCADE
);

CREATE TABLE discarding
(
  unique_code MEDIUMINT UNSIGNED NOT NULL AUTO_INCREMENT,
  discard_date DATE NOT NULL,
  cost DECIMAL(16,2) UNSIGNED NOT NULL,
  tab_num CHAR(3) NOT NULL,
  PRIMARY KEY (unique_code),
  FOREIGN KEY (tab_num) REFERENCES workers (tab_num)
    ON UPDATE NO ACTION
    ON DELETE NO ACTION,
  CONSTRAINT CK_DISCARD_DATE CHECK (CURRENT_DATE = discard_date)
);

CREATE TABLE providers
(
  code CHAR(8) NOT NULL,
  company_name CHAR(100) NOT NULL,
  address CHAR(100) NOT NULL,
  contact_person_name CHAR(50) NOT NULL,
  contact_person_tel CHAR(13) NOT NULL,
  email CHAR(30) NULL,
  sign_date DATE NOT NULL,
  break_date DATE NULL,
  break_reason CHAR(70) NULL,
  PRIMARY KEY(code),
  CONSTRAINT CK_DISCARD_DATE CHECK (break_date > sign_date)
);

CREATE TABLE deliveries
(
  delivery_num MEDIUMINT UNSIGNED NOT NULL AUTO_INCREMENT,
  is_received BIT(1) NOT NULL,
  purchased BIT(1) NOT NULL,
  returned BIT(1) NOT NULL,
  invoice_num INT UNSIGNED NULL,
  receiving_date DATE NULL,
  pay_date DATE NULL,
  cost DECIMAL(16,2) UNSIGNED NOT NULL,
  provider_code CHAR(8) NULL,
  PRIMARY KEY (delivery_num),
  FOREIGN KEY (provider_code) REFERENCES providers(code)
    ON UPDATE NO ACTION
    ON DELETE NO ACTION,
  CONSTRAINT CK_DATE CHECK (receiving_date <= CURRENT_DATE)
);

CREATE TABLE units
(
  unit_name CHAR(2) NOT NULL,
  graduation_rule FLOAT NOT NULL,
  PRIMARY KEY(unit_name)
);

CREATE TABLE goods
(
  unique_code MEDIUMINT UNSIGNED NOT NULL AUTO_INCREMENT,
  goods_name CHAR(50) NOT NULL,
  unit_price DECIMAL(16,2) UNSIGNED NOT NULL,
  cost DECIMAL(16,2) UNSIGNED NOT NULL,
  expected_amount FLOAT UNSIGNED NOT NULL, -- NOT perfect
  curr_amount FLOAT UNSIGNED NOT NULL, -- NOT perfect
  start_amount FLOAT UNSIGNED NOT NULL, -- NOT perfect
  production_date DATE NULL,
  expiration_date DATE NULL,
  inventarization_date DATE NULL,
  ing_name CHAR(20) NOT NULL,
  delivery_num MEDIUMINT UNSIGNED NOT NULL,
  unit_name CHAR(2) NOT NULL,
  PRIMARY KEY (unique_code),
  FOREIGN KEY (ing_name) REFERENCES ingredients (ing_name)
    ON DELETE NO ACTION
    ON UPDATE CASCADE,
  FOREIGN KEY (delivery_num) REFERENCES deliveries (delivery_num)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  FOREIGN KEY (unit_name) REFERENCES units (unit_name)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT CK_DATE CHECK (production_date <= expiration_date),
  CONSTRAINT CK_DATE_INVENT CHECK (inventarization_date = CURRENT_DATE)
);

CREATE TABLE discarding_goods
(
  discard_code MEDIUMINT UNSIGNED NOT NULL,
  good_code MEDIUMINT UNSIGNED NOT NULL,
  amount FLOAT UNSIGNED NOT NULL, -- NOT perfect
  reason CHAR(100) NOT NULL,
  cost  DECIMAL(16,2) UNSIGNED NOT NULL,
  PRIMARY KEY (discard_code, good_code),
  FOREIGN KEY (discard_code) REFERENCES discarding (unique_code)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  FOREIGN KEY (good_code) REFERENCES goods (unique_code)
    ON DELETE CASCADE
    ON UPDATE NO ACTION
);