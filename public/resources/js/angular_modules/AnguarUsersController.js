//the controller definition
app.controller('AngularUsersController', ['$scope', 'httpCallWithCSRF',
    function ($scope, httpCallWithCSRF) {
        $scope.showUserForm = false;//mostrar form de usuario "ligado a data-ng-show"
        $scope.updateUser = false;//nuevo usuario o modificación?
        //checkbox roles
        $scope.USER = {"checked":true,"id":2};
        $scope.ADMIN = {"checked":false,"id":1};
        
        httpCallWithCSRF.setURL("/user/");
        
        //GET usuarios desde API
        $scope.getUsers = function () {
            httpCallWithCSRF.get(function (response) {
                $scope.users = response.data;
            }, function (respose) {
                error(respose);
            });
        };


        //Return json con los datos del form usuarios
        function getFormData() {
            var profileList=[];
            //añadir roles seleccionados
            if ($scope.USER.checked){profileList.push($scope.USER);}
            if ($scope.ADMIN.checked){profileList.push($scope.ADMIN);}
            return {"id": $scope.user_id,
                "username": $scope.username,
                "password": $scope.password,
                "first_name": $scope.first_name,
                "last_name": $scope.last_name,
                "state": $scope.state,
                "profiles": profileList};
        };
        
        //Asigna al form los datos del usuario a partir de su id
        $scope.setFormData = function (id, showForm = true) {
            var user = $scope.getUserById(id);
            $scope.showUserForm = showForm;
            $scope.updateUser = true;//actualización
            $scope.user_id = user.id;
            $scope.username = user.username;
            $scope.password = "";
            $scope.first_name = user.first_name;
            $scope.last_name = user.last_name;
            $scope.state = (user.state)?true:false;//no acepta int.. solo boolean
            //activar checkbox a partir de los roles del usuario
            if(findInJson(user.profiles,"type","ADMIN")){
                $scope.ADMIN.checked=true;
            }else{
                $scope.ADMIN.checked=false;
            }
            
            if(findInJson(user.profiles,"type","USER")){
                $scope.USER.checked=true;
            }else{
                $scope.USER.checked=false;
            }
        };

        //Save(POST) - Update(PUT) a la API
        $scope.saveOrUpdateUser = function () {
            if ($scope.updateUser) {
                httpCallWithCSRF.update($scope.user_id,getFormData(),
                        function (response) {
                            success(response);
                        },
                        function (response) {
                            error(response);
                        }
                );
            } else {
                httpCallWithCSRF.save(getFormData(),
                        function (response) {
                            success(response);
                        },
                        function (response) {
                            error(response);
                        }
                );
            }
        };
        $scope.deleteUser = function (id) {
            $scope.setFormData(id, false);
            httpCallWithCSRF.delete($scope.user_id,
                    function (response) {
                        success(response);
                    },
                    function (response) {
                        error(response);
                    }
            );
        };
        //mostrar y limpiar form usuario 
        $scope.showForm = function () {
            $scope.showUserForm = !$scope.showUserForm;
            $scope.updateUser = false;//nuevo usuario
            $scope.user_id = "";
            $scope.username = "";
            $scope.password = "";
            $scope.first_name = "";
            $scope.last_name = "";
            $scope.state = true;
            $scope.USER.checked=true;
            $scope.ADMIN.checked=false;
        };
       
        //Success callback generico
        function success(response) {
            alert(response.data.message);
            console.log(response.data);
            $scope.showUserForm = false;
            $scope.getUsers();
        }
        ;
        //Error callback generico
        function error(response) {
            alert(response.data.message);
            console.log(response.data);
        }
        ;
        //El json de usuarios ($scope.users) tiene un orderby en el tabla, por lo que es necesaria la búsqueda por id
        $scope.getUserById = function (id) {
            var user = [];
            angular.forEach($scope.users, function (value, key) {
                if (id === value.id) {user.push(value);}
            });
            return user[0];
        };
    }]);



