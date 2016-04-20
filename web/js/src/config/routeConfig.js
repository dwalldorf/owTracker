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

app.run(['$rootScope', '$state', 'UserService', 'STATE_LOGIN',
    function ($rootScope, $state, userService, STATE_LOGIN) {

        $rootScope.$on('$stateChangeStart', function (event, toState, toParams) {
            event.preventDefault();

            var stateName = toState.name,
                stateData = toState.data || {};

            if (stateData.requireLogin) {
                userService.getMe().then(function (res) {
                    if (res.status === 200) {
                        $state.go(stateName, toParams, {notify: false}).then(function () {
                            $rootScope.$broadcast('$stateChangeSuccess', toState, toParams);
                        });
                    } else {
                        $state.go(STATE_LOGIN, toParams, {notify: false}).then(function () {
                            $rootScope.$broadcast('$stateChangeSuccess', toState, toParams);
                        });
                    }
                });
            } else {
                // page does not require login - go on
                $state.go(stateName, toParams, {notify: false}).then(function () {
                    $rootScope.$broadcast('$stateChangeSuccess', toState, toParams);
                });
            }
        });

    }]
);