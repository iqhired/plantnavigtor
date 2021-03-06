
<!------ Include the above in your HEAD tag ---------->
<style>
    /*
Fade content bs-carousel with hero headers
Code snippet by maridlcrmn (Follow me on Twitter @maridlcrmn) for Bootsnipp.com
Image credits: unsplash.com
*/

    /********************************/
    /*       Fade Bs-carousel       */
    /********************************/
    .fade-carousel {
        position: relative;
        /* margin-top: 118px; */
        z-index: -1;
    }
    .fade-carousel .carousel-inner .item {
        height: 100vh;
    }
    .fade-carousel .carousel-indicators > li {
        margin: 0 2px;
        background-color: #f39c12;
        border-color: #f39c12;
        opacity: .7;
    }
    .fade-carousel .carousel-indicators > li.active {
        width: 10px;
        height: 10px;
        opacity: 1;
    }

    /********************************/
    /*          Hero Headers        */
    /********************************/
    .hero {
        position: absolute;
        top: 45%;
        left: 50%;
        z-index: 3;
        color: #fff;
        width: 100%;
        text-align: center;
        text-transform: uppercase;
        text-shadow: 1px 1px 0 rgba(0,0,0,.75);
        -webkit-transform: translate3d(-50%,-50%,0);
        -moz-transform: translate3d(-50%,-50%,0);
        -ms-transform: translate3d(-50%,-50%,0);
        -o-transform: translate3d(-50%,-50%,0);
        transform: translate3d(-50%,-50%,0);
    }
    .hero h1 {
        font-size: 2em;
        font-weight: bold;
        margin: 0;
        padding: 0;
    }

    .fade-carousel .carousel-inner .item .hero {
        opacity: 0;
        -webkit-transition: 2s all ease-in-out .1s;
        -moz-transition: 2s all ease-in-out .1s;
        -ms-transition: 2s all ease-in-out .1s;
        -o-transition: 2s all ease-in-out .1s;
        transition: 2s all ease-in-out .1s;
    }
    .fade-carousel .carousel-inner .item.active .hero {
        opacity: 1;
        -webkit-transition: 2s all ease-in-out .1s;
        -moz-transition: 2s all ease-in-out .1s;
        -ms-transition: 2s all ease-in-out .1s;
        -o-transition: 2s all ease-in-out .1s;
        transition: 2s all ease-in-out .1s;
    }

    /********************************/
    /*          Custom Buttons      */
    /********************************/
    .btn.btn-lg {padding: 10px 40px;}
    .btn.btn-hero,
    .btn.btn-hero:hover,
    .btn.btn-hero:focus {
        color: #f5f5f5;
        background-color: #1abc9c;
        border-color: #1abc9c;
        outline: none;
        margin: 20px auto;
    }

    /********************************/
    /*       Slides backgrounds     */
    /********************************/
    .fade-carousel .slides .slide-1

   {
        height: 10vh;
        background-size: cover;
        background-position: center center;
        background-repeat: no-repeat;
        opacity: 0.9;
    }
    .fade-carousel .slides .slide-1 {
        background-image: url(../assets/img/background_img.png);
    }

    /********************************/
    /*          Media Queries       */
    /********************************/
    @media screen and (min-width: 980px){
        .hero { width: 980px; }
    }
    @media screen and (max-width: 640px){
        .hero h1 { font-size: 1.5em; }
    }



</style>
<div class="carousel fade-carousel slide" data-ride="carousel" data-interval="4000" id="bs-carousel">


    <!-- Wrapper for slides -->

        <div class="item slides active">
            <div class="slide-1"></div>
            <div class="hero">
                <hgroup>
                    <h1><?php echo $cust_cam_page_header; ?></h1>

                </hgroup>

            </div>
        </div>

</div>