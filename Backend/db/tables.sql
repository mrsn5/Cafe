ALTER DATABASE cafe CHARACTER SET utf8 COLLATE utf8_general_ci;
USE cafe;

create table workers
(
  tab_num char(3) not null,
  surname char(20) not null,
  first_name char(20) not null,
  father_name char(20) null,
  birth_date date not null,
  address char(100) not null,
  gender enum('Ч', 'Ж') not null,
  position enum('власник', 'адміністратор', 'бухгалтер', 'шеф-кухар', 'кухар', 'офіціант', 'бармен', 'прибиральниця') not null,
  salary decimal(16,2) UNSIGNED not null,
  hire_date date not null,
  fire_date date null,
  primary key (tab_num),
  CONSTRAINT CK_JUVENILE CHECK (year(current_timestamp) - year(birth_date) > 16) -- Not perfect
);

create table telephones
(
  tel_num char(13) not null,
  tab_num char(3) not null,
  primary key (tel_num),
  foreign key (tab_num) REFERENCES workers (tab_num)
    on update no action
    on delete cascade
);

create table orders
(
  unique_num MEDIUMINT UNSIGNED NOT NULL AUTO_INCREMENT,
  order_time timestamp not null,
  table_num smallint UNSIGNED not null,
  is_paid bit(1) not null,
  cost decimal(16,2) UNSIGNED not null,
  n_people smallint UNSIGNED not null,
  close_time timestamp null,
  is_closed bit(1) not null,
  tab_num char(3) not null,
  primary key (unique_num),
  foreign key (tab_num) REFERENCES workers (tab_num)
    on update no action
    on delete no action,
  CONSTRAINT CK_ORDER_TIME CHECK (current_timestamp > order_time),
  CONSTRAINT CK_ORDER_TIME_DIFF CHECK (close_time > order_time OR close_time = null)
);

create table dishes
(
  tech_card_num INT UNSIGNED not null,
  calc_card_num INT UNSIGNED not null UNIQUE,
  dish_name char(30) not null,
  weight SMALLINT UNSIGNED not null,
  price decimal(16,2) UNSIGNED not null,
  is_in_menu bit(1) not null,
  department enum('бар', 'кухня') not null,
  is_ing_available bit(1) not null,
  calories INT UNSIGNED not null,
  cooking_time INT UNSIGNED not null,
  primary key (tech_card_num)
);

create table portions
(
  unique_num MEDIUMINT UNSIGNED NOT NULL AUTO_INCREMENT,
  is_ready bit(1) not null,
  is_served bit(1) not null,
  price decimal(16,2) UNSIGNED not null,
  special_wishes char(200) null,
  discount decimal(3,2) UNSIGNED null,
  order_num MEDIUMINT UNSIGNED not null,
  tech_card_num INT UNSIGNED not null,

  primary key (unique_num),
  CONSTRAINT CK_DISCOUNT_FORMAT CHECK (discount >= 0 AND discount <= 1),

  foreign key (order_num) REFERENCES orders (unique_num)
    on update no action
    on delete cascade,

  foreign key (tech_card_num) REFERENCES dishes (tech_card_num)
    on update no action
    on delete cascade
);

create table categories
(
  cat_name char(20) not null,
  primary key (cat_name)
);

create table dishes_categories
(
  tech_card_num INT UNSIGNED not null,
  cat_name char(20) not null,
  primary key (tech_card_num, cat_name),
  foreign key (cat_name) REFERENCES categories (cat_name)
    on update cascade
    on delete no action,

  foreign key (tech_card_num) REFERENCES dishes (tech_card_num)
    on update no action
    on delete cascade
);

create table ingredients
(
  ing_name char(20) not null,
  units char(5) not null,
  curr_amount MEDIUMINT UNSIGNED not null,
  primary key (ing_name)
);


create table dishes_ingredients
(
  tech_card_num INT UNSIGNED not null,
  ing_name char(20) not null,
  amount MEDIUMINT UNSIGNED not null,
  primary key (tech_card_num, ing_name),
  foreign key (ing_name) REFERENCES ingredients (ing_name)
    on update cascade
    on delete no action,

  foreign key (tech_card_num) REFERENCES dishes (tech_card_num)
    on update no action
    on delete cascade
);

create table discarding
(
  unique_code MEDIUMINT UNSIGNED NOT NULL AUTO_INCREMENT,
  discard_date DATE not null,
  cost decimal(16,2) UNSIGNED not null,
  tab_num char(3) not null,
  primary key (unique_code),
  foreign key (tab_num) REFERENCES workers (tab_num)
    on update no action
    on delete no action,
  CONSTRAINT CK_DISCARD_DATE CHECK (CURRENT_DATE = discard_date)
);

create table providers
(
  code char(8) not null,
  company_name char(100) not null,
  address char(100) not null,
  contact_person_name char(50) not null,
  contact_person_tel char(13) not null,
  email char(30) null,
  sign_date date not null,
  break_date date null,
  break_reason char(70) null,
  primary key(code),
  CONSTRAINT CK_DISCARD_DATE CHECK (break_date > sign_date)
);

create table deliveries
(
  delivery_num MEDIUMINT UNSIGNED NOT NULL AUTO_INCREMENT,
  is_received bit(1) not null,
  purchased bit(1) not null,
  returned bit(1) not null,
  invoice_num INT UNSIGNED null,
  receiving_date date null,
  pay_date date null,
  cost decimal(16,2) UNSIGNED not null,
  provider_code char(8) null,
  primary key (delivery_num),
  foreign key (provider_code) references providers(code)
    on update no action
    on delete no action,
  CONSTRAINT CK_DATE CHECK (receiving_date <= CURRENT_DATE)
);

create table units
(
  unit_name char(2) not null,
  graduation_rule float not null,
  primary key(unit_name)
);

create table goods
(
  unique_code MEDIUMINT UNSIGNED NOT NULL AUTO_INCREMENT,
  goods_name char(50) not null,
  unit_price decimal(16,2) UNSIGNED not null,
  cost decimal(16,2) UNSIGNED not null,
  expected_amount float UNSIGNED not null, -- Not perfect
  curr_amount float UNSIGNED not null, -- Not perfect
  start_amount float UNSIGNED not null, -- Not perfect
  production_date date null,
  expiration_date date null,
  inventarization_date date null,
  ing_name char(20) not null,
  delivery_num MEDIUMINT UNSIGNED NOT NULL,
  primary key (unique_code),
  foreign key (ing_name) references ingredients (ing_name)
    on delete no action
    on update cascade,
  foreign key (delivery_num) references deliveries (delivery_num)
    on delete no action
    on update no action,
  CONSTRAINT CK_DATE CHECK (production_date <= expiration_date),
  CONSTRAINT CK_DATE_INVENT CHECK (inventarization_date = CURRENT_DATE)
);

create table discarding_goods
(
  discard_code MEDIUMINT UNSIGNED NOT NULL,
  good_code MEDIUMINT UNSIGNED NOT NULL,
  amount float UNSIGNED not null, -- Not perfect
  reason char(100) not null,
  cost  decimal(16,2) UNSIGNED not null,
  primary key (discard_code, good_code),
  foreign key (discard_code) references discarding (unique_code)
    on delete no action
    on update no action,
  foreign key (good_code) references goods (unique_code)
    on delete cascade
    on update no action
);