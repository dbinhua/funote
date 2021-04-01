<?php

namespace App\Models\User;

class Professions
{
    const STUDENT = 'student';
    const BUSINESSMAN = 'businessman';
    const IT = 'it';
    const SERVANT = 'servant';
    const PROFESSIONAL = 'professional';
    const BOSS = 'boss';
    const UNEMPLOYED = 'unemployed';
    const OTHER = 'other';

    const MAP = [
        self::STUDENT => '学生',
        self::BUSINESSMAN => '个体户',
        self::IT => '互联网从业者',
        self::SERVANT => '公务员',
        self::PROFESSIONAL => '专业人员（医生、律师、教师等）',
        self::BOSS => '公司高管',
        self::UNEMPLOYED => '无业',
        self::OTHER => '其他'
    ];
}
