Carters Games:

Install instructions:

This is a typical LAMP stack setup. 
I have included a MySQL file to build the database and tables.

There are two tables:
`games`
	This has the fields you requested in the docx. `id`,`publisher`,`name`,`nickname`, and ENUM `rating`. I have included a `created_at` as well, just for general logging.
`log`
	This table is to help log requests and responses, this is to help in any debugging needs that comes long. It holds the uri being requested, the user (usually more useful if we have a login type situation), ip_address, user_agent (to help me know if its web, ios, or android hitting the end point), tne request (this is what is being sent to the service), the response (in the beginning of a new project, we save both success and NO responses - but as we get through UAT, we typically only log failures), and the timestamp.

The repo includes two sample files:
php/connection.sample.php
js/config.sample.js

You will take the connection.sample.php and save off a new 'connection.php';
This will hold the mysql connection info and any other variables that don't change often and can live in a connection file.
Typically we hold any info for emailers, an include for the 'php_fns.php' file which will hold any PHP functions that we would reuse throughout the backend.

The config.js file where we usually hold the 'debug' function which helps me console.log the Form being sent to the backend for quicker debugging.
It also holds the 'baseURL' variable which usually is a different endpoint for the backend API (not used here). Typically we don't house the PHP services in the same repo as the front end repo, but for the sake of time - everything is in one repo here.

The page and services I created are fairly simple in nature, as you said I should probably only take about an hour or so on the actual code of it. Obviously with more time, I could make it look a bit cleaner. But for the hour I took, this is what I came up with. It should be responsive and work with mobile devices. If I had more time, I would probably look to optimize the responsiveness with as many devices as possible (as mobile browsing is used much more these days.)  

The datatables plugin I used for the table should allow it to scale up fairly decently to 50k or more. The "deferRender" option when instantiating the table allows the page to only render what is currently in view. It will not try to "load" all 50k at the same time. Will it work with millions of responses? It might hold its own, but we would have to look into if the web service will time out trying to grab that many entries. 