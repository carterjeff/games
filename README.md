Carters Games:

Install instructions:

This is a typical LAMP stack setup. 
I have included a MySQL file to build the database and tables.

There are two tables:
`games`
	This has the fields you requested in the docx. `id`,`publisher`,`name`,`nickname`, and ENUM `rating`. I have included a `created_at` as well, just for general logging.
`log`
	This table is to help log requests and responses, this is to help in any debugging needs that comes long. It holds the uri being requested, the user (usually more useful if we have a login type situation), `ip_address`, `user_agent` (to help me know if its web, ios, or android hitting the end point), the `request` (this is what is being sent to the service), the response (in the beginning of a new project, we save both success and NO responses - but as we get through UAT, we typically only log failures), and the timestamp.

The repo includes two sample files:
php/connection.sample.php
js/config.sample.js

You will take the connection.sample.php and save off a new 'connection.php';
This will hold the mysql connection info and any other variables that don't change often and can live in a connection file.
Typically we hold any info for emailers, an include for the 'php_fns.php' file which will hold any PHP functions that we would reuse throughout the backend.

The config.js file where we usually hold the 'debug' function which helps me console.log the Form being sent to the backend for quicker debugging.
It also holds the 'baseURL' variable which usually is a different endpoint for the backend API (not used here). Typically we don't house the PHP services in the same repo as the front end repo, but for the sake of time - everything is in one repo here.

The code base I started out with is kind of the template I use here at fusion. It is a mix of bootstrap and material admin. Typically it includes many dependancies for various things to use in the pages. I have tried to strip out much of it, but didn’t want to spend too much time on that. 

The page and services I created are fairly simple in nature, as you said I should probably only take about an hour or so on the actual code of it. Obviously with more time, I could make it look a bit cleaner. But for the hour I took, this is what I came up with. It should be responsive and work with mobile devices. If I had more time, I would probably look to optimize the responsiveness with as many devices as possible (as mobile browsing is used much more these days). Once you get down to the iPhone 5/SE size, it probably could use a few tweaks. I would also talk with a designer to help get some ideas on how to improve the UI with the necessary search/add components of the page. 
My first instinct is also to turn it into a type of "management" page, where you would be able to click the table row and a modal would pop up allowing you to edit the game fields, and possible disable the game. 

The DataTables plugin I used for the table should allow it to scale up fairly decently to 50k or more. The "deferRender" option when instantiating the table allows the page to only render what is currently in view. It will not try to "load" all 50k at the same time. Will it work with millions of responses? It might hold its own, but we would have to look into if the web service will time out trying to grab that many entries.  We could also ditch the DataTables plugin and implement a paging web service where it returns just a subset of the search responses.

When you search from the input, the search.php web service will look through all 4 fields: name, publisher, nickname, and rating. Since it is looking through all 4 fields, this could prove problematic once we have millions of rows, especially if it is a pretty standard search of “the” for example. 

There are a couple ways to approach the search/add function. In this iteration, if you were to search for a game, and then the list shows up without the game you are looking for. You can add the game (while the list is still being displayed) - and once the game successfully adds, it will research that query to display the game you just added.
You would decide to just clear the table once a game is added, and force the user to research manually. It really would depend on how it handles the million plus games to search through.

-carter