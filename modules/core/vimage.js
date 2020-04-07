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

function onselected(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        var fullname = input.files[0].name
        var name = Math.round(new Date().getTime() / 1000) + '_' + fullname.substr(0, fullname.lastIndexOf('.'))
        var extension = fullname.substr(fullname.lastIndexOf('.') + 1)
        filename = name + '.' + extension

        reader.onload = function (e) {
            var image = new Image();
            image.src = e.target["result"];
            image.onload = (e2) => {
                blah.setAttribute('src', file)
                file = file.substr(file.indexOf(',') + 1);
            };
        };

        if (imageType.indexOf(extension) >= 0) {

            reader.readAsDataURL(input.files[0]);
        }
    }
}

function uploader() {
    return new Promise(resolve => {
        if (!(file || filename)) {
            resolve('')
        }
        else {
            var uploadTask = storageRef.child('images/' + filename).putString(file, 'base64', metadata);
            uploadTask.on(firebase.storage.TaskEvent.STATE_CHANGED, // or 'state_changed'
                function (snapshot) {
                    var progress = (snapshot.bytesTransferred / snapshot.totalBytes) * 100;
                    console.log('Upload is ' + progress + '% done');
                    switch (snapshot.state) {
                        case firebase.storage.TaskState.PAUSED: // or 'paused'
                            console.log('Upload is paused');
                            break;
                        case firebase.storage.TaskState.RUNNING: // or 'running'
                            console.log('Upload is running');
                            break;
                    }
                }, function (error) {
                    resolve('')
                    switch (error.code) {
                        case 'storage/unauthorized':
                            // User doesn't have permission to access the object
                            break;
                        case 'storage/canceled':
                            // User canceled the upload
                            break;
                        case 'storage/unknown':
                            // Unknown error occurred, inspect error.serverResponse
                            break;
                    }
                }, function () {
                    // Upload completed successfully, now we can get the download URL
                    uploadTask.snapshot.ref.getDownloadURL().then(function (downloadURL) {
                        resolve(downloadURL)
                        console.log('File available at', downloadURL);
                    });
                });
        }
    })
}
