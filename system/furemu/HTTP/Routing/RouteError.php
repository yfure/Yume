<?php

namespace Yume\Fure\HTTP\Routing;

use Yume\Fure\HTTP;

/*
 * RouteError
 *
 * @package Yume\Fure\HTTP\Routing
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
     * If the meta type is invalid.
     *
     * @access Public Static
     *
     * @value Int
     */
    public const UNHANDLED_META_TYPE = 3584;
    
    /*
     * @inherit Yume\Fure\Error\BaseError
     *
     */
    protected Array $flags = [
        self::DUPLICATE_PATH => "Route path {} must not have duplicate path.",
        self::INVALID_HANDLER_STRING => "Route handler string must be valid view name or controller name, \"{}\" given.",
        self::PAGE_NOT_FOUND => "Route path is currently uncaught, page {} not found.",
        self::SEGMENT_NAME_ERROR => "Route path {} has no segment name {}.",
        self::SEGMENT_NAME_DUPLICATE => "Route path {} has more than one {} segment.",
        self::SEGMENT_NAME_PROHIBITED => "Route path {} is prohibited from using segment name :params.",
        self::SEGMENT_READONLY => "Segment {} on route path {} is read only.",
        self::THERE_ARE_MANY_PARAMS_SEGMENTS => "Route path {} has more than one /SegmentMatchAll/",
        self::UNHANDLED_META_TYPE => "Unhandled meta type \"{}\" for route \"{}\"."
    ];
    
}

?>