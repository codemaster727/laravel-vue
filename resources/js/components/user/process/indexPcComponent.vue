<template>
	<div class="calendar">
        <header>
            <a href="" onclick="window.history.back(); return false;">前のページに戻る</a>
        </header>
        <main class="calendar--main">
            <!-- Test Start -->
            <div id="gstc"></div>
            <!-- Test End -->
        </main>
	</div>
</template>
<script>
	import GSTC from '../../../utilities/gstc.esm.min.js';
	import { Plugin as TimelinePointer } from '../../../utilities/gantt/timeline-pointer.esm.min.js';
	import { Plugin as Selection } from '../../../utilities/gantt/selection.esm.min.js';
	import { Plugin as ItemMovement } from '../../../utilities/gantt/item-movement.esm.min.js';
	import { Plugin as ItemResizing } from '../../../utilities/gantt/item-resizing.esm.min.js';
	import { Plugin as DependencyLines } from '../../../utilities/gantt/dependency-lines.esm.min.js';
	import moment from 'moment';
	import dayjs from 'dayjs';
	dayjs.locale('ja');

	export default {
		data() {
			return {

				isDetailActive1: false,
				isDetailActive2: false,
				isDetailActive3: false,

				rowsFromDB: [],
				itemsFromDB: [],
				rows: {}
			}
		},
		created: function() {
			this.loadProcesses();
		},
		computed: {},
		methods: {
            loadProcesses: function() {
                axios.get('/api/processes')
                    .then(result => {
						var _this = this;
                        let data = result.data.data;
                        if (data) {
							var index = 1;
							var prefiex = 'child';
							const GSTCID = GSTC.api.GSTCID;
							data.forEach(function(item, key) {
								_this.rowsFromDB.push({
									id: item.id,
									label: item.name,
									period: 'day',
								});

								_this.rows[GSTCID(String(item.id))] = {
									id: GSTCID(String(item.id)),
									label: '<div style="padding-left: 10px;">' + item.name + '</div>',
									parentId: undefined,
									expanded: false,
									progress: Math.floor(Math.random() * 100),
								};

								let periodArray = item.process_period;
								let title_index = 1;
								let title_prefix = '#';
								periodArray.forEach(function(period_item) {
									_this.rows[GSTCID(String(prefiex + '-' + period_item.process_id))] = {
										id: GSTCID(String(prefiex + '-' + period_item.id)),
										label: '<div style="padding-left: 8px; border-left: 16px solid '+ item.process_color_id +'";">' + title_prefix + title_index + '　' + item.work.name + '</div>',
										parentId: GSTCID(String(item.id)),
										expanded: false,
										progress: Math.floor(Math.random() * 100),
									};

									_this.itemsFromDB.push({
										id: period_item.id,
										rowId: prefiex + '-' + item.id,
										style: {
											background: item.process_color_id,
										},
										period: 'day',
										time: {
												start: GSTC.api
														.date(period_item.start_date)
														.startOf('day')
														.add(0, 'hour')
														.valueOf(),
												end: GSTC.api.date(period_item.finish_date)
														.endOf('day')
														.add(0, 'hour')
														.valueOf()
											}
									});

									index ++;
									title_index ++;
								});


							});

							this.display();
                        }
                    })
                    .catch(error => {
                        console.log('err', error);
                    });
            },
			toggleDetail1: function() {
                this.isDetailActive1 = !this.isDetailActive1;
			},
			toggleDetail2: function() {
                this.isDetailActive2 = !this.isDetailActive2;
			},
			toggleDetail3: function() {
                this.isDetailActive3 = !this.isDetailActive3;
			},
			isItemResizable: function (item) {
				if (typeof item.resizable === 'boolean') return item.resizable;
				return true;
			},
			limitTime: function(item, oldItem) {
				if (item.resizableFrom && item.time.start < item.resizableFrom) {
					item.time.start = item.resizableFrom;
				}
				if (item.resizableTo && item.time.end > item.resizableTo) {
					item.time.end = item.resizableTo;
				}
				if (item.resizableLength && item.resizablePeriod) {
					const actualDiff = GSTC.api
					.date(item.time.end)
					.diff(item.time.start, item.resizablePeriod, true);
					if (actualDiff > item.resizableLength) {
					const resizingFromStart = item.time.end === oldItem.time.end;
					if (resizingFromStart) {
						item.time.start = GSTC.api
						.date(item.time.end)
						.subtract(item.resizableLength, item.resizablePeriod) // -1 here because end of day - 3 days -> startOf day = almost 4 days
						.valueOf();
					} else {
						item.time.end = GSTC.api
						.date(item.time.start)
						.add(item.resizableLength, item.resizablePeriod)
						.valueOf();
					}
					}
				}
				return item;
			},
			snapToTimeSeparately: function(item) {
				return item;
			},
			isCollision: function(item) {
				const allItems = gstc.api.getAllItems();
				for (const itemId in allItems) {
					if (itemId === item.id) continue;
					const currentItem = allItems[itemId];
					if (currentItem.rowId === item.rowId) {
					if (
						item.time.start >= currentItem.time.start &&
						item.time.start <= currentItem.time.end
					)
						return true;
					if (
						item.time.end >= currentItem.time.start &&
						item.time.end <= currentItem.time.end
					)
						return true;
					if (
						item.time.start <= currentItem.time.start &&
						item.time.end >= currentItem.time.end
					)
						return true;
					if (
						item.time.start >= currentItem.time.start &&
						item.time.end <= currentItem.time.end
					)
						return true;
					}
				}
				return false;
			},
			updateStatus: function(items) {
				let itemInfo = items;
				let id = itemInfo[0].id.split('-')[1];
				let process_id = itemInfo[0].rowId.split('-')[2];
				let start_date = itemInfo[0].time.start;
				let end_date = itemInfo[0].time.end;
				start_date = moment(start_date).format("YYYY-MM-DD");
				end_date = moment(end_date).format("YYYY-MM-DD");
				let params = {
					process_id: process_id,
					start_date: start_date,
					finish_date: end_date,
				};
				axios.put('/api/process-periods/' + id, params)
						.then(result => {

						})
						.catch(error => {

						});
			},
			display: function() {
				var _this = this;
				const movementPluginConfig = {
					events: {
						onStart({ items }) {
							return items.after;
						},
						onResize({ items }) {
							const filtered = items.after
								.map((item, index) => {
									if (!_this.isItemResizable(item)) {
										return items.before[index];
									}
									return item;
								})
								.map((item, index) => _this.limitTime(item, items.before[index]))
								.map((item) => _this.snapToTimeSeparately(item));

							return filtered;
						},
						onEnd({ items }) {
							let initialRowId = items.initial[0].rowId;
							let targetInfoRowId = items.targetData.rowId;
							if(initialRowId != targetInfoRowId)
								return items.initial;

							_this.updateStatus(items.after);
							return items.after;
						},
					},
					snapToTime: {
						start({ startTime, time }) {
							return startTime.startOf('day').add(0, 'hour');
						},
					},
				};

				const columnsFromDB = [{
					id: 'label',
					data: 'label',
					isHTML: true,
					width: 230,
					height: 120,
					expander: true,
					header: {},
				}];

				const weekdays = ['月','火','水','木','金','土','日'];
				function dateSlot(vido, props) {
					const { onChange, update, html } = vido;
					let style = 'cursor: pointer;';
					let status = 0;
					let index = 0;
					onChange((newProps) => {
						props = newProps;
						if (!props) return;
						const day = moment(props.date.leftGlobalDate.$d).weekday();
						if (day === 6) {
							style = 'color: red;';
						} else if(day == 5) {
							style = 'color: blue;';
						} else {
							style = 'color: inherit;';
						}

						update();
					});

					return (content) =>
						html`<div class="my-date-slot" style=${style}>
						<div style="padding-top: 6px">${content}</div>
						</div>`;

				}
				const calendarLevel0  = [
				{
					zoomTo: 23,
					period: 'month',
					periodIncrement: 1,
					format({ timeStart }) {
					return timeStart.format('YYYY年MMMM');
					},
				}
				];
				const calendarLevel1  = [
				{
					zoomTo: 20,
					period: 'day',
					main: true,
					periodIncrement: 1,
					format({ timeStart, vido, className }) {
					return vido.html`<div class="${className}-content gstc-date-top">${moment(timeStart.format()).weekday(

					) + 1}</div><div class="${className}-content gstc-date-small">${timeStart.format(
						'dddd'
					)}</div>`;
					},
				},
				];
				const GSTCID = GSTC.api.GSTCID;
				const rows = _this.rows;
				// Configuration object
				const config = {
					licenseKey:
						'====BEGIN LICENSE KEY====\nN/CdZo1FnK3uLPDFsnQQkiuqFJfTgbhphMeAXNd7WCjEFaHJxyii9drMijXXl/dJydvmGRLvnGv188R4Veuu6PrulhqkHZTjmezVMYRiOSLAciqKNM6iuxRTd/LIpmsSWmM61z2Dl1JDIa9ghXMOprYFK9WoFa+soUjxzbpAkE5TVhLobm7WHp0M1Kbckp1rKXOoqIUT3tCvbOZ4jCAm8NHoiHCRi6YulRkg8WnEKEQQIrwoXKXsE6FM/XySSTG3UfcPSHfIQdw/I3t6vuwvsXpXFHJ5RLH2a3i4MQKpO4fdhbv5fVOe/vN87QGNK42vxPJC2EskuFTU/trrtNCCvg==||U2FsdGVkX1+I39HyAbKczHA7Kah2duwxe8ZOpgqNWuL+0bjF48GB3SffZ23c9txlo200kX9XPPuNMgwdnZvHE8SGAc8o3GOwvlOuL3s4v0c=\nBJkre6HK4ah8JbE0GDxmyQxmAqj2FfFa2uecJVEO1VO22MQ7hYQ4bYwGR+gf2dCZzGk1np6FlLwhVeqyv+Wb5bxNXEOuLnorzC2sx9IBI0eEY9noRg/Hf6TFMb/7eYVx4dhgcRfUgjy8y/OUE36JdMIabyxMeGvRmCJy4dUHxDWYfUkwnu3riJy2UQXRwh/LF5WMmzfTyvFFgzRRU5e+ZH7p202ASYheB7QFMaLPyNX+xYJ13XaoqTAUcWTAayT+Fl5svjs2yBbb2Snj8NrUTSQMAKY5ZeY+HAKjO6m+M5VpnP0YyHpNLBz95dOfaY5TTKfV3oytO4U0RSaxyaKsgA==\n====END LICENSE KEY====',
					innerHeight: 428,
					headerHeight: 72,
					plugins: [
						TimelinePointer({}), // timeline pointer must go first before selection, resizing and movement
						Selection(),
						ItemResizing({
						events: {
							onStart({ items }) {
								return items.after;
							},
							onResize({ items }) {
							const filtered = items.after
								.map((item, index) => {
									if (!_this.isItemResizable(item)) {
										return items.before[index];
									}
									return item;
								})
								.map((item, index) => _this.limitTime(item, items.before[index]))
								.map((item) => _this.snapToTimeSeparately(item));
								return filtered;
							},
							onEnd({ items }) {
								let beforeStarTime = items.before[0].time.start;
								let beforeEndTime = items.before[0].time.end;

								let initialStarTime = items.initial[0].time.start;
								let initialEndTime = items.initial[0].time.end;

								if(beforeStarTime == initialStarTime && beforeEndTime == initialEndTime)
									return items.initial;

								_this.updateStatus(items.after);
									return items.after;
							},
						},
						snapToTime: {
							start({ startTime }) {
								return startTime.startOf('day').add(0,'hour');
							},
							end({ endTime }) {
								// reset default period snapping behavior
								return endTime;
							},
						},
						}), // resizing must go before movement
						ItemMovement(movementPluginConfig),
					],
					list: {
						columns: {
							data: GSTC.api.fromArray(columnsFromDB),
							minWidth: 10,
						},
						rows
					},

					chart: {
						items: GSTC.api.fromArray(_this.itemsFromDB),
						time: {
							onLevelDates: [({ dates }) => dates],
							onCurrentViewLevelDates: [({ dates }) => dates],
							onDate: {
								format: "YYYY-MM"
							}
						},
						calendarLevels: [calendarLevel0, calendarLevel1],
					},
					slots: {
						'chart-calendar-date': { outer: [dateSlot] },
					},
					locale : {
						name: 'ja',
						weekdays: '日_月_火_水_木_金_土'.split('_'),
						weekdaysShort: '日_月_火_水_木_金_土'.split('_'),
						weekdaysMin: '日_月_火_水_木_金_土'.split('_'),
						months: '1月_2月_3月_4月_5月_6月_7月_8月_9月_10月_11月_12月'.split('_'),
						monthsShort: '1月_2月_3月_4月_5月_6月_7月_8月_9月_10月_11月_12月'.split('_'),
						ordinal: n => `${n}日`,
						formats: {
							LT: 'HH:mm',
							LTS: 'HH:mm:ss',
							L: 'YYYY/MM/DD',
							LL: 'YYYY年M月D日',
							LLL: 'YYYY年M月D日 HH:mm',
							LLLL: 'YYYY年M月D日 dddd HH:mm',
							l: 'YYYY/MM/DD',
							ll: 'YYYY年M月D日',
							lll: 'YYYY年M月D日 HH:mm',
							llll: 'YYYY年M月D日(ddd) HH:mm'
						},
						meridiem: hour => (hour < 12 ? '午前' : '午後'),
						relativeTime: {
							future: '%s後',
							past: '%s前',
							s: '数秒',
							m: '1分',
							mm: '%d分',
							h: '1時間',
							hh: '%d時間',
							d: '1日',
							dd: '%d日',
							M: '1ヶ月',
							MM: '%dヶ月',
							y: '1年',
							yy: '%d年'
						}
					}
				};

				const state = GSTC.api.stateFromConfig(config);
				window.state = state;

				const app = GSTC({
					element: document.getElementById('gstc'),
					state,
				});

				window.gstc = app;

			}
		},
		watch: {},
	}
</script>
