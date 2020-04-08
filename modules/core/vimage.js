var vimage = {
    data: {},
    clear: (id) => {
        vimage[id] = []
    },
    install: (posid, width, height, reload_func) => {
        input = document.createElement('input')
        input.setAttribute('id', posid + '-input')
        input.setAttribute('type', 'file')
        input.setAttribute('accept', '.png, .jpg, .jepg')
        document.getElementById(posid).appendChild(input)
        input.addEventListener('change', (e) => {
            var reader = new FileReader();
            reader.readAsDataURL(e.target.files[0]);
            reader.onload = (e) => {
                var image = new Image();
                image.src = e.target["result"];
                image.onload = () => {
                    if (!vimage.data[posid]) vimage.data[posid] = []
                    vimage.data[posid].push(vimage.resize(image, width, height))
                    reload_func(vimage.data[posid])
                }
            }
        })
    },
    resize: (image, width, height) => {
        var canvas = document.createElement("canvas")
        var context = canvas.getContext("2d");
        var ratio = 1;
        if (image.width > width) ratio = width / image.width;
        else if (image.height > height) ratio = height / image.height;
        canvas.width = image.width * ratio;
        canvas.height = image.height * ratio;
        context.drawImage(image, 0, 0, canvas.width, canvas.height);
        base64 = canvas.toDataURL("image/jpeg")
        return base64
    }
}
