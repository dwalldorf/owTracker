'use strict';

var app = angular.module('owTracker');

// routes
app.config(['$locationProvider', '$urlRouterProvider', '$stateProvider',
    function ($locationProvider, $urlRouterProvider, $stateProvider) {
        $urlRouterProvider.otherwise(function ($injector) {
            $injector.get('$state').go('index');
        });

        $stateProvider.state('page', {
            abstract: true,
            templateUrl: 'js/src/views/base.html'
        });
    }]
);