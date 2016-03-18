
var $FilesUpload = [];
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
                headers: {'Content-Type': 'application/json; charset=UTF-8', 'X-Requested-With': 'XMLHttpRequest'}
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
                    headers: {'Content-Type': 'application/json; charset=UTF-8', 'X-Requested-With': 'XMLHttpRequest'}
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
                    headers: {'Content-Type': 'application/json; charset=UTF-8', 'X-Requested-With': 'XMLHttpRequest'}
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
                    headers: {'Content-Type': 'application/json; charset=UTF-8', 'X-Requested-With': 'XMLHttpRequest'}
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
                    headers: {'Content-Type': 'application/json; charset=UTF-8', 'X-Requested-With': 'XMLHttpRequest'}
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
                    headers: {'Content-Type': 'application/json; charset=UTF-8', 'X-Requested-With': 'XMLHttpRequest'}
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
        }).controller('Pot', function ($scope, $routeParams, $http) {
    var cnf = frs.pot.cnf(),
            frm = cnf.getForm();
    $scope.form = frm.head;
    $scope.items = frm.items;
    $scope.params = frm.params;
    $scope.field = {};

    function getPotList() {

        $http({
            method: 'POST',
            // cache: true,
            url: '/formsanajax',
            data: {mdl: 'PotList', id: 33}, //@todo , dodac filtrowanie id
            headers: {'Content-Type': 'application/json; charset=UTF-8', 'X-Requested-With': 'XMLHttpRequest'}
        }).then(function (response) {
            //console.debug(response.data.rows.list[0], 'response.data.form.elements');
            $scope.list = response.data.rows.list;
        });
    }
    getPotList();

    $scope.submit = function () {
        //console.debug(this.field, 'submi-this');               

        $http({
            method: 'POST',
            // cache: true,
            url: '/formsanajax',
            data: {mdl: 'PotSet', param: this.field}, //id=78&baz=moe',//
            headers: {'Content-Type': 'application/json; charset=UTF-8', 'X-Requested-With': 'XMLHttpRequest'}
        }).then(function (response) {
            //console.debug(response.data.form.elements, 'response.data.form.elements');
            //$scope.list = response.data.rows;
            // alert(45);
            getPotList();
        });
        return false;
    };

    $scope.getElement = function (id) {
        $http({
            method: 'POST',
            // cache: true,
            url: '/formsanajax',
            data: {mdl: 'PotById', param: {id: id}}, //id=78&baz=moe',//
            headers: {'Content-Type': 'application/json; charset=UTF-8', 'X-Requested-With': 'XMLHttpRequest'}
        }).then(function (response) {
            $scope.field = response.data.rows;

            //console.debug(response.data.categories, 'response.data.categories');
            //console.debug(response.data.rows, 'response.data.rows-2');

            frm = cnf.setSelect(frm, 1, response.data.categories.list, response.data.rows.category);
            $scope.items = frm.items;
            //$scope.items = frm.items;
            //console.debug($scope.items, '$scope-items-2');


        });
    };
})
        .controller('Gallery', function ($scope, $routeParams, $http) {
            var cnf = frs.gallery.cnf(),
                    frm = cnf.getForm();
            $scope.form = frm.head;
            $scope.items = frm.items;
            $scope.params = frm.params;
            $scope.field = {};
            $scope.files = [];
            $scope.uploadFile = function () {
                console.debug($scope.files, '$scope.files');
                console.log($scope.files.length + " files selected ... Write your Upload Code");

            };

            /*$scope.$watch('variable', function (value) {
             
             //alert(71);
             if (value) {
             console.log(value);
             }
             });*/

            function getGalleryList() {

                $http({
                    method: 'POST',
                    // cache: true,
                    url: '/formsanajax',
                    data: {mdl: 'StuffList', id: 33, type: 'G'}, //@todo , dodac filtrowanie id
                    headers: {'Content-Type': 'application/json; charset=UTF-8', 'X-Requested-With': 'XMLHttpRequest'}
                }).then(function (response) {
                    //console.debug(response.data.rows.list[0], 'response.data.form.elements');
                    $scope.list = response.data.rows.list;
                });
            }
            getGalleryList();




            $scope.submit = function () {
                console.debug(this.field, 'submi-this');
                this.field.type = 'G';
                console.debug($scope, '$scope.files-submit');

                console.debug($FilesUpload, '$FilesUpload');
                $http({
                    method: 'POST',
                    // cache: true,
                    url: '/formsanajax',
                    data: {mdl: 'StuffSet', param: this.field}, //id=78&baz=moe',//
                    headers: {'Content-Type': 'application/json; charset=UTF-8', 'X-Requested-With': 'XMLHttpRequest'}
                }).then(function (response) {
                    //console.debug(response.data.form.elements, 'response.data.form.elements');
                    //$scope.list = response.data.rows;
                    // alert(45);
                    getGalleryList();
                });
                return false;
            };

            $scope.getElement = function (id) {
                $http({
                    method: 'POST',
                    // cache: true,
                    url: '/formsanajax',
                    data: {mdl: 'StuffById', param: {id: id}}, //id=78&baz=moe',//
                    headers: {'Content-Type': 'application/json; charset=UTF-8', 'X-Requested-With': 'XMLHttpRequest'}
                }).then(function (response) {
                    $scope.field = response.data.rows;

                    //console.debug(response.data.categories, 'response.data.categories');
                    //console.debug(response.data.rows, 'response.data.rows-2');

                    frm = cnf.setSelect(frm, 1, response.data.categories.list, response.data.rows.category);
                    $scope.items = frm.items;
                    //$scope.items = frm.items;
                    //console.debug($scope.items, '$scope-items-2');


                });
            };
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

                    .when('/pot', {
                        templateUrl: '/formsantemplate,s,list',
                        controller: 'Pot'
                    })

                    .when('/param', {
                        templateUrl: '/formsantemplate,s,list',
                        controller: 'Param'
                    })

                    .when('/gallery', {
                        templateUrl: '/formsantemplate,s,list',
                        controller: 'Gallery'
                    });
            //alert($locationProvider.path());    
            console.debug($routeProvider, '$routeProvider');
            console.debug($locationProvider, '$locationProvider');
            // configure html5 to get links working on jsfiddle
            //$locationProvider.html5Mode(true);
        })


        .directive('ngFileModel', ['$parse', function ($parse) {

                return function (scope, elm, attrs) {
                    
                    console.debug(scope, 'scope');
                    console.debug(elm, 'elm');
                    console.debug(attrs, 'attrs');
                    
                    elm.bind('change', function (evt) {
                        
                         console.debug(evt.target.files, 'evt');
                        scope.$apply(function () {
                            scope[ 'files' ] = evt.target.files;
                        });
                    });
                };

                /*return {
                 restrict: 'A',
                 //scope: {files:[]},
                 link: function (scope, element, attrs) {
                 
                 alert(89);
                 var model = $parse(attrs.ngFileModel);
                 var isMultiple = attrs.multiple;
                 var modelSetter = model.assign;
                 element.bind('change', function () {
                 var values = [];
                 alert(23);
                 angular.forEach(element[0].files, function (item) {
                 var value = {
                 // File Name 
                 name: item.name,
                 //File Size 
                 size: item.size,
                 //File URL to view 
                 url: URL.createObjectURL(item),
                 // File Input Value 
                 _file: item
                 };
                 values.push(value);
                 });
                 scope.$apply(function () {
                 if (isMultiple) {
                 modelSetter(scope, values);
                 } else {
                 modelSetter(scope, values[0]);
                 }
                 $FilesUpload  = values;
                 console.debug(values, 'values');
                 console.debug(scope, 'scope');
                 });
                 });
                 }
                 };*/
            }])



        .directive('filelistBind', function () {
            /*return function (scope, elm, attrs) {
             elm.bind('change', function (evt) {
             scope.$apply(function () {
             scope[ attrs.name ] = evt.target.files;
             });
             });
             };*/
        });





   