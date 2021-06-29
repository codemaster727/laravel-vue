export default {
    // エラーメッセージをアラート表示(APIの返却値がエラーである場合に使用)
    async errorMessage(result) {
        console.log(result)
        if (result.request.status == 500) {
            alert("サーバーエラーが発生しました")
        } else {
            let errors = await this.parseToJson(result)
            let message = '';
            Object.values(errors).forEach (
                value => (message = message + value[0] + "\n")
            )
            alert(message)
        }
    },

    // レスポンスをJSONに整形するメソッド
    async parseToJson(result) {
        if (result.request.responseType === "blob") {
            const text = await this.parseToText(result)
            return JSON.parse(text).errors
        } else {
            return result.response.data.errors
        }
    },

    // 受け取ったblobをテキストに変換するメソッド
    parseToText(result) {
        const fileReader = new FileReader()
        return new Promise((resolve, reject) => {
            fileReader.onerror = () => {
                fileReader.abort()
                reject()
            }
            fileReader.onload = () => {
                resolve(fileReader.result)
            }
            fileReader.readAsText(result.response.data)
        })
    }
}
