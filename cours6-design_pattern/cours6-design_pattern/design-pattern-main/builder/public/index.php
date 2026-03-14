<?php

use App\MySQLQueryBuilder;

require('../vendor/autoload.php');

$queryBuilder = new MySQLQueryBuilder();

echo "--- Test 1 : Requête simple ---\n";
echo $queryBuilder->select(['id', 'name'])
    ->from('users')
    ->build() . "\n\n";

echo "--- Test 2 : Requête avec une condition (nombre) ---\n";
echo (new MySQLQueryBuilder())->select(['*'])
    ->from('products')
    ->where('price', '>', 100)
    ->build() . "\n\n";

echo "--- Test 3 : Requête avec une condition (texte) ---\n";
echo (new MySQLQueryBuilder())->select(['email'])
    ->from('users')
    ->where('status', '=', 'active')
    ->build() . "\n\n";

echo "--- Test 4 : Requête avec plusieurs conditions ---\n";
echo (new MySQLQueryBuilder())->select(['id', 'title', 'price'])
    ->from('books')
    ->where('author', '=', 'Victor Hugo')
    ->where('year', '>=', 1830)
    ->where('available', '=', 1)
    ->build() . "\n\n";

echo "--- Test 5 : Requête par défaut (SELECT *) ---\n";
echo (new MySQLQueryBuilder())->from('categories')
    ->build() . "\n";
