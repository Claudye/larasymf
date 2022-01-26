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

5. Go to the app/Pages folder then create a test_controller.php file
6. Put the following code in front
<code> 
    function index(){
        return view('test_view.php',[
            'variable'=>'John'
        ]);
   }
</code>
7. Go to the views folder
And create a <code> test_view.php </code> file
Put html code in it
with the following code
`<?php echo "Name is $variable" ?>`;

If everything went well you should have your code working perfectly :(

You just used larasymf
Get inspired by this and create whatever you like
# Important:
The first version of this framework is not yet official, we continue to develop it.
