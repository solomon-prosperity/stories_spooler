# Stories Spooler

The Stories spooler schedules a job that runs every 12 hours to spool 100 top stories 
from [Hacker News API](https://github.com/HackerNews/API) and asynchronous writes the stories alongside their authors and comments to a SQL database, using laravel's native queue system for aynchronous processing. Also, the stories spooler makes APIs available to interact with the datastore.



## API Documentation
Find the API documentation [HERE](https://documenter.getpostman.com/view/16946617/2sA2rB13Xb)


## Process Flow Overview

- A job is scheduled to run every 12 hours, this job calls the service class "HackerNewsService" when it runs
- The service layer implements methods that holds all the logic for the entire process.
- When the job fires, it calls the SpoolStories method. The SpoolStories Method calls the topstories endpoint of the Hackernews API to retrieve the stories.
- The Hackernews API responds with an array of strings representing IDs of the stories
- The SpoolStories then parses the response to JSON, splices the array response and picks 100 IDs from the array
- The new array of 100 story_ids are then iterated over and each ID is put on a SpoolStoryJob
- This new job then uses the SpoolStory method of the HackerNewsService to retrieve the detailed story for each story_id it receives
- On retrieving a story, the method validates(check for duplicates with the title of the story) and saves the story to the datastore. It the dispatches a job to the SpoolAuthorJob to spool the author details with the author ID and then checks if the story contains comments
- If the Story Contains comments, it loops through the comments and dispatches jobs to the SpoolCommentJob with the comment_id of each comment.
- on the SpoolAuthorJob, the class method SpoolAuthor is utilized to retrieve the details of the author, check for duplicate with the author_name(author names are unique from the HackerNews API, they are actually IDs for the users) and write the author data to the datastore.
- on the SpoolCommentJob, the class method SpoolComment is used to retrieve details for that comment, the "text" field is used for duplicates validation, and the valid data is saved to the datastore. 
- A comment can also have other comments within it which also needs to be entered in the database. To handle this, the SpoolComment method checks if each comment it receives has other comments within it and if it does, it recursively passed each comment_id back to the SpoolCommentJob. This process will go on until it finds the last comment that do not have any other nested comments   
- Every step of the process are entire asynchronous and independent of each other. Multiple workers for each job can also be spun to further fasten the process.


## Development Environment Setup

1.  Uses Laravel `v10`
2.  Uses PHP `v8.33`
2.  Uses SQLITE3 `v3.43.2`

## Quick Start
1. to clone the project `git clone https://github.com/solomon-prosperity/stories_spooler.git`
2. make sure your development environment matches or is similar as listed above 
3. create `.env` file in root directory, populate with variables values in the `.env.example` file 
4. make sure `QUEUE_CONNECTION` in `.env` is set to `database` 
5. Provide database credentials in the `.env` 
6. Run the migration with `php artisan migrate`
7. For immediate processing, You can set a less timer for the scheduler by editing the schedule job in `App\Console\Kernel.php`
8. Run the scheduler with `php artisan schedule:run` or `php artisan schedule:work`
9. Run the queue with `php artisan queue:work`
10. To access the API, start the service with `php artisan serve`




### Databases & Messaging

- SQLITE - Main datastore
- Laravel Queues - Message Broker


## Author
[Eravwuvieke Prosper Ilouoghene](https://www.linkedin.com/in/prosper-eravwuvieke-25b534163/)


## License
MIT License - fork, modify and use however you want.
