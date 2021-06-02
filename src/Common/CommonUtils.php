<?php

namespace Juancrrn\Carrier\Common;

/**
 * Common utils
 * 
 * @package carrier
 *
 * @author juancrrn
 *
 * @version 0.0.1
 */

class CommonUtils
{
    
    /**
     * Formato estándar de tipo de dato DATETIME de MySQL.
     */
    public const MYSQL_DATETIME_FORMAT = 'Y-m-d H:i:s';
    
    /**
     * Formato estándar de tipo de dato DATE de MySQL.
     */
    public const MYSQL_DATE_FORMAT = 'Y-m-d';
    
    /**
     * Formato estándar de tipo de dato DATETIME para legibilidad humana.
     */
    public const HUMAN_DATETIME_FORMAT = 'j \d\e F \d\e\l Y \a \l\a\s H:i';
    public const HUMAN_DATETIME_FORMAT_STRF = '%e de %B de %Y a las %H:%M';
    
    /**
     * Formato estándar de tipo de dato DATE para legibilidad humana.
     */
    public const HUMAN_DATE_FORMAT = 'j \d\e F \d\e\l Y';
    public const HUMAN_DATE_FORMAT_STRF = '%e de %B de %Y';
}