## Introduction:

This application is a news aggregator, where backend is developed using Laravel and frontend is developed with React Js. 
The RDBMS is MySQL (But can be exchanged with PostgreSQL too, if required). 

### Features:

- The Application is aggregating news from multiple APIs i.e. NewsAPI and TheGuardian. 
- Each API has some request limits that we have to adhere to.
- All news aggregated from multiple APIS are shown to the viewers in a single screen (according to the number of news feed limit of api) with search option.
- Preferences are used to allow the user to adjust her/his feed by Authors, Categories and sources.
- select, search, and date inputs are used to allow the user to search by Author, Category and source.
- Those APIs, which dont provide images or corressponding information like Author etc have been replaced by general tags to keep the frontend design compact.
- Middlewares in Laravel are used for security.
- At most, reusable components are used in React Js for reusability and compact designs. 
- Redux is used for state management.
- I created two separate dockerfiles and two separate docker-compose files both for frontend and backend as per the requirement. But from my perspective, this should not be the ideal case. We should have two separate dockerfiles but not two seperate docker-compose files. A single docker-compose file should handle the running of both of the frontend and backend. 
- The virtual host configuration is also provided in the myapp.conf. Which defines a local development environment. Requests to localhost on port 80 will be served from the /var/www/html/public directory.

### Filters 
- The filters on the left side are available and if you select any filter for e.g. 
  - select a filter by category i.e. Football and then click on Apply Filter button and on the right side you will see all the news related to that category, if available. 
  - You can provide multiple filters at a time. 
  - There might be data available or not available based on certain categories and sources. So if data is available you will see it otherwise, you will see the default news. You can also see the default news by clicking on the Reset Filter to wash out any filters already selected. 
  - If there is no data in the filter, the only thing that is missing is an alert box shown to the user that NO data is available in this filter. Due to time limitation, I skipped development of the alert box.


### Preferences
- For preferences, go to settings (User information with person icon).
- In settings, there are three boxes (authors, sources,catagories) with add buttons to add the preferences and for delete trash icon is available.

### Exceptions
- As I already mentioned that there are request rate limits for each api as a free account. So here are the list of API endpoints that have request rate limitations and where I am using them.

- News API: 
  - E.g. Everything: https://newsapi.org/docs/endpoints/everything
  - This is used in the front page to aggregate all the news from all categories, sources and authors. 
  - This has a request limit of 1000 per day.
- for api keys check local.env (front-end) where you can change the api keys for NewsAPI and The Guardien API.

### APIs used

- **[NewsAPI](https://newsapi.org/)**
- **[Guardian](https://open-platform.theguardian.com/documentation/)**

##### Note: I wasnt able to find a third new aggregator API from your given sources that was as good as newsAPI and the Guardian. I worked on NYT (New York Times API) but it was having issue in their site to authorise the API, I hope they might fix it.

### Unit Tests
- I didn't write unit tests for this project due to time limitation. 
- But unit tests are really essential both for front-end and back-end to test different features of the project. 

## Techstack
- Backend : Laravel, MySQL
- Frontend : React Js

## Run Backend
- First make sure that you are in the ```backend-laravel-api``` folder.
- To run the backend, you have to type the following command:
```
docker-compose up --build
```

## Migrations
- In order to have the application working, you first need to run the migration after building the Backend. 
- Type the following command:
```
docker ps
```
- grab the container id of the ```backend-laravel-api_app```
- and then type the following command in terminal:
```
docker exec -it <container_id_of_backend-laravel-api_app> sh
```
- After entering above command, you will enter into the shell of the docker container. then type the following command:
- For authentication, I used passport. So before running migration, please run the following command:
```
php artisan passport:install
```
```
php artisan migrate
```
- if you want to also create a default user or prepopulate user table, you can also then run the seeds:
```
php artisan db:seed       (optional)
```
- After runnig the above command you can use ``Username: sabaoon`` and ``Password:123123``
- That is it. You will now have ready tables and then you can run the docker commands to start the frontend and use the application straight away. 



## Run Frontend

- To run the frontend, you have to type the following command, but before running the command make sure that you have Docker Desktop installed on your local computer. 
- First make sure that you are in the ```react-news-app``` folder.
```
docker-compose up --build
```
- After successfully building the frontend, Go to a browser of your choice, I recommend either Google or Firefox and type the following:
```
http://localhost:3000/
```
- Create your own username and password by clicking on Registration Button. 
- Then login with the created username and password. 

## Status Check
- To make sure that everything works, you should check that below three container services must run wit the following command of docker:

- I would recommend to use a powerful specs' laptop to run docker as Docker is heavier and will take more time with weaker specs' laptop.
```
docker ps
```
- After typing above command, you will see a list of docker container services with container id and image name i.e.:
- Image: backend-laravel-api_app
- Image: mysql:5.7.22
- Image: react-news-app_client

