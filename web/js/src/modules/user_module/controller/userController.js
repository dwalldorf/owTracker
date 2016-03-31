'use strict';

angular.module('owTracker')
    .controller('UserController', ['$scope', 'UserService', function ($scope, userService) {

        function init() {
            $scope.loginUser = {
                email: '',
                password: ''
            };
            $scope.registerUser = {
                email: '',
                password: ''
            };
        }

        $scope.login = function () {
            userService.login($scope.loginUser).then(function () {

            });
        };

        $scope.register = function () {
            userService.register($scope.registerUser);
        };

        init();
    }]);