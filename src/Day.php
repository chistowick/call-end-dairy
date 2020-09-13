<?php

namespace Chistowick;

/**
 * День
 */
class Day
{
    private $mday;
    private $classes = [];

    /**
     * @param int|null $mday Порядковый номер дня месяца
     * @return object $this
     */
    public function __construct(int $mday = null)
    {
        $this->mday = $mday;

        return $this;
    }

    /**
     * Получить массив классов дня
     * 
     * @return array Массив классов дня
     */
    public function getClasses(): array
    {
        return $this->classes;
    }

    /**
     * Добавить класс к дню
     * 
     * @param string $class Имя класса
     * @return object \Chistowick\Day;
     */
    public function addClass(string $class): object
    {
        $this->classes[] = $class;

        return $this;
    }

    /**
     * Отрисовка HTML-представления
     * 
     * @return string
     **/
    public function rendering()
    {
        $class = implode(' ', $this->classes);

        return sprintf("<td class=\"%s\">%s</td>", $class, ($this->mday) ?: '');
    }
}
