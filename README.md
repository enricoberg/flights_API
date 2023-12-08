

<a  name="readme-top" id="readme-top"></a>

  
  
  


  

<h3  align="center">FLIGHTS API - PHP & MYSQL PROJECT</h3>

  
  
  

<!-- ABOUT THE PROJECT -->

## About The Project

  



  

The application is realized as final test to conclude the module "PHP & MYSQL" of the Start2Impact Backend Development Course.

  

The requisites for the development of the app:


* The API must respect REST architecture, in particular with regards to naming, methods and status code of the response.

* The API must allow the user to insert, modify, delete one country that will have only one parameter: the name.

* The API must allow the user to insert, modify or delete one travel that will have the following characteristics: countries involved in the flight, the number of available seats.
* The API must allow visualization of all inserted travels and to filter them based on the country and available number of seats.
* Information must be stored in MySQL database.
* A migrations.sql file must be provided in order to reconstruct the structure of the database.



  



  

<p  align="right">(<a  href="#readme-top">back to top</a>)</p>

  
  
  

### Built With

  

* ![PHP LOGO](https://img.shields.io/badge/PHP-777BB4?style=for-the-badge&logo=PHP&logoColor=FFF) 

* ![PYTHON LOGO](https://img.shields.io/badge/Python-3776AB?style=for-the-badge&logo=Python&logoColor=FFF) 
* ![MYSQL LOGO](https://img.shields.io/badge/MySQL-4479A1?style=for-the-badge&logo=MySQL&logoColor=FFF)








  



  
  
  

<!-- GETTING STARTED -->

## Getting Started

  

  


  

### Installation
First you need to recreate the database and [have PHP installed.](https://www.php.net/manual/en/install.php)
Download the migrations.sql file and execute the queries to recreate the database, all the tables and their values.
I have used XAMPP as a software to host the database locally.
If you want to use the same software, you can [download it here.](https://www.apachefriends.org/download)

Once you have it installed, you can run the application by clicking START on the Apache and MySQL modules.

  ![XAMPP SCREEN](https://i.postimg.cc/zfDb5csn/xampp.png)
  
You can run the API locally by cloning the repo in the folder 

```xml
C:\xampp\htdocs
```
Make sure you save all the credentials of your newly created database in as environment variables.
Create a .env file in the project directory and add the following lines with your custom values.
```xml
DB_HOST=localhost

DB_NAME=travel_db

DB_USER=

DB_PASS=
```
<!-- USAGE EXAMPLES -->
You're good to go! Open a browser or a software like POSTMAN to simulate all the requests that you can make to the server.
If you need it, you can [download it](https://www.postman.com/downloads/) here.

## Features



The app features comprehend: 

 - Get all the flights present on the server
 - Filter them on many criteria
 - Get all the locations available around the world
 - Filter locations by country or by city
 - Get all the current offers and their expiration time
 - Filter the offers by airport of departure, arrival or both
 - You can even search for discounts greater than x %!
 - Book a seat on the flight of your choice requesting the /book URL
 - Booking is available until there are avilable seats on the plane or until the time for booking expires 6 hours before the flight.

 

  



  
  
  



  

<p  align="right">(<a  href="#readme-top">back to top</a>)</p>

  
  
  ## Example of GET requests
### /flights
Retrieves a JSON with the full data on the travels.
### /flights/13
Retrieves the information of the flight with ID=13
### /flights?arrival=RNB&departure=NBA
Add parameters in the query string to add filters to your search.
You can use one parameter or combine multiple for a more advanced query.
The available parameters are:

 - departure (ID of the departure airport)
 - arrival (ID of the destination airport)
 - company (e.g. filter for RYANAIR flights only)
 - status (BOOKING, CLOSED, DEPARTED)
 - cheaper-than (filter only flights cheaper than your budget)
 - date (put the exact date of departure)
 - date-from (filter all the flights after one specific date)
 - date-to (filter all the flight before one specific date)
### /locations
Retrieves a JSON with the full data on the locations (airport ID, city, country, timezone)
### /locations/ATL
Retrieves the data about a specific airport (e.g. Atlanta, USA)
### /locations?city=Milan
Use the city parameter to filter on one specific city or the country parameter to filter on one specific country (/locations?country=Italy)
### /offers
Retrieves a JSON with the full data on active offers.
### /offers?departure=LIN
You can filter using the following query parameters:
 - departure (ID of the departure airport)
 - arrival (ID of the arrival airport)
 - discount (filter offers with a discount greater than xx % )
### /book?id=13&seats=5
You can use this request to book one or more seats on the flight and have the number of available seats drop automatically.
Pass to the query string both the parameters id (of the flight) and number of seats that you want to book.
The system will let you book seats until there are enough available seats or until the status goes to "CLOSED".

<p  align="right">(<a  href="#readme-top">back to top</a>)</p>
<!-- OTHER REQUEST -->

## Other requests
You can also add data, modify records or delete them from the database.
For every table there are:

 - POST request to add data (put the parameters in the body of the request)
 - PATCH request to modify the data: insert only the parameter that you want to modify as header of the request and the ID of the record in the URL --> 
	 ```xml
	 eg. PATCH /flights/13   with header departure:LIN
	 ```
	 to change the departure airport to Linate in the flight 13
 - DELETE to remove one item (put the ID in the URL)
	 ```xml
	 e.g. DELETE /flights/13
	  ```
	to delete flight number 13.

Find here the full list of parameters that you can pass to the requests.

**POST /flights**
 - departure
 - arrival
 - time-departure
 - time-arrival
 - flight-company
 - max-seats (optional, default = 200)
 - price
 
**POST /locations**
 - airport
 - city
 - country
 - timezone
 
**POST /offers**
 - ID
 - discount (% from the standard price)
 - expiration (optional, otherwise 6 hours prior to the departure)

<p  align="right">(<a  href="#readme-top">back to top</a>)</p>
<!-- CONTRIBUTING -->

## Contributing

  

Contributions are what make the open source community such an amazing place to learn, inspire, and create. Any contributions you make are **greatly appreciated**.

  

If you have a suggestion that would make this better, please fork the repo and create a pull request. You can also simply open an issue with the tag "enhancement".

Don't forget to give the project a star! Thanks again!

  

1. Fork the Project

2. Create your Feature Branch (`git checkout -b feature/AmazingFeature`)

3. Commit your Changes (`git commit -m 'Add some AmazingFeature'`)

4. Push to the Branch (`git push origin feature/AmazingFeature`)

5. Open a Pull Request

  



  
  
  



  
  
  

<!-- CONTACT -->

## Contact

  

Enrico Bergamini -  enricobergamini@outlook.it

[![LinkedIn][linkedin-shield]][linkedin-url]

  

<p  align="right">(<a  href="#readme-top">back to top</a>)</p>


  
  
  


<!-- MARKDOWN LINKS & IMAGES -->

<!-- https://www.markdownguide.org/basic-syntax/#reference-style-links -->

[contributors-shield]: https://img.shields.io/github/contributors/othneildrew/Best-README-Template.svg?style=for-the-badge

[contributors-url]: https://github.com/othneildrew/Best-README-Template/graphs/contributors

[forks-shield]: https://img.shields.io/github/forks/othneildrew/Best-README-Template.svg?style=for-the-badge

[forks-url]: https://github.com/othneildrew/Best-README-Template/network/members

[stars-shield]: https://img.shields.io/github/stars/othneildrew/Best-README-Template.svg?style=for-the-badge

[stars-url]: https://github.com/othneildrew/Best-README-Template/stargazers

[issues-shield]: https://img.shields.io/github/issues/othneildrew/Best-README-Template.svg?style=for-the-badge
[HTML-url]: https://img.shields.io/badge/HTML5-E34F26?style=for-the-badge&logo=html5&logoColor=whit
[issues-url]: https://github.com/othneildrew/Best-README-Template/issues

[license-shield]: https://img.shields.io/github/license/othneildrew/Best-README-Template.svg?style=for-the-badge

[license-url]: https://github.com/othneildrew/Best-README-Template/blob/master/LICENSE.txt

[linkedin-shield]: https://img.shields.io/badge/-LinkedIn-black.svg?style=for-the-badge&logo=linkedin&colorB=555

[linkedin-url]: https://linkedin.com/in/enrico-bergamini

[product-screenshot]: images/screenshot.png

[Next.js]: https://img.shields.io/badge/next.js-000000?style=for-the-badge&logo=nextdotjs&logoColor=white

[Next-url]: https://nextjs.org/

[React.js]: https://img.shields.io/badge/React-20232A?style=for-the-badge&logo=react&logoColor=61DAFB

[React-url]: https://reactjs.org/

[Vue.js]: https://img.shields.io/badge/Vue.js-35495E?style=for-the-badge&logo=vuedotjs&logoColor=4FC08D

[Vue-url]: https://vuejs.org/

[Angular.io]: https://img.shields.io/badge/Angular-DD0031?style=for-the-badge&logo=angular&logoColor=white

[Angular-url]: https://angular.io/

[Svelte.dev]: https://img.shields.io/badge/Svelte-4A4A55?style=for-the-badge&logo=svelte&logoColor=FF3E00

[Svelte-url]: https://svelte.dev/

[Laravel.com]: https://img.shields.io/badge/Laravel-FF2D20?style=for-the-badge&logo=laravel&logoColor=white

[Laravel-url]: https://laravel.com

[Bootstrap.com]: https://img.shields.io/badge/Bootstrap-563D7C?style=for-the-badge&logo=bootstrap&logoColor=white

[Bootstrap-url]: https://getbootstrap.com

[JQuery.com]: https://img.shields.io/badge/jQuery-0769AD?style=for-the-badge&logo=jquery&logoColor=white

[JQuery-url]: https://jquery.com
[CSS-url]: https://img.shields.io/badge/CSS3-1572B6?style=for-the-badge&logo=css3&logoColor=whit
[JAVASCRIPT-url]: https://img.shields.io/badge/JavaScript-F7DF1E?style=for-the-badge&logo=javascript&logoColor=black