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
  salary decimal(16,2) not null,
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
  cost decimal(16,2) not null,
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