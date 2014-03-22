KMF-MVC
=======
<p>KMF-MVC is a Lightweight PHP MVC which is developed based upon ORM - PHP ActiveRecord & Template Engine - Twig.</p>
<hr/>

##Required Libraries
- PHP ORM : [PHP ActiveRecord] (http://www.phpactiverecord.org/)
- Template Engine : [Twig] (http://twig.sensiolabs.org)
 
<hr/>

<h2><u>Directory Structure</u></h2>
```
config/
  config.ini
controllers/
  example.ctrl.php
  dashboard.ctrl.php
models/
  example.model.php
  user.model.php
helpers/
  pagination.help.php
  session.help.php
themes/
  [template_name(e.g: default, bootstrap, classics, simple)]/
    css/
    js/
    images/
    views/
      [controller_name]/
        action_name.html
        example.html
        login.html
        index.html
      dashboard/
        index.html
        charts.html
        forms.html
```
##Examples
###Your Application 
######.htaccess
```htaccess
Options +FollowSymLinks
IndexIgnore */*
# Turn on the RewriteEngine
RewriteEngine On
#  Rules
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d

RewriteRule ^([^/]+)(?:/([^/]+)|)(?:/?([^*]+)|) index.php?controller=$1&action=$2 [QSA,NC,L]
```
###### index.php
```php
<?php
 /* Place index.php in the root of Application Folder*/
namespace Your_Application_Namespace;

$config = __DIR__."/config/config.ini";

include("../Core/KMF/KMF.php");
new \KMF\Bootstrap($config);
```
###Configuration
###### config/config.ini
```ini
APPNAMESPACE = Your_Application_Namespace

[PATH] ;Set the PATH (Without ROOT Folder)
APP = path/to/application/
KMF = path/to/KMF-MVC/
ORM = path/to/php-activerecord/
TWIG = path/to/twig/

[DEFAULT] ;Set Default
DBCONNECTION = default_db_connection     ;(e.g: development)
CONTROLLER = default_controller          ;(e.g: dashboard)
TEMPLATE = default_template_to_load      ;(e.g: default, simple, classic...)

[DB] ;Assgin DB Connection of Application
development[USER] = root                        
development[PASS] = password                    
development[HOST] = localhost                   
development[PORT] = 3306                        
development[NAME] = DB_NAME                     

[MENU]  ;Set MENU controller[action] equal to title/action (Optional)
user[login] = login                             
user[logout] = logout
dashboard[index] = Home
dashboard[chart] = Charts
```
###Model 
######models/example.model.php (For more info [PHP Active Record] (http://www.phpactiverecord.org/))
```php
<?php

namespace Your_Application_Namespace;

Class example extends \ActiveRecord\Model{

  static $table_name = 'users';

}
```
###Controller 
######controllers/example.ctrl.php
```php
<?php

namespace Your_Application_Namespace;

Class Example extends \KMF\Controller{
  
  /* While declaring __construct pass $registry variables and extend from parent*/
  function __construct($registry){
    parent::__construct($registry);
  }
  
  /* index() - action is mandatory in all controller */
  function index(){
  
    $params = $this->dispatcher->getParams(); // Get all the request passed through URL i.e $_GET
    $menu = $this->menu(); // Get all menu configured in config.ini file
    
    //If no action is mentioned it redirect to index() of controller & params can be null
    $url = $this->url(
              array(
                'controller' => 'auth', 
                'action' => 'login', 
                'params' => array(
                              'title' => 'Login', 
                              'error' => 'Invalid User'
                            )
               )
           ); // Automated URL generating method
    
    $redirect = $this->redirect(
                   array(
                      'controller' => 'error'
                   )
                ); //Automated Redirection Method

    /* Pass variable to Views */
    $this->view->varName = varValue;
    $this->view->title = 'Home';
    $this->view->msg = 'Hello World';
    
    /* Render View*/
    $this->view->render();
    
  }
}
```
###View 
######themes/[template]/views/[controller]/[action].html  (For more info [Twig] (http://twig.sensiolabs.org))
```html
{{isAjaxRequest}} <!-- View Method to test Ajax request -->

{% if isAjaxRequest == false %}
   Do something non-ajax call
{% else %}
   Do Something else on ajax call
{% endif %}

{{varName}} <!--Passed by View through Controller-->

<title>{{title}}</title> <!-- Title assigned in controller -->

<h1>{{msg}}</h1> <!-- Message assigned in controller -->

{% if user '' %} <!-- Control Statement -->
    {{user}}
{% else %}
    Hello Guest
{% endif %}

{% for key,value in arrayFromView %} <!-- loop Statement -->
   <li><a href = "{{key}}">{{value}}</a>
{% endfor %}
```
<hr/>

##License & Authors

<img class="commit-form-avatar js-avatar" width="60" height="60" src="https://avatars2.githubusercontent.com/u/2240650?s=140" data-user="2240650" alt="Kaviarasan K K"></img>

*Kaviarasan K K* [(kaviarasankk@gmail.com)] (mailto:kaviarasankk@gmail.com)  

```
The MIT License (MIT)

Copyright (c) 2014 Kaviarasan K K

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.
```

