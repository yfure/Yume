<?php

def Test:
    def Test:
        access:
            values: String
            require: True
    ;;
    def data():
        
    ;;
    def mounted():
        if( typeof this.access === "undefined" )
        {
            var access = "@access;";
        }
    ;;
    def computed():
        ....
    ;;
    def template():
        @from[/].import( "" );
    ;;


?>