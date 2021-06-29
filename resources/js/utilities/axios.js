import Axios from 'axios'

const getSender = () => {
    const axiosConfig = {
        timeout: 30000,
        headers: {
            'Accept': 'application/json',
            'X-CSRF-TOKEN': document.getElementsByName("csrf-token")[0].content,
            // TODO:ある程度実装後、APIの認可処理としてコメントアウトを除外する
            // 'Authorization': `Bearer ${document.getElementsByName('api-token')[0].content}`,
        },
        data: {}
    }
    return Promise.resolve(Axios.create(axiosConfig))
}

const BASE_URL = process.env.MIX_API_BASE_URL

export default {
    get (url, params) {
        return Promise.resolve()
            .then(async () => {
                try {
                    const sender = await getSender()
                    const baseUrl = BASE_URL
                    const response = await sender.get(baseUrl + url, { params: params })
                    return Promise.resolve(response.data)
                } catch (response) {
                    if (response.response.status == 401) {
                        // 認証エラー時、ログイン画面へリダイレクトする
                        return location.href = `${BASE_URL}/login`
                    }
                    return Promise.reject(response)
                }
            })
    },
    post (url, params, config = null) {
        return Promise.resolve()
            .then(async () => {
                try {
                    const sender = await getSender()
                    const baseUrl = BASE_URL
                    const response = await sender.post(baseUrl + url, params, config)
                    return Promise.resolve(response.data)
                } catch (response) {
                    return Promise.reject(response)
                }
            })
    },
    put (url, params) {
        return Promise.resolve()
            .then(async () => {
                try {
                    const sender = await getSender()
                    const baseUrl = BASE_URL
                    const response = await sender.put(baseUrl + url, params)
                    return Promise.resolve(response.data)
                } catch (response) {
                    return Promise.reject(response)
                }
            })
    },
    delete (url, params) {
        return Promise.resolve()
            .then(async  () => {
                try {
                    const sender = await getSender()
                    const baseUrl = BASE_URL
                    const response = await sender.delete(baseUrl + url, { data: params })
                    return Promise.resolve(response.data)
                } catch (response) {
                    return Promise.reject(response)
                }
            })
    }
}
