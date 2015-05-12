Read Me:
This Application bases it's looks and functionality on UrbanDictionary.com - though all the code and CSS/HTML is written by me.
It is an MVC based version of it, and uses user validation to determine who can and cannot post.


:::::STRUCTURE:::::

The application is broken up into many parts

Home:: Uses the PostController to establish all the posts(limited to 15) and get a random post as the spec suggests. In here there's also an option to set the Cookie Sort. The home is a basic version of..

Posts:: Displays all the posts, can click on them to get to

GetPost:: Displays a single post and all the replies

User:: Displays your user or another users page. Here you can edit the Bio and see all the users posts.

Admin:: Admin page to add category or make others admins.

Register/Login:: handles the login and registration of users. The registration uses 2 forms of validation, JS and PHP.

Search - uses wildcard searches %$SEARCH% to find posts. outputs these posts using the post View.

Error: Simple error page.


:::::DESIGN:::::

Uses PDO as the database class, initially instantiated in the Model Class and then extended into PostModel and UserModel.
Uses Prepared statements put into individual methods.
XSS is prevented by htmlentities, but if we were sure this application would only be used for a html web app we could also push htmlentities to the db to have double validation\
However, it could be extended to a mobile app or something similar so I did not do that.

Post class is incredibly abstract, it's used multiple times, as such many of the names of the reply and entries are the same to ensure that it works for both. this is done with Aliases.

Validation is done with a login_token that is the users hashed password and userAgent combined into one SHA256ed encrypted string.

:::::HOW TO USE:::::

FIRST USE THE SETUP.PHP this sets up the SQL and Databases necessary. The application will not function without these. Setup.php sets up the db and adds the admin. Admin password is: rootpassword


Search is from the Header file, it pushes you to search
The login is done via the user picture at the top, this will put you in user if you are already logged in.
Logout is in the footer.
Add Post requires you to select a category.
Replying to a post does not and thus hides the Category, otherwise it uses the same interface, if you add a Post that already has a topic it will reply to that instead. This is done in the model.
Admin can make others admin and add categories. The Constructor for the Admin class ensures no normal user can do this.
