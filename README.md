LOGIN FORM test , Symfony Standard Edition, v.3.4.5
===================================================

#### Begins from AUTHENTICATION (who you are, check credentials), AUTHORIZATION (what are permissions to take an actions) comes later
#### Firewall is all about finding "who you are", not denying acces

##### Create User class 

* create Entity User which implements Userinterface (it is not required to use User class as an entity, just optional for storing users in DB)
* add private $id and $email properties
* implement ```getUsername()``` and ```getRoles()``` methods
* add getter and setter for $email property
* add Doctrine ORM mapping annotations
* install Doctrine migration bundle : ```composer require doctrine/doctrine-migrations-bundle```
* generate migration ```bin/console doctrine:migrations:diff```
* run migration: ```bin/console doctrine:migrations:migrate```
* load fixtures: ```php bin/console doctrine:fixtures:load```
* create Security controller in AppBundle
* google for "How to Build a Traditional Login Form" : http://symfony.com/doc/2.6/cookbook/security/form_login_setup.html
* copy code from their loginAction and form block itself

#### Using GUARD authenticating system

* create Security/LoginFormAuthenticator.php file with class LoginFormAuthenticator
(https://symfony.com/doc/3.4/security/guard_authentication.html)
1) check if the user is submitting the login form
2) read the username and password from the request
3) load the user object from database





