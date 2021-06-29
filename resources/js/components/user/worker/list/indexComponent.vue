<template>
	<div class="l-wrap--inner">
		<div class="l-worker--header">
			<p class="title">現場を選択する</p>
		</div>
		<div class="l-worker--body">
			<div class="l-worker--body__main">
				<div class="l-worker--body__box">
					<div class="l-worker--body__main__list">
						<template v-for="(data, index) in workList" :id="data.id">
							<div class="l-worker--body__main__list__box">
								<a v-bind:href="'/worker/work-detail?id=' + data.id" class="c-link--detail">
									<p class="c-text--main">{{ data.name }}</p>
									<p class="c-text--sub">{{ data.startDate }} - {{ data.finishDate }}</p>
									<p class="c-text--sub">{{ data.user.company }}</p>
								</a>
							</div>
						</template>
					</div>
				</div>
			</div>
		</div>
	</div>
</template>


<script>
	export default {
		data() {
			return {
				workList: []
			}
		},
		created: function() {
			this.loadList();
		},
		 props: {
			id: 1
		},
		computed: {},
		methods: {
			loadList: function() {
				axios.get('/api/works')
					.then(result => {
						console.log(result);
						this.workList = result.data.data;
					})
					.catch(error => {
						console.log(error);
					});
			},
			setID: function(id) {
				alert(id);
			}
		},
		watch: {},
	}
</script>