-- Багатотабличні запити з кількістю таблиць не менше 3:
-- •	Кількість замовлених порцій за сьогодні і сума за них
(SELECT  dish_name,
                  COUNT(unique_num) AS n_portions,
                  SUM(portions.price) AS total
 FROM portions INNER JOIN dishes ON dishes.tech_card_num = portions.tech_card_num
 WHERE order_num IN (SELECT unique_num
                                         FROM orders
                                         WHERE DATE(close_time) = CURRENT_DATE
                                                        AND is_paid = TRUE)
GROUP BY dish_name
ORDER BY dish_name)
UNION
(SELECT  'ВСЬОГО', COUNT(*) AS n_portions, SUM(cost) AS total
FROM       orders INNER JOIN portions ON orders.unique_num = order_num
WHERE   DATE(close_time) = CURRENT_DATE AND is_paid = TRUE);

--Багатотабличних з групуванням:
--•	Отримати список страв, котрі були замовлені менше 100 разів за останній місяць.
SELECT dish_name
FROM dishes
WHERE tech_card_num IN
              (SELECT tech_card_num
               FROM portions
               WHERE order_num IN
                              (SELECT unique_num
                               FROM orders
                               WHERE CURRENT_DATE <=
                                              ADDDATE(order_time, INTERVAL 1 MONTH))
               GROUP BY tech_card_num
               HAVING COUNT(unique_num) <= 100);

-- •	Обрахувати ціну страв з націнкою 50%.
CREATE VIEW avg_ing_prices(ing_name, unit_price) AS
SELECT ing_name, AVG(unit_price / graduation_rule) AS unit_price
FROM goods INNER JOIN units ON goods.unit_name = units.unit_name
GROUP BY ing_name;

SELECT tech_card_num, dish_name,
               1.5 * (SELECT SUM(unit_price * amount)
                         FROM dishes_ingredients INNER JOIN avg_ing_prices
                               ON dishes_ingredients.ing_name = avg_ing_prices.ing_name
                         WHERE X.tech_card_num = tech_card_num) AS markuped_price
FROM dishes X;
-- Багатотабличних з подвійним запереченням:
-- •	Знайти постачальника, у котрого можна купити всі відсутні інгредієнти потрібні для страв у меню:
CREATE VIEW needed_ingredients AS
SELECT DISTINCT ing_name
FROM dishes_ingredients X
WHERE amount > (SELECT curr_amount
                                 FROM ingredients
                                 WHERE ingredients.ing_name = X.ing_name)
      AND TRUE = ALL (SELECT is_in_menu
                                         FROM dishes
                                         WHERE dishes.tech_card_num = X.tech_card_num);
SELECT code, company_name, contact_person_name, contact_person_tel
FROM providers X
WHERE NOT EXISTS (SELECT ing_name
                  FROM needed_ingredients
                  WHERE ing_name NOT IN (SELECT ing_name
                                         FROM deliveries INNER JOIN goods
                                                   ON goods.delivery_num = deliveries.delivery_num
                                         WHERE X.code = provider_code));
-- Параметричний:
-- •	Отримати відомості про наявність ігредієнтів на складі для конкретної страви.
SELECT ing_name,
                IF(amount <= COALESCE((SELECT curr_amount
                                       FROM ingredients
                                       WHERE ing_name = X.ing_name), 0),
                "YES", "NO") AS is_available
FROM dishes_ingredients X
WHERE tech_card_num IN (SELECT tech_card_num
                                               FROM dishes
                                               WHERE dish_name = 'Салат "Португальський');













