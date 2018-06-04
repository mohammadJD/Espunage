var paramAll= {};
var dataAll = {

};

var app = angular.module("myApp",[]);

app.controller("homePageController",function ($scope,$http) {
    $scope.test = "test.....";
    var octopus = {
        testApi:function () {
            $http.get("api/get-products").then(function (response) {
                console.log("test api....");
                console.log(response.data.data);
            });
        },
        init:function () {
            view.init();
        }
    };
    var view = {
        init:function () {
        octopus.testApi();
        }
    };

    octopus.init();
});

var octopusAll = {
    init:function () {
        viewAll.init();
    }
};
var viewAll = {
    init:function () {

    }
};

octopusAll.init();