<?php

namespace Yume\Kama\Obi\HTTP\Routing;

use Yume\Kama\Obi\HTTP;

/*
 * RouteError
 *
 * @package Yume\Kama\Obi\HTTP\Routing
 */
class RouteError extends HTTP\HTTPError
{
    
    /*
     * If path duplication is detected.
     *
     * @access Public Static
     *
     * @values Int
     */
    public const DUPLICATE_PATH = 3570;
    
    public const INVALID_HANDLER_STRING = 3573;
    
    public const METHOD_NOT_ALLOWED = 3574;
    
    public const PAGE_NOT_FOUND = 3578;
    
    /*
     * If the segment name does not exist.
     *
     * @access Public Static
     *
     * @values Int
     */
    public const SEGMENT_NAME_ERROR = 3579;
    
    /*
     * If the detected segment name has duplicates.
     *
     * @access Public Static
     *
     * @values Int
     */
    public const SEGMENT_NAME_DUPLICATE = 3580;
    
    /*
     * If the segment name uses the name :params.
     *
     * @access Public Static
     *
     * @values Int
     */
    public const SEGMENT_NAME_PROHIBITED = 3581;
    
    /*
     * If the segment is read only.
     *
     * @access Public Static
     *
     * @values Int
     */
    public const SEGMENT_READONLY = 3582;
    
    /*
     * If the :params segment has multiple or more than one.
     *
     * @access Public Static
     *
     * @values Int
     */
    public const THERE_ARE_MANY_PARAMS_SEGMENTS = 3583;
    
    /*
     * @inherit Yume\Kama\Obi\Trouble\TroubleError
     *
     */
    protected Array $flags = [
        self::DUPLICATE_PATH => "Route path {} must not have duplicate path.",
        self::PAGE_NOT_FOUND => "Route path is currently uncaught, page {} not found.",
        self::SEGMENT_NAME_ERROR => "Route path {} has no segment name {}.",
        self::SEGMENT_NAME_DUPLICATE => "Route path {} has more than one {} segment.",
        self::SEGMENT_NAME_PROHIBITED => "Route path {} is prohibited from using segment name :params.",
        self::SEGMENT_READONLY => "Segment {} on route path {} is read only.",
        self::THERE_ARE_MANY_PARAMS_SEGMENTS => "Route path {} has more than one /SegmentMatchAll/"
    ];
    
}

?>