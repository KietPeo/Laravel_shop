<section id="billboard" class="position-relative overflow-hidden bg-light-blue">
    <style>
        .img-small {
            width: 90%;
            /* Thu nhỏ hình ảnh lại 80% */
            height: auto;
            /* Đảm bảo tỷ lệ khung hình không bị thay đổi */
        }
       
        
    </style>
    <div class="swiper main-swiper">
        <div class="swiper-wrapper">
            <div class="swiper-slide">
                <div class="container">
                    <div class="row d-flex align-items-center">
                        <div class="col-md-6">
                            <div class="banner-content">
                                <h1 class="display-2 text-uppercase text-dark pb-5 fs-1">Your Products Are Great.</h1>
                                <a href="shop.html" class="btn btn-medium btn-dark text-uppercase btn-rounded-none">Shop
                                    Product</a>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="image-holder">
                                <img class="img-small" src="{{ asset('client/home/images/banner-image.png') }}"
                                    alt="banner">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="swiper-slide">
                <div class="container">
                    <div class="row d-flex flex-wrap align-items-center">
                        <div class="col-md-6">
                            <div class="banner-content">
                                <h1 class="display-2 text-uppercase text-dark pb-5 fs-1">Technology Hack You Won't Get</h1>
                                <a href="shop.html" class="btn btn-medium btn-dark text-uppercase btn-rounded-none">Shop
                                    Product</a>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="image-holder">
                                <img class="img-small" src="{{ asset('client/home/images/banner-image.png') }}"
                                    alt="banner">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="swiper-icon swiper-arrow swiper-arrow-prev">
        <svg class="chevron-left">
            <use xlink:href="#chevron-left" />
        </svg>
    </div>
    <div class="swiper-icon swiper-arrow swiper-arrow-next">
        <svg class="chevron-right">
            <use xlink:href="#chevron-right" />
        </svg>
    </div>
</section>
