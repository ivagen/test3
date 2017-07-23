var app = angular.module('app', ['toaster']).config(function ($interpolateProvider) {
    $interpolateProvider.startSymbol('{[{').endSymbol('}]}');
});

app.factory("services", function ($http, toaster) {

    return {
        getBets: function () {
            return $http.get('list?' + new Date().getTime(), {headers: {'Cache-Control': 'no-cache'}});
        },
        addBet: function (bet) {
            return $http.post('bet', bet.data).then(function successCallback(response) {
                toaster.pop({
                    type: 'success',
                    title: 'Create item',
                    body: 'Bet added'
                });

                for (k in bet.data) {
                    bet.data[k] = '';
                }
            }, function errorCallback(response) {
                response.data.errors.forEach(function (error) {
                    toaster.pop({
                        type: 'error',
                        title: 'Error',
                        body: error
                    });
                });
            });
        },
        addScore: function (score) {
            return $http.post('score', score.data).then(function successCallback(response) {
                toaster.pop({
                    type: 'success',
                    title: 'Create item',
                    body: 'Score added'
                });

                for (k in score.data) {
                    score.data[k] = '';
                }
            }, function errorCallback(response) {
                response.data.errors.forEach(function (error) {
                    toaster.pop({
                        type: 'error',
                        title: 'Error',
                        body: error
                    });
                });
            });
        }
    };
});

app.controller('ListController', [ '$scope', '$rootScope', 'services', function ($scope, $rootScope, services) {

    $rootScope.$on('getBets', function(event) {
        services.getBets().then(function (data) {
            $scope.bets = data.data;
        });
    });

    $rootScope.$emit('getBets');
}]);

app.controller('BetController', [ '$scope', '$rootScope', 'services', function ($scope, $rootScope, services) {
    $scope.addBet = function (bet) {
        services.addBet(bet);
        $rootScope.$emit('getBets');
    };
}]);

app.controller('ScoreController', [ '$scope', '$rootScope', 'services', function ($scope, $rootScope, services) {
    $scope.addScore = function (score) {
        services.addScore(score);
        $rootScope.$emit('getBets');
    };
}]);
