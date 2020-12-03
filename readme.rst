###################
MBTA TEST
###################

Test to gauge 3 questions - Link to access and view the question implementation https://mbta-test.sandbox.co.ke/

1. Downloading results from an API vs Relying on the server for filtering
2. Extend your program so it displays the following additional information.
		1. The name of the subway route with the most stops as well as a count of its
		stops.
		2. The name of the subway route with the fewest stops as well as a count of its
		stops.
		3. A list of the stops that connect two or more subway routes along with the
		relevant route
		names for each of those stops.

3. List a rail route you could travel to get from one stop to the other.

###################
About the project
###################

The project has been done using PHP - Codeigniter framework 3 to achieve faster reselts
The project is simply segmented to Controller, Views and simple model
Controller - The home controller that has been routed to only show the questions
View - Simple templating without using parser to just present results in a plain bootstrap tempate
Model - Modeling the act of reading data from a file.

Implementation pending
Looking forward to implement the project to have websockets to update data periodically once the server (https://www.mbta.com/) updates the data.
Use of state management to update user data once the front end is notified of new updates

###################
Important Files in the project
###################
1. Controllers - Home 
Hosts all the functions for the questions

2. Config - Custom
Where api_key, url has been defined. This is always important to manage urls using config for ease during production

3. Model - Routes_m
Reading and interplating the file

4. Libraries - Curl - 
To make curl requests to the server

5. Helpers - Custom
To do any helper tasks like saving the downloaded file. In this case saved the file as .txt but a user can save it in a different format as they so wish.
