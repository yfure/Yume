<!DOCTYPE html>
<html>
    <head>
        <title>@html:String $title;</title>
    </head>
    <body>
        <div class="main">
            @def $users = [[ "fname" => "Chintya" ]]
            @each $users As $i => $user:
                @if $user['fname'] !== Null:
                    @if $user['fname'] === "Chintya":
                        Hi <b>160824020125</b>! Welcome to the board.
                    @else:
                        Gg bangsd!
                    @endl
                @else:
                @endl
            @endl
        </div>
    </body>
</html>