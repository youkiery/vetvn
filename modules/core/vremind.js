var vremind = {
    install: (inputSelector, suggestSelector, excuteFunction, inputDelay = 0, suggestDelay = 0) => {
        var input = $(inputSelector)
        var suggest = $(suggestSelector)
        suggest.hide()
        var delay = 0

        $(document).on('keyup', inputSelector, () => {
            clearTimeout(delay)
            delay = setTimeout(() => {
                excuteFunction(input.val()).then((html) => {
                    suggest.html(html)
                })
            }, inputDelay);
        })
        $(document).on('focus', inputSelector, () => {
            setTimeout(() => {
                suggest.show()
            }, suggestDelay);
        })
        $(document).on('focus', inputSelector, () => {
            setTimeout(() => {
                suggest.hide()
            }, suggestDelay);
        })
    }
}
