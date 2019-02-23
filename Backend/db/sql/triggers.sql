use cafe;


-- ОНОВЛЕННЯ ЦІНИ ПОРЦІЇ
CREATE TRIGGER bfr_ins_price BEFORE INSERT ON cafe.portions
FOR EACH ROW
BEGIN
  SET NEW.price = (SELECT SUM(price) * (1.0 -  COALESCE(NEW.discount, 0))
                   FROM dishes
                   WHERE tech_card_num = NEW.tech_card_num);
END;

DROP TRIGGER cafe.bfr_ins_price;


CREATE TRIGGER bfr_upd_price BEFORE UPDATE ON cafe.portions
FOR EACH ROW
BEGIN
  SET NEW.price = (SELECT SUM(price) * (1.0 -  COALESCE(NEW.discount, 0))
                   FROM dishes
                   WHERE tech_card_num = NEW.tech_card_num);
END;

DROP TRIGGER cafe.bfr_upd_price;



-- ОНОВЛЕННЯ СУМИ У ЗАМОВЛЕННЯХ
CREATE TRIGGER afr_ins_price AFTER INSERT ON cafe.portions
FOR EACH ROW
BEGIN
  UPDATE orders
  SET cost = COALESCE((SELECT SUM(price)
               FROM portions
               WHERE order_num = orders.unique_num), 0)
  WHERE unique_num = NEW.order_num;
END;

DROP TRIGGER cafe.afr_ins_price;


CREATE TRIGGER afr_upd_price AFTER UPDATE ON cafe.portions
FOR EACH ROW
BEGIN
  UPDATE orders
  SET cost = COALESCE((SELECT SUM(price)
               FROM portions
               WHERE order_num = orders.unique_num), 0)
  WHERE unique_num = NEW.order_num;
END;

DROP TRIGGER cafe.afr_upd_price;

CREATE TRIGGER afr_del_price AFTER DELETE ON cafe.portions
FOR EACH ROW
BEGIN
  UPDATE orders
  SET cost = COALESCE((SELECT SUM(price)
               FROM portions
               WHERE order_num = orders.unique_num), 0)
  WHERE unique_num = OLD.order_num;
END;

DROP TRIGGER cafe.afr_del_price;


-- ОНОВЛЕННЯ АТРИБУТУ "НАЯВНІСТЬ ІНГРІДІЄНТІВ" ДЛЯ СТРАВИ
CREATE TRIGGER bfr_ins_aval BEFORE INSERT ON cafe.dishes
FOR EACH ROW
BEGIN
  SET NEW.is_ing_available = IF("NO" IN (SELECT IF(amount >= (SELECT SUM(curr_amount * graduation_rule)
                                                              FROM goods INNER JOIN units ON goods.unit_name = units.unit_name
                                                              WHERE ing_name = X.ing_name),
                                                "YES", "NO")
                                         FROM dishes_ingredients X
                                         WHERE tech_card_num = NEW.tech_card_num), 0b0, 0b1);
END;

DROP TRIGGER cafe.bfr_ins_aval;






