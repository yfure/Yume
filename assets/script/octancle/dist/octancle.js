/*
 * @author hxAri
 * @create 25.03-2022
 * @update
 * @github https://github.com/hxAri
 *
 */
( function( root, factory )
{
    if( typeof define === "function" && define.amd )
    {
        // AMD. Register as an anonymous module.
        define( ['b'], function( b )
        {
            return( root.returnExportsGlobal = factory( b ) );
        });
    } else
    if( typeof module === "object" && module.exports )
    {
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
    var Self = Octancle =
    {
        // Number utility.
        Number: {
            suffix: [
                "",  // Default
                "K", // Kilo
                "M", // Million
                "B", // Billion
                "T"  // Trillion
            ],
            suffixNum: ( n ) => Math.floor( ( "" + n ).length / 3 ),
            parseFloat: function( n, sN, pre )
            {
                if( sN != 0 )
                {
                    var f = n / Math.pow( 1000, sN );
                } else {
                    var f = n;
                }
                return( parseFloat( f.toPrecision( pre ) ) );
            },
            abbreviate: function( n )
            {
                // Copy number.
                var newN = n;
                
                if( n >= 1000 )
                {
                    // Suffix number.
                    var suffixNum = this.suffixNum( n );
                    
                    // Short number.
                    var shortN = "";
                    
                    for( var pre = 2; pre >= 1; pre-- )
                    {
                        // Pare float number.
                        shortN = this.parseFloat( n, suffixNum, pre );
                        
                        if( `${shortN}`.replace( /[^a-zA-Z 0-9]+/g,"" ).length <= 2 )
                        {
                            break;
                        }
                    }
                    if( shortN % 1 != 0 )
                    {
                        shortN = shortN.toFixed( 1 );
                    }
                    newN = shortN + this.suffix[suffixNum];
                }
                return newN;
            }
        },
        
        // Pattern Utility
        Pattern: {
            User: {
                mail: /(?:[a-z0-9!#$%&'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*|"(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21\x23-\x5b\x5d-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])*")@(?:(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?|\[(?:(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.){3}(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?|[a-z0-9-]*[a-z0-9]:(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21-\x5a\x53-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])+)\])/,
                name: /^([a-z_][a-z0-9_\.]{1,28}[a-z0-9_])$/,
                pass: /(((?=.*[a-z])(?=.*[A-Z]))|((?=.*[a-z])(?=.*[0-9]))|((?=.*[A-Z])(?=.*[0-9])))(?=.{6,})/
            },
            Test: {
                name: ( str ) => Self.Pattern.User.name.test( str ),
                mail: ( str ) => Self.Pattern.User.mail.test( str ),
                pass: ( str ) => Self.Pattern.User.pass.test( str ),
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
            template: Templates.Avatar
        };
        
        Components.Verify = {
            template: Templates.Verify
        };
        
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
            template: Templates.Card
        };
        
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
        
        Components.Markdown = {
            data: () => {
                return({
                    shorted: {
                        short: null,
                        shortString: false,
                        shortLength: false
                    }
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
            template: Templates.Is
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
            template: Templates.Shorts
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
            template: Templates.Swiper
        };
        
        Components.Footer = {
            template: Templates.Footer
        };
        
        Components.Signin = {
            data: function() {
                return({
                    image: {
                        avatar: "https://cdn-icons-png.flaticon.com/512/2885/2885034.png",
                        sample: "/storage/resource/image/default/1648811219;f5fnC0wqMd.jpg",
                    },
                    input: {
                        username: {
                            model: null
                        },
                        password: {
                            type: "password",
                            model: null
                        }
                    },
                    error: null
                });
            },
            methods: {
                show: function()
                {
                    this.input.password.type = this.input.password.type !== "password" ? "password" : "text";
                },
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
            },
            components: {
                Avatar: Components.Avatar
            },
            template: Templates.Signin
        };
        
        Components.Signup = {
            data: function() {
                return({
                    image: {
                        avatar: "https://cdn-icons-png.flaticon.com/512/2885/2885034.png",
                        sample: "/storage/resource/image/default/1648811634;ec5xuiZBpV.jpg",
                    },
                    group: {
                        usermail: {
                            type: "email",
                            name: "usermail",
                            place: "example@example.io",
                            label: {
                                class: "label",
                                inner: "Usermail"
                            },
                            model: "ari160824@gmail.com",
                            valid: false,
                            alias: "mail",
                            class: "input"
                        },
                        username: {
                            type: "text",
                            name: "username",
                            place: "example",
                            label: {
                                class: "label",
                                inner: "Username"
                            },
                            model: "hxari",
                            valid: false,
                            alias: "name",
                            class: "input"
                        },
                        password: {
                            type: "password",
                            name: "password",
                            place: "*******",
                            label: {
                                class: "label",
                                inner: "Password"
                            },
                            model: "/hx.ari_",
                            valid: false,
                            alias: "pass",
                            class: "input"
                        }
                    },
                    error: null
                });
            },
            methods: {
                show: function()
                {
                    this.group.password.type = this.group.password.type !== "password" ? "password" : "text";
                },
                change: function( i )
                {
                    if( this.group[i].model !== null && this.group[i].model !== "" )
                    {
                        if( Self.Pattern.Test[this.group[i].alias]( this.group[i].model ) )
                        {
                            if( this.group[i].alias === "mail" )
                            {
                                if( this.group[i].model[0] !== "." && this.group[i].model[this.group[i].model.length - 1] !== "." )
                                {
                                    this.group[i].class = "input isvalid";
                                    this.group[i].label.class = "label isvalid";
                                    
                                    return( this.group[i].valid = true );
                                }
                            } else {
                                this.group[i].class = "input isvalid";
                                this.group[i].label.class = "label isvalid";
                                
                                return( this.group[i].valid = true );
                            }
                        }
                        this.group[i].class = "input invalid";
                        this.group[i].label.class = "label invalid";
                        
                        return( this.group[i].valid = false );
                    }
                    this.group[i].class = "input";
                    this.group[i].label.class = "label";
                    
                    return( this.group[i].valid = false );
                },
                submit: function()
                {
                    var data = {
                    };
                    for( let input in this.group )
                    {
                        if( this.group[input].valid === false )
                        {
                            return false;
                        }
                        data[input] = this.group[input].model;
                    }
                    this.$store
                        .dispatch( "signup", data )
                        .then( function( r )
                        {
                            console.log( r );
                            this.$router.push({
                                name: "home"
                            });
                        })
                        .catch( function( e )
                        {
                            this.error = e.response.data.errors;
                        });
                }
            },
            components: {
                Avatar: Components.Avatar
            },
            template: Templates.Signup
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
                        caption: "Silence in the *crowd*, love @[hxari]",
                        
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
            template: Templates.Post
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
            template: Templates.Profile
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
            template: Templates.ProfilePost
        };
        
        Components.ProfileInsight = {
            template: Templates.ProfileInsight
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
        
        //Router.push( "/hxari" );
        
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
                        template: Templates.Root
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