use cafe;


-- ОНОВЛЕННЯ ЦІНИ ПОРЦІЇ -----------------------------------------------------------------------------------------------
CREATE TRIGGER bfr_ins_price BEFORE INSERT ON cafe.portions
FOR EACH ROW
BEGIN
  SET NEW.price = (SELECT SUM(price) * (1.0 -  COALESCE(NEW.discount, 0))
                   FROM dishes
                   WHERE tech_card_num = NEW.tech_card_num);
END;


CREATE TRIGGER bfr_upd_price BEFORE UPDATE ON cafe.portions
FOR EACH ROW
BEGIN
  IF NEW.discount <> OLD.discount THEN
    SET NEW.price = (SELECT SUM(price) * (1.0 -  COALESCE(NEW.discount, 0))
                     FROM dishes
                     WHERE tech_card_num = NEW.tech_card_num);
  END IF;
END;


-- ОНОВЛЕННЯ СУМИ У ЗАМОВЛЕННЯХ ----------------------------------------------------------------------------------------
CREATE TRIGGER create_order BEFORE INSERT ON cafe.orders
FOR EACH ROW
BEGIN
  SET NEW.cost = 0;
END;



CREATE TRIGGER afr_ins_price AFTER INSERT ON cafe.portions
FOR EACH ROW
BEGIN
  UPDATE orders
  SET cost = COALESCE((SELECT SUM(price)
               FROM portions
               WHERE order_num = orders.unique_num), 0)
  WHERE unique_num = NEW.order_num;
END;



CREATE TRIGGER afr_upd_price AFTER UPDATE ON cafe.portions
FOR EACH ROW
BEGIN
  IF NEW.price <> OLD.price THEN
      UPDATE orders
      SET cost = COALESCE((SELECT SUM(price)
                   FROM portions
                   WHERE order_num = orders.unique_num), 0)
      WHERE unique_num IN (NEW.order_num, OLD.order_num);
  END IF;
END;


CREATE TRIGGER afr_del_price AFTER DELETE ON cafe.portions
FOR EACH ROW
BEGIN
  UPDATE orders
  SET cost = COALESCE((SELECT SUM(price)
               FROM portions
               WHERE order_num = orders.unique_num), 0)
  WHERE unique_num = OLD.order_num;
END;



-- ОНОВЛЕННЯ АТРИБУТУ "НАЯВНІСТЬ ІНГРІДІЄНТІВ" ДЛЯ СТРАВИ --------------------------------------------------------------
DROP TRIGGER aft_ins_d_i; -----------------------
DROP TRIGGER aft_del_d_i;
DROP TRIGGER aft_upd_d_i;



CREATE TRIGGER aft_ins_d_i AFTER INSERT ON dishes_ingredients
FOR EACH ROW
BEGIN
  UPDATE dishes Y
  SET is_ing_available = IF("NO" IN (SELECT IF(amount <= COALESCE((SELECT SUM(curr_amount)
                                                                   FROM ingredients
                                                                   WHERE ing_name = X.ing_name), 0),
                                               "YES", "NO")
                                     FROM dishes_ingredients X
                                     WHERE tech_card_num = Y.tech_card_num), 0b0, 0b1)
  WHERE tech_card_num = NEW.tech_card_num;
END;

CREATE TRIGGER aft_del_d_i AFTER DELETE ON dishes_ingredients
FOR EACH ROW
BEGIN
  UPDATE dishes Y
  SET is_ing_available = IF("NO" IN (SELECT IF(amount <= COALESCE((SELECT SUM(curr_amount)
                                                                   FROM ingredients
                                                                   WHERE ing_name = X.ing_name), 0),
                                               "YES", "NO")
                                     FROM dishes_ingredients X
                                     WHERE tech_card_num = Y.tech_card_num), 0b0, 0b1)
  WHERE tech_card_num = OLD.tech_card_num;
END;


CREATE TRIGGER aft_upd_d_i AFTER UPDATE ON dishes_ingredients
FOR EACH ROW
BEGIN
  UPDATE dishes Y
  SET is_ing_available = IF("NO" IN (SELECT IF(amount <= COALESCE((SELECT SUM(curr_amount)
                                                                   FROM ingredients
                                                                   WHERE ing_name = X.ing_name), 0),
                                               "YES", "NO")
                                     FROM dishes_ingredients X
                                     WHERE tech_card_num = Y.tech_card_num), 0b0, 0b1)
  WHERE tech_card_num IN (NEW.tech_card_num, OLD.tech_card_num);
END;


DROP TRIGGER afr_upd_i; -----------------------
DROP TRIGGER afr_del_i;


CREATE TRIGGER afr_upd_i AFTER UPDATE ON ingredients
FOR EACH ROW
BEGIN
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
END;


CREATE TRIGGER afr_del_i AFTER DELETE ON ingredients
FOR EACH ROW
BEGIN
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
END;


-- ОНОВЛЕННЯ КІЛЬКОСТІ ІНГРІДІЄНТА -------------------------------------------------------------------------------------
CREATE TRIGGER create_ing BEFORE INSERT ON cafe.ingredients
FOR EACH ROW
BEGIN
  SET NEW.curr_amount = 0;
END;


DROP TRIGGER afr_del_good;
DROP TRIGGER afr_upd_good;
DROP TRIGGER afr_ins_good;

CREATE TRIGGER afr_del_good AFTER DELETE ON goods
FOR EACH ROW
BEGIN
  UPDATE ingredients
  SET curr_amount = curr_amount - (OLD.curr_amount * (SELECT SUM(graduation_rule)
                                                      FROM units
                                                      WHERE OLD.unit_name = unit_name))
  WHERE ing_name = OLD.ing_name;
END;


CREATE TRIGGER afr_upd_good AFTER UPDATE ON goods
FOR EACH ROW
BEGIN
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
END;

CREATE TRIGGER afr_ins_good AFTER INSERT ON goods
FOR EACH ROW
BEGIN
  UPDATE ingredients
  SET curr_amount = curr_amount + NEW.curr_amount * (SELECT SUM(graduation_rule)
                                                     FROM units
                                                     WHERE NEW.unit_name = unit_name)
  WHERE ing_name = NEW.ing_name;
END;



-- ОНОВЛЕННЯ КІЛЬКОСТІ ПРОДУКТІВ ---------------------------------------------------------------------------------------
CREATE TRIGGER bfr_ins_good BEFORE INSERT ON cafe.goods
FOR EACH ROW
BEGIN
  SET NEW.curr_amount = NEW.start_amount;
  SET NEW.expected_amount = NEW.start_amount;
END;


CREATE TRIGGER afr_ins_dis_good_amount AFTER INSERT ON cafe.discarding_goods
FOR EACH ROW
BEGIN
  UPDATE goods
  SET expected_amount = expected_amount - NEW.amount
  WHERE unique_code = NEW.good_code;
END;


CREATE TRIGGER afr_upd_dis_good_amount AFTER UPDATE ON cafe.discarding_goods
FOR EACH ROW
BEGIN
  IF NEW.amount <> OLD.amount THEN
      UPDATE goods
      SET expected_amount = expected_amount - (NEW.amount - OLD.amount)
      WHERE unique_code = NEW.good_code;
  END IF;

  IF NEW.good_code <> OLD.good_code THEN
      UPDATE goods
      SET expected_amount = expected_amount + OLD.amount
      WHERE unique_code = OLD.good_code;
      UPDATE goods
      SET expected_amount = expected_amount - NEW.amount
      WHERE unique_code = NEW.good_code;
  END IF;
END;

CREATE TRIGGER afr_del_dis_good_amount AFTER DELETE ON cafe.discarding_goods
FOR EACH ROW
BEGIN
  UPDATE goods
  SET expected_amount = expected_amount + OLD.amount
  WHERE unique_code = OLD.good_code;
END;


-- ОНОВЛЕННЯ ЦІНИ ПОСТАВКИ ---------------------------------------------------------------------------------------------
CREATE TRIGGER create_deliv BEFORE INSERT ON cafe.deliveries
FOR EACH ROW
BEGIN
  SET NEW.cost = 0;
END;



CREATE TRIGGER afr_ins_good_price AFTER INSERT ON cafe.goods
FOR EACH ROW
BEGIN
  UPDATE deliveries
  SET cost = cost + NEW.cost
  WHERE delivery_num = NEW.delivery_num;
END;



CREATE TRIGGER afr_upd_good_price AFTER UPDATE ON cafe.goods
FOR EACH ROW
BEGIN
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
END;



CREATE TRIGGER afr_del_good_price AFTER DELETE ON cafe.goods
FOR EACH ROW
BEGIN
  UPDATE deliveries
  SET cost = cost - OLD.cost
  WHERE delivery_num = OLD.delivery_num;
END;




-- ОНОВЛЕННЯ ЦІНИ СПИСАНОГО ПРОДУКТУ -----------------------------------------------------------------------------------
CREATE TRIGGER bfr_ins_dis_good BEFORE INSERT ON cafe.discarding_goods
FOR EACH ROW
BEGIN
  SET NEW.cost = NEW.amount * (SELECT SUM(unit_price)
                               FROM goods
                               WHERE unique_code = NEW.good_code);
END;



CREATE TRIGGER bfr_upd_dis_good BEFORE UPDATE ON cafe.discarding_goods
FOR EACH ROW
BEGIN
  IF NEW.amount <> OLD.amount OR NEW.good_code <> OLD.good_code THEN
      SET NEW.cost = NEW.amount * (SELECT SUM(unit_price)
                                   FROM goods
                                   WHERE unique_code = NEW.good_code);
  END IF;
END;



-- ОНОВЛЕННЯ ЦІНИ В АКТІ СПИСАННЯ --------------------------------------------------------------------------------------
CREATE TRIGGER create_discard BEFORE INSERT ON cafe.discarding
FOR EACH ROW
BEGIN
  SET NEW.cost = 0;
END;


CREATE TRIGGER afr_ins_dis_good AFTER INSERT ON cafe.discarding_goods
FOR EACH ROW
BEGIN
  UPDATE discarding
  SET cost = COALESCE ((SELECT SUM(cost)
                            FROM discarding_goods
                            WHERE discard_code = NEW.discard_code), 0)
  WHERE unique_code = NEW.discard_code;
END;




CREATE TRIGGER afr_upd_dis_good AFTER UPDATE ON cafe.discarding_goods
FOR EACH ROW
BEGIN
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
END;



CREATE TRIGGER afr_del_dis_good AFTER DELETE ON cafe.discarding_goods
FOR EACH ROW
BEGIN
  UPDATE discarding
  SET cost = COALESCE ((SELECT SUM(cost)
                        FROM discarding_goods
                        WHERE discard_code = OLD.discard_code), 0)
  WHERE unique_code = OLD.discard_code;
END;


-- ПЕРЕВІРКА МОЖЛИВОСТІ ДОДАТИ ПОРЦІЮ ----------------------------------------------------------------------------------
CREATE TRIGGER before_create_portion BEFORE INSERT ON cafe.portions
FOR EACH ROW
BEGIN
  SET NEW.tech_card_num = IF(0b0 IN (SELECT is_ing_available
                                     FROM dishes
                                     WHERE dishes.tech_card_num = NEW.tech_card_num), NULL, NEW.tech_card_num);
END;

CREATE TRIGGER before_update_portion BEFORE UPDATE ON cafe.portions
FOR EACH ROW
BEGIN
  SET NEW.tech_card_num = IF(0b0 IN (SELECT is_ing_available
                                     FROM dishes
                                     WHERE dishes.tech_card_num = NEW.tech_card_num), NULL, NEW.tech_card_num);
END;


-- ОНОВЛЕННЯ КІЛЬКОСТІ ПРОДУКТУ ПІСЛЯ СТВОРЕННЯ ПОРЦІЙ -----------------------------------------------------------------
DROP TRIGGER after_create_portion;

CREATE TRIGGER after_create_portion AFTER UPDATE ON cafe.portions
FOR EACH ROW
BEGIN
  IF NEW.is_ready <> OLD.is_ready THEN
      IF NEW.is_ready = '1' THEN
          BEGIN
          DECLARE ingr VARCHAR(40);
          DECLARE amo MEDIUMINT UNSIGNED;
          DECLARE done INTEGER DEFAULT 0;
          DECLARE IngsCursor CURSOR FOR
          SELECT ing_name, amount FROM dishes_ingredients WHERE tech_card_num = NEW.tech_card_num;

          DECLARE CONTINUE HANDLER FOR SQLSTATE '02000' SET done=1;
          OPEN IngsCursor;

          WHILE done = 0 DO
              FETCH IngsCursor INTO ingr, amo;


              BLOCK2: BEGIN
              DECLARE exp_amount FLOAT UNSIGNED;
              DECLARE goods_code MEDIUMINT UNSIGNED;
              DECLARE grad_rule FLOAT UNSIGNED;
              DECLARE done2 INTEGER DEFAULT 0;
              DECLARE GoodsCursor CURSOR FOR
              SELECT unique_code, expected_amount, graduation_rule
              FROM (goods INNER JOIN units ON goods.unit_name = units.unit_name)
                          INNER JOIN deliveries ON goods.delivery_num = deliveries.delivery_num
              WHERE ing_name = ingr AND is_received = 1
              ORDER BY order_date;

              DECLARE CONTINUE HANDLER FOR SQLSTATE '02000' SET done2=1;
              OPEN GoodsCursor;

              WHILE done2 = 0 DO
              FETCH GoodsCursor INTO goods_code,exp_amount,grad_rule;
                  IF exp_amount * grad_rule < amo THEN
                      UPDATE goods
                      SET expected_amount = 0
                      WHERE unique_code = goods_code;

                      SET amo = amo - exp_amount * grad_rule;
                  ELSE
                      SET exp_amount = exp_amount - amo / grad_rule;

                      UPDATE goods
                      SET expected_amount = exp_amount
                      WHERE unique_code = goods_code;
                      SET done2=1;
                  END IF;

              END WHILE;

              CLOSE GoodsCursor;
              END BLOCK2;
          END WHILE;
          CLOSE IngsCursor;
          END;
      ELSE BEGIN
              DECLARE ingr VARCHAR(40);
              DECLARE amo MEDIUMINT UNSIGNED;
              DECLARE done INTEGER DEFAULT 0;
              DECLARE IngsCursor CURSOR FOR
              SELECT ing_name, amount FROM dishes_ingredients WHERE tech_card_num = NEW.tech_card_num;

              DECLARE CONTINUE HANDLER FOR SQLSTATE '02000' SET done=1;
              OPEN IngsCursor;

              WHILE done = 0 DO
                  FETCH IngsCursor INTO ingr, amo;


                  BLOCK2: BEGIN
                  DECLARE exp_amount FLOAT UNSIGNED;
                  DECLARE st_amount FLOAT UNSIGNED;
                  DECLARE goods_code MEDIUMINT UNSIGNED;
                  DECLARE grad_rule FLOAT UNSIGNED;
                  DECLARE done2 INTEGER DEFAULT 0;
                  DECLARE GoodsCursor CURSOR FOR
                  SELECT unique_code, expected_amount, graduation_rule, start_amount
                  FROM (goods INNER JOIN units ON goods.unit_name = units.unit_name)
                              INNER JOIN deliveries ON goods.delivery_num = deliveries.delivery_num
                  WHERE ing_name = ingr AND is_received = 1
                  ORDER BY order_date DESC;

                  DECLARE CONTINUE HANDLER FOR SQLSTATE '02000' SET done2=1;
                  OPEN GoodsCursor;

                  WHILE done2 = 0 DO
                  FETCH GoodsCursor INTO goods_code,exp_amount,grad_rule,st_amount;

                  SET exp_amount = exp_amount + amo / grad_rule;
                  UPDATE goods
                  SET expected_amount = exp_amount
                  WHERE unique_code = goods_code;
                  SET done2=1;

                  END WHILE;

                  CLOSE GoodsCursor;
                  END BLOCK2;
              END WHILE;
              CLOSE IngsCursor;
              END;


      END IF;
  END IF;
END;
