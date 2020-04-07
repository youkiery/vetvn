var vnumber = {
    formatter: new Intl.NumberFormat('vi-VI', {
        style: 'currency',
        currency: 'VND'
    }),
    install: (id) => {
        var prv = ''
        var input = $("#" + id)
        input.keyup(() => {
            value = input.val().replace(/\,/g, "")

            if (isFinite(value)) {
                // là số                
                prv = vnumber.formatter.format(value).replace(/ ₫/g, "").replace(/\./g, ",")
            }
            input.val(prv)
        })        
    }
}