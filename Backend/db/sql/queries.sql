USE cafe;
-- Дізнатися, який офіціант оформив найбільше замовлень за конкретний період.
SELECT workers.tab_num, surname, first_name, COUNT(orders.unique_num) AS n_orders
FROM workers INNER JOIN orders ON workers.tab_num = orders.tab_num
WHERE position = 'офіціант'
      AND fire_date IS NULL
      AND close_time BETWEEN '2001-01-01' AND '2019-03-01'
GROUP BY workers.tab_num
ORDER BY n_orders DESC
LIMIT 1;

-- Дізнатися, який офіціант приніс найбільше прибутку за конкретний період.
SELECT workers.tab_num, surname, first_name, SUM(cost) AS total
FROM workers INNER JOIN orders ON workers.tab_num = orders.tab_num
WHERE     position = 'офіціант'
      AND fire_date IS NULL
      AND close_time BETWEEN '2001-01-01' AND '2019-03-01'
GROUP BY workers.tab_num
ORDER BY total DESC
LIMIT 1;

-- Обрахувати витрати за поставки за конкретний період.
SELECT SUM(cost) AS total
FROM deliveries
WHERE     pay_date <= '2019-03-01'
      AND pay_date >= '2017-01-01';

-- Обрахувати дохід від замовлень за конкретний період.
SELECT SUM(cost) AS total
FROM orders
WHERE     order_time <= '2019-03-01'
      AND order_time >= '2017-01-01';

-- Обрахувати ціну страв з певною націнкою.
CREATE VIEW avg_ing_prices(ing_name, unit_price) AS
SELECT ing_name, AVG(unit_price / graduation_rule) AS unit_price
FROM goods INNER JOIN units ON goods.unit_name = units.unit_name
GROUP BY ing_name;

SELECT tech_card_num, dish_name, 1.5 * (SELECT SUM(unit_price * amount)
                                  FROM dishes_ingredients INNER JOIN avg_ing_prices
                                       ON dishes_ingredients.ing_name = avg_ing_prices.ing_name
                                  WHERE X.tech_card_num = tech_card_num) AS markuped_price
FROM dishes X;

-- Отримати X/Z-звіт.
SELECT SUM(cost) AS total
FROM orders
where DATE(close_time) = '2019-02-24' AND is_paid = 0b1;


-- Кількість замовлених порцій і сума за них
(SELECT dish_name, COUNT(unique_num) AS n_portions, SUM(portions.price) AS total
FROM portions INNER JOIN dishes ON dishes.tech_card_num = portions.tech_card_num
WHERE order_num IN (SELECT unique_num
                    FROM orders
                    WHERE DATE(close_time) = '2019-02-24' AND is_paid = TRUE)
GROUP BY dish_name
ORDER BY dish_name)
UNION
(SELECT 'ВСЬОГО', COUNT(*) AS n_portions, SUM(cost) AS total
FROM orders INNER JOIN portions ON orders.unique_num = order_num
where DATE(close_time) = '2019-02-24' AND is_paid = TRUE);


-- Отримати відомості про наявність ігредієнтів на складі для конкретної страви.
SELECT ing_name, IF(amount <= COALESCE((SELECT SUM(curr_amount)
                               FROM ingredients
                               WHERE ing_name = X.ing_name), 0),
                 "YES", "NO") AS is_available
FROM dishes_ingredients X
WHERE tech_card_num IN (SELECT tech_card_num
                        FROM dishes
                        WHERE dish_name = 'Салат "Португальський');

-- Отримати відомості про наявність конкретного інгредієнту на складі.
SELECT IF(COUNT(*) > 0, "YES", "NO") AS is_available
FROM goods
WHERE ing_name = 'картопля' AND curr_amount > 0;


-- Отримати відомості про продажі за певною категорією страв (кількість замовлених порцій) за період.
SELECT COUNT(*) AS quantity
FROM portions
WHERE     tech_card_num IN (SELECT tech_card_num
                            FROM dishes_categories
                            WHERE cat_name = 'Холодні закуски')
      AND order_num IN (SELECT order_num
                        FROM orders
                        WHERE     close_time <= '2020-01-01'
                              AND close_time >= '2001-01-01');

-- Отримати відомості про продажі конкретної страви (кількість замовлених порцій).
SELECT COUNT(*) AS quantity
FROM portions
WHERE     tech_card_num IN (SELECT tech_card_num
                        FROM dishes
                        WHERE dish_name = 'Борщ')
      AND order_num IN (SELECT order_num
                        FROM orders
                        WHERE     order_time <= '2020-01-01'
                              AND order_time >= '2001-01-01');

-- Отримати інформацію про поточні замовлення.
SELECT *
FROM orders
WHERE is_closed = 0b0;

-- Отримати інформацію про поточні свої замовлення.
SELECT *
FROM orders
WHERE is_closed = 0b0 AND tab_num = '516';

-- Отримати кількість оформлених чеків (замовлень) за конкретний період.
SELECT COUNT(*) AS n_checks
FROM orders
WHERE     order_time <= '2020-01-01'
      AND order_time >= '2001-01-01'
      AND is_closed;

-- Отримати поточне меню.
SELECT dish_name, weight, price
FROM dishes
WHERE is_in_menu = 0b1;

-- Отримати перелік та кількість необхідних страв всіх поточних замовлень для кухні.
SELECT dish_name, special_wishes, COUNT(portions.unique_num) AS quantity
FROM (orders INNER JOIN portions ON order_num = orders.unique_num)
             INNER JOIN dishes   ON dishes.tech_card_num = portions.tech_card_num
WHERE is_closed = 0b0 AND is_ready = 0b0
GROUP BY dish_name, special_wishes;


-- Отримати перелік не винесених порцій.
SELECT dish_name, special_wishes, COUNT(portions.unique_num) AS quantity
FROM (orders INNER JOIN portions ON order_num = orders.unique_num)
             INNER JOIN dishes   ON dishes.tech_card_num = portions.tech_card_num
WHERE is_closed = 0b0 AND is_ready AND is_served = 0b0
GROUP BY dish_name, special_wishes;

-- Отримати середнє перебування клієнта у кафе за конкретний період.
SELECT AVG(TIME_TO_SEC(TIMEDIFF(close_time, order_time))) / 60 AS avg_time
FROM orders
WHERE     order_time <= '2020-01-01'
      AND order_time >= '2001-01-01'
      AND is_closed;

-- Отримати середнє перебування клієнта у кафе.
SELECT AVG(TIME_TO_SEC(TIMEDIFF(close_time, order_time))) / 60 AS avg_time
FROM orders;

-- Отримати середню вартість чека за конкретний період.
SELECT AVG(cost) AS avg_cost
FROM orders
WHERE     order_time <= '2020-01-01'
      AND order_time >= '2001-01-01'
      AND is_closed;

-- Отримати середню вартість чека на людину за конкретний період.
SELECT SUM(cost) / SUM(n_people) AS avg_cost_per_person
FROM orders
WHERE     order_time <= '2020-01-01'
      AND order_time >= '2001-01-01'
      AND is_paid;

-- Отримати поточний список офіціантів/барменів/кухарів.
SELECT *
FROM workers
WHERE fire_date IS NULL AND position = 'офіціант';

-- Отримати список оформлених чеків (замовлень) за конкретний період конкретним офіціантом/барменом.
SELECT *
FROM orders
WHERE     tab_num = '516'
      AND order_time <= '2020-01-01'
      AND order_time >= '2001-01-01'
      AND is_closed;

-- Отримати список постачальників, котрі поставляли певний інгредієнт.
SELECT *
FROM providers
WHERE code IN (SELECT provider_code
               FROM deliveries
               WHERE delivery_num IN (SELECT delivery_num
                                      FROM goods
                                      WHERE ing_name = 'картопля'));

-- Отримати список страв, котрі були замовлені менше/більше n разів за конкретний період.
SELECT dish_name
FROM dishes
WHERE tech_card_num IN (SELECT tech_card_num
                        FROM portions
                        WHERE order_num IN (SELECT unique_num
                                            FROM orders
                                            WHERE     order_time <= '2020-01-01'
                                                  AND order_time >= '2001-01-01')
                        GROUP BY tech_card_num
                        HAVING COUNT(unique_num) <= 20);

-- Отримати список страв, котрі були замовлені менше 100 разів за останній місяць.
SELECT dish_name
FROM dishes
WHERE tech_card_num IN (SELECT tech_card_num
                        FROM portions
                        WHERE order_num IN (SELECT unique_num
                                            FROM orders
                                            WHERE CURRENT_DATE <= ADDDATE(order_time, INTERVAL 1 MONTH))
                        GROUP BY tech_card_num
                        HAVING COUNT(unique_num) <= 100);


-- Отримати список страв, котрі були замовлені менше/більше n разів.
SELECT dish_name
FROM dishes
WHERE tech_card_num IN (SELECT tech_card_num
                        FROM portions
                        GROUP BY tech_card_num
                        HAVING COUNT(unique_num) < 100);

-- Отримати страви за категорією.
SELECT *
FROM dishes
WHERE tech_card_num IN (SELECT tech_card_num
                        FROM dishes_categories
                        WHERE cat_name = 'Холодні закуски');

-- Переглянути замовлення за конкретний період.
SELECT *
FROM orders
WHERE     order_time <= '2020-01-01'
      AND order_time >= '2001-01-01';

-- Переглянути інформацію про поставки за конкретний період.
SELECT *
FROM deliveries
WHERE     receiving_date <= '2020-01-01'
      AND receiving_date >= '2001-01-01';

-- Переглянути інформацію про поточні поставки (ті, що не доставили або не заплатили).
SELECT *
FROM deliveries
WHERE    is_received = 0b0
      OR pay_date IS NULL;

-- Сформувати «стоп-список» (див. п. 1.2.1 абзац 4)
SELECT tech_card_num, dish_name
FROM dishes
WHERE is_ing_available;

-- Сформувати «топ-список» страв з першими n інгредієнтами, що скоро зіпсуються (див. п. 1.2.1 абзац 4) 
SELECT dish_name, (SELECT MIN(expiration_date)
                   FROM goods
                   WHERE     curr_amount <> 0
                         AND ing_name IN (SELECT ing_name
                                      FROM dishes_ingredients
                                      WHERE dishes.tech_card_num = dishes_ingredients.tech_card_num)) AS expiration_date

FROM dishes
WHERE (SELECT MIN(expiration_date)
                   FROM goods
                   WHERE     curr_amount <> 0
                         AND ing_name IN (SELECT ing_name
                                      FROM dishes_ingredients
                                      WHERE dishes.tech_card_num = dishes_ingredients.tech_card_num)) IS NOT NULL
ORDER BY expiration_date
LIMIT 10;


--	Знайти постачальника, у котрого можна купити всі відсутні інгредієнти потрібні для страв у меню:


SELECT *
FROM workers NATURAL JOIN telephones
WHERE position LIKE 'офіціант'
     AND CONCAT(first_name, ' ', surname, ' ', father_name) LIKE '%Ї%'
ORDER BY tab_num;