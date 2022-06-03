<div class="header">
    <div class="header-banner flex flex-left pd-10">
        <a href="/">
            <component
                :bind="Avatar" 
                :rad="@avatarRad; mg-right-14"
                :alt="@avatarAlt;"
                :src="@avatarSrc;" />
        </a>
        <button class="header-button rd-circle flex flex-center" id="header-button">
            <i class="bx bx-list-ul"></i>
        </button>
        <div class="header-content">
            <slot:name="default">Octancle</slot>
        </div>
    </div>
</div>
<div class="header-br"></div>