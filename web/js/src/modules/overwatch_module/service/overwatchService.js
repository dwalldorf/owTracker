'use strict';

angular.module('overwatchModule')
    .service('OverwatchService', ['$rootScope', '$http', '$q', '$cacheFactory', '$cookieStore', 'appConf',
        function ($rootScope, $http, $q, $cacheFactory, $cookieStore, appConf) {

            var OVERWATCH_URI = appConf.baseUrl + '/overwatch/verdicts';

            var getOverwatchList = function () {
                var userId = $rootScope.user.id;
                return $http.get(OVERWATCH_URI + '/' + userId, {cache: false});
            };

            var getMapPool = function () {
                return $http.get(appConf.baseUrl + '/overwatch/mappool', {cache: false});
            };

            var submitOverwatch = function (overwatch) {
                return $http.post(OVERWATCH_URI, overwatch);
            };

            var getOverwatchUserScores = function () {
                /*
                 * TODO: implement
                 */
            };

            return {
                getOverwatchList: getOverwatchList,
                submitOverwatch: submitOverwatch,
                getMapPool: getMapPool,
                getOverwatchUserScores: getOverwatchUserScores
            }
        }
    ]);
