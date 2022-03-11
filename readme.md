# Larasymf, PHP Framework
Larasymf, as its says is a mini framework for medium sized projects based on laravel and symfony packages

We have not yet written a documentation for the framework but if you know how to use Laravel or Symfony or any framework based on the MVC concept, you can already start using it
## Usage
1. Clone the project
2. If you know how to handle the command line, turn on the project on any port and consult it in the browser

    . If you do not master the command line download the project in xamp or wamp or other, open it in your browser like all your projects.

3. You must see at the reception: Welcome to Larasymf.
4. Go to the routes folder then to the route file

    - Add this line to the array
<code> addRoute('/test', ['test_controller', 'index']); </code>

. `/test` is the url to access the test page

. `test_controller` is the controller that will generate the data for the view. It is like the place of preparing the view to be displayed to the visitor.

. `index`is the name of the function in the test_controller which will process the data to finally send it to the view   
5. Go to the app/Pages folder then create a test_controller.php file
6. Put the following code the test_controller.php
<code> 
    function index(){
        return view('test_view.php',[
            'variable'=>'John'
        ]);
   }
</code>
7. Go to the ./views folder
And create a <code> test_view.php </code> file
Put a html code in it
with the following code
<code> echo "My name is $variable";  </code>

If everything went well you should have your code working perfectly :(

You just used larasymf
Get inspired by this and create whatever you like
# News!
    . Larasymf is perfectly adapted to micro projects
    . Larasymf is super fast compared to its parents
    . Larasymf is not necessarily object oriented, it supports closures, classes, and procedural functions as a controller while handling expense injection.
    . Larasymf is perfectly adapted to shared hosting
    . Larasymf is designed for zero beginners but it is still a prelude to learning laravel like symfony; by the way, the code is practically a carbon copy of laravel

Internally, larasymf uses symfony's http foundation and laravel's database abstraction.
# Important:
The first version of this framework is not yet official, we continue to develop it.
