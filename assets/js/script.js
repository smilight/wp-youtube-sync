var WPYS = WPYS || {
    init: function () {
        WPYS.initYPlayer();
    },
    initYPlayer: function () {
        mejs.i18n.language('uk');

        $('.youtube_placeholder').each(function (i, el, arr) {

            var item = $(el),
                videoId = item.data('id'),
                image = item.data('image');

            item.prepend('<video width="800" height="360" poster="' + image + '"><source src="https://www.youtube.com/watch?v=' + videoId + '" type="video/youtube" /></video>');

            item.find('video').mediaelementplayer({
                renderers: ['native_dash', 'youtube_iframe'],
                fill: true
            });

        })
    }
};

$(function () {
    WPYS.init();
});