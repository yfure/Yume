<!DOCTYPE html>
<html data-theme="dark">
    
    <head>
        
        <!-- Web Title -->
        <title> @\Yume\Func\config => ( "app.name" ); </title>
        
        <!-- Web Meta -->
        <meta charset="UTF-8" />
        <meta name="author" content="@\Yume\Func\config => ( "app.author.name" );" />
        <meta name="theme-color" content="#202521">
        <meta name="robots" content="noimageindex, noarchive" />
        <meta name="description" content="Stay connected together even if the distance separates you." />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
        
        <!-- Boxicons Library -->
        <link rel="stylesheet" href="https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css" />
        
        <!-- Swiper Library -->
        <link rel="stylesheet" href="https://unpkg.com/swiper@8.0.3/swiper-bundle.min.css " />
        
        <!-- Styles Library -->
        <link rel="stylesheet" href="@RESOURCE_PATH;/styles/octancle.css" />
        
        <!-- Styles Builtin -->
        <style type="text/css">@import[@RESOURCE_PATH;/styles/octancle-built{css}];</style>
        
        <!-- Mobile Console -->
        @import[@RESOURCE_PATH;/views/components/eruda{saimin}];
        
    </head>
    
    <body>
        
        <component:bind="Header" />
        
        <component
            :bind="Navbar"
            :sliding="right" />
        
        <div class="container home">
            <div class="single flex flex-center">
                <div class="single flex">
                    <div class="single dp-block mg-right-14">
                        <h1 class="title ff-lato">@\Yume\Func\config => ( "app.name" );</h1>
                        <p class="mg-top-14 fs-16">
                            Join and stay connected with friends, relatives and family even though distance separates you.
                        </p>
                    </div>
                    <div class="single dp-block">
                        <div class="card form">
                            <div class="card-parent pd-14 pd-top-0">
                                <form method="POST" id="signup" action="/signup/post">
                                    <div class="group">
                                        <label class="label">Username</label>
                                        <input class="input" type="text" id="name" name="username" value="hxari" />
                                    </div>
                                    <div class="group">
                                        <label class="label">Usermail</label>
                                        <input class="input" type="email" id="mail" name="usermail" value="ari160824@gmail.com" />
                                    </div>
                                    <div class="group">
                                        <label class="label">Password</label>
                                        <input class="input" type="password" id="pass" name="password" value="/hx.ari*160824" />
                                    </div>
                                    <div class="group mg-top-16">
                                        <input class="input submit" type="submit" value="Signup" />
                                    </div>
                                    <div class="group mg-top-16">
                                        <p class="fs-14">I have read and agree to all the terms and privacy policy of @\Yume\Func\config => ( "app.name" );</p>
                                    </div>
                                    <div class="group mg-top-10">
                                        <a class="fs-14" href="/signin">Already have an account</a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <component
            :bind="Footer"
            :index="/"
            :github="octancle"
            :twitter="octancle"
            :facebook="octancle"
            :instagram="octancle" />
        
        <script type="text/javascript">
            
            function navbarEvent()
            {
                document.getElementById( "navbar" ).classList.toggle( "show" );
                document.getElementById( "navbar-main" ).classList.toggle( "show" );
            }
            
            function navbarClose()
            {
                document.getElementById( "navbar-exit" ).onclick = navbarEvent;
                document.getElementById( "navbar-button" ).onclick = navbarEvent;
            }
            
            function isNameValid( name )
            {
                return( /^([a-z_][a-z0-9_\.]{1,28}[a-z0-9_])$/.test( name ) );
            }
            
            function isMailValid( mail )
            {
                return( /(?:[a-z0-9!#$%&'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*|"(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21\x23-\x5b\x5d-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])*")@(?:(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?|\[(?:(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.){3}(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?|[a-z0-9-]*[a-z0-9]:(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21-\x5a\x53-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])+)\])/.test( mail ) );
            }
            
            function isPassValid( pass )
            {
                return( /(((?=.*[a-z])(?=.*[A-Z]))|((?=.*[a-z])(?=.*[0-9]))|((?=.*[A-Z])(?=.*[0-9])))(?=.{6,})/.test( pass ) );
            }
            
            window.onload = function() {
                document.getElementById( "header-button" ).onclick = function( e ) {
                    navbarEvent();
                    navbarClose();
                };
                document.getElementById( "signup" ).onsubmit = function( e ) {
                    
                    var user = document.getElementById( "name" );
                    var mail = document.getElementById( "mail" );
                    var pass = document.getElementById( "pass" );
                    
                    if( isNameValid( user.value ) === false )
                    {
                        user.className = "input error"; return( e.preventDefault() );
                    } else {
                        user.className = "input";
                    }
                    if( isMailValid( mail.value ) === false )
                    {
                        mail.className = "input error"; return( e.preventDefault() );
                    } else {
                        mail.className = "input";
                    }
                    if( isPassValid( pass.value ) === false )
                    {
                        pass.className = "input error"; return( e.preventDefault() );
                    } else {
                        pass.className = "input";
                    }
                    
                };
            };
            
        </script>
    </body>
    
</html>