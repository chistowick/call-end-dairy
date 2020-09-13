<?php

namespace Chistowick;

use Chistowick\Week;

/**
 * Месяц
 */
class Month
{
    private $lang; // Язык названия месяца
    private $month;
    private $daysCount; // Дней в текущем месяце
    private $weeks = []; // Массив с неделями месяца
    static private $monthName = [
        1 => ['en' => 'January', 'ru' => 'Январь'],
        2 => ['en' => 'February', 'ru' => 'Февраль'],
        3 => ['en' => 'March', 'ru' => 'Март'],
        4 => ['en' => 'April', 'ru' => 'Апрель'],
        5 => ['en' => 'May', 'ru' => 'Май'],
        6 => ['en' => 'June', 'ru' => 'Июнь'],
        7 => ['en' => 'July', 'ru' => 'Июль'],
        8 => ['en' => 'August', 'ru' => 'Август'],
        9 => ['en' => 'September', 'ru' => 'Сентябрь'],
        10 => ['en' => 'October', 'ru' => 'Октябрь'],
        11 => ['en' => 'November', 'ru' => 'Ноябрь'],
        12 => ['en' => 'December', 'ru' => 'Декабрь'],
    ];

    /**
     * Возвращает массив объектов типа \Chistowick\Week;
     *
     * @param string $year Год
     * @param string $month Месяц
     * @return object $this
     **/
    public function __construct(string $year, string $month, string $lang = 'en')
    {
        $this->month = $month;
        $this->lang = $lang;

        $this->daysCount = cal_days_in_month(CAL_GREGORIAN, $this->month, $year);

        $day = 1; // день в месяце
        $date = strtotime(sprintf("%04d-%02d-%02d", $year, $this->month, $day));

        // Порядковый номер дня недели первого дня месяца 
        $startWeekDay = getdate($date)['wday'];

        // Количество дней в первой неделе
        $daysInFirstWeek = ($startWeekDay == 0) ? 1 : (8 - $startWeekDay);

        // Количество дней в последней неделе
        $daysInLastWeek = ($this->daysCount - $daysInFirstWeek) % 7;

        // Кол-во недель в месяце
        $countWeeks = 1 + intdiv(($this->daysCount - $daysInFirstWeek), 7) + (($daysInLastWeek == 0) ? 0 : 1);

        // Для удобства формируем массив длин недель
        $lengthWeek[1] = $daysInFirstWeek;

        for ($i = 2; $i < $countWeeks; $i++) {
            $lengthWeek[$i] = 7;
        }

        // Если последняя неделя была полная, то она равна 7, иначе сколько было высчитано
        $lengthWeek[$countWeeks] = ($daysInLastWeek) ?: 7;

        for ($j = 1; $j <= $countWeeks; $j++) {
            $this->weeks[] = new Week($startWeekDay, $day, $lengthWeek[$j], $this->month);

            // Вычисляем число, с которого начнется следующая неделя
            $day += $lengthWeek[$j];

            // Любая неделя кроме первой будет начинаться с понедельника
            $startWeekDay = 1;
        }

        return $this;
    }

    /**
     * Возвращает массив недель
     *
     * @return array
     **/
    public function getWeeks(): array
    {
        return $this->weeks;
    }

    /**
     * Отрисовка HTML-представления
     * 
     * @return string
     **/
    public function rendering()
    {
        $str = "<tr><td colspan=\"7\">" . self::$monthName[$this->month][$this->lang] . "</td></tr>";

        foreach ($this->weeks as $week) {
            $str .= $week->rendering();
        }

        $id = self::$monthName[$this->month]['en'];
        $str = sprintf("<table id=\"%s\" class=\"calendar table table-bordered\">%s</table>", $id, $str);

        return $str;
    }
}
