/*
 * @author hxAri
 * @create 25.03-2022
 * @update
 * @github https://github.com/hxAri
 *
 */
( function( root, factory ) {
    if( typeof define === "function" && define.amd ) {
        
        // AMD. Register as an anonymous module.
        define( ['b'], function( b ) {
            return( root.returnExportsGlobal = factory( b ) );
        });
    } else if( typeof module === "object" && module.exports ) {
        
        /*
         * Node. Does not work with strict CommonJS, but only
         * CommonJS-like environments that support module.exports,
         * like Node.
         */
        module.exports = factory( require( "b" ) );
    } else {
        
        // Browser globals
        root.returnExportsGlobal = factory( root.b );
    }
}( typeof Octancle !== "undefined" ? Octancle : this, function( b ) {
    
    // Application components.
    var Components = {};
    
    // Application utility.
    var Self = Octancle = {
        
        // Number utility.
        Number: {
            suffix: [
                "",  // Default
                "K", // Kilo
                "M", // Million
                "B", // Billion
                "T"  // Trillion
            ],
            suffixNum: function( n ) {
                return( Math.floor( ( "" + n ).length / 3 ) );
            },
            parseFloat: function( n, sN, pre ) {
                if( sN != 0 ) {
                    var f = n / Math.pow( 1000, sN );
                } else {
                    var f = n;
                }
                return( parseFloat( f.toPrecision( pre ) ) );
            },
            abbreviate: function( n ) {
                
                // Copy number.
                var newN = n;
                
                if( n >= 1000 ) {
                    
                    // Suffix number.
                    var suffixNum = this.suffixNum( n );
                    
                    // Short number.
                    var shortN = "";
                    
                    for( var pre = 2; pre >= 1; pre-- ) {
                        
                        // Pare float number.
                        shortN = this.parseFloat( n, suffixNum, pre );
                        
                        if( `${shortN}`.replace( /[^a-zA-Z 0-9]+/g,"" ).length <= 2 ) {
                            break;
                        }
                    }
                    if( shortN % 1 != 0 ) {
                        shortN = shortN.toFixed( 1 );
                    }
                    newN = shortN + this.suffix[suffixNum];
                }
                return newN;
            }
        },
        
        // Syntax utility.
        Syntax: {
            HTML: function( tag, attr, inner )
            {
                var el = "<";
                    el += tag;
                if( typeof attr !== "undefined" )
                {
                    for( let key in attr )
                    {
                        el += " ";
                        el += key;
                        el += "=\"";
                        if( key === "class" )
                        {
                            el += "mk-";
                        }
                        el += attr[key];
                        el += "\"";
                    }
                }
                el += ">";
                el += inner;
                el += "</";
                el += tag;
                el += ">";
                
                return el;
            },
            regexp: [
                {
                    name: "heading",
                    pattern: /[\t|\s|\n]+(#{1,6})\s(.*)/g,
                    replace: function( m, string )
                    {
                        if( m[1].length <= 6 )
                        {
                            return( string ).replace( m[0], Self.Syntax.HTML( "h" + m[1].length, { class: this.name }, m[2] ) )
                        }
                        return( string );
                    }
                },
                {
                    name: "bold-italic",
                    pattern: /(\*\_)+(\S+)(\_\*)+/g,
                    replace: function( m, string )
                    {
                        return( string ).replace( m[0], Self.Syntax.HTML( "span", { class: this.name }, m[2] ) );
                    }
                },
                {
                    name: "bold",
                    pattern: /(\*)+(\S+)(\*)+/g,
                    replace: function( m, string )
                    {
                        return( string ).replace( m[0], Self.Syntax.HTML( "span", { class: this.name }, m[2] ) );
                    }
                },
                {
                    name: "italic",
                    pattern: /(\_)+(\S+)(\_)+/g,
                    replace: function( m, string )
                    {
                        return( string ).replace( m[0], Self.Syntax.HTML( "span", { class: this.name }, m[2] ) );
                    }
                },
                {
                    name: "link",
                    pattern: /([\t|\s]*)\[([^\]]*)\]\((https?:\/\/(?:www\.|(?!www))[a-zA-Z0-9][a-zA-Z0-9-]+[a-zA-Z0-9]\.[^\s]{2,}|www\.[a-zA-Z0-9][a-zA-Z0-9-]+[a-zA-Z0-9]\.[^\s]{2,}|https?:\/\/(?:www\.|(?!www))[a-zA-Z0-9]+\.[^\s]{2,}|www\.[a-zA-Z0-9]+\.[^\s]{2,})\)/g,
                    replace: function( m, string )
                    {
                        if( m[2] !== "" )
                        {
                            return( string ).replace( m[0], Self.Syntax.HTML( "a", { class: this.name, href: m[3], target: "_blank", rel: "noopener noreferrer" }, m[1] + m[2] ) );
                        }
                        return( string );
                    },
                },
                {
                    name: "route",
                    pattern: /([\@|\#])\[([a-zA-Z_][a-zA-Z0-9_\.]{1,18}[a-zA-Z0-9_])\]/g,
                    replace: function( m, string )
                    {
                        var to = "/";
                        
                        if( m[1] === "#" )
                        {
                            to += "hashtag/";
                        }
                        return( string ).replace( m[0], Self.Syntax.HTML( "router-link", { to: to + m[2] }, m[1] + m[2] ) );
                    }
                },
                {
                    name: "code tokyo-night code-block",
                    pattern: /\`{3}([a-z0-9]+)\n(.*?)\n[\t]*\`{3}/gms,
                    replace: function( m, string )
                    {
                        return( string ).replace( m[0], Self.Syntax.HTML( "pre", { class: this.name }, hljs.highlight( m[2], { language: m[1] } ).value ) );
                    }
                },
                {
                    name: "code tokyo-night inline-code",
                    pattern: /\`{3}([a-z]+)\s(.*)\`{3}/g,
                    replace: function( m, string )
                    {
                        return( string ).replace( m[0], Self.Syntax.HTML( "span", { class: this.name }, hljs.highlight( m[2], { language: m[1] } ).value ) );
                    }
                },
                {
                    name: "code tokyo-night inline-code",
                    pattern: /\`{1}(.*)\`{1}/g,
                    replace: function( m, string )
                    {
                        return( string ).replace( m[0], Self.Syntax.HTML( "span", { class: this.name }, m[1] ) );
                    }
                },
                {
                    name: "line",
                    pattern: /(\=|\-|\*){3}/g,
                    replace: ( m, string ) => string.replace( m[0], "<hr class=\"mk-line\" />" )
                },
                {
                    name: "tabs",
                    pattern: /(\t)/g,
                    replace: function( m, string )
                    {
                        return( string ).replace( /\t/gms, "    " );
                    }
                },
                {
                    name: "break",
                    pattern: /(\n)/g,
                    replace: ( m, string ) => string.replace( /\n/g, "<br/>" )
                }
            ],
            compile: function( string )
            {
                for( let i in this.regexp )
                {
                    // New RegExp instance.
                    var regexp = new RegExp( this.regexp[i].pattern );
                    var result = null;
                    
                    while( result = regexp.exec( string ) )
                    {
                        string = this.regexp[i].replace( result, string );
                    }
                }
                return( string );
            }
        },
        
        // Object utility.
        Object: {
            
            // Object to string.
            string: ( e ) => Object.prototype.toString.call( e ).replace( /\[object\s*(.*?)\]/, `$1` ),
            is: {
                
                // If Object is defined.
                defined: ( e ) => Self.Object.string( e ) !== "Undefined",
                
                // If Object is integer.
                integer: ( e ) => Self.Object.string( e ) === "Number",
                
                // If Object is object.
                object: ( e ) => Self.Object.string( e ) === "Object",
                
                // If Object is array.
                array: ( e ) => Self.Object.string( e ) === "Array",
                
                // If Object is null.
                null: ( e ) => Self.Object.string( e ) === "Null"
                
            }
            
        },
        
        // Example users
        Users: [
            {
                id: 593065,
                account: {
                    private: true
                },
                contact: {
                    usermail: {
                        type: "private",
                        mail: null
                    },
                    usernumb: {
                        type: "private",
                        numb: null
                    }
                },
                profile: {
                    fullname: "Chintya",
                    username: "chintya",
                    abouts: {
                        profession: {
                            display: true,
                            value: "Pharmacology"
                        },
                        category: {
                            display: true,
                            value: "Personal Blog"
                        },
                        location: {
                            display: true,
                            value: "Indonesian"
                        },
                        company: {
                            display: true,
                            value: "Octancle"
                        },
                        verify: true,
                        about: "I'm not as cold as you think @[hxari]"
                    },
                    pictures: {
                        cover: {
                            type: "image",
                            href: "/storage/resource/image/chintya/1648558719;ebI1mKG6mJ.png"
                        },
                        main: {
                            type: "image",
                            href: "/storage/resource/image/chintya/1648558710;71jbAB9vnU.png"
                        }
                    }
                },
                website: [],
                socials: {
                    instagram: null,
                    whatsapp: null,
                    facebook: null,
                    twitter: null,
                    youtube: null,
                    github: null
                },
                section: {
                    posts: {
                        total: 1,
                        posts: []
                    },
                    charms: {
                        total: 6829757,
                        users: []
                    },
                    tagged: {
                        total: 0,
                        posts: []
                    },
                    bookmark: {
                        total: 0,
                        posts: []
                    },
                    followers: {
                        total: 195000,
                        users: [],
                    },
                    following: {
                        total: 1,
                        users: [
                            {
                                profile: {
                                    id: 593064,
                                    follback: true,
                                    username: "hxari",
                                    pictures: {
                                        main: {
                                            type: "image",
                                            href: "/storage/resource/image/chintya/1648558710;71jbAB9vnU.png"
                                        }
                                    },
                                    abouts: {
                                        verify: true
                                    }
                                }
                            }
                        ]
                    }
                }
            },
            {
                id: 593064,
                account: {
                    private: true
                },
                contact: {
                    usermail: {
                        type: "public",
                        mail: null
                    },
                    usernumb: {
                        type: "private",
                        numb: null
                    }
                },
                profile: {
                    fullname: "hxAri",
                    username: "hxari",
                    abouts: {
                        profession: {
                            display: true,
                            value: "Programmer"
                        },
                        category: {
                            display: true,
                            value: "Personal Blog"
                        },
                        location: {
                            display: true,
                            value: "Indonesian"
                        },
                        company: {
                            display: true,
                            value: "Octancle"
                        },
                        verify: true,
                        about: "Do you also think I'm cool @[chintya]"
                    },
                    pictures: {
                        cover: {
                            type: "image",
                            href: "/storage/resource/image/hxari/1646505419;b3Zr6ex5zl.jpg"
                        },
                        main: {
                            type: "image",
                            href: "/storage/resource/image/hxari/1642767906;89xm2c2YWw.jpg"
                        }
                    }
                },
                website: [],
                socials: {
                    instagram: null,
                    whatsapp: null,
                    facebook: null,
                    twitter: null,
                    youtube: null,
                    github: null
                },
                section: {
                    posts: {
                        total: 1,
                        posts: []
                    },
                    charms: {
                        total: 4829757,
                        users: []
                    },
                    tagged: {
                        total: 0,
                        posts: []
                    },
                    bookmark: {
                        total: 0,
                        posts: []
                    },
                    followers: {
                        total: 485000,
                        users: [],
                    },
                    following: {
                        total: 1,
                        users: [
                            {
                                profile: {
                                    id: 593065,
                                    follback: true,
                                    username: "chintya",
                                    pictures: {
                                        main: {
                                            type: "image",
                                            href: "/storage/resource/image/chintya/1648558710;71jbAB9vnU.png"
                                        }
                                    },
                                    abouts: {
                                        verify: true
                                    }
                                }
                            }
                        ]
                    }
                }
            }
        ],
        
        // Commponent get.
        Component: ( name ) => Self.Object.is.defined( Components[name] ) ? Components[name] : false,
        
        // Template get.
        Template: ( name ) => Self.Object.is.defined( Templates[name] ) ? Templates[name] : false,
        
    };
    
    try {
        
        /*
         * Image Avatar.
         *
         * @props String <rad>
         * @props String <alt>
         * @props String <src>
         */
        Components.Avatar = {
            props: [
                "rad",
                "alt",
                "src"
            ],
            methods: {
                radius: function() {
                    if( Self.Object.is.defined( this.rad ) ) {
                        return( `avatar rd-${this.rad} flex flex-center` );
                    } else {
                        return( "avatar rd-none flex flex-center" );
                    }
                }
            },
            template: `
                <div :class="radius()">
                    <img class="avatar-image" :src="src" :alt="alt" />
                    <div class="avatar-cover"></div>
                </div>
            `
        };
        
        Components.Verify = {
            template: `
                <p class="verify flex flex-center">
                    <i class="bx bx-check"></i>
                    <i class="bx bxs-certification"></i>
                </p>
            `
        };
        
        /*
         * Card.
         *
         * @props Int <headerPd>
         * @props Int <parentPd>
         * @props Int <footerPd>
         */
        Components.Card = {
            props: {
                headerPd: Number,
                parentPd: Number,
                footerPd: Number
            },
            methods: {
                padding: function( prefix, pd ) {
                    if( Self.Object.is.defined( pd ) ) {
                        return( prefix + " pd-" + pd );
                    }
                    return( prefix );
                }
            },
            template: `
                <div class="card">
                    <div :class="padding( 'card-header', headerPd )">
                        <slot name="header"></slot>
                    </div>
                    <div :class="padding( 'card-parent', parentPd )">
                        <slot name="default"></slot>
                    </div>
                    <div :class="padding( 'card-footer', footerPd )">
                        <slot name="footer"></slot>
                    </div>
                </div>
            `
        };
        
        /*
         * Short text length.
         *
         * @props String <text>
         * @props Int <max>
         * @props Int <min>
         */
        Components.ShortText = {
            data: function() {
                return({
                    short: null,
                    shortString: false,
                    shortLength: false
                });
            },
            props: [
                "text",
                "max"
            ],
            mounted: function() {
                this.substr();
            },
            methods: {
                substr: function() {
                    if( Self.Object.is.defined( this.text ) && 
                        Self.Object.is.defined( this.max ) ) {
                        if( this.text.length > this.max ) {
                            this.short = this.text.substr( 0, this.max );
                            this.shortString = true;
                            this.shortLength = true;
                        } else {
                            this.short = this.text;
                        }
                    }
                },
                click: function() {
                    this.short = this.text;
                    this.shortLength = false;
                }
            },
            template: `
                <div class="short-text">
                    {{ short }}
                    <span v-if="shortString && shortLength" v-on:click="click" class="short-text-view">....</span>
                    <p v-if="shortString && shortLength !== true " v-on:click="substr" class="short-text-hidden">
                        Short text.
                    </p>
                </div>
            `
        };
        
        Components.TokyoNight = {
            data: () => {
                return({
                    className: "*"
                });
            },
            props: {
                pre: Boolean,
                lang: String,
                code: String
            },
            methods: {
                self: function() {
                    
                    var code = this.lang ? hljs.highlight( this.code, { language: this.lang } ) : this.code;
                    
                    if( this.pre ) {
                        return({
                            template: `<pre class="tokyo-night">${code}</pre>`
                        });
                    }
                    return({
                        template: `<span class="tokyo-night">${code}</span>`
                    });
                }
            },
            template: `<component :is="self"></component>`
        };
        
        Components.Markdown = {
            data: () => {
                return({
                    shorted: {
                        short: null,
                        shortString: false,
                        shortLength: false
                    },
                    syntax: [
                        {
                            search: /\`\`\`([a-z0-9]+)([\s|\n|\t]+)(.*?)\`\`\`|\`(.*?)\`/gs,
                            methods: {
                                block: function( lang, code, pre ) {
                                    
                                    code = lang ? hljs.highlight( code, { language: lang } ).value : code;
                                    
                                    if( pre ) {
                                        return( `<pre class="tokyo-night">${code}</pre>` );
                                    }
                                    return( `<span class="tokyo-night">${code}</span>` );
                                }
                            },
                            handler: function( result, string ) {
                                
                                var code = "";
                                
                                if( Self.Object.is.defined( result[1] ) ) {
                                    if( result[2].match( /\n/gs ) ) {
                                        code = this.methods.block( result[1], result[3], true );
                                    } else {
                                        code = this.methods.block( result[1], result[3], false );
                                    }
                                } else {
                                    code = `<span class="tokyo-night">${result[4]}</span>`;
                                }
                                return( string.replace( result[0], code ) );
                            }
                        },
                        {
                            search: /\n/g,
                            replace: "<br/>"
                        },
                        {
                            search: /\*(.*?)\*/g,
                            replace: `<span class="fb-45">$1</span>`
                        },
                        {
                            search: /\_(.*?)\_/g,
                            replace: `<span class="fs-italic">$1</span>`
                        },
                        {
                            search: /\[\s*bx\:\:(bxs|bx)\-([a-z0-9\-]+)\s*\]/gi,
                            handler: ( result, string ) => string.replace( result[0], `<i class="bx ${result[1]}-${result[2]}"></i>` )
                        },
                        {
                            search: /\#([a-zA-Z_][a-zA-Z0-9_\.]{1,28}[a-zA-Z0-9_])/g,
                            replace: `<router-link to="/tags/$1">#$1</router-link>`
                        },
                        {
                            search: /\@([a-zA-Z_][a-zA-Z0-9_\.]{1,18}[a-zA-Z0-9_])/g,
                            replace: `<router-link to="/$1">@$1</router-link>`
                        },
                        {
                            search: /\[([^\]]*)\]\((https?:\/\/(?:www\.|(?!www))[a-zA-Z0-9][a-zA-Z0-9-]+[a-zA-Z0-9]\.[^\s]{2,}|www\.[a-zA-Z0-9][a-zA-Z0-9-]+[a-zA-Z0-9]\.[^\s]{2,}|https?:\/\/(?:www\.|(?!www))[a-zA-Z0-9]+\.[^\s]{2,}|www\.[a-zA-Z0-9]+\.[^\s]{2,})\)/gi,
                            replace: `<a href="$2" target="_blank_">$1</a>`
                        },
                        {
                            search: /\[(chintya|hxari|octancle|yume)\]/gi,
                            replace: `<button class="keyword fb-45" @click="event">$1</button>`
                        }
                    ],
                    regexp: [],
                });
            },
            props: {
                short: Number,
                string: String
            },
            computed: {
                view() {
                    return( this.compile() );
                }
            },
            methods: {
                compile: function() {
                    return({
                        methods: {
                        },
                        template: `<div class="single markdown">${Self.Syntax.compile( this.string )}</div>`
                    });
                }
            },
            template: '<component :is="view"></component>'
        };
        
        Components.Shorts = {
            data: () => {
                return({
                    self: null
                });
            },
            created: function() {
                this.self = Self.Users[0];
            },
            computed: {
                ...Vuex.mapGetters({
                    logged: "is",
                    user: "user"
                })
            },
            template: `
                <div class="template">
                    <div class="shorts-br dp-none"></div>
                    <div class="shorts dp-none" v-if="logged">
                        <button class="single box flex flex-center">
                            <router-link to="/">
                                <i class="bx bxs-dashboard fs-28"></i>
                            </router-link>
                        </button>
                        <button class="single box flex flex-center">
                            <router-link to="/">
                                <i class="bx bx-search fs-28"></i>
                            </router-link>
                        </button>
                        <button class="single box flex flex-center">
                            <router-link to="/">
                                <i class="bx bx-plus fs-28"></i>
                            </router-link>
                        </button>
                        <button class="single box flex flex-center">
                            <router-link to="/">
                                <i class="bx bx-bell fs-28"></i>
                            </router-link>
                        </button>
                        <button class="single box flex flex-center">
                            <router-link :to="{ path: self.profile.username }">
                                <i class="bx bx-user fs-28"></i>
                            </router-link>
                        </button>
                    </div>
                    <div class="shorts dp-none" v-else-if="( $route.path !== '/signup' && $route.path !== '/signin' )">
                        <router-link to="/signup">
                            <button class="single box signup flex flex-center fs-16 pd-14 rd-square fb-45">
                                Signup
                            </button>
                        </router-link>
                    </div>
                </div>
            `
        };
        
        Components.Swiper = {
            data: function() {
                return {
                    slider: null,
                    swiper: null
                };
            },
            props: {
                options: Object
            },
            mounted: function() {
                this.swiper = new Swiper( this.$refs.swiper, this.options );
            },
            methods: {
                next: function() {
                    this.slider.slideNext();
                }
            },
            template: `
                <div class="swiper">
                    <slot name="header"></slot>
                    <div class="swiper-container" ref="swiper">
                        <div class="swiper-wrapper">
                            <slot name="default"></slot>
                        </div>
                    </div>
                    <slot name="footer"></slot>
                </div>
            `
        };
        
        Components.Footer = {
            template: `
                <div class="footer">
                    <div class="deep">
                        <div class="line-up dp-flex">
                            <div class="single">
                                <h5 class="mg-bottom-8">Pages</h5>
                                <p class="fc-1m">Some important pages.</p>
                                <li class="li dp-inline-block mg-right-10">
                                    <a href="/" class="fs-14 fc-0m">Home</a>
                                </li>
                                <li class="li dp-inline-block mg-right-10">
                                    <a href="/about" class="fs-14 fc-0m">About</a>
                                </li>
                                <li class="li dp-inline-block mg-right-10">
                                    <a href="/contact" class="fs-14 fc-0m">Contact</a>
                                </li>
                                <li class="li dp-inline-block mg-right-10">
                                    <a href="/privacy" class="fs-14 fc-0m">Privacy</a>
                                </li>
                                <li class="li dp-inline-block mg-right-10">
                                    <a href="/sitemap" class="fs-14 fc-0m">Sitemap</a>
                                </li>
                            </div>
                            <div class="single">
                                <h5 class="mg-bottom-8">Follow us</h5>
                                <p class="fc-1m">Stay connected with us.</p>
                                <li class="li dp-inline-block mg-right-10">
                                    <a href="https://instagram.com/octancle">
                                        <i class="bx bxl-instagram"></i>
                                    </a>
                                </li>
                                <li class="li dp-inline-block mg-right-10">
                                    <a href="https://facebook.com/octancle">
                                        <i class="bx bxl-facebook-square"></i>
                                    </a>
                                </li>
                                <li class="li dp-inline-block mg-right-10">
                                    <a href="https://twitter.com/octancle">
                                        <i class="bx bxl-twitter"></i>
                                    </a>
                                </li>
                                <li class="li dp-inline-block">
                                    <a href="https://github.com/octancle">
                                        <i class="bx bxl-github"></i>
                                    </a>
                                </li>
                            </div>
                        </div>
                        <div class="single">
                            <p class="fs-14 fc-1m">&copy <a class="fc-1m" href="/">Octancle</a> 2022</p>
                        </div>
                    </div>
                </div>
            `
        };
        
        Components.Signin = {
            data: function() {
                return({
                    input: {
                        username: "",
                        password: ""
                    },
                    error: null
                });
            },
            methods: {
                submit: function() {
                    this.$store
                        .dispatch( "signin", input )
                        .then( function( r ) {
                            console.log( r );
                            this.$router.push({
                                name: "home"
                            });
                        })
                        .catch( function( e ) {
                            this.error = error.response.data.errors;
                        });
                }
            }
        };
        
        Components.Signup = {
            data: function() {
                return({
                    image: "/storage/resource/image/default/1648811634;ec5xuiZBpV.jpg",
                    input: {
                        usermail: "",
                        username: "",
                        password: ""
                    },
                    error: null
                });
            },
            methods: {
                submit: function() {
                    this.$store
                        .dispatch( "signup", input )
                        .then( function( r ) {
                            console.log( r );
                            this.$router.push({
                                name: "home"
                            });
                        })
                        .catch( function( e ) {
                            this.error = error.response.data.errors;
                        });
                }
            },
            components: {
                Avatar: Components.Avatar
            },
            template: `
                <div class="signup">
                    <div class="counter flex flex-center">
                        <div class="single content dp-flex">
                            <div class="def-image">
                                <Avatar :src="image" alt="Cover" />
                            </div>
                            <div class="group content">
                                <div class="single image">
                                    <Avatar :src="image" alt="Octancle" />
                                </div>
                                <div class="form">
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            `
        };
        
        Components.Post = {
            data: () => {
                return({
                    post: {
                        // Random id string.
                        id: "gmgm97h",
                        
                        // Random url string.
                        url: "Cbk3QDdpr2V",
                        
                        // User data embeded.
                        author: {
                            id: 593065,
                            profile: {
                                fullname: "Chintya",
                                username: "chintya",
                                contact: [],
                                abouts: {
                                    category: "Personal Blog",
                                    location: "Indonesian",
                                    company: "Octancle",
                                    verify: true,
                                    about: "I'm not as cold as you think @[hxari]"
                                },
                                cover: {
                                    type: "image",
                                    href: "/storage/resource/image/chintya/1648558719;ebI1mKG6mJ.png"
                                },
                                main: {
                                    type: "image",
                                    href: "/storage/resource/image/chintya/1648558710;71jbAB9vnU.png"
                                }
                            }
                        },
                        
                        // Datetime post info.
                        create: 0,
                        update: 0,
                        
                        // Post actions.
                        action: {
                            react: {
                                total: 36143,
                                users: []
                            },
                            repost: {
                                total: 0,
                                users: []
                            },
                            comment: {
                                total: 2565,
                                users: []
                            },
                            removed: {
                                remove: false,
                                expire: 0
                            }
                        },
                        
                        // Post captions.
                        caption: "Silence in the *crowd*, love @[hxari] [Link](https://hxari.github.io) ```py\nfor i in range( 100 ):\n  print( \"Hello World!\" )\n```",
                        
                        // Post contents.
                        content: [
                            {
                                type: "image",
                                href: "/storage/resource/image/chintya/1648558706;367s94jvId.png"
                            },
                            {
                                type: "image",
                                href: "/storage/resource/image/chintya/1648558679;edWbK.WIHg.png"
                            },
                            {
                                type: "image",
                                href: "/storage/resource/image/chintya/1648558696;954zDWgBMR.png"
                            },
                            {
                                type: "image",
                                href: "/storage/resource/image/chintya/1648558702;995nez88AI.png"
                            },
                            {
                                type: "image",
                                href: "/storage/resource/image/chintya/1648558710;71jbAB9vnU.png"
                            },
                            {
                                type: "image",
                                href: "/storage/resource/image/chintya/1648558714;14BR7tzohV.png"
                            },
                            {
                                type: "image",
                                href: "/storage/resource/image/chintya/1648558719;ebI1mKG6mJ.png"
                            }
                        ]
                    },
                    swiper: {
                        lazy: true,
                        zoom: true,
                        autoHeight: true,
                        pagination: {
                            el: ".swiper-pagination",
                            clickable: true,
                            dynamicBullets: true,
                            /** type: "fraction", */
                            renderBullet: function( index, className ) {
                                return `<span class="${className} rd-circle"></span>`;
                            }
                        }
                    }
                });
            },
            mounted: function() {
            },
            methods: {
                total: function( n ) {
                    return( Self.Number.abbreviate( n ) );
                },
                path: function( url ) {
                    return( `/${url}` );
                },
                test: function() {
                    
                }
            },
            computed: {
                ...Vuex.mapGetters({
                    logged: "is",
                    user: "user"
                })
            },
            components: {
                Avatar: Components.Avatar,
                Card: Components.Card,
                Markdown: Components.Markdown,
                Swiper: Components.Swiper,
                Verify: Components.Verify
            },
            template: `
                <div class="post container">
                    <div class="single">
                        <Card :headerPd="10">
                            <template v-slot:header>
                                <router-link :to="{ path: '/' + post.author.profile.username }">
                                    <Avatar rad="circle" :src="post.author.profile.main.href" />
                                </router-link>
                                <router-link :to="{ path: '/' + post.author.profile.username }" class="mg-left-14 fc-1m">
                                    <p class="card-title fb-45">{{ post.author.profile.username }}</p>
                                </router-link>
                                <Verify v-if="post.author.profile.abouts.verify" />
                                <button class="single button flex">
                                    <i class="bx bx-dots-horizontal-rounded fs-28"></i>
                                </button>
                            </template>
                            <template v-slot:default>
                                <Swiper :options="swiper">
                                    <template v-slot:default>
                                        <div class="swiper-slide" v-for="( image, i ) in post.content">
                                            <Avatar :src="image.href" :alt="post.caption" />
                                        </div>
                                    </template>
                                    <template v-slot:footer>
                                        <div class="swiper-pagination"></div>
                                    </template>
                                </Swiper>
                                <!--<Avatar :src="post.content[0].href" />-->
                            </template>
                            <template v-slot:footer>
                                <div class="group action flex pd-14">
                                    <button class="single button flex mg-right-14">
                                        <i class="bx bxs-heart fs-28"></i>
                                    </button>
                                    <button class="single button flex mg-right-14">
                                        <i class="bx bx-message-rounded fs-28"></i>
                                    </button>
                                    <button class="single button flex mg-right-14">
                                        <i class="bx bxs-bookmark fs-28"></i>
                                    </button>
                                    <button class="single button flex">
                                        <i class="bx bx-bar-chart fs-28"></i>
                                    </button>
                                </div>
                                <div class="single totals pd-left-14 pd-right-14 fc-1m" v-if="( post.action.react.total !== 0 )">
                                    <p v-if="( post.action.comment.total !== 0 )">
                                        <span class="fb-45">{{ total( post.action.react.total ) }}</span> Likes · <span class="fb-45">{{ total( post.action.comment.total ) }}</span> Comments
                                    </p>
                                    <p v-else>
                                        <span class="fb-45">{{ total( post.action.react.total ) }}</span> Likes
                                    </p>
                                </div>
                                <div class="single totals pd-left-14 pd-right-14 fc-1m" v-else>
                                    <p v-if="( post.action.comment.total !== 0 )">
                                        <span class="fb-45">{{ total( post.action.comment.total ) }}</span> Comments
                                    </p>
                                </div>
                                <div class="single caption pd-14 pd-top-0">
                                    <Markdown :short="18" :string="post.caption" v-if="post.caption" />
                                </div>
                            </template>
                        </Card>
                    </div>
                </div>
            `
        };
        
        Components.Profile = {
            data: () => {
                return({
                    self: null
                });
            },
            created: function() {
                for( let i in Self.Users ) {
                    if( this.$route.params.profile === Self.Users[i].profile.username ) {
                        this.self = Self.Users[i]; break;
                    }
                }
            },
            methods: {
                route: function( to ) {
                    return( "/" + this.$route.params.profile + to );
                },
                total: function( n ) {
                    return( Self.Number.abbreviate( n ) );
                }
            },
            computed: {
                ...Vuex.mapGetters({
                    logged: "is",
                    user: "user"
                })
            },
            components: {
                Avatar: Components.Avatar,
                Verify: Components.Verify,
                Markdown: Components.Markdown,
                ShortText: Components.ShortText
            },
            beforeRouteUpdate: function( to, from ) {
                if( Self.Object.is.defined( to.params.profile ) && to.params.profile ) {
                    if( this.self.profile.username !== to.params.profile ) {
                        for( let i in Self.Users ) {
                            if( to.params.profile === Self.Users[i].profile.username ) {
                                this.self = Self.Users[i]; break;
                            }
                        }
                    }
                }
            },
            template: `
                <div class="profile">
                    <div class="parent">
                        <div class="profile-cover">
                            <Avatar
                                alt="Profile Cover" 
                                :src="self.profile.pictures.cover.href" />
                        </div>
                        <div class="common dp-flex">
                            <div class="section-1x mg-right-20">
                                <div class="sideways">
                                    <div class="profile-picture flex flex-center">
                                        <div class="border rd-circle flex flex-center">
                                            <div class="padding rd-circle flex flex-center">
                                                <Avatar
                                                    rad="circle"
                                                    alt="Profile Picture" 
                                                    :src="self.profile.pictures.main.href" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="group detail dp-none">
                                        <div class="single">
                                            <p class="text fb-55 fs-16 fc-1m">{{ total( self.section.posts.total ) }}</p>
                                            <p class="text">Post</p>
                                        </div>
                                        <div class="single">
                                            <p class="text fb-55 fs-16 fc-1m">{{ total( self.section.followers.total ) }}</p>
                                            <p class="text">Followers</p>
                                        </div>
                                        <div class="single">
                                            <p class="text fb-55 fs-16 fc-1m">{{ total( self.section.following.total ) }}</p>
                                            <p class="text">Following</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="group abouts">
                                    <p class="fullname ff-lato flex fs-24 fb-55 fc-1m mg-0">
                                        {{ self.profile.fullname }} <Verify v-if="self.profile.abouts.verify" />
                                    </p>
                                    <p class="username ff-lato fs-20 fb-35">
                                        {{ self.profile.username }}
                                    </p>
                                    <div class="group info ff-lato mg-top-8">
                                        <Markdown :string="self.profile.abouts.about" />
                                    </div>
                                    <hr class="single hr mg-top-10 mg-bottom-10" />
                                    <div class="group info dp-flex" v-if="self.profile.abouts.profession.display">
                                        <div class="icon flex flex-center mg-right-8">
                                            <i class="bx bx-task fs-18"></i>
                                        </div>
                                        <div class="text">
                                            {{ self.profile.abouts.profession.value }}
                                        </div>
                                    </div>
                                    <div class="group info dp-flex mg-top-8" v-if="self.profile.abouts.company.display">
                                        <div class="icon flex flex-center mg-right-8">
                                            <i class="bx bx-building fs-18"></i>
                                        </div>
                                        <div class="text">
                                            {{ self.profile.abouts.company.value }}
                                        </div>
                                    </div>
                                    <div class="group info dp-flex mg-top-8" v-if="self.profile.abouts.location.display">
                                        <div class="icon flex flex-center mg-right-8">
                                            <i class="bx bx-map fs-18"></i>
                                        </div>
                                        <div class="text">
                                            {{ self.profile.abouts.location.value }}
                                        </div>
                                    </div>
                                    <div class="group info dp-flex mg-top-8">
                                        <div class="icon flex flex-center mg-right-8">
                                            <i class="bx bx-link fs-18"></i>
                                        </div>
                                        <div class="text">
                                            <a href="https://octancle.com" target="__blank__">link</a>
                                        </div>
                                    </div>
                                    <div class="options group flex mg-top-12">
                                        <button class="follow single flex flex-center fb-45 pd-10">
                                            Follow
                                        </button>
                                        <button class="option single flex flex-center fb-45 pd-10">
                                            <i class="bx bx-dots-horizontal-rounded"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="section-2x">
                                <div class="tabs group flex flex-center">
                                    <router-link :to="route( '' )">
                                        <div class="tab single flex flex-center fb-45 fc-0m">Posts</div>
                                    </router-link>
                                    <router-link :to="route( '/charms' )">
                                        <div class="tab single flex flex-center fb-45 fc-0m">Charms</div>
                                    </router-link>
                                    <router-link :to="route( '/tagged' )">
                                        <div class="tab single flex flex-center fb-45 fc-0m">Tagged</div>
                                    </router-link>
                                    <router-link :to="route( '/insight' )">
                                        <div class="tab single flex flex-center fb-45 fc-0m">Insight</div>
                                    </router-link>
                                    <router-link :to="route( '/followers' )">
                                        <div class="tab single flex flex-center fb-45 fc-0m">Followers</div>
                                    </router-link>
                                    <router-link :to="route( '/following' )">
                                        <div class="tab single flex flex-center fb-45 fc-0m">Following</div>
                                    </router-link>
                                </div>
                                <router-view v-slot="{ Component }">
                                    <Transition name="slide">
                                        <component :is="Component" />
                                    </Transition>
                                </router-view>
                            </div>
                        </div>
                    </div>
                </div>
            `
        };
        
        Components.ProfilePosts = {
            data: function() {
                return({
                    self: {
                        username: "octancle",
                        following: false
                    },
                    click: [],
                    swipe: false,
                    posts: [
                        {
                            // Random id string.
                            id: "gmgm97h",
                            
                            // Random url string.
                            url: "Cbk3QDdpr2V",
                            
                            // User data embeded.
                            author: {
                                profile: {
                                    fullname: "Chintya",
                                    username: "chintya"
                                }
                            },
                            
                            // Datetime post info.
                            create: 0,
                            update: 0,
                            
                            // Post actions.
                            action: {
                                react: {
                                    total: 36143,
                                    users: []
                                },
                                repost: {
                                    total: 0,
                                    users: []
                                },
                                comment: {
                                    total: 255,
                                    users: []
                                },
                                removed: {
                                    remove: false,
                                    expire: 0
                                }
                            },
                            
                            // Post captions.
                            caption: "Silence in the crowd.",
                            
                            // Post contents.
                            content: [
                                {
                                    type: "image",
                                    href: "/storage/resource/image/chintya/1648558706;367s94jvId.png"
                                },
                                {
                                    type: "image",
                                    href: "/storage/resource/image/chintya/1648558679;edWbK.WIHg.png"
                                },
                                {
                                    type: "image",
                                    href: "/storage/resource/image/chintya/1648558696;954zDWgBMR.png"
                                },
                                {
                                    type: "image",
                                    href: "/storage/resource/image/chintya/1648558702;995nez88AI.png"
                                },
                                {
                                    type: "image",
                                    href: "/storage/resource/image/chintya/1648558710;71jbAB9vnU.png"
                                },
                                {
                                    type: "image",
                                    href: "/storage/resource/image/chintya/1648558714;14BR7tzohV.png"
                                },
                                {
                                    type: "image",
                                    href: "/storage/resource/image/chintya/1648558719;ebI1mKG6mJ.png"
                                }
                            ]
                        }
                    ]
                });
            },
            mounted: function() {
                //this.click = this.posts[0];
            },
            computed: {
                ...Vuex.mapGetters({
                    logged: "is",
                    user: "user"
                })
            },
            methods: {
                path: function( url ) {
                    return( `/p/${url}` );
                }
            },
            components: {
                Avatar: Components.Avatar
            },
            template: `
                <div class="wrapper posts">
                    <div class="contents dp-flex">
                        <div class="single content" v-for="( post, i ) in posts">
                            <router-link :to="path( post.url )">
                                <Avatar
                                    :alt="post.caption"
                                    :src="post.content[0].href" />
                            </router-link>
                        </div>
                    </div>
                </div>
            `
        };
        
        Components.ProfileInsight = {
            template: `
                <div class="wrapper insight">
                    Insight
                </div>
            `
        };
        
        /*
         * Make a global request endpoint by
         * Setting the default axios baseURL.
         */
        axios.defaults.baseURL = "http://localhost:8082/api/";
        
        var Util = {
            Auth: {
                
                // Set header authentication token.
                setHeaderToken: ( token ) => axios.defaults.headers.common['Authorization'] = `Bearer ${token}`,
                
                // Remove header authentication token.
                removeHeaderToken: () => delete axios.defaults.headers.common['Authorization']
                
            }
        };
        
        // Create vue store application.
        var Store = new Vuex.Store({
            state: {
                user: null,
                logged: false
            },
            mutations: {
                set: function( state, user ) {
                    state.user = user;
                    state.logged = true;
                },
                res: function( state ) {
                    state.user = null;
                    state.logged = false;
                }
                
            },
            getters: {
                is: function( state ) {
                    return( state.logged );
                },
                user: function( state ) {
                    return( state.user );
                }
            },
            actions: {
                signin: function( { dispatch, commit }, data ) {
                    return new Promise( function( resolve, reject ) { 
                        axios
                            .post( "signin", data )
                            .then( function( r ) {
                                const token = r.data.token;
                                localStorage.setItem( "token", token ) ;
                                Util.Auth.setHeaderToken( token );
                                dispatch( "get" );
                                resolve( r );
                            })
                            .catch( function( e ) {
                                commit( "res" );
                                localStorage.removeItem( "token" );
                                reject( e );
                            });
                    });
                },
                signup: function( {commit}, data ) {
                    return new Promise( function( resolve, reject ) { 
                        axios
                            .post( "signup", data )
                            .then( function( r ) { 
                                resolve( r );
                            })
                            .catch( function( e ) {
                                commit( "res" ); 
                                reject( e );
                            });
                    });
                },
                logout: function( {commit} ) {
                    return new Promise( function( resolve ) {
                        commit( "res" );
                        localStorage.removeItem( "token" );
                        Util.Auth.removeHeaderToken();
                        resolve();
                    });
                },
                get: async function( {commit} ) {
                    if( Cookies.get( "token" ) === "undefined" ) {
                        return;
                    }
                    try { 
                        
                        // Get user data.
                        let response = await axios.get( "user" );
                        
                        // Commits with the Store for the user data set.
                        commit( "set", response.data.data );
                        
                    } catch( e ) {
                        
                        // Commit the Store to reset the data.
                        commit( "res" );
                        
                        // Remove header token user.
                        Util.Auth.removeHeaderToken();
                        Cookies.remove( "token" );
                        
                        return e;
                    }
                }
            }
        });
        
        var token = localStorage.getItem( "token" );
        
        if( token ) {
            Util.Auth.setHeaderToken( token );
        }
        
        // Create the router instance.
        var Router = VueRouter.createRouter({
            
            // Provide the history implementation to use.
            history: VueRouter.createWebHistory(),
            
            // Define some routes.
            // Each route should map to a component.
            routes: [
                {
                    name: "signin",
                    path: "/signin",
                    meta: {
                        guest: true
                    },
                    component: Components.Signin
                },
                {
                    name: "signup",
                    path: "/signup",
                    meta: {
                        guest: true
                    },
                    component: Components.Signup
                },
                {
                    name: "/post",
                    path: "/p/:url",
                    meta: {
                        auth: true,
                        guest: true
                    },
                    component: Components.Post
                },
                {
                    name: "profile",
                    path: "/:profile",
                    meta: {
                        auth: true,
                        guest: true
                    },
                    component: Components.Profile,
                    children: [
                        {
                            path: "",
                            component: Components.ProfilePosts
                        },
                        {
                            path: "posts",
                            component: Components.ProfilePosts
                        },
                        {
                            path: "charms",
                            component: {
                                template: `
                                    <div class="wrapper">
                                        {{ $route.path }}
                                    </div>
                                `
                            }
                        },
                        {
                            path: "tagged",
                            component: {
                                template: `
                                    <div class="wrapper">
                                        {{ $route.path }}
                                    </div>
                                `
                            }
                        },
                        {
                            path: "insight",
                            component: Components.ProfileInsight
                        },
                        {
                            path: "followers",
                            component: {
                                template: `
                                    <div class="wrapper">
                                        {{ $route.path }}
                                    </div>
                                `
                            }
                        },
                        {
                            path: "following",
                            component: {
                                template: `
                                    <div class="wrapper">
                                        {{ $route.path }}
                                    </div>
                                `
                            }
                        }
                    ]
                }
            ]
            
        });
        
        // Create router navigation guard.
        Router.beforeEach( function( to, from, next ) {
            if( to.matched.some( record => record.meta.auth ) ) {
                if( Store.getters.logged && Store.getters.user ) {
                    next();
                } else {
                    if( to.matched.some( record => record.meta.guest ) ) {
                        next();
                    } else {
                        next( "/signin" );
                    }
                }
            } else {
                if( to.matched.some( record => record.meta.guest ) ) {
                    if( Store.getters.logged === false ) {
                        next();
                    } else {
                        next();
                    }
                } else {
                    next();
                }
            }
        });
        
        // Add event listener when the windows is loaded.
        window.addEventListener( "load", function() {
            
            // Dispatch store.
            Store
                .dispatch( "get", token )
                .then( function() {
                    
                    // Create and mount the root instance.
                    var Root = Vue.createApp({
                        data: () => {
                            return({
                                avatar: "https://cdn-icons-png.flaticon.com/512/2885/2885034.png"
                            });
                        },
                        components: {
                            Avatar: Components.Avatar,
                            Footer: Components.Footer,
                            Shorts: Components.Shorts
                        },
                        template: `
                            <div class="template">
                                <div class="group" v-if="( $route.path !== '/signup' && $route.path !== '/signin' )">
                                    <div class="header">
                                        <div class="header-banner flex flex-left pd-14">
                                            <router-link to="/" class="mg-right-14">
                                                <Avatar rad="circle" :src="avatar" alt="Octancle" />
                                            </router-link>
                                            <Shorts />
                                            <button class="single button chat">
                                                <i class="bx bx-paper-plane fc-1m fs-28"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="header-br"></div>
                                </div>
                                <router-view />
                                <Footer />
                                <Shorts />
                            </div>
                        `
                    });
                    
                    // Make sure to use module.
                    Root.use( Store );
                    Root.use( Router );
                    
                    // Root element by id.
                    Root.mount( "#root" );
                    
                })
                .catch( function( e ) {
                    throw e;
                });
                
        });
        
    } catch( e ) {
        document.getElementById( "root" ).innerHTML = Self.Object.string( e ) + ": " + e.message;
    }
    
    return({});
    
}));