'use strict';

var bestBookApp = angular.module('bestBooks', [
	'ngRoute',
	'userModule'                                                       
]);

bestBookApp.config(function($routeProvider, $httpProvider) {

	$routeProvider.when('/', {
		templateUrl : 'home.html',
		controller : 'home'
	})
    .when('/login', {
		templateUrl : 'login.html',
		controller : 'login'
	})
    .when('/register', {
		templateUrl : 'register.html',
		controller : 'register'
	})
    .when('/resetPassword', {
		templateUrl : 'resetPassword.html',
		controller : 'resetPassword'
	})
    .otherwise('/');

	$httpProvider.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

});