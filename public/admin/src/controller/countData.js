layui.define(function(exports){
	

	//tab  初始化 及监听事件切换
	layui.use(['admin',"echarts"], function(){
		var $ = layui.$, element = layui.element, echarts = layui.echarts, admin = layui.admin, form = layui.form;
		element.render();
		
		//获取当前日期
	    var nowDate = new Date(), startDate = nowDate.getFullYear()+'-'+((nowDate.getMonth()+1)<10?'0'+(nowDate.getMonth()+1):nowDate.getMonth()+1)+'-'+(nowDate.getDate()<10?'0'+nowDate.getDate():nowDate.getDate());
	    //防止开始日期被重置为空
	    $('#orderStartTime').attr('value', startDate);

		var showTypeCount = function(){
			var gamecount = echarts.init(document.getElementById('gamecount'));

			var gamecountoption = {
			    title: {
			        x: 'center',
			        text: '彩种投注金额统计',
			    },
			    tooltip: {
			        trigger: 'item'
			    },
				toolbox: {
					show : true,
					feature: {
						magicType: {show: true, type: ['line', 'bar']},
						restore: {show: true},
						saveAsImage: {show: true}
					}
				},
			    grid: {
			        borderWidth: 0,
			        x:10,
			        x2:10,
			        y: 120,
			        y2: 0
			    },
			    xAxis: [
			        {
			            type: 'category',
			            show: false,
			            data: []
			        }
			    ],
			    yAxis: [
			        {
			            type: 'value',
			            show: false
			        }
			    ],
			    series: [
			        {
			            name: '投注额',
			            type: 'bar',
			            itemStyle: {
			                normal: {
			                    label: {
			                        show: true,
			                        position: 'top',
			                        formatter: '{b}\n{c}'
			                    }
			                }
			            },
			            data: []
			        }
			    ]
			};
			admin.req({
		       url: layui.setter.URL_ADMIN+'/countData/getTypeCount'
		       ,data:{
		    	   startTime: $('#orderStartTime').val(),
		    	   endTime: $('#orderEndTime').val(),
		    	   userID: $('#orderUserID').val()
		       }
		       ,done: function(res){
		    	   gamecountoption['xAxis'][0]['data'] = res.data.title;
		    	   gamecountoption['series'][0]['data'] = res.data.amount;
		    	   gamecount.setOption(gamecountoption);
		       }
			});
		}
		showTypeCount();
	    
		//可以把这些放入 layui 模块中
		// 配置init
		var water = echarts.init(document.getElementById('layui-index-water'));
		var game = echarts.init(document.getElementById('layui-index-game'));



		/*ajax修改传入参数 water game
		set 这个函数重新执行 重绘图标*/
		//存款/提款
		var optionwater = {
			title: {
				text: '充值/提现',
		        //subtext: '最近30天数据'
			},
			tooltip: {
				trigger: 'axis'
			},
			toolbox: {
				show : true,
				feature: {
					magicType: {show: true, type: ['line', 'bar']},
					restore: {show: true},
					saveAsImage: {show: true}
				}
			},
			color:['#3498db','red','#cccccc'],
			grid:{
				x2:20,
				y:60,
				y2:30
			},
			legend: {
				data:['充值','提现','盈亏']
			},
			xAxis: [
				{
					type: 'category',
					boundaryGap : false,
					data: []
				}
			],
			yAxis: [
				{
					type: 'value',
					name: '充值/提现/盈亏',
					min: 0,
					//max: 100,
					interval: 5,
					axisLabel: {
						formatter: '{value} 元'
					}
				},
				{
					type: 'value',
					name: '盈亏',
					min: 0,
					//max: 100,
					interval: 5,
					axisLabel: {
						formatter: '{value} 元'
					}
				}
			],
			series: [
				{
					name:'充值',
					type:'line',
					data:[]
				},
				{
					name:'提现',
					type:'line',
					data:[]
				},
				{
					name:'盈亏',
					type:'line',
					//yAxisIndex: 1,
					data:[]
				}
			]
		};

		//游戏中奖
		var optiongame = {
			title: {
				text: '投注/中奖',
		        //subtext: '最近30天数据'
			},
			tooltip: {
				trigger: 'axis'
			},
			toolbox: {
				show : true,
				feature: {
					magicType: {show: true, type: ['line', 'bar']},
					restore: {show: true},
					saveAsImage: {show: true}
				}
			},
			grid:{
				x2:20,
				y:60,
				y2:30
			},
			color:['#3498db','red','#cccccc'],
			legend: {
				data:['投注','中奖','盈亏']
			},
			xAxis: [
				{
					type: 'category',
					boundaryGap : false,
					data: []
				}
			],
			yAxis: [
				{
					type: 'value',
					name: '投注/中奖/盈亏',
					min: 0,
					//max: 100,
					interval: 5,
					axisLabel: {
						formatter: '{value} 元'
					}
				},
				{
					type: 'value',
					name: '盈亏',
					//min: 0,
					//max: 100,
					interval: 5,
					axisLabel: {
						formatter: '{value} 元'
					}
				}
			],
			series: [
				{
					name:'投注',
					type:'line',
					data:[]
				},
				{
					name:'中奖',
					type:'line',
					data:[]
				},
				{
					name:'盈亏',
					type:'line',
					//yAxisIndex: 1,
					data:[]
				}
			]
		};
		
		//获取充值提现/投注中奖图表数据
		admin.req({
	       url: layui.setter.URL_ADMIN+'/countData/getCountData'
	       ,done: function(res){
	    	   optionwater['xAxis'][0]['data'] = res.data.labels;
	    	   optiongame['xAxis'][0]['data'] = res.data.labels;
	    	   optionwater['series'][0]['data'] = res.data.recharge;
	    	   optionwater['series'][1]['data'] = res.data.cash;
	    	   optionwater['series'][2]['data'] = res.data.recharge_win;
	    	   optiongame['series'][0]['data'] = res.data.bets;
	    	   optiongame['series'][1]['data'] = res.data.wins;
	    	   optiongame['series'][2]['data'] = res.data.bets_wins;
	    	   // 使用刚指定的配置项和数据显示图表。
	    	   water.setOption(optionwater);
	    	   game.setOption(optiongame);
	       }
		});
		
		//监听报表查询
		form.on('submit(countDataForm)', function(data){
			getDayStatCount();
			showTypeCount();
			return false;
		});
		
		//查询报表数据
		var getDayStatCount = function(){
			admin.req({
		        url: layui.setter.URL_ADMIN+'/countData/getDayStatCount'
		       ,data:{
		    	   startTime: $('#orderStartTime').val(),
		    	   endTime: $('#orderEndTime').val(),
		    	   userID: $('#orderUserID').val()
		       }
		       ,done: function(res){
				   if(res.otherData.uid==8) $('#supertadmincheck').show();
		    	   for(i in res.data){
		    		   $('#layui-data-'+i).text(res.data[i]);
		    	   }
		    	   $('#totalRecharge>i').text(res.data[19]);
		       }
			});
		}
		getDayStatCount();
	});
	
	layui.use('table', function(){
	    var $ = layui.$,table = layui.table;

	     //盈亏统计x
	     table.render({
	       elem: '#LAY-CountData-mainLeftReports'
	       ,url: layui.setter.URL_ADMIN+'/countData/mainLeftReports'
    	   ,where: {
	     	  token: layui.data('layuiAdmin').access_token
	       }
	       ,page: false
	       ,cols: [[
	         {field: 'title', width: 120, align: 'center', unresize: true}
	         ,{field: 'today', title: '今日统计', unresize: true}
	         ,{field: 'yesterday', title: '昨日统计', unresize: true}
	         ,{field: 'week', title: '本周统计', unresize: true}
	         ,{field: 'month', title: '本月统计', unresize: true}
	         ]]
	     });
	    
	     //月份统计x
	     table.render({
	       elem: '#LAY-CountData-mainRightReports'
	       ,url: layui.setter.URL_ADMIN+'/countData/mainRightReports'
    	   ,where: {
	     	  token: layui.data('layuiAdmin').access_token
	       }
	       ,page: false
	       ,cols: [[
	         {field: 'month', title: '月份', width: 120, align: 'center', unresize: true}
	         ,{field: 'rechargeAmount', title: '总存款', unresize: true}
	         ,{field: 'betAmount', title: '总投注', unresize: true}
	         ,{field: 'rechargeProfit', title: '充值盈亏', unresize: true}
	       ]]
	     });
	  });

	layui.use(['form','laydate'], function(){
		var form = layui.form;
		var laydate = layui.laydate;


		//初始化日历
		for(var i=1;i<=2;i++){
			var el='.time'+i
			laydate.render({
				elem: el
			});
		}
	});
	
	exports('countData', {})
});
