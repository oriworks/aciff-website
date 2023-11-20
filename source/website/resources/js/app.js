import './bootstrap';

$('#toggle-side-menu').click(() => {
    $("#side-menu").toggleClass('w-96');
})

$('[id=toggle-menu]').on('click', function (event) {
    // Check has Open
    if ($(this).parent().hasClass('open')) {
        $(this).find('svg').addClass('-rotate-90')
        $(this).parent().removeClass('open')
        $(this).parent().css({ height: `` })
    } else {
        $('[id=toggle-menu]').each(function () {
            $(this).find('svg').addClass('-rotate-90')
            $(this).parent().removeClass('open')
            $(this).parent().css({ height: `` })
        })

        $(this).find('svg').removeClass('-rotate-90')
        $(this).parent().addClass('open');
        $(this).parent().css({ height: `${3*$(this).parent().children().length}rem` })
    }
})

// SlideShow
const timeInterval = 5000;
var interval;
function slideShowMove(index) {
    var currentIndex = 0;
    var slides = $('.slideShow').find('.slideShowContainer').children();
    slides.each(function (i) {
        if (!$(this).hasClass('opacity-0')) {
            currentIndex = i;
        }
    });
    var newIndex = index ?? ((currentIndex + 1) % slides.length)
    if (currentIndex != newIndex) {
        $(`.slideShow .slideShowContainer :nth-child(${currentIndex + 1})`).addClass('opacity-0')
        $(`.slideShow .slideShowContainer :nth-child(${newIndex + 1})`).removeClass('opacity-0')

        $(`.slideShow .slideShowIndicators :nth-child(${currentIndex + 1})`).addClass('opacity-60')
        $(`.slideShow .slideShowIndicators :nth-child(${newIndex + 1})`).removeClass('opacity-60')
    }
}
function initSlideShow() {
    var slideShow = $('.slideShow');
    if (slideShow.length) {
        var slides = slideShow.find('.slideShowContainer').children();

        slides.first().removeClass('opacity-0');
        if(slides.length > 1) {
            if(slideShow.find('.slideShowIndicators')) {
                slideShow.find('.slideShowIndicators').append('<span class="transition duration-500 w-5 h-5 rounded-full bg-gray-50 m-1.5" />');
                for (let index = 1; index < slides.length; index++) {
                    slideShow.find('.slideShowIndicators').append('<span class="transition duration-500 w-5 h-5 rounded-full bg-gray-50 opacity-60 m-1.5" />');
                }
                $('.slideShowIndicators span').on('click', function () {
                    slideShowMove($(this).index())
                })
            }
        }


        interval = setInterval(slideShowMove, timeInterval);
        // don't move when cursor hover slideShow
        slideShow.hover(
            () => clearInterval(interval),
            () => {
                interval = setInterval(slideShowMove, timeInterval);
            },
        )
    }
}
initSlideShow();
