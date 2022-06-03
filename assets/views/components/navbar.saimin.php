<div class="navbar @sliding;" id="navbar">
    <div class="navbar-exit" id="navbar-exit"></div>
    <div class="navbar-main" id="navbar-main">
        <div class="navbar-header pd-10">
            <button class="navbar-button flex flex-center" id="navbar-button">
                <i class="bx bx-x"></i>
            </button>
        </div>
        <div class="navbar-parent">
            <slot:name="default">
                Content
            </slot>
        </div>
    </div>
</div>