<?php

namespace App\Models\User;

class Constellations
{
    const ARIES = 'aries';
    const TAURUS = 'taurus';
    const GEMINI = 'gemini';
    const CACER = 'cacer';
    const LEO = 'leo';
    const VIRGO = 'virgo';
    const LIBRA = 'libra';
    const SCORPIO = 'scorpio';
    const SAGITTARIUS = 'sagittarius';
    const CAPRICOM = 'capricom';
    const AQUARIUS = 'aquarius';
    const PISCES = 'pisces';

    const MAP = [
        self::ARIES => '白羊座',
        self::TAURUS => '金牛座',
        self::GEMINI => '双子座',
        self::CACER => '巨蟹座',
        self::LEO => '狮子座',
        self::VIRGO => '处女座',
        self::LIBRA => '天秤座',
        self::SCORPIO => '天蝎座',
        self::SAGITTARIUS => '射手座',
        self::CAPRICOM => '摩羯座',
        self::AQUARIUS => '水瓶座',
        self::PISCES => '双鱼座'
    ];
}
