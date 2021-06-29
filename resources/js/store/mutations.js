let mutations = {
    CREATE_POST(state, post) {
        state.posts.unshift(post)
    },
    FETCH_POSTS(state, posts) {
        return state.posts = posts
    },
    DELETE_POST(state, post) {
        let index = state.posts.findIndex(item => item.id === post.id)
        state.posts.splice(index, 1)
    },
    FETCH_DAILY_REPORTS(state, dailyReport){
        console.log(dailyReport);
        return state.dailyReports = dailyReport.data
    },
    DELETE_DAILY_REPORT(state, dailyReport) {
        let index = state.dailyReports.findIndex(item => item.id === dailyReport.id)
        state.dailyReports.splice(index, 1)
        alert("履歴を削除!");
    },

}
export default mutations