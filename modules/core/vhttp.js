var vhttp = {
    // check: dùng để rút gọn jquery post | trả về dữ liệu trả về
    check: function (url, param) {
        return new Promise((resolve, reject) => {
            $.post(url, param, (response, status) => {
                try {
                    response = JSON.parse(response)
                    if (response['notify']) {
                        // thông báo kết quả
                    }
                    if (status == 'success' && response['status']) {
                        resolve(response)
                    }
                    reject()
                }
                catch (exception) {
                    // giá trị không thuộc dạng json, báo lỗi hệ thống
                    reject()
                }
            })
        })
    },
    // checkelse: giống check, nhưng không cần reject
    checkelse: function (url, param) {
        return new Promise((resolve) => {
            this.check(url, param).then((data) => {
                resolve(data)
            }, () => {  })
        })
    }
}
