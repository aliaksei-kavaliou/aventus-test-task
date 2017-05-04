SELECT c1.* FROM car_location c1
INNER JOIN car_location c2 ON c1.x=c2.x AND c1.y=c2.y AND c1.car <> c2.car
GROUP BY car
ORDER BY x, y, car