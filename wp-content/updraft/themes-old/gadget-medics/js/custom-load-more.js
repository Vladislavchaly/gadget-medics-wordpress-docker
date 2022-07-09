var page = 2;
jQuery(function($) {
    $('body').on('click', '.loadmore-custom', function(event) {
        event.preventDefault();
        var data = {
            'action': 'load_marketplaces_by_ajax',
            'page': page,
            'security': blog.security
        };

        $.post(blog.ajaxurl, data, function(response) {
            if(response != '' && response.length > 10) {
                $('.custom-load-more-content').append(response);
                page++;
            } else {
                $('.loadmore-custom').hide();
            }
        });
    });
});


//for news
var pageNews = 2;
jQuery(function($) {
    $('body').on('click', '.loadmore-custom-news', function(event) {
        event.preventDefault();
        var data = {
            'action': 'load_news_by_ajax',
            'page': pageNews,
            'security': blog.security
        };
        $.post(blog.ajaxurl, data, function(response) {
            if(response != '' && response.length > 10) {
                $('.cst-news-loadmore').append(response);
                pageNews++;
            } else {
                $('.loadmore-custom-news').hide();
            }
        });
    });
});