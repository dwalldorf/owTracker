'use strict';

angular.module('owTracker')
    .controller('UserController', ['$scope', 'UserService', function ($scope, userService) {

        var initialUser = {
            email: '',
            password: ''
        };

        function init() {
            $scope.loginUser = angular.copy(initialUser);
            $scope.registerUser = angular.copy(initialUser);
        }

        $scope.login = function () {
            userService.login($scope.loginUser);
        };

        $scope.register = function () {
            userService.register($scope.registerUser);
        };

        init();
    }]);