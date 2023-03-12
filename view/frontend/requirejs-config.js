var config = {
    map: {
        '*': {
            'amici_slickslider': 'Amici_BannerSlider/js/slider/slick.min',
            'wow_animation': 'Amici_BannerSlider/js/slider/wow.min'
        }
    },
    shim: {
        'amici_slickslider': {
            deps: ['jquery']
        },
        'wow_animation': {
            deps: ['jquery']
        }
    }
};
