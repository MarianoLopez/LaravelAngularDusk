<!DOCTYPE html>
<!-- YOUR_APP_NAME!--> 
<html data-ng-app="users" xmlns="http://www.w3.org/1999/xhtml">
@include('shared.header')
<!-- YOUR_CONTROLLER_NAME!-->
<main data-ng-controller="AngularUsersController" data-ng-init="getUsers()"> 
    <div class="container">
        <div class="row">
            <div class="rigth-btn">
                <a href="/logout" class="waves-effect waves-light btn"><i class="material-icons right">power_settings_new</i>Logout</a>
            </div>
        </div>

        @if(Auth::check())
        <div>
            <p>Usuario: {{ Auth::user()->username }}</p>
            <p>Roles: {{ Auth::user()->profiles }}</p>
        </div>
        @endif

        <div data-ng-show="showUserForm" class="row">
            <hr></hr>
            @include('forms.userForm')
            <hr></hr>   
        </div>
        <div class="row">
            <h3>Usuarios</h3>
            <div style="overflow-y: auto; ">
            <table class="striped">
                <thead>
                    <tr>
                        <th data-field="ID">ID</th>
                        <th data-field="Name">Username</th>
                        <th >First Name</th>
                        <th >Last Name</th>
                        <th >State</th>
                        <th >Roles</th>
                        <th >Operaciones</th>
                    </tr>
                </thead>
                <tbody>
<!-- for each record found within the records object (which is apart of the $scope variable). 
    Finally the orderBy:orderProp specifies which property (in this case the title) can be used to sort the records.!-->
    <tr data-ng-repeat="user in users|orderBy:'username'">
        <td>@{{ user.id}}</td>
        <td>@{{ user.username}}</td>
        <td>@{{ user.first_name}}</td>
        <td>@{{ user.last_name}}</td>
        <td><input type="checkbox" data-ng-checked="@{{user.state}}"/><label for="state"></label></td>
        <td><p data-ng-repeat="profile in user.profiles">@{{profile.type}}</p></td>
        <td>
            <a data-ng-click="setFormData(user.id)"><i class="small material-icons">mode_edit</i></a>
            <a confirmed-click="deleteUser(user.id)" data-ng-confirm-click="Desea eliminar al usuario ID: @{{user.id}}, Username: @{{user.username}}?"><i class="small material-icons">delete</i></a>
        </td>
    </tr>
</tbody>
</table>
</div>
</div>
<div class="fixed-action-btn">
    <a data-ng-click="showForm()" class="btn-floating btn-large">
        <i class="large material-icons">add</i>
    </a>
</div>
</div>
</main>
@include('shared.footer')
</html>
