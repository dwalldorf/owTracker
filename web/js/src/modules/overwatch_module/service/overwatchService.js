'use strict';

angular.module('overwatchModule')
    .service('OverwatchService', ['$rootScope', '$http', '$q', '$cacheFactory', '$cookieStore', 'appConf',
        function ($rootScope, $http, $q, $cacheFactory, $cookieStore, appConf) {

            var OVERWATCH_URI = appConf.baseUrl + '/overwatch';

            var getOverwatchList = function () {
                return $http.get(OVERWATCH_URI, {cache: false});
            };

            var submitOverwatch = function (overwatch) {
                return $http.post(OVERWATCH_URI, overwatch);
            };

            return {
                getOverwatchList: getOverwatchList,
                submitOverwatch: submitOverwatch
            }
        }
    ]);
