'use strict';

var app = angular.module('owTracker');

app.factory('httpErrorsInterceptor', ['$rootScope', '$q', '$injector', 'STATE_LOGIN',
    function ($rootScope, $q, $injector, ST_LOGIN) {

        return {
            responseError: function (res) {
                if (res.status === 403) {
                    var $state = $injector.get('$state');
                    $state.go(ST_LOGIN);
                }
                return $q.reject(res);
            }
        };

    }
]);

app.config(['$httpProvider', function ($httpProvider) {
    $httpProvider.defaults.withCredentials = true;
    $httpProvider.interceptors.push('httpErrorsInterceptor');
}]);