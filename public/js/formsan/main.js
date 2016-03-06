angular.module('Formsan', ['ngRoute', 'ngSanitize'])
        .controller('MainController', function ($scope, $route, $routeParams, $location) {
            $scope.$route = $route;
            $scope.$location = $location;
            $scope.$routeParams = $routeParams;

            console.debug($location, '$location');
        })
        .controller('Category', function ($scope, $routeParams, $http) {

            console.debug(frs.category.cnf, 'frs.category.cnf');

            var cnf = frs.category.cnf(),
                    frm = cnf.getForm();
            $scope.form = frm.head;
            $scope.items = frm.items;
            $scope.params = frm.params;
            $scope.field = {};
            console.debug($scope.items, '$scope.items');

            $http({
                method: 'POST',
                // cache: true,
                url: '/formsanajax',
                data: {mdl: 'CategoryList', id: 33}, //id=78&baz=moe',//
                headers: {'Content-Type': 'application/json; charset=UTF-8'}
            }).then(function (response) {
                console.debug(response.data.rows.list[0], 'response.data.form.elements');
                $scope.list = response.data.rows.list;
                $scope.field = response.data.rows.list[0];

                console.debug($scope.field);

            });


            $scope.submit = function () {
//@todo radio + hidden + select + checkbox
                console.debug(this.field, 'submi-this');
                var mthod = this.field.id > 0 ? 'CategoryUpdate' : 'CategoryAdd';

                $http({
                    method: 'POST',
                    // cache: true,
                    url: '/formsanajax',
                    data: {mdl: mthod, param: this.field}, //id=78&baz=moe',//
                    headers: {'Content-Type': 'application/json; charset=UTF-8'}
                }).then(function (response) {
                    //console.debug(response.data.form.elements, 'response.data.form.elements');
                    $scope.list = response.data.rows;

                });


                return false;

            };

            $scope.getElement = function (id) {                
                $http({
                    method: 'POST',
                    // cache: true,
                    url: '/formsanajax',
                    data: {mdl: 'CategoryById', param: {id: id}}, //id=78&baz=moe',//
                    headers: {'Content-Type': 'application/json; charset=UTF-8'}
                }).then(function (response) {
                    console.debug(response.data.rows, 'response.data.rows-1');
                    // $scope.list = response.data.rows;
                    $scope.field = response.data.rows;
                });
            }
        })

        .controller('List', function ($scope, $routeParams, $http) {

            /*$http.get("http://www.w3schools.com/angular/customers.php").then(function (response) {
             
             console.log(response);
             $scope.list = response.data.records;
             });
             
             //alert(6);
             $scope.firstName = "monika";
             $scope.lastName = "s";*/
        })
        
        .controller('Param', function ($scope, $routeParams, $http) {

        })


        .controller('Plant', function ($scope, $routeParams, $http) {
            var cnf = frs.plant.cnf(),
                    frm = cnf.getForm();
            $scope.form = frm.head;
            $scope.items = frm.items;
            $scope.params = frm.params;
            $scope.field = {};

            function getPlantList() {
                
                $http({
                    method: 'POST',
                    // cache: true,
                    url: '/formsanajax',
                    data: {mdl: 'PlantList', id: 33}, //@todo , dodac filtrowanie id
                    headers: {'Content-Type': 'application/json; charset=UTF-8'}
                }).then(function (response) {
                    //console.debug(response.data.rows.list[0], 'response.data.form.elements');
                    $scope.list = response.data.rows.list;
                });
            }
            getPlantList();
            
            $scope.submit = function () {
                //console.debug(this.field, 'submi-this');               
               
                $http({
                    method: 'POST',
                    // cache: true,
                    url: '/formsanajax',
                    data: {mdl: 'PlantSet', param: this.field}, //id=78&baz=moe',//
                    headers: {'Content-Type': 'application/json; charset=UTF-8'}
                }).then(function (response) {
                    //console.debug(response.data.form.elements, 'response.data.form.elements');
                    //$scope.list = response.data.rows;
                   // alert(45);
                    getPlantList();
                });
                return false;
            };

            $scope.getElement = function (id) {
                $http({
                    method: 'POST',
                    // cache: true,
                    url: '/formsanajax',
                    data: {mdl: 'PlantById', param: {id: id}}, //id=78&baz=moe',//
                    headers: {'Content-Type': 'application/json; charset=UTF-8'}
                }).then(function (response) {
                    $scope.field = response.data.rows;

                    //console.debug(response.data.categories, 'response.data.categories');
                    //console.debug(response.data.rows, 'response.data.rows-2');

                    frm = cnf.setSelect(frm, 1, response.data.categories.list, response.data.rows.category);
                    $scope.items = frm.items;
                    //$scope.items = frm.items;
                    //console.debug($scope.items, '$scope-items-2');
                    

                });
            }
        })

//https://scotch.io/tutorials/single-page-apps-with-angularjs-routing-and-templating
//https://docs.angularjs.org/api/ngRoute/service/$route#example
        .config(function ($routeProvider, $locationProvider) {

            $routeProvider
                    .when('/', {//http://cedrus.dv/formsan#/
                        templateUrl: '/formsantemplate,s,list',
                        controller: 'List'
                    })
                    // route for the home page
                    .when('/category', {
                        templateUrl: '/formsantemplate,s,list',
                        controller: 'Category'
                    })

                    // route for the about page
                    .when('/plant', {
                        templateUrl: '/formsantemplate,s,list',
                        controller: 'Plant'
                    })
                    
                    .when('/param', {
                        templateUrl: '/formsantemplate,s,list',
                        controller: 'Param'
                    });
            //alert($locationProvider.path());    
            console.debug($routeProvider, '$routeProvider');
            console.debug($locationProvider, '$locationProvider');
            // configure html5 to get links working on jsfiddle
            //$locationProvider.html5Mode(true);
        });





   