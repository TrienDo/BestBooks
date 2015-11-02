'use strict';
//Declare a module
var userModule = angular.module('userModule', []);

userModule.controller('login3', function($rootScope, $scope, $http, $location, $route) {

	$scope.tab = function(route) {
		return $route.current && route === $route.current.controller;
	};

	var authenticate = function(credentials, callback) {
		//encode and create header
		var headers = credentials ? {
			authorization : "Basic " + btoa(credentials.username + ":" + credentials.password)
		} : {};
		
		//Authenticate with server
		$http.get('/user', { headers : headers})
		.success(function(data) {
			if (data.id != -1) {
				$rootScope.authenticated = true;				
			} 
			else {
				$rootScope.authenticated = false;
			}
			callback && callback($rootScope.authenticated);
		})
		.error(function() {
			$rootScope.authenticated = false;
			callback && callback(false);
		});
	}

	//authenticate();

	//$scope.credentials = {};
	
	
	$scope.logout = function() {
		$http.post('/logout', {}).success(function() {
			$rootScope.authenticated = false;
			$location.path("/");
		}).error(function(data) {
			console.log("Logout failed")
			$location.path("/");
			$rootScope.authenticated = false;
		});
	}

});

userModule.controller('home', function($scope, $http) {
	//$http.get('/resource').success(function(data) {
	//	$scope.greeting = data;
	//});
});

userModule.controller('register', function($scope, $http, $route) {
	$scope.register = function() {					
		var userObj = {
			username : $scope.user.username,
			email : $scope.user.email,
			password : $scope.user.password
		};
	
		$http.post('/BestBooks/api/v1/users', userObj).success(function(data) {
			//$location.path("/login");
			$scope.error = data.error;
			$scope.messageContent = data.message;			
		});
	};		
});

userModule.controller('login', function($scope, $http, $route,$location) {
	$scope.login = function() {
	   var loginObj = {
			email: $scope.user.email,
            password: btoa($scope.user.password)
		};
	   
	   $http.post('/BestBooks/api/v1/login',loginObj).success(function(data) {
			$location.path("/");
			$scope.error = data.error;
			$scope.messageContent = data.username;	
            if(!$scope.error)
            {
                $location.path("/");
                //$("#userName").text($scope.messageContent);
                //Add submenu
                var content = '<li class="dropdown">'
                            + '<a class="dropdown-toggle" data-toggle="dropdown" href="#">' + $scope.messageContent + '<span class="caret"></span></a>'
                            +    '<ul class="dropdown-menu">'
                            +        '<li><a href="#">Your details</a></li>'
                            +        '<li><a href="#">Change password</a></li>'
                            +        '<li><a href="#">Log out</a></li>'                        
                            +    '</ul>'
                            + '</li>';
                $("#userProfile").empty();
                $("#userProfile").append(content);
            }		
	   }); 
	};	
});
