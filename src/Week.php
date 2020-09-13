<?php

namespace Chistowick;

use Chistowick\Day;

/**
 * Неделя
 */
class Week
{
    private $days = []; // Массив с днями недели
    private static $weekDaysName = [
        1 => 'Monday',
        2 => 'Tuesday',
        3 => 'Wednesday',
        4 => 'Thursday',
        5 => 'Friday',
        6 => 'Saturday',
        0 => 'Sunday',
    ];

    /**
     * Возвращает массив объектов типа \Chistowick\Day
     * 
     * @param int $startWeekDay Порядковый номер дня недели, с которого начинается неделя (1-пон., 0-воскр.)
     * @param int $startWeekMonthDay День месяца, с которого начинается неделя
     * @param int $countDay Дней в текущей неделе месяца
     * @return object $this
     **/
    public function __construct(int $startWeekDay, int $startWeekMonthDay, int $countDay = 7, $month)
    {
        // Устанавливаем начальные данные:

        // дату первого дня недели и порядковый номер дня недели
        $day = $startWeekMonthDay;
        $wday = $startWeekDay;

        // Добавляем в неделю заданное количество дней
        for ($i = 1; $i <= $countDay; $i++) {

            // Создаем дни с необходимыми классами
            $this->days[] = (new Day($day))
                ->addClass(self::$weekDaysName[$wday])
                ->addClass(sprintf("%02d-%02d", $month, $day));

            // Увеличиваем дату и порядковый номер дня недели
            $day++;
            $wday = (($wday + 1) == 7) ? 0 : ($wday + 1);
        }

        // Если неделя является началом месяца
        if ($startWeekDay != 1) {
            // пробуем дополнить её до полного размера пустыми днями слева
            $this->days = array_pad($this->days, -7, (new Day())->addClass('empty_day'));
        } elseif ($countDay < 7) { // Если неделя последняя и неполная
            //  добавляем дни справа
            $this->days = array_pad($this->days, 7, (new Day())->addClass('empty_day'));
        }


        return $this;
    }


    /**
     * Возвращает массив дней
     *
     * @return array
     **/
    public function getDays(): array
    {
        return $this->days;
    }

    /**
     * Отрисовка HTML-представления
     * 
     * @return string
     **/
    public function rendering(): string
    {
        $str = '';

        foreach ($this->days as $day) {
            $str .= $day->rendering();
        }
        return sprintf("<tr>%s</tr>", $str);
    }
}
