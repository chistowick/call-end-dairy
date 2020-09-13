<?php

namespace Chistowick;

use Chistowick\Month;

class Calendar
{
    private $lang; // Язык названия месяца
    private $year;
    private $month; // Порядковый номер месяца - входные данные
    private $monthObject; // Объект - месяц

    /**
     * @param int $year Год (4 цифры) (по умолчанию - текущий год)
     * @param int $month Порядковый номер месяца (по умолчанию - текущий месяц)
     * @return 
     **/
    public function __construct(int $year = null, int $month = null, string $lang = 'en')
    {
        $this->year = $year ?: getdate()['year'];
        $this->month = $month ?: getdate()['mon'];
        
        $this->lang = $lang;

        $this->monthObject = $this->createMonth();

        return $this;
    }

    /**
     * Сформировать таблицу календарного месяца
     *
     * @return object объект типа \Chistowick\Month;
     **/
    public function createMonth(): object
    {
        return new Month($this->year, $this->month, $this->lang);
    }

    /**
     * Формирование HTML-таблицы календаря месяца
     *
     * @return string HTML-таблица календарь месяца
     **/
    public function rendering()
    {
        $str = "";

        $str .= $this->monthObject->rendering();

        return str_replace("><", ">\n<", $str);
    }
}
