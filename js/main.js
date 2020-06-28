document.documentElement.style.setProperty('--animate-duration', '.125s')

function show() {
    const animation = 'animate__animated animate__fadeIn'
    const animationEnd = 'webkitAnimationEnd mozAnimationEnd MSAnimationEnd onaimationend animationend'
    const window = $('.page')

    window.addClass(animation).one(animationEnd, function () {
        window.removeClass(animation)
    })
}

function hide() {
    const animation = 'animate__animated animate__fadeOut'
    const animationEnd = 'webkitAnimationEnd mozAnimationEnd MSAnimationEnd onaimationend animationend'
    const window = $('.page')

    window.addClass(animation).one(animationEnd, function () {
        window.removeClass(animation)
    })
}