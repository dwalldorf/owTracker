'use strict';

angular.module('owTracker')
    .controller('UserController', ['$scope', '$state', 'UserService', 'STATE_INDEX', 'STATE_LOGIN',
        function ($scope, $state, userService, STATE_INDEX, STATE_LOGIN) {

            var initialUser = {
                username: '',
                email: '',
                password: ''
            };

            function init() {
                userService.getMe().then(function (res) {
                    if (res.status === 200) {
                        $state.go(STATE_INDEX);
                    }
                });

                $scope.loginUser = angular.copy(initialUser);
                $scope.registerUser = angular.copy(initialUser);
            }

            $scope.login = function () {
                userService.login($scope.loginUser).then(function (res) {
                    if (res.status === 200) {
                        $state.go(STATE_INDEX);
                    }
                });
            };

            $scope.register = function () {
                userService.register($scope.registerUser).then(function (res) {
                    if (res.status === 201) {
                        $state.go(STATE_LOGIN);
                    }
                });
            };

            init();
        }]);