<?php

namespace App;

interface QueryBuilderInterface
{
    public function select(array $fields): QueryBuilderInterface;

    public function from(string $table): QueryBuilderInterface;

    public function where(string $field, string $operator, $value): QueryBuilderInterface;

    public function build(): string;
}
