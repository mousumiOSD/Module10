<?php

1.User Order History:
sql = SELECT 
    o.id AS order_id,
    o.order_date,
    o.total_amount,
    o.status,
    d.name AS dish_name,
    oi.quantity,
    oi.price AS dish_price
FROM orders o
JOIN order_items oi ON o.id = oi.order_id
JOIN dishes d ON oi.dish_id = d.id
JOIN users u ON o.user_id = u.id
WHERE u.name = 'John Doe'
ORDER BY o.order_date DESC;

2.Revenue by Cuisine:
SELECT 
    d.cuisine,
    SUM(o.total_amount) AS total_revenue
FROM orders o
JOIN order_items oi ON o.id = oi.order_id
JOIN dishes d ON oi.dish_id = d.id
WHERE o.status = 'Completed'
GROUP BY d.cuisine;

3.Popular Dish:
SELECT 
    d.name AS popular_dish,
    COUNT(oi.dish_id) AS order_count
FROM order_items oi
JOIN dishes d ON oi.dish_id = d.id
GROUP BY oi.dish_id
ORDER BY order_count DESC
LIMIT 1;

4.Unpopular Dish:
SELECT 
    d.name AS unpopular_dish,
    MAX(o.order_date) AS last_ordered_date
FROM dishes d
LEFT JOIN order_items oi ON d.id = oi.dish_id
LEFT JOIN orders o ON oi.order_id = o.id
GROUP BY d.id
ORDER BY last_ordered_date
LIMIT 20;

5.Repeating Customers:
SELECT 
    u.name AS customer_name,
    COUNT(o.id) AS order_count,
    SUM(o.total_amount) AS total_spent
FROM users u
JOIN orders o ON u.id = o.user_id
GROUP BY u.id
ORDER BY order_count DESC
LIMIT 10;

6.Summary Status for Dashboard:
    
    SELECT COUNT(*) AS total_orders_today FROM orders WHERE DATE(order_date) = CURDATE();

    SELECT COUNT(*) AS total_incomplete_orders FROM orders WHERE status != 'Completed';

    SELECT COUNT(*) AS total_orders_this_week FROM orders WHERE WEEK(order_date) = WEEK(CURDATE());
     

7.Open text search:
SELECT 
d.name,
d.description,
d.price,
d.cuisine
FROM dishes d
WHERE 
CONCAT(d.name, d.description, d.cuisine) LIKE '%search_term%'
ORDER BY d.price DESC;

8.User Order History with Filters:
SELECT 
o.id AS order_id,
o.order_date,
o.total_amount,
o.status,
d.name AS dish_name,
oi.quantity,
oi.price AS dish_price
FROM orders o
JOIN order_items oi ON o.id = oi.order_id
JOIN dishes d ON oi.dish_id = d.id
JOIN users u ON o.user_id = u.id
WHERE 
(u.name = 'John Doe' OR 'John Doe' IS NULL)
AND (o.order_date >= '2024-01-01' OR '2024-01-01' IS NULL)
AND (d.name = 'Margherita Pizza' OR 'Margherita Pizza' IS NULL)
ORDER BY o.order_date DESC;

9.Revenue by Cuisine with Date Range Filter:
SELECT 
    d.cuisine,
    SUM(o.total_amount) AS total_revenue
FROM orders o
JOIN order_items oi ON o.id = oi.order_id
JOIN dishes d ON oi.dish_id = d.id
WHERE o.status = 'Completed'
    AND o.order_date BETWEEN '2024-01-01' AND '2024-01-10'
GROUP BY d.cuisine;


10. Open Text Search:
SELECT 
    d.name,
    d.description,
    d.price,
    d.cuisine
FROM dishes d
WHERE 
    CONCAT(d.name, d.description, d.cuisine) LIKE '%search_term%'
    AND d.price BETWEEN 0 AND 150
ORDER BY d.price DESC;
