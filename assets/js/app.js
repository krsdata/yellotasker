var app = angular.module('paymentApp', [], function($interpolateProvider) {
	$interpolateProvider.startSymbol('<%');
	$interpolateProvider.endSymbol('%>');
});


app.controller('paymentController', function($scope, $http) {

	$scope.todos = [];
	$scope.loading = false;
	$scope.userProfit=0;
	$scope.userNetOutgoing=0;
	$scope.userNetIncoming=0;
	$scope.date='';
	$scope.endDate='';
	$scope.yelloEarn='';
	$scope.yelloSpend='';
	$scope.yelloProfit='';
	$scope.taskList=[];
	$scope.userData='';
	$scope.showList=false;
	$scope.label='';
	$scope.outgoingIndicator=true;
	$scope.incomingIndicator=false;

	$scope.init = function() {
		$scope.loading = true;
		$http.get('http://api.yellotasker.com/api/v1/getPostTask?releasedFund=0&taskStatus=completed').
		success(function(data, status, headers, config) {
			$scope.todos = data.data;
      console.log('data 2',$scope.todos);
				$scope.loading = false;

		});
	}



	$scope.releaseFund = function(taskId,userId,doerId) {
		$scope.loading = true;
		$http.get('http://api.yellotasker.com/api/v1/user/task/release-fund?taskId='+taskId+'&userId='+userId).
		success(function(data, status, headers, config) {
			if(data.message=='Task Payment done succesfully.') {
					$http.post('http://api.yellotasker.com/api/v1/taskCompleteFromDoer', {
						taskId : taskId,
						taskDoerId : doerId,
						status : 'completed '
					}).success(function(data, status, headers, config) {
						var index = $scope.todos.findIndex(x => x.id==taskId);
						if (index > -1) {
							$scope.todos.splice(index, 1);
					}
					});
					alert('Fund released Successfully')
				} else {
					alert('Fund already released')
				}
				$scope.loading = false;
		});
	}

	$scope.getUserData = function() {
		var userId=$scope.userId;
		$scope.loading = true;
		$http.get('http://api.yellotasker.com/api/v1/user/payments-histroy/outgoing?userId='+userId+'page_size=20&page_num=1').
		success(function(data, status, headers, config) {
			if(data.net_incoming!='0.00'||data.net_outgoing!='0.00') {
				  $scope.userData=data;
					$scope.userProfit=data.net_incoming-data.net_outgoing;
					$scope.label=$scope.userProfit>0?'Earned':'Spent';
					$scope.userNetOutgoing=data.net_outgoing;
					$scope.userNetIncoming=data.net_incoming;
					$scope.taskList=$scope.userData.data.outgoing;
					$scope.showList=$scope.taskList.length>0?true:false;
				} else {
					$scope.showList=false;
					$scope.userData='';
					$scope.userProfit=0;
					$scope.userNetOutgoing=0;
					$scope.userNetIncoming=0;
					$scope.taskList=[];
					alert('No transaction found found for this input.Please enter correct user id or check into the user management module.');
				}
				$scope.loading = false;
		});
	}
	$scope.showTaskList = function(listType){
		if(listType=='outgoing') {
      $scope.taskList=$scope.userData.data.outgoing!=undefined?$scope.userData.data.outgoing:[];
			$scope.showList=$scope.taskList.length>0?true:false;
			$scope.outgoingIndicator=true;
			$scope.incomingIndicator=false;
		} else if(listType=='incoming') {
			$scope.outgoingIndicator=false;
			$scope.incomingIndicator=true;
			var userId=$scope.userId;
			$http.get('http://api.yellotasker.com/api/v1/user/payments-histroy/earned?userId='+userId+'page_size=20&page_num=1').
			success(function(data, status, headers, config) {
				if(data.message=='Payment histroy found.') {
						$scope.userData=data;
						$scope.taskList=$scope.userData.data;
						$scope.showList=$scope.taskList.length>0?true:false;
					} else {
						$scope.taskList=[];
						$scope.showList=false;
					}
					$scope.loading = false;
			});

		}
	}

	$scope.getYellotaskerData= function() {
	$scope.loading = true;
  var startDate=$("#startDate").val();
	var endDate=$("#endDate").val()
	$http.get('http://api.yellotasker.com/api/v1/incomeDetail?startDate='+startDate+'&endDate='+endDate).
	success(function(data, status, headers, config) {
		if(data.message=='Yellotasker income details') {
				$scope.yelloEarn=data.data.earn;
				$scope.yelloSpend=data.data.spend;
				$scope.yelloProfit=data.data.profit;
			} else {
				alert('No details found');
			}
			$scope.loading = false;
	});
};

	$scope.addTodo = function() {
		console.log('here');
				$scope.loading = true;

		$http.post('/api/todos', {
			title: $scope.todo.title,
			done: $scope.todo.done
		}).success(function(data, status, headers, config) {
			$scope.todos.push(data);
			$scope.todo = '';
				$scope.loading = false;

		});
	};

	$scope.updateTodo = function(todo) {
		$scope.loading = true;

		$http.put('/api/todos/' + todo.id, {
			title: todo.title,
			done: todo.done
		}).success(function(data, status, headers, config) {
			todo = data;
				$scope.loading = false;

		});;
	};

	$scope.deleteTodo = function(index) {
		$scope.loading = true;

		var todo = $scope.todos[index];

		$http.delete('/api/todos/' + todo.id)
			.success(function() {
				$scope.todos.splice(index, 1);
					$scope.loading = false;

			});;
	};



	$scope.init();

});

// app.directive('datepicker', function () {
// 	console.log('here');
// return {
//     restrict: 'A',
//     require: 'ngModel',
//      link: function (scope, element, attrs, ngModelCtrl) {
// 			 	console.log('here');
//             $(element).datepicker({
//                 dateFormat: ' yy,dd, MM',
//                 onSelect: function (date) {
// 								//	scope.date = date;
//                   //  scope.$apply();
//                 }
//             });
//         }
//     };
// });
