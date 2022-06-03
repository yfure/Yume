
var Templates = {};
    Templates.Avatar = `
        <div :class="radius()">
            <img class="avatar-image" :src="src" :alt="alt" />
            <div class="avatar-cover"></div>
        </div>
    `;
    Templates.Card = `
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
    `;
    Templates.Footer = `
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
    `;
    Templates.Is = `<component :is="view"></component>`;
    Templates.Root = `
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
    `;
    Templates.Shorts = `
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
                    <button class="single box login flex flex-center fs-16 pd-14 rd-square fb-45">
                        Signup
                    </button>
                </router-link>
            </div>
        </div>
    `;
    Templates.Signin = `
        <div class="login flex flex-center">
            <div class="counter dp-flex">
                <div class="single content">
                    <Avatar :src="image.sample" alt="Sample Image" />
                </div>
                <div class="group content">
                    <div class="single center flex flex-center">
                        <div class="single block">
                            <Avatar rad="circle" :src="image.avatar" alt="Octancle" />
                            <h3 class="title mg-bottom-18">Signin</h3>
                            <div class="group form pd-14">
                                <div class="group">
                                    <label class="label">Username</label>
                                    <input class="input" type="text" v-model="input.username.model" />
                                </div>
                                <div class="group">
                                    <label class="label">Password</label>
                                    <input class="input" :type="input.password.type" v-model="input.password.model" />
                                </div>
                                <div class="group mg-top-14 display" @click="show()">
                                    <label class="label">
                                        <span v-if="( input.password.type === 'password' )">
                                            <i class="bx bx-hide"></i> Show password.
                                        </span>
                                        <span v-else>
                                            <i class="bx bx-show"></i> Hide password.
                                        </span>
                                    </label>
                                </div>
                                <div class="group mg-top-12">
                                    <button class="button submit fb-45 flex flex-center" @click="submit">
                                        Signin
                                    </button>
                                </div>
                                <div class="single trigger warning rd-square mg-top-14 pd-14">
                                    <p class="text">Forgot password? Click <router-link class="link" to="/signin/f/p">here</router-link>.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    `;
    Templates.Signup = `
        <div class="login flex flex-center">
            <div class="counter dp-flex">
                <div class="single content">
                    <Avatar :src="image.sample" alt="Sample Image" />
                </div>
                <div class="group content">
                    <div class="single center flex flex-center">
                        <div class="single block">
                            <Avatar rad="circle" :src="image.avatar" alt="Octancle" />
                            <h3 class="title mg-bottom-18">Signup</h3>
                            <form class="group form pd-14" method="POST" action="/api/signup">
                                <div class="group" v-for="( input, i ) in group">
                                    <label :class="group[i].label.class">{{ input.label.inner }}</label>
                                    <input :class="group[i].class" :type="group[i].type" :name="group[i].name" @change="change( i )" v-model="group[i].model" required/>
                                </div>
                                <div class="group mg-top-14 display" @click="show()">
                                    <label class="label">
                                        <span v-if="( group.password.type === 'password' )">
                                            <i class="bx bx-hide"></i> Show password.
                                        </span>
                                        <span v-else>
                                            <i class="bx bx-show"></i> Hide password.
                                        </span>
                                    </label>
                                </div>
                                <div class="group mg-top-12">
                                    <button class="button submit fb-45 flex flex-center" ><!--@click="submit">-->
                                        Signup
                                    </button>
                                </div>
                                <div class="single trigger info rd-square mg-top-14 pd-14">
                                    <p class="text">I have read and agree to all the terms and privacy policy of <span class="fb-45">Octancle</span>.</p>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    `;
    Templates.Post = `
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
    `;
    Templates.Profile = `
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
    `;
    Templates.ProfilePost = `
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
    `;
    Templates.ProfileInsight = `
        <div class="wrapper insight">
            Insight
        </div>
    `;
    Templates.Swiper = `
        <div class="swiper">
            <slot name="header"></slot>
            <div class="swiper-container" ref="swiper">
                <div class="swiper-wrapper">
                    <slot name="default"></slot>
                </div>
            </div>
            <slot name="footer"></slot>
        </div>
    `;
    Templates.Verify = `
        <p class="verify flex flex-center">
            <i class="bx bx-check"></i>
            <i class="bx bxs-certification"></i>
        </p>
    `;