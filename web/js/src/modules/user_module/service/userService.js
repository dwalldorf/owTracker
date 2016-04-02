'use strict';

angular.module('userModule')
    .service('UserService', ['$rootScope', '$http', '$q', '$cacheFactory', '$cookieStore', 'appConf',
        function ($rootScope, $http, $q, $cacheFactory, $cookieStore, appConf) {

            var CURRENT_USER_URI = appConf.baseUrl + '/users/me';
            var LOGIN_URI = appConf.baseUrl + '/user/login';
            var USERS_URI = appConf.baseUrl + '/users';

            var getMe = function () {
                var promise = $http.get(CURRENT_USER_URI, {cache: true});

                return promise.then(function (res) {
                    $rootScope.user = res.data;
                    return $rootScope.user;
                }, function () {
                    // error - user not logged in anymore
                    $rootScope.user = undefined;
                    return promise;
                });
            };

            var login = function (user) {
                return $http.post(LOGIN_URI, user).then(function (res) {
                    if (res.status == 200) {
                        $rootScope.user = res.data;
                    }
                });
            };

            var register = function (user) {
                return $http.post(USERS_URI, user);
            };

            return {
                getMe: getMe,
                login: login,
                register: register
            };
        }
    ]);
