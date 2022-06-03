
#!- @author hxAri
#!- @create 05.02-2022
#!- @update 06.02-2022
#!- @github <https://github.com/hxAri>

<style type="text/css">
    
    .error::-webkit-scrollbar,
    .error .hidden .single::-webkit-scrollbar {
        width: 0;
    }
    .error {
        color: #842029;
        padding: 14px;
        background: #f8d7da;
        font-family: sans-serif;
        border-radius: 3px;
        border: 1px solid #f5c2c7;
    }
        .error .level {
            color: #6a1a21;
            font-weight: 650;
        }
        .error .hidden {
            height: 0;
            overflow: hidden;
            max-height: 0;
            transition: .3s all ease-in-out;
        }
            .error .hidden .single {
                padding: 14px;
                background: #ff9999;
                border-radius: 3px;
                margin-top: 14px;
            }
            .error .hidden .single:last-child {
                overflow-y: hidden;
                overflow-x: scroll;
            }
    .error:hover .hidden {
        height: auto;
        max-height: 100vh;
    }
    
</style>

<div class="error">
    <div class="message">
        <span class="level">@levl;:</span> @strg;
    </div>
    <div class="hidden">
        <div class="single">@code;</div>
        <div class="single">@line;</div>
        <div class="single">@file;</div>
    </div>
</div>