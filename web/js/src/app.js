'use strict';

var app = angular.module('owTracker', ['ngCookies', 'ui.router', 'userModule', 'overwatchModule']);

app.run(['$rootScope', '$state', 'UserService', 'OverwatchService',
        function ($rootScope, $state, userService, overwatchService) {
            $rootScope.$state = $state;

            userService.getMe();
            overwatchService.getMapPool().then(function (res) {
                if (res.status == 200) {
                    $rootScope.mapPool = res.data;
                }
            });
        }
    ]
);