<?php

namespace App;

class MySQLQueryBuilder implements QueryBuilderInterface
{
    private array $fields = ['*'];
    private string $table = '';
    private array $whereConditions = [];

    public function select(array $fields): QueryBuilderInterface
    {
        $this->fields = $fields;
        return $this;
    }

    public function from(string $table): QueryBuilderInterface
    {
        $this->table = $table;
        return $this;
    }

    public function where(string $field, string $operator, $value): QueryBuilderInterface
    {
        // On ajoute des guillemets si la valeur est une chaîne
        $formattedValue = is_string($value) ? "'$value'" : $value;
        $this->whereConditions[] = "$field $operator $formattedValue";
        return $this;
    }

    public function build(): string
    {
        $sql = "SELECT " . implode(', ', $this->fields);
        $sql .= " FROM " . $this->table;

        if (!empty($this->whereConditions)) {
            $sql .= " WHERE " . implode(' AND ', $this->whereConditions);
        }

        return $sql . ";";
    }
}
