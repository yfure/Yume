<!DOCTYPE html>
<html data-theme="dark">
    
    <head>
        
        <!-- Web Title -->
        <title> @title; </title>
        
        <!-- Web Meta -->
        <meta charset="UTF-8" />
        <meta name="author" content="@\Yume\Func\config => ( "app.author.name" );" />
        <meta name="theme-color" content="#202521">
        <meta name="robots" content="noimageindex, noarchive" />
        <meta name="description" content="Stay connected together even if the distance separates you." />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
        
        <link rel="stylesheet" href="@RESOURCE_PATH;/script/swiper/swiper-bundle.min.css" />
        <link rel="stylesheet" href="@RESOURCE_PATH;/script/highlightjs/styles/atom-one-dark.css" />
        <link rel="stylesheet" href="@RESOURCE_PATH;/script/boxicons/css/boxicons.min.css" />
        <link rel="stylesheet" href="@RESOURCE_PATH;/styles/octancle.css" />
        <link rel="stylesheet" href="@RESOURCE_PATH;/styles/octancle-built.css" />
        
        <script type="text/javascript" src="@RESOURCE_PATH;/script/axios/dist/axios.min.js"></script>
        <script type="text/javascript" src="@RESOURCE_PATH;/script/swiper/swiper-bundle.min.js"></script>
        <script type="text/javascript" src="@RESOURCE_PATH;/script/apexcharts/dist/apexcharts.min.js"></script>
        <script type="text/javascript" src="@RESOURCE_PATH;/script/js-cookie/dist/js.cookie.min.js"></script>
        <script type="text/javascript" src="@RESOURCE_PATH;/script/highlightjs/highlight.pack.min.js"></script>
        <script type="text/javascript" src="@RESOURCE_PATH;/script/vue/dist/vue.global.prod.js"></script>
        <script type="text/javascript" src="@RESOURCE_PATH;/script/vuex/dist/vuex.global.prod.js"></script>
        <script type="text/javascript" src="@RESOURCE_PATH;/script/vue-router/dist/vue-router.global.prod.js"></script>
        <script type="text/javascript" src="@RESOURCE_PATH;/script/vue-apexcharts/dist/vue-apexcharts.min.js"></script>
        <script type="text/javascript" src="@RESOURCE_PATH;/script/vue-plugin/dist/highlightjs-vue.min.js"></script>
        
    </head>
    
    <body>
        
        <script type="text/javascript">
            
        </script>
        
        <component
            ::bind="Header">
            <a href="/@user;">
                <h5 class="fb-35 ff-lato">@user;</h5>
            </a>
        </component>
        
        <component
            :bind="Navbar"
            :sliding="right" />
        
        <div id="root"></div>
        
        <component
            :bind="Footer"
            :index="/"
            :github="octancle"
            :twitter="octancle"
            :facebook="octancle"
            :instagram="octancle" />
        
        <script type="text/javascript" src="@RESOURCE_PATH;/script/octancle.js"></script>
        <script type="text/javascript">
            
            function navbarEvent() {
                document.getElementById( "navbar" ).classList.toggle( "show" );
                document.getElementById( "navbar-main" ).classList.toggle( "show" );
            }
            
            function navbarClose() {
                document.getElementById( "navbar-exit" ).onclick = navbarEvent;
                document.getElementById( "navbar-button" ).onclick = navbarEvent;
            }
            
            window.onload = function() {
                document.getElementById( "header-button" ).onclick = function() {
                    navbarEvent();
                    navbarClose();
                };
            };
            
        </script>
    </body>
</html>