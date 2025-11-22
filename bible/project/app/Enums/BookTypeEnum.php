<?php

namespace App\Enums;

enum BookTypeEnum: string
{
    case TOTAL_ISSUED = 'total_issued';
    case POLITICAL = 'political';
    case NATURAL_SCIENCE = 'natural_science';
    case MATHEMATICS = 'mathematics';
    case MEDICINE = 'medicine';
    case TECHNICAL = 'technical';
    case ART_AND_SPORT = 'art_and_sport';
    case FICTION = 'fiction';
    case MAGAZINES = 'magazines';
    case OTHER = 'other';
    case STUDENTS = 'students';
    case VIDEOCASSETTES = 'videocassettes';
    case AUDIORECORDS = 'audiorecords';
    case NOTE = 'note';

    public function label(): string
    {
        return match($this) {
            self::TOTAL_ISSUED => 'Всего выдано',
            self::POLITICAL => 'Политическая литература (1, 2, 3к, 3)',
            self::NATURAL_SCIENCE => 'Естествознание',
            self::MATHEMATICS => 'Математика',
            self::MEDICINE => 'Медицина (5, 5а, 61)',
            self::TECHNICAL => 'Техника (6)',
            self::ART_AND_SPORT => 'Искусство и спорт (7)',
            self::FICTION => 'Художественная литература',
            self::MAGAZINES => 'Журналы',
            self::OTHER => 'Прочие (0,4,8,91)',
            self::STUDENTS => 'Студентам',
            self::VIDEOCASSETTES => 'Видеокассеты',
            self::AUDIORECORDS => 'Звукозаписи',
            self::NOTE => 'Примечание',
        };
    }

    public static function options(): array
    {
        $result = [];
        foreach (self::cases() as $case) {
            $result[$case->value] = $case->label();
        }
        return $result;
    }

    /**
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }
}
