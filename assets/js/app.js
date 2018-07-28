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
	$scope.userReportIncoming=[];
	$scope.userReportOutgoing=[];
	$scope.showList=false;
	$scope.label='';
	$scope.outgoingIndicator=false;
	$scope.incomingIndicator=false;
	$scope.showError = false;
	$scope.yelloIncome=[];
	$scope.yelloOutgoing=[];
	$scope.yelloOutgoingIndicator=false;
	$scope.yelloIncomingIndicator=false;
	$scope.showYelloList=false;
	$scope.chngServiceChargeIndicator=false;
	$scope.currentServiceCharge='';
	$scope.serviceChargeError=false;
	$scope.withdrawallist = [];
	$scope.showWithdrawalList=false;
	$scope.currDomain='';
	$scope.sipListIndicator=false;
	$scope.rfListIndicator=false;
	
	$scope.init = function() {
		//$scope.currDomain=window.location.origin;
		//var re = new RegExp(/^.*\//);
		$scope.currDomain +=  window.location.origin 
		? window.location.origin + '/'
		: window.location.protocol + '/' + window.location.host + '/';
		console.log('domain',$scope.currDomain);
		$scope.loading = true;
		$http.get('http://api.yellotasker.com/api/v1/getPostTask?releasedFund=0&taskStatus=completed').
		success(function(data, status, headers, config) {
			$scope.list = data.data;
			$scope.showReleaseFundList=$scope.list.length>0?true:false;
			$scope.loading = false;

		});
		$scope.getServiceCharge();
		$scope.getWithrawalList();
	}
	// get withrawal list
	$scope.getWithrawalList = function() {
		$http.get('http://api.yellotasker.com/api/v1/withdrawalsRequest').
		success(function(data, status, headers, config) {
			if(data.status==1&&data.message=='Withdrawals List found.')
			$scope.withdrawallist = data.data;
			$scope.sipListIndicator=true;
			$scope.showWithdrawalList=$scope.withdrawallist.length>0?true:false;
			$scope.loading = false;

		});
	}
	//release fund
	$scope.releaseFund = function(id,response) {
		if(response!=null&&response!='') {
			alert(response)
		} else {
			$http.get('http://api.yellotasker.com/api/v1/user/withdrawal/approve?withdrawalId='+id).
			success(function(data, status, headers, config) {
				console.log('id',data.status,data.message);
				if(data.status==1&&data.message=='Withdrawal request initialize successfully.') {
					var index = $scope.withdrawallist.findIndex(x => x.id==id);
					if (index > -1) {
						$scope.withdrawallist.splice(index, 1);
					}
					$scope.showWithdrawalList=$scope.withdrawallist.length>0?true:false;
					$scope.loading = false;
				} else {
					alert('Something went wrong!')
				}
			});
		}
	}

	$scope.sendWithrawalReq = function(taskId,userId,doerId,amount) {
		$scope.loading = true;
			$http.get('http://api.yellotasker.com/api/v1/user/task/release-fund?taskId='+taskId+'&userId='+doerId).
		success(function(data, status, headers, config) {
			$http.get('http://api.yellotasker.com/api/v1/user/bank_detail/list?userId='+doerId).
			success(function(data, status, headers, config) {
				if(data.message=='Records found.') {
					var bankId=data.data[0].id;
						$http.get('http://api.yellotasker.com/api/v1/user/withdrawal/newrequest?userId='+doerId+'&amount='+amount+'&bankId='+bankId).success(function(data, status, headers, config) {
						if(data.message=='Withdrawal request added succesfully.'){
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
							alert('Task closed successfully.Task life cycle completed successfully.You can release funds now.')
							} else {
								alert('Something went wrong!');
							}							
						});
						
					} else {
						alert('No record found')
					}
					$scope.loading = false;
			});
		});
	}

	$scope.getUserData = function() {
		var userId=$scope.userId;
		$scope.loading = true;
		$http.get('http://api.yellotasker.com/api/v1/user/payments-histroy/outgoing?userId='+userId+'page_size=20&page_num=1').
		success(function(data, status, headers, config) {
			if(data.net_incoming!='0.00'||data.net_outgoing!='0.00') {
				    $scope.userReportOutgoing=data;
					$scope.userProfit=data.net_incoming-data.net_outgoing;
					$scope.label=$scope.userProfit>0?'Earned':'Spent';
					$scope.userProfit=$scope.userProfit>0?$scope.userProfit:Math.abs($scope.userProfit);
					$scope.userNetOutgoing=data.net_outgoing;
					$scope.userNetIncoming=data.net_incoming;
					$scope.taskList=$scope.userReportOutgoing.data.outgoing;
					$scope.showList=$scope.taskList.length>0?true:false;
					$scope.outgoingIndicator=true;
					$scope.incomingIndicator=false;
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
            $scope.taskList=$scope.userReportOutgoing.data.outgoing;
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
						$scope.userReportIncoming=data;
						$scope.taskList=$scope.userReportIncoming.data;
						$scope.showList=$scope.taskList.length>0?true:false;
					} else {
						$scope.taskList=[];
						$scope.showList=false;
					}
					$scope.loading = false;
			});

		}
	}
	// yellotasker report tab indicator
	$scope.showYelloTaskList= function(listType){
		if(listType=='outgoing') {
			$scope.showYelloList=$scope.yelloOutgoing!=null&&$scope.yelloOutgoing.length>0?true:false;
			$scope.yelloOutgoingIndicator=true;
			$scope.yelloIncomingIndicator=false;
		} else if(listType=='incoming') {
			$scope.showYelloList=$scope.yelloIncome!=null&&$scope.yelloIncome.length>0?true:false;
			$scope.yelloOutgoingIndicator=false;
			$scope.yelloIncomingIndicator=true;

		}
	}
	//applied active class for yellotasker report
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
	//applied active class for user report
	$scope.appliedClassForUser = function() {
	    if ($scope.incomingIndicator === true) {
	        return "active";
	    } else {
	        return ""; // Or even "", which won't add any additional classes to the element
	    }
	}
	$scope.appliedActiveClassForUser = function() {
	    if ($scope.outgoingIndicator === true) {
	        return "active";
	    } else {
	        return ""; // Or even "", which won't add any additional classes to the element
	    }
	}
	// applied active class for release fund
	$scope.appliedActiveClassForRf = function() {
	    if ($scope.sipListIndicator === true) {
	        return "active";
	    } else {
	        return ""; 
	    }
	}
	// applied active class for release fund
	$scope.appliedClassForRf = function() {
	    if ($scope.rfListIndicator === true) {
	        return "active";
	    } else {
	        return ""; 
	    }
	}
	// change list
	$scope.changeList = function(listType) {
	    if (listType === 'sip') {
			$scope.sipListIndicator = true
			$scope.rfListIndicator = false
	    } else if(listType === 'rf') {
			$scope.rfListIndicator = true
			$scope.sipListIndicator = false
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
// get service charge 
$scope.getServiceCharge = function() {
	$scope.loading = true;
	$http.get('http://api.yellotasker.com/api/v1/serviceCharge').
	success(function(data, status, headers, config) {
		if(data.message=='Service charge'){
			$scope.currentServiceCharge=data.data.field_value;
		} else {
			$scope.currentServiceCharge='';
		}
	
		$scope.loading = false;

	});
}
//save service charge
$scope.saveServiceCharge=function() {
	var newServiceCharge=$scope.model.serviceCharge;
	if (/^\d*[1-9]\d*$/.test(+newServiceCharge)&&newServiceCharge!=''){
		$scope.serviceChargeError=false;
		$http.post('http://api.yellotasker.com/api/v1/serviceCharge', {
			service_charge :newServiceCharge
		}).success(function(data, status, headers, config) {
			if(data.message=='Service charge updated') {
				$scope.chngServiceChargeIndicator = false;
				$scope.model.serviceCharge='';
				$scope.currentServiceCharge=newServiceCharge;
				alert('Service charge updated successfully.')
			} else {
				alert('Something went wrong!')
						}
			});
				} else {
					$scope.serviceChargeError=true;
				}
			
			}

$scope.changeServiceCharge= function() {
	$scope.chngServiceChargeIndicator = true;


};
$scope.close= function() {
	$scope.chngServiceChargeIndicator = false;
	$scope.serviceChargeError=false;
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
