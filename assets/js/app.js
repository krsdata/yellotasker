var app = angular.module('paymentApp', [], function($interpolateProvider) {
	$interpolateProvider.startSymbol('<%');
	$interpolateProvider.endSymbol('%>');
});


app.controller('paymentController', function($scope, $http) {

	$scope.list = [];
	$scope.showReleaseFundList=false;
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
	$scope.showError = false;
	$scope.yelloIncome=[];
	$scope.yelloOutgoing=[];
	$scope.yelloOutgoingIndicator=false;
	$scope.yelloIncomingIndicator=false;
	$scope.showYelloList=false;
	$scope.chngServiceChargeIndicator=false;

	$scope.init = function() {
		$scope.loading = true;
		$http.get('http://api.yellotasker.com/api/v1/getPostTask?releasedFund=0&taskStatus=completed').
		success(function(data, status, headers, config) {
			$scope.list = data.data;
			$scope.showReleaseFundList=$scope.list.length>0?true:false;
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
						status : 'closed '
					}).success(function(data, status, headers, config) {
						var index = $scope.list.findIndex(x => x.id==taskId);
						if (index > -1) {
							$scope.list.splice(index, 1);
					}
					$scope.showReleaseFundList=$scope.list.length>0?true:false;
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
					$scope.userProfit=$scope.userProfit>0?$scope.userProfit:Math.abs($scope.userProfit);
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
	$scope.showYelloTaskList= function(listType){
		if(listType=='outgoing') {
			$scope.showYelloList=$scope.yelloOutgoing!=null&&$scope.yelloOutgoing.length>0?true:false;
			$scope.yelloOutgoingIndicator=true;
			$scope.yelloIncomingIndicator=false;
		} else if(listType=='incoming') {
			$scope.showYelloList=$scope.yelloIncomess!=null&&$scope.yelloIncome.length>0?true:false;
			$scope.yelloOutgoingIndicator=false;
			$scope.yelloIncomingIndicator=true;

		}
	}
	$scope.appliedClass = function() {
	    if ($scope.yelloIncomingIndicator === true) {
	        return "active";
	    } else {
	        return ""; // Or even "", which won't add any additional classes to the element
	    }
	}
	$scope.appliedActiveClass = function() {
	    if ($scope.yelloOutgoingIndicator === true) {
	        return "active";
	    } else {
	        return ""; // Or even "", which won't add any additional classes to the element
	    }
	}
	$scope.getYellotaskerData= function() {
	$scope.loading = true;
  var startDate=$("#startdate").val();
	var endDate=$("#enddate").val()
	if(startDate&&endDate) {
		$scope.showError = false;
		$http.get('http://api.yellotasker.com/api/v1/incomeDetail?startDate='+startDate+'&endDate='+endDate).
		success(function(data, status, headers, config) {
			if(data.message=='Yellotasker income details') {
					$scope.yelloEarn=data.income_details.earn;
					$scope.yelloSpend=data.income_details.spend;
					$scope.yelloProfit=data.income_details.profit;
					$scope.yelloIncome=data.data.erned_task_list;
					$scope.yelloOutgoing=data.data.spend_task_list;
					$scope.yelloOutgoingIndicator=true;
					$scope.showYelloList=$scope.yelloOutgoing!=null&&$scope.yelloOutgoing.length>0?true:false;
				} else {
					alert('No details found');
				}
				$scope.loading = false;
		});
	} else {
		$scope.showError = true;
	}

};
$scope.changeServiceCharge= function() {
	$scope.chngServiceChargeIndicator = true;


};
$scope.close= function() {
	$scope.chngServiceChargeIndicator = false;
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
