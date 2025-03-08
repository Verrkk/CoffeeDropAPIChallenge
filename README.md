# Coffee Drop API
This task requires you to build a Laravel based web application that provides a JSON API, meeting the brief below. Other code (eg HTML, CSS and Javascript) will be reviewed but is entirely optional.
 
## Brief
A brand new start up, CoffeeDrop, have spotted a gap in the market to build an Android and IOS mobile app which shows their existing 16 national coffee shops, listing them as "locations" for recycling Nespresso coffee pods, for which the client will receive "cashback" - money for each pod.

After initial meetings with CoffeeDrop, they have asked us to develop a small API service which allows a customer using their mobile app to enter their postcode, and be informed of their nearest (as the crow flies) CoffeeDrop location and their opening times.

The API must also allow CoffeeDrop to add a new recycling center, as well as calculate for the user of the app the total amount of "cashback" they will receive according to an algorithm listed below.
 
### New Endpoints Required (Hint: see postman file)
 1. An endpoint which accepts a postcode, it should return the address and opening times of the closest CoffeeDrop Location
 2. An endpoint which accepts a postcode and set of opening and closing times, it should create a new location in the database and then return the created location
 3. An endpoint that accepts a quantity of each of the three sizes of used coffee pods as raw post data in the format 
	 ```
	 {
		"Ristretto":10,
		"Espresso":100,
		"Lungo":30
	  }
	  ```
	  it should return the amount in pounds and pence that the client will receive in cashback according to the following rules:
	  
	  - For the first 50 capsules: [Ristretto = 2p, Espresso = 4p, Lungo = 6p]
	  - For capsules 50-500: [Ristetto = 3p, Espresso = 6p Lungo = 9p]
	  - For capsules 501+: [Ristretto = 5p, Espresso = 10p, Lungo = 15p]
	  
	  These requests should be saved in the database.
  4. (Optional) An API to return the last 5 calculations done by API 3. It should give the number of each type of capsules as well as their result
 
## What we are looking for
- Use of Laravel conventions
- Database migrations and a seeder to seed the data in the location_data.csv file included in this repo
- Use of MVC
- Clean, well-commented code
- Use of the Postcodes.io (https://postcodes.io/) to geocode postcodes
- Use of the Haversine Formula for calculating distances between differnt latitudes and longitudes
 - Use of Eloquent, Resources, Requests and Routes
 - An updated Postman (https://www.getpostman.com/) file (included in this repository) which allows us to query the API
 
## Optional
If you like a challenge and want to showcase further skills, we will review what you send us, here are a few suggestions:
- Authentication on the API (We use either Laravel Sanctum or Laravel Passport at Image+)
- A frontend website with forms or mobile app to interact with the API
 
 ## Submission Instructions
  - Please email your contact at Image+ with a link to a fork of this github repository containing your response

