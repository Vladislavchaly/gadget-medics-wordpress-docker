// load
$(window).on('load', function () {

    var pageWrapper  = $('.wrapper');

    pageWrapper.addClass('loaded');

});

$(document).ready(function() {


    $('.header-menu__btn').click(function(){
        $('.header-navigation').toggleClass('active');
        $('.header-navigation__menu').toggleClass('active');
        $('.overlay').toggleClass('active');
        $(this).toggleClass('active');
    });

    $('.overlay').click(function(){
        $('.header-navigation').removeClass('active');
        $('.header-navigation__menu').removeClass('active');
        $('.overlay').removeClass('active');
        $('.header-menu__btn').removeClass('active');
    });



    $('[data-fancybox],[data-src]').fancybox({
        autoFocus: false
    });

    new WOW().init();

    var homeSlider = $('.homepage-slider');
    homeSlider .each(function(){
        var homeSwiper = new Swiper(this, {
            loop: true,
            speed: 500,
            spaceBetween: 0,
            effect: 'fade',
            slidesPerView:1,
            navigation: {
                prevEl: $(this).parents('.homepage-slider__wrapper').find('.homepage-slider__prev')[0],
                nextEl: $(this).parents('.homepage-slider__wrapper').find('.homepage-slider__next')[0],
            },
        });
    });

    var galleryThumbs = new Swiper('.reviews-block__thumbs', {
        spaceBetween: 5,
        slidesPerView: 3,
        loop: true,
        freeMode: false,
        centeredSlides: true,
        loopedSlides: 5, //looped slides should be the same
        watchSlidesVisibility: true,
        watchSlidesProgress: true,
    });
    var galleryTop = new Swiper('.reviews-block__main', {
        spaceBetween: 5,
        slidesPerView: 1,
        effect: 'fade',
        autoHeight: true,
        fadeEffect: {
            crossFade: true
        },
        loop:true,
        loopedSlides: 5, //looped slides should be the same
        navigation: {
            prevEl: '.reviews-slider__prev',
            nextEl: '.reviews-slider__next',
        },
        thumbs: {
            swiper: galleryThumbs,
        },
    });



    // jQuery('.custom_date_picker').datetimepicker({
    //     step: 30,
    //     allowTimes:[],
    //     format: 'd/m/Y h:i A'
    // });

});

// $(function(){
//     var onInputClass = "onFormControl";
//     var showInputClass = "showFormControl";
//     $(".form-control").bind("checkval",function(){
//         var labelFC = $(this).parents('.').find('.wpforms-field-label');
//         if(this.value !== ""){
//             labelFC.addClass(showInputClass);
//         } else {
//             labelFC.removeClass(showInputClass);
//         }
//     }).on("keyup",function(){
//         $(this).trigger("checkval");
//     }).on("focus",function(){
//         $(this).parents('.').find('.wpforms-field-label').addClass(onInputClass);
//     }).on("blur",function(){
//         $(this).parents('.').find('.wpforms-field-label').removeClass(onInputClass);
//     }).trigger("checkval");
// });



$('.input-field input').focus(function(){
    $(this).parents('.input-field').addClass('focused');
});
$('.input-field input').blur(function(){
    var inputValue = $(this).val();
    if ( inputValue == "" ) {
        $(this).removeClass('filled');
        $(this).parents('.input-field').removeClass('focused');
    } else {
        $(this).addClass('filled');
    }
});

$('ul.tabs_caption').on('click', 'li:not(.active)', function() {
    $(this)
        .addClass('active').siblings().removeClass('active')
        .closest('div.wrap_tabs').find('div.tabs_content').removeClass('active').eq($(this).index()).addClass('active');
});
var tabIndex = window.location.hash.replace('#tab','')-1;
if (tabIndex != -1) $('ul.tabs_caption li').eq(tabIndex).click();




// ajax filter
$('.category-filter_content').on('click', 'a:not(.active)', function(e) {
    e.preventDefault();
    $(this).addClass('active').siblings().removeClass('active');
    var data = {
        action: 'filter',
        term_id: $(this).data('filter'),
    };
    $.ajax({
        url: ajaxurl, // обработчик
        data: data, // данные
        type: 'POST', // тип запроса
        success: function(data) {
            if (data) {
                //console.log(data2);
                $('.blog-filtered-content').find('.news-block__item').remove();
                $('.blog-filtered-content').append(data);
            }
        }
    });
});

// slick
if(/iPad/i.test(navigator.userAgent)){
    $('.slider-news-block').slick({
        slidesToShow: 2,
        slidesToScroll: 1,
        dots: false,
        focusOnSelect: true
    });
}
if(/iPhone|iPod|Android/i.test(navigator.userAgent)){
    $('.slider-news-block').slick({
        slidesToShow: 1,
        slidesToScroll: 1,
        dots: false,
        focusOnSelect: true
    });
}else {
$('.slider-news-block').slick({
    slidesToShow: 3,
    slidesToScroll: 1,
    dots: false,
    focusOnSelect: true
}); }
