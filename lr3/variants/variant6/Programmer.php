<?php

class Programmer
{
    public string $name;
    public string $language;
    public string $level;

    public function __construct(string $name = '', string $language = '', string $level = '')
    {
        $this->name = $name;
        $this->language = $language;
        $this->level = $level;
    }

    public function getInfo(): string
    {
        return "Програміст: {$this->name}, Мова: {$this->language}, Рівень: {$this->level}";
    }
}