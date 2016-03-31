'use strict';

angular.module('overwatchModule')
    .service('OverwatchService', ['$rootScope', '$http', '$q', '$cacheFactory', '$cookieStore', 'appConf',
        function ($rootScope, $http, $q, $cacheFactory, $cookieStore, appConf) {

            var OVERWATCH_URI = appConf.baseUrl + '/overwatch';

            var getOverwatchList = function () {
                var promise = $http.get(OVERWATCH_URI, {cache: false});

                return promise.then(function (res) {
                    $rootScope.overwatch = res.data;
                    return $rootScope.user;
                }, function () {
                    return promise;
                });
            };

            return {
                getOverwatchList: getOverwatchList
            }
        }
    ]);
