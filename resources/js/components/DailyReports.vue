<template>
    <div>
        <h4 class="text-center font-weight-bold">現場進捗状況</h4>
        <table class="table table-striped">
            <thead>
            <tr>
                <th scope="col">No</th>
                <th scope="col">ID</th>
                <th scope="col">作業名</th>
                <th scope="col">作業者名</th>
                <th scope="col">日付</th>
                <th scope="col">開始時間</th>
                <th scope="col">終了時間</th>
                <th scope="col">履歴を削除</th>
            </tr>
            </thead>
            <tbody>
                <tr v-if="dailyReports.length == 0">
                    <td colspan="8" style="text-align:center">表示するデータはありません。</td>
                </tr>
                <tr v-for="(dailyReport, index) in dailyReports" :key="dailyReport.id">
                    <td>{{index + 1}}</td>
                    <td>{{dailyReport.id}}</td>
                    <td>{{dailyReport.work_name}}</td>
                    <td>{{dailyReport.worker_name}}</td>
                    <!-- <td>{{date('Y年m月d日', strtotime(dailyReport.work_date))}}</td> -->
                    <td>{{dailyReport.work_date}}</td>
                    <td>{{dailyReport.work_start_on}}</td>
                    <td>{{dailyReport.work_finish_on}}</td>
                    <td>
                        <button class="btn btn-danger" @click="deletePost(dailyReport)"><i style="color:white" class="fa fa-trash"></i></button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

</template>

    <script>
        import {mapGetters} from 'vuex'

        export default {
            name: "DailyReports",
            mounted() {
                this.$store.dispatch('fetchDailyReports')
            },
            methods: {
                deletePost(post) {
                    this.$store.dispatch('deleteDailyReport',post)
                }
            },
            computed: {
                ...mapGetters([
                    'dailyReports'
                ])
            }
        }
    </script>

    <style scoped>

    </style>